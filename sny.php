<?php
/**
 * Strona archiwum snów — /sny i /sny/YYYY/MM/DD
 * Obsługuje: listę per-język, filtrowanie po dacie, paginację
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/klasy/Jezyk.php';

$jezyk = new Jezyk(__DIR__ . '/jezyk');
$j = function (string $klucz, array $p = []) use ($jezyk): string {
    return $jezyk->t($klucz, $p);
};

// ── Parametry routingu ──
$wszystkie  = isset($_GET['wszystkie']);
$rok        = isset($_GET['rok'])     && preg_match('/^\d{4}$/', $_GET['rok'])     ? $_GET['rok']     : null;
$miesiac    = isset($_GET['miesiac']) && preg_match('/^\d{2}$/', $_GET['miesiac']) ? $_GET['miesiac'] : null;
$dzien      = isset($_GET['dzien'])   && preg_match('/^\d{2}$/', $_GET['dzien'])   ? $_GET['dzien']   : null;
$strona     = max(1, (int) ($_GET['strona'] ?? 1));
$naStronie  = 12;

$aktualnyJezyk = $jezyk->pobierzAktualny();

// ── Funkcja do wczytywania snów ──
function pobierzSny(string $katalogDane, ?string $jezyk, ?string $rok, ?string $miesiac, ?string $dzien): array
{
    $sny = [];

    if (!is_dir($katalogDane)) {
        return $sny;
    }

    // Buduj wzorzec ścieżki
    $wzorzecRok  = $rok     ?? '[0-9]{4}';
    $wzorzecMies = $miesiac ?? '[0-9]{2}';
    $wzorzecDzien = $dzien  ?? '[0-9]{2}';

    // Iteruj po katalogach rok/miesiac/dzien
    $rokDirs = glob($katalogDane . '/*', GLOB_ONLYDIR) ?: [];
    foreach ($rokDirs as $rokDir) {
        $r = basename($rokDir);
        if ($rok && $r !== $rok) continue;

        $miesiacDirs = glob($rokDir . '/*', GLOB_ONLYDIR) ?: [];
        foreach ($miesiacDirs as $miesiacDir) {
            $m = basename($miesiacDir);
            if ($miesiac && $m !== $miesiac) continue;

            $dzienDirs = glob($miesiacDir . '/*', GLOB_ONLYDIR) ?: [];
            foreach ($dzienDirs as $dzienDir) {
                $d = basename($dzienDir);
                if ($dzien && $d !== $dzien) continue;

                $pliki = glob($dzienDir . '/*.json') ?: [];
                foreach ($pliki as $plik) {
                    $dane = json_decode(file_get_contents($plik), true);
                    if (!is_array($dane)) continue;

                    // Filtruj po języku (chyba że wszystkie)
                    if ($jezyk !== null && ($dane['jezyk'] ?? '') !== $jezyk) continue;

                    $sny[] = $dane;
                }
            }
        }
    }

    // Sortuj od najnowszych
    usort($sny, function ($a, $b) {
        $da = ($a['data'] ?? '') . ' ' . ($a['czas'] ?? '');
        $db = ($b['data'] ?? '') . ' ' . ($b['czas'] ?? '');
        return strcmp($db, $da);
    });

    return $sny;
}

$katalogDane = __DIR__ . '/pliki/sny/dane';
$jezykFiltr  = $wszystkie ? null : $aktualnyJezyk;
$wszystkieSny = pobierzSny($katalogDane, $jezykFiltr, $rok, $miesiac, $dzien);

$razem     = count($wszystkieSny);
$stron     = max(1, (int) ceil($razem / $naStronie));
$strona    = min($strona, $stron);
$snyStrony = array_slice($wszystkieSny, ($strona - 1) * $naStronie, $naStronie);

// ── Tytuł strony ──
$tytulStrony = $wszystkie ? $j('sny.wszystkie_tytul') : $j('sny.tytul_strony');
if ($rok && $miesiac && $dzien) {
    $nazwyMiesiecy = array_map(fn($i) => $j('sny.miesiac_' . str_pad($i, 2, '0', STR_PAD_LEFT)), range(1, 12));
    $nazMies = $nazwyMiesiecy[(int)$miesiac - 1] ?? $miesiac;
    $tytulStrony .= ' — ' . $j('sny.filtr_dzien', ['dzien' => (int)$dzien, 'miesiac' => $nazMies, 'rok' => $rok]);
} elseif ($rok && $miesiac) {
    $nazwyMiesiecy = array_map(fn($i) => $j('sny.miesiac_' . str_pad($i, 2, '0', STR_PAD_LEFT)), range(1, 12));
    $nazMies = $nazwyMiesiecy[(int)$miesiac - 1] ?? $miesiac;
    $tytulStrony .= ' — ' . $j('sny.filtr_miesiac', ['miesiac' => $nazMies, 'rok' => $rok]);
} elseif ($rok) {
    $tytulStrony .= ' — ' . $j('sny.filtr_rok', ['rok' => $rok]);
}

// ── Canonical URL ──
$sciezkaUrl = '/sny';
if ($wszystkie) $sciezkaUrl = '/sny/wszystkie';
elseif ($rok && $miesiac && $dzien) $sciezkaUrl = "/sny/{$rok}/{$miesiac}/{$dzien}";
elseif ($rok && $miesiac) $sciezkaUrl = "/sny/{$rok}/{$miesiac}";
elseif ($rok) $sciezkaUrl = "/sny/{$rok}";

$bazaUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
    . '://' . $_SERVER['HTTP_HOST'] . $sciezkaUrl;

$rok = $rok ?? date('Y'); // dla stopki

// ── Funkcja budowania URL paginacji ──
function urlPaginacji(int $nr): string {
    $params = $_GET;
    $params['strona'] = $nr;
    unset($params['rok'], $params['miesiac'], $params['dzien'], $params['wszystkie']);
    return '?' . http_build_query($params);
}
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($jezyk->pobierzKodHtml()) ?>" dir="<?= $jezyk->pobierzKierunek() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($j('sny.opis_strony')) ?>">

    <meta property="og:title"       content="<?= htmlspecialchars($tytulStrony) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($j('sny.opis_strony')) ?>">
    <meta property="og:type"        content="website">
    <meta property="og:url"         content="<?= htmlspecialchars($bazaUrl) ?>">

    <link rel="canonical" href="<?= htmlspecialchars($bazaUrl) ?>">
    <?= $jezyk->generujHreflang($bazaUrl) ?>

    <title><?= htmlspecialchars($tytulStrony) ?> — <?= htmlspecialchars($j('naglowek.tytul')) ?></title>

    <link rel="stylesheet" href="/wyglad/zmienne.css">
    <link rel="stylesheet" href="/wyglad/glowny.css">
    <link rel="stylesheet" href="/wyglad/naglowek.css">
    <link rel="stylesheet" href="/wyglad/menu.css">
    <link rel="stylesheet" href="/wyglad/stopka.css">
    <link rel="stylesheet" href="/wyglad/sny.css">

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "CollectionPage",
        "name": "<?= htmlspecialchars($tytulStrony) ?>",
        "description": "<?= htmlspecialchars($j('sny.opis_strony')) ?>",
        "url": "<?= htmlspecialchars($bazaUrl) ?>"
    }
    </script>
</head>
<body>
    <a href="#tresc-glowna" class="sr-only"><?= htmlspecialchars($j('menu.strona_glowna')) ?></a>

    <?php require __DIR__ . '/fragmenty/nawigacja.php'; ?>

    <!-- ══ NAGLOWEK ══ -->
    <header class="kontener naglowek naglowek--maly">
        <h1 class="naglowek__tytul naglowek__tytul--maly"><?= htmlspecialchars($tytulStrony) ?></h1>
        <p class="naglowek__podtytul"><?= htmlspecialchars($wszystkie ? $j('sny.wszystkie_opis') : $j('sny.opis_strony')) ?></p>
    </header>

    <!-- ══ TRESC ══ -->
    <main id="tresc-glowna" class="kontener" style="padding-bottom: var(--odstep-2xl);">

        <?php if (empty($snyStrony)): ?>
        <div class="sny__brak">
            <p><?= htmlspecialchars($wszystkie ? $j('sny.brak_snow_wszystkie') : $j('sny.brak_snow_jezyk')) ?></p>
            <?php if (!$wszystkie): ?>
            <a href="/sny/wszystkie" class="sny__link-wszystkie"><?= htmlspecialchars($j('menu.wszystkie_sny')) ?></a>
            <?php endif; ?>
        </div>
        <?php else: ?>

        <!-- Lista snów -->
        <div class="sny__siatka">
            <?php foreach ($snyStrony as $sen):
                $dataSnu    = $sen['data'] ?? date('Y-m-d');
                $dataCzesci = explode('-', $dataSnu);
                $sRok    = $dataCzesci[0] ?? date('Y');
                $sMiesiac = $dataCzesci[1] ?? date('m');
                $sDzien  = $dataCzesci[2] ?? date('d');
                $urlSnu  = '/sny/' . $sRok . '/' . $sMiesiac . '/' . $sDzien . '/' . ($sen['slug'] ?? '');
                $flagaJezyka = '';
                switch ($sen['jezyk'] ?? '') {
                    case 'pl': $flagaJezyka = '🇵🇱'; break;
                    case 'en': $flagaJezyka = '🇬🇧'; break;
                    default:   $flagaJezyka = '🌐';
                }
            ?>
            <article class="sen-karta" itemscope itemtype="https://schema.org/CreativeWork">
                <?php if (!empty($sen['obraz'])): ?>
                <a href="<?= htmlspecialchars($urlSnu) ?>" class="sen-karta__link-obraz" tabindex="-1" aria-hidden="true">
                    <div class="sen-karta__obraz-kontener">
                        <img src="/<?= htmlspecialchars($sen['obraz']) ?>"
                             alt="<?= htmlspecialchars($sen['tytul'] ?? '') ?>"
                             class="sen-karta__obraz"
                             loading="lazy"
                             width="1280" height="720"
                             itemprop="image">
                    </div>
                </a>
                <?php endif; ?>

                <div class="sen-karta__tresc">
                    <?php if ($wszystkie): ?>
                    <span class="sen-karta__flaga" title="<?= htmlspecialchars($sen['jezyk'] ?? '') ?>"><?= $flagaJezyka ?></span>
                    <?php endif; ?>

                    <h2 class="sen-karta__tytul" itemprop="name">
                        <a href="<?= htmlspecialchars($urlSnu) ?>"><?= htmlspecialchars($sen['tytul'] ?? '') ?></a>
                    </h2>

                    <?php if (!empty($sen['wstep'])): ?>
                    <p class="sen-karta__wstep" itemprop="description">
                        <?= htmlspecialchars(mb_strimwidth($sen['wstep'], 0, 160, '…')) ?>
                    </p>
                    <?php endif; ?>

                    <div class="sen-karta__meta">
                        <time datetime="<?= htmlspecialchars($dataSnu) ?>" itemprop="dateCreated">
                            <?= htmlspecialchars($sDzien . '.' . $sMiesiac . '.' . $sRok) ?>
                        </time>
                        <?php if (!empty($sen['gatunek'])): ?>
                        <span class="sen-karta__tag"><?= htmlspecialchars($sen['gatunek']) ?></span>
                        <?php endif; ?>
                    </div>

                    <a href="<?= htmlspecialchars($urlSnu) ?>" class="sen-karta__przycisk" itemprop="url">
                        <?= htmlspecialchars($j('sny.zobacz_sen')) ?>
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

        <!-- Paginacja -->
        <?php if ($stron > 1): ?>
        <nav class="sny__paginacja" aria-label="<?= htmlspecialchars($j('sny.strona')) ?>">
            <?php if ($strona > 1): ?>
            <a href="<?= htmlspecialchars($sciezkaUrl . urlPaginacji($strona - 1)) ?>" class="sny__paginacja-link">
                <?= htmlspecialchars($j('sny.poprzednia')) ?>
            </a>
            <?php endif; ?>

            <span class="sny__paginacja-info">
                <?= htmlspecialchars($j('sny.strona')) ?> <?= $strona ?> <?= htmlspecialchars($j('sny.z')) ?> <?= $stron ?>
            </span>

            <?php if ($strona < $stron): ?>
            <a href="<?= htmlspecialchars($sciezkaUrl . urlPaginacji($strona + 1)) ?>" class="sny__paginacja-link">
                <?= htmlspecialchars($j('sny.nastepna')) ?>
            </a>
            <?php endif; ?>
        </nav>
        <?php endif; ?>

        <?php endif; ?>

    </main>

    <!-- ══ STOPKA ══ -->
    <footer class="kontener stopka">
        <p class="stopka__tekst"><?= $j('stopka.tekst') ?></p>
        <p class="stopka__prawa"><?= $j('stopka.prawa', ['rok' => date('Y')]) ?></p>
    </footer>

    <script>
    const przyciskJezyka = document.getElementById('przycisk-jezyka');
    const listaJezykow   = document.getElementById('lista-jezykow');
    if (przyciskJezyka && listaJezykow) {
        przyciskJezyka.addEventListener('click', function (e) {
            e.stopPropagation();
            const aktywna = listaJezykow.classList.toggle('wybor-jezyka__lista--aktywna');
            przyciskJezyka.setAttribute('aria-expanded', aktywna);
        });
        document.addEventListener('click', function () {
            listaJezykow.classList.remove('wybor-jezyka__lista--aktywna');
            przyciskJezyka.setAttribute('aria-expanded', 'false');
        });
    }
    </script>
</body>
</html>
