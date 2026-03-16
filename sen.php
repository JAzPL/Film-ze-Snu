<?php
/**
 * Indywidualna strona snu — /sny/YYYY/MM/DD/slug
 * SEO, W3C, RWD
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
$rok     = isset($_GET['rok'])     && preg_match('/^\d{4}$/', $_GET['rok'])     ? $_GET['rok']     : null;
$miesiac = isset($_GET['miesiac']) && preg_match('/^\d{2}$/', $_GET['miesiac']) ? $_GET['miesiac'] : null;
$dzien   = isset($_GET['dzien'])   && preg_match('/^\d{2}$/', $_GET['dzien'])   ? $_GET['dzien']   : null;
$slug    = isset($_GET['slug'])    && preg_match('/^[a-z0-9-]+$/', $_GET['slug']) ? $_GET['slug']  : null;

if (!$rok || !$miesiac || !$dzien || !$slug) {
    http_response_code(404);
    // Pokaż 404 w dalszej części
    $sen = null;
} else {
    $plikJson = __DIR__ . "/pliki/sny/dane/{$rok}/{$miesiac}/{$dzien}/{$slug}.json";
    if (!file_exists($plikJson)) {
        http_response_code(404);
        $sen = null;
    } else {
        $sen = json_decode(file_get_contents($plikJson), true);
        if (!is_array($sen)) {
            http_response_code(404);
            $sen = null;
        }
    }
}

$urlPowrotu   = "/sny/{$rok}/{$miesiac}/{$dzien}";
$bazaUrlSen   = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
    . '://' . $_SERVER['HTTP_HOST'] . "/sny/{$rok}/{$miesiac}/{$dzien}/{$slug}";

$tytul        = $sen['tytul']  ?? $j('bledy.nie_znaleziono');
$wstep        = $sen['wstep']  ?? '';
$gatunek      = $sen['gatunek'] ?? '';
$nastroj      = $sen['nastroj'] ?? '';
$dataSnu      = $sen['data']   ?? '';
$obraz        = $sen['obraz']  ?? null;
$film         = $sen['film']   ?? null;
$sceny        = $sen['sceny']  ?? [];
$jezykSnu     = $sen['jezyk']  ?? '';

$flagaJezyka  = match ($jezykSnu) { 'pl' => '🇵🇱', 'en' => '🇬🇧', default => '🌐' };

$ogObraz = $obraz ? ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' . $obraz) : '';

// Nazwy miesięcy dla daty
$nazwyMiesiecy = array_map(fn($i) => $j('sny.miesiac_' . str_pad($i, 2, '0', STR_PAD_LEFT)), range(1, 12));
$nazMiesiac    = $miesiac ? ($nazwyMiesiecy[(int)$miesiac - 1] ?? $miesiac) : '';
$dataPelna     = $dzien ? ((int)$dzien . ' ' . $nazMiesiac . ' ' . $rok) : $dataSnu;
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($jezyk->pobierzKodHtml()) ?>" dir="<?= $jezyk->pobierzKierunek() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars(mb_strimwidth($wstep, 0, 160, '…') ?: $j('sny.opis_strony')) ?>">

    <meta property="og:title"       content="<?= htmlspecialchars($tytul) ?>">
    <meta property="og:description" content="<?= htmlspecialchars(mb_strimwidth($wstep, 0, 200, '…')) ?>">
    <meta property="og:type"        content="article">
    <meta property="og:url"         content="<?= htmlspecialchars($bazaUrlSen) ?>">
    <?php if ($ogObraz): ?>
    <meta property="og:image"       content="<?= htmlspecialchars($ogObraz) ?>">
    <meta property="og:image:width"  content="1280">
    <meta property="og:image:height" content="720">
    <?php endif; ?>

    <link rel="canonical" href="<?= htmlspecialchars($bazaUrlSen) ?>">
    <?= $jezyk->generujHreflang($bazaUrlSen) ?>

    <title><?= htmlspecialchars($tytul) ?> — <?= htmlspecialchars($j('naglowek.tytul')) ?></title>

    <link rel="stylesheet" href="/wyglad/zmienne.css">
    <link rel="stylesheet" href="/wyglad/glowny.css">
    <link rel="stylesheet" href="/wyglad/naglowek.css">
    <link rel="stylesheet" href="/wyglad/menu.css">
    <link rel="stylesheet" href="/wyglad/stopka.css">
    <link rel="stylesheet" href="/wyglad/sny.css">

    <?php if ($sen): ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": "<?= htmlspecialchars($tytul) ?>",
        "description": "<?= htmlspecialchars(mb_strimwidth($wstep, 0, 200, '…')) ?>",
        "datePublished": "<?= htmlspecialchars($dataSnu) ?>",
        "inLanguage": "<?= htmlspecialchars($jezykSnu) ?>"
        <?php if ($ogObraz): ?>
        ,"image": "<?= htmlspecialchars($ogObraz) ?>"
        <?php endif; ?>
    }
    </script>
    <?php endif; ?>
</head>
<body>
    <a href="#tresc-glowna" class="sr-only"><?= htmlspecialchars($j('menu.strona_glowna')) ?></a>

    <?php require __DIR__ . '/fragmenty/nawigacja.php'; ?>

    <?php if (!$sen): ?>
    <!-- ══ 404 ══ -->
    <main id="tresc-glowna" class="kontener kontener--waski sen__404" style="padding: var(--odstep-2xl) 0;">
        <h1><?= htmlspecialchars($j('bledy.nie_znaleziono')) ?></h1>
        <a href="/sny" class="sen__powrot"><?= htmlspecialchars($j('sny.powrot')) ?></a>
    </main>

    <?php else: ?>

    <!-- ══ NAGLOWEK SNU ══ -->
    <header class="kontener naglowek naglowek--maly">
        <div class="sen__naglowek-meta">
            <span class="sen__flaga" title="<?= htmlspecialchars($jezykSnu) ?>"><?= $flagaJezyka ?></span>
            <?php if ($gatunek): ?>
            <span class="sen-karta__tag"><?= htmlspecialchars($gatunek) ?></span>
            <?php endif; ?>
            <?php if ($nastroj): ?>
            <span class="sen-karta__tag sen-karta__tag--nastroj"><?= htmlspecialchars($nastroj) ?></span>
            <?php endif; ?>
        </div>
        <h1 class="naglowek__tytul naglowek__tytul--maly" itemprop="headline"><?= htmlspecialchars($tytul) ?></h1>
        <time class="sen__data" datetime="<?= htmlspecialchars($dataSnu) ?>"><?= htmlspecialchars($dataPelna) ?></time>
    </header>

    <!-- ══ TRESC ══ -->
    <main id="tresc-glowna" class="kontener kontener--waski" itemscope itemtype="https://schema.org/Article"
          style="padding-bottom: var(--odstep-2xl);">

        <!-- Główny obraz -->
        <?php if ($obraz): ?>
        <figure class="sen__obraz-glowny">
            <img src="/<?= htmlspecialchars($obraz) ?>"
                 alt="<?= htmlspecialchars($tytul) ?>"
                 class="sen__obraz"
                 width="1280" height="720"
                 itemprop="image">
        </figure>
        <?php endif; ?>

        <!-- Wstęp — tekst do czytania -->
        <?php if ($wstep): ?>
        <section class="sen__wstep" aria-label="<?= htmlspecialchars($j('sny.wstep')) ?>">
            <p class="sen__wstep-tekst" itemprop="description"><?= nl2br(htmlspecialchars($wstep)) ?></p>
        </section>
        <?php endif; ?>

        <!-- Filmik z narracją -->
        <?php if ($film): ?>
        <section class="sen__film" aria-label="<?= htmlspecialchars($j('sny.odtworz_film')) ?>">
            <h2 class="sen__sekcja-tytul"><?= htmlspecialchars($j('sny.odtworz_film')) ?></h2>
            <div class="sen__wideo-kontener">
                <video controls preload="metadata" class="sen__wideo"
                       poster="<?= $obraz ? '/' . htmlspecialchars($obraz) : '' ?>">
                    <source src="/<?= htmlspecialchars($film) ?>" type="video/mp4">
                </video>
            </div>
        </section>
        <?php elseif (!empty($sceny)): ?>
        <!-- Brak video - pokaż odtwarzacz narracji ze sceny 1 -->
        <?php
        $scena1     = $sceny[0] ?? [];
        $narrPlik   = $scena1['narracja_plik'] ?? null;
        $muzykaPlik = $scena1['muzyka_plik']   ?? null;
        ?>
        <?php if ($narrPlik): ?>
        <section class="sen__film" aria-label="<?= htmlspecialchars($j('sny.odtworz_film')) ?>">
            <h2 class="sen__sekcja-tytul"><?= htmlspecialchars($j('sny.odtworz_film')) ?></h2>
            <div class="sen__narracja-player">
                <audio controls preload="metadata" class="sen__audio">
                    <source src="/<?= htmlspecialchars($narrPlik) ?>" type="audio/mpeg">
                </audio>
            </div>
        </section>
        <?php endif; ?>
        <?php endif; ?>

        <!-- Sceny — mini-galeria z pełną narracją -->
        <?php if (count($sceny) > 1): ?>
        <section class="sen__sceny" aria-label="<?= htmlspecialchars($j('sceny.scena', ['numer' => ''])) ?>">
            <?php foreach ($sceny as $scena):
                $nrSceny  = $scena['numer'] ?? 0;
                $tytSceny = $scena['tytul'] ?? '';
                $narrTekst = $scena['narracja'] ?? '';
                $obrazSceny = $scena['obraz'] ?? null;
                $narrSceny  = $scena['narracja_plik'] ?? null;
                $muzSceny   = $scena['muzyka_plik']   ?? null;
                $wideoSceny = $scena['wideo_plik']     ?? null;
            ?>
            <article class="sen__scena-karta">
                <?php if ($obrazSceny): ?>
                <div class="sen__scena-obraz-kontener">
                    <img src="/<?= htmlspecialchars($obrazSceny) ?>"
                         alt="<?= htmlspecialchars($j('sceny.scena', ['numer' => $nrSceny]) . ': ' . $tytSceny) ?>"
                         class="sen__scena-obraz"
                         loading="lazy" width="1280" height="720">
                    <span class="scena-karta__numer"><?= htmlspecialchars($j('sceny.scena', ['numer' => $nrSceny])) ?></span>
                </div>
                <?php endif; ?>
                <div class="sen__scena-tresc">
                    <?php if ($tytSceny): ?>
                    <h3 class="sen__scena-tytul"><?= htmlspecialchars($tytSceny) ?></h3>
                    <?php endif; ?>
                    <?php if ($narrTekst): ?>
                    <p class="sen__scena-narracja">"<?= htmlspecialchars($narrTekst) ?>"</p>
                    <?php endif; ?>
                    <div class="sen__scena-media">
                        <?php if ($narrSceny): ?>
                        <audio controls preload="none" class="sen__audio-maly">
                            <source src="/<?= htmlspecialchars($narrSceny) ?>" type="audio/mpeg">
                        </audio>
                        <?php endif; ?>
                        <?php if ($wideoSceny): ?>
                        <div class="sen__scena-wideo">
                            <video controls preload="none" class="sen__wideo-maly">
                                <source src="/<?= htmlspecialchars($wideoSceny) ?>" type="video/mp4">
                            </video>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </section>
        <?php endif; ?>

        <!-- Nawigacja powrót -->
        <nav class="sen__nawigacja-powrot" aria-label="<?= htmlspecialchars($j('sny.powrot')) ?>">
            <a href="<?= htmlspecialchars($urlPowrotu) ?>" class="sen__powrot">
                <?= htmlspecialchars($j('sny.powrot')) ?>
            </a>
            <a href="/sny" class="sen__powrot sen__powrot--sny">
                <?= htmlspecialchars($j('sny.archiwum')) ?>
            </a>
        </nav>

    </main>
    <?php endif; ?>

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
