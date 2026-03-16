<?php
/**
 * Dokumentacja aplikacji Film ze Snu
 * Wielojezyczna strona dokumentacji z automatycznym wykrywaniem jezyka
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../klasy/Jezyk.php';

$jezyk = new Jezyk(__DIR__ . '/jezyk');
$j = function (string $klucz, array $p = []) use ($jezyk): string {
    return $jezyk->t($klucz, $p);
};

$bazaUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
    . '://' . $_SERVER['HTTP_HOST']
    . strtok($_SERVER['REQUEST_URI'], '?');

$rok = date('Y');

// Skroty do sekcji docs
$d = function (string $klucz, array $p = []) use ($jezyk): string {
    return $jezyk->t('docs.' . $klucz, $p);
};
$s = function (string $sekcja, string $klucz, array $p = []) use ($jezyk): string {
    return $jezyk->t('docs.sekcje.' . $sekcja . '.' . $klucz, $p);
};

$sekcje = $jezyk->t('docs.sekcje');
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($jezyk->pobierzKodHtml()) ?>"
      dir="<?= $jezyk->pobierzKierunek() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"  content="<?= htmlspecialchars($d('opis_strony')) ?>">
    <meta name="keywords"     content="<?= htmlspecialchars($d('slowa_klucze')) ?>">
    <meta name="robots"       content="index, follow">

    <!-- Open Graph -->
    <meta property="og:title"       content="<?= htmlspecialchars($d('tytul_strony')) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($d('opis_strony')) ?>">
    <meta property="og:type"        content="website">
    <meta property="og:url"         content="<?= htmlspecialchars($bazaUrl) ?>">
    <meta property="og:locale"      content="<?= htmlspecialchars($jezyk->pobierzKodHtml()) ?>">

    <!-- Hreflang -->
    <?= $jezyk->generujHreflang($bazaUrl) ?>

    <title><?= htmlspecialchars($d('tytul_strony')) ?></title>

    <!-- Style -->
    <link rel="stylesheet" href="../wyglad/zmienne.css">
    <link rel="stylesheet" href="../wyglad/glowny.css">
    <link rel="stylesheet" href="../wyglad/naglowek.css">
    <link rel="stylesheet" href="../wyglad/menu.css">
    <link rel="stylesheet" href="../wyglad/stopka.css">
    <link rel="stylesheet" href="wyglad/dokumentacja.css">

    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "TechArticle",
        "name": "<?= htmlspecialchars($d('tytul_strony')) ?>",
        "description": "<?= htmlspecialchars($d('opis_strony')) ?>",
        "url": "<?= htmlspecialchars($bazaUrl) ?>",
        "inLanguage": "<?= htmlspecialchars($jezyk->pobierzKodHtml()) ?>",
        "about": { "@type": "SoftwareApplication", "name": "Film ze Snu" }
    }
    </script>
</head>
<body>
    <a href="#docs-tresc" class="sr-only"><?= htmlspecialchars($j('menu.strona_glowna')) ?></a>

    <!-- ══ NAWIGACJA ══ -->
    <nav class="kontener nawigacja"
         role="navigation"
         aria-label="<?= htmlspecialchars($j('menu.strona_glowna')) ?>">

        <div class="nawigacja__logo">🎬 <?= $j('naglowek.tytul') ?></div>

        <ul class="nawigacja__menu">
            <li><a href="../index.php" class="nawigacja__link"><?= $j('menu.strona_glowna') ?></a></li>
            <li><a href="index.php"    class="nawigacja__link"
                   aria-current="page"><?= $j('menu.dokumentacja') ?></a></li>

            <!-- Wybor jezyka — dynamiczny -->
            <li class="wybor-jezyka">
                <button class="wybor-jezyka__przycisk"
                        id="przycisk-jezyka"
                        aria-expanded="false"
                        aria-haspopup="true">
                    <?php
                    $dostepne = $jezyk->pobierzDostepne();
                    $aktualny = $jezyk->pobierzAktualny();
                    echo htmlspecialchars($dostepne[$aktualny]['ikona'] . ' ' . $dostepne[$aktualny]['nazwa']);
                    ?>
                    <span aria-hidden="true">▾</span>
                </button>
                <ul class="wybor-jezyka__lista" id="lista-jezykow" role="menu">
                    <?php foreach ($dostepne as $kod => $dane): ?>
                        <li role="none">
                            <a href="?jezyk=<?= htmlspecialchars($kod) ?>"
                               class="wybor-jezyka__opcja <?= $kod === $aktualny ? 'wybor-jezyka__opcja--aktywna' : '' ?>"
                               role="menuitem"
                               lang="<?= htmlspecialchars($dane['kod_html']) ?>">
                                <?= htmlspecialchars($dane['ikona']) ?>
                                <?= htmlspecialchars($dane['nazwa']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- ══ NAGLOWEK DOKUMENTACJI ══ -->
    <header class="kontener naglowek">
        <h1 class="naglowek__tytul"><?= $d('tytul') ?></h1>
        <p class="naglowek__podtytul"><?= $d('podtytul') ?></p>
    </header>

    <!-- ══ LAYOUT — SIDEBAR + TRESC ══ -->
    <div class="kontener">
        <div class="docs-layout">

            <!-- ── SIDEBAR ── -->
            <aside class="docs-sidebar" aria-label="<?= $d('spis_tresci') ?>">
                <p class="docs-sidebar__tytul"><?= $d('spis_tresci') ?></p>

                <nav aria-label="<?= $d('spis_tresci') ?>">
                    <ul class="docs-nav">
                        <?php
                        $ids_sekcji = [
                            'o_aplikacji'    => $s('o_aplikacji', 'tytul'),
                            'wymagania'      => $s('wymagania', 'tytul'),
                            'instalacja'     => $s('instalacja', 'tytul'),
                            'struktura'      => $s('struktura', 'tytul'),
                            'modele'         => $s('modele', 'tytul'),
                            'jezyki'         => $s('jezyki', 'tytul'),
                            'api'            => $s('api', 'tytul'),
                            'proces'         => $s('proces', 'tytul'),
                            'seo'            => $s('seo', 'tytul'),
                            'faq'            => $s('faq', 'tytul'),
                            'bezpieczenstwo' => $s('bezpieczenstwo', 'tytul'),
                        ];
                        foreach ($ids_sekcji as $id => $tytul):
                        ?>
                            <li class="docs-nav__pozycja">
                                <a href="#sekcja-<?= $id ?>"
                                   class="docs-nav__link">
                                    <?= htmlspecialchars($tytul) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>

                <a href="index.php" class="docs-sidebar__wroc">
                    <?= $d('wroc') ?>
                </a>
            </aside>

            <!-- ── TRESC ── -->
            <main class="docs-tresc" id="docs-tresc">

                <!-- ════════════════════
                     1. O APLIKACJI
                ════════════════════ -->
                <section id="sekcja-o_aplikacji" class="docs-sekcja" aria-labelledby="h2-o_aplikacji">
                    <h2 id="h2-o_aplikacji" class="docs-h2"><?= $s('o_aplikacji', 'tytul') ?></h2>

                    <p class="docs-p"><?= htmlspecialchars($s('o_aplikacji', 'opis')) ?></p>

                    <h3 class="docs-h3"><?= $s('o_aplikacji', 'co_robi') ?></h3>

                    <ul class="docs-lista">
                        <?php foreach ($s('o_aplikacji', 'kroki') as $krok): ?>
                            <li><?= htmlspecialchars($krok) ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <h3 class="docs-h3"><?= $s('o_aplikacji', 'technologie_tytul') ?></h3>

                    <div class="docs-tech-siatka">
                        <?php foreach ($s('o_aplikacji', 'technologie') as $tech): ?>
                            <div class="docs-tech-karta">
                                <div class="docs-tech-karta__nazwa"><?= htmlspecialchars($tech['nazwa']) ?></div>
                                <div class="docs-tech-karta__opis"><?= htmlspecialchars($tech['opis']) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>

                <!-- ════════════════════
                     2. WYMAGANIA
                ════════════════════ -->
                <section id="sekcja-wymagania" class="docs-sekcja" aria-labelledby="h2-wymagania">
                    <h2 id="h2-wymagania" class="docs-h2"><?= $s('wymagania', 'tytul') ?></h2>

                    <h3 class="docs-h3"><?= $s('wymagania', 'serwer_tytul') ?></h3>

                    <div class="docs-tabela-kontener">
                        <table class="docs-tabela">
                            <thead>
                                <tr>
                                    <th scope="col">Komponent</th>
                                    <th scope="col">Wersja</th>
                                    <th scope="col">Uwagi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($s('wymagania', 'serwer') as $w): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($w['nazwa']) ?></td>
                                        <td><code><?= htmlspecialchars($w['wersja']) ?></code></td>
                                        <td><?= htmlspecialchars($w['opis']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <h3 class="docs-h3"><?= $s('wymagania', 'przegladarka_tytul') ?></h3>

                    <ul class="docs-lista">
                        <?php foreach ($s('wymagania', 'przegladarka') as $p): ?>
                            <li><?= htmlspecialchars($p) ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <h3 class="docs-h3"><?= $s('wymagania', 'api_tytul') ?></h3>

                    <p class="docs-p"><?= htmlspecialchars($s('wymagania', 'api_opis')) ?></p>

                    <ol class="docs-kroki">
                        <?php foreach ($s('wymagania', 'api_kroki') as $krok): ?>
                            <li><?= htmlspecialchars($krok) ?></li>
                        <?php endforeach; ?>
                    </ol>

                    <div class="docs-alert docs-alert--ostrzezenie">
                        <span class="docs-alert__ikona">⚠️</span>
                        <span>Nigdy nie umieszczaj klucza <code>sk_</code> w kodzie JavaScript ani po stronie klienta! Uzyj klucza <code>pk_</code> (publishable) jesli musisz dzialac po stronie przegladarki.</span>
                    </div>
                </section>

                <!-- ════════════════════
                     3. INSTALACJA
                ════════════════════ -->
                <section id="sekcja-instalacja" class="docs-sekcja" aria-labelledby="h2-instalacja">
                    <h2 id="h2-instalacja" class="docs-h2"><?= $s('instalacja', 'tytul') ?></h2>

                    <!-- Krok 1 -->
                    <h3 class="docs-h3"><?= $s('instalacja', 'krok1_tytul') ?></h3>
                    <p class="docs-p"><?= htmlspecialchars($s('instalacja', 'krok1_opis')) ?></p>

                    <!-- Krok 2 -->
                    <h3 class="docs-h3"><?= $s('instalacja', 'krok2_tytul') ?></h3>
                    <p class="docs-p"><?= htmlspecialchars($s('instalacja', 'krok2_opis')) ?></p>
                    <div class="docs-kod">
                        <span class="docs-kod__etykieta">konfiguracja/klucz_api.php</span>
                        <pre>&lt;?php
return [
    'klucz'    =&gt; 'sk_TWOJ_KLUCZ_API_TUTAJ',
    'baza_url' =&gt; 'https://gen.pollinations.ai',
];</pre>
                    </div>

                    <!-- Krok 3 -->
                    <h3 class="docs-h3"><?= $s('instalacja', 'krok3_tytul') ?></h3>
                    <p class="docs-p"><?= htmlspecialchars($s('instalacja', 'krok3_opis')) ?></p>
                    <div class="docs-kod">
                        <span class="docs-kod__etykieta">bash</span>
                        <pre>mkdir -p projekty
chmod 755 projekty
# Lub na niektorych serwerach:
chmod 777 projekty</pre>
                    </div>

                    <!-- Krok 4 -->
                    <h3 class="docs-h3"><?= $s('instalacja', 'krok4_tytul') ?></h3>
                    <p class="docs-p"><?= htmlspecialchars($s('instalacja', 'krok4_apache')) ?></p>
                    <div class="docs-kod">
                        <span class="docs-kod__etykieta">.htaccess (Apache)</span>
                        <pre># Wymagane dla mod_rewrite
Options -Indexes
AllowOverride All</pre>
                    </div>
                    <p class="docs-p"><?= htmlspecialchars($s('instalacja', 'krok4_nginx')) ?></p>
                    <div class="docs-kod">
                        <span class="docs-kod__etykieta">nginx.conf</span>
                        <pre>location / {
    try_files $uri $uri/ /index.php?$query_string;
}</pre>
                    </div>

                    <!-- Krok 5 -->
                    <h3 class="docs-h3"><?= $s('instalacja', 'krok5_tytul') ?></h3>
                    <p class="docs-p"><?= htmlspecialchars($s('instalacja', 'krok5_opis')) ?></p>

                    <!-- Lokalnie -->
                    <h4 class="docs-h4"><?= $s('instalacja', 'lokalne_php_tytul') ?></h4>
                    <div class="docs-kod">
                        <span class="docs-kod__etykieta">bash</span>
                        <pre># Uruchom wbudowany serwer PHP
php -S localhost:8000

# Otworz w przegladarce
# http://localhost:8000</pre>
                    </div>

                    <div class="docs-alert docs-alert--info">
                        <span class="docs-alert__ikona">ℹ️</span>
                        <span>Na <code>localhost</code> MediaRecorder API dziala bez HTTPS — mozna nagrac glos w trakcie testowania.</span>
                    </div>
                </section>

                <!-- ════════════════════
                     4. STRUKTURA
                ════════════════════ -->
                <section id="sekcja-struktura" class="docs-sekcja" aria-labelledby="h2-struktura">
                    <h2 id="h2-struktura" class="docs-h2"><?= $s('struktura', 'tytul') ?></h2>

                    <p class="docs-p"><?= htmlspecialchars($s('struktura', 'opis')) ?></p>

                    <div class="docs-kod">
                        <span class="docs-kod__etykieta">drzewo katalogow</span>
                        <pre>film-ze-snu/
├── konfiguracja/
│   ├── klucz_api.php
│   └── modele.php
├── klasy/
│   ├── Api.php
│   ├── Jezyk.php
│   └── Generator.php
├── jezyk/
│   ├── pl.php
│   ├── en.php
│   └── [de.php, fr.php ...]
├── wyglad/
│   ├── zmienne.css
│   ├── glowny.css
│   ├── naglowek.css
│   ├── menu.css
│   ├── formularz.css
│   ├── postep.css
│   ├── sceny.css
│   ├── odtwarzacz.css
│   ├── stopka.css
│   └── dokumentacja.css
├── projekty/
│   └── sen_20241201_143022_a1b2c3d4/
│       ├── obrazy/
│       ├── narracja/
│       ├── muzyka/
│       ├── wideo/
│       └── scenariusz.json
├── index.php
├── dokumentacja.php
├── przetwarzanie.php
├── .htaccess
└── robots.txt</pre>
                    </div>

                    <div class="docs-katalogi">
                        <?php foreach ($s('struktura', 'katalogi') as $kat): ?>
                            <div class="docs-katalog-karta">
                                <div class="docs-katalog-karta__naglowek">
                                    <span class="docs-katalog-karta__ikona"><?= htmlspecialchars($kat['ikona']) ?></span>
                                    <span class="docs-katalog-karta__nazwa"><?= htmlspecialchars($kat['nazwa']) ?></span>
                                </div>
                                <div class="docs-katalog-karta__opis"><?= htmlspecialchars($kat['opis']) ?></div>
                                <ul class="docs-katalog-karta__pliki">
                                    <?php foreach ($kat['pliki'] as $plik): ?>
                                        <li class="docs-katalog-karta__plik">
                                            <span class="docs-katalog-karta__plik-nazwa"><?= htmlspecialchars($plik['nazwa']) ?></span>
                                            <span class="docs-katalog-karta__plik-opis"><?= htmlspecialchars($plik['opis']) ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>

                <!-- ════════════════════
                     5. MODELE AI
                ════════════════════ -->
                <section id="sekcja-modele" class="docs-sekcja" aria-labelledby="h2-modele">
                    <h2 id="h2-modele" class="docs-h2"><?= $s('modele', 'tytul') ?></h2>

                    <p class="docs-p"><?= htmlspecialchars($s('modele', 'opis')) ?></p>

                    <div class="docs-alert docs-alert--info">
                        <span class="docs-alert__ikona">🎲</span>
                        <span><?= htmlspecialchars($s('modele', 'jak_dzialaj')) ?></span>
                    </div>

                    <h3 class="docs-h3"><?= $s('modele', 'dostepne_tytul') ?></h3>

                    <div class="docs-tabela-kontener">
                        <table class="docs-tabela">
                            <thead>
                                <tr>
                                    <th scope="col"><?= $s('modele', 'tabela.zadanie') ?></th>
                                    <th scope="col"><?= $s('modele', 'tabela.modele') ?></th>
                                    <th scope="col"><?= $s('modele', 'tabela.opis') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($s('modele', 'modele_lista') as $m): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($m['zadanie']) ?></td>
                                        <td><code><?= htmlspecialchars($m['modele']) ?></code></td>
                                        <td><?= htmlspecialchars($m['opis']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <h4 class="docs-h4">Przyklad konfiguracji modeli</h4>
                    <div class="docs-kod">
                        <span class="docs-kod__etykieta">konfiguracja/modele.php</span>
                        <pre>return [
    'tekst' =&gt; [
        'najlepsze' =&gt; ['openai-large', 'claude', 'gemini'],
        'zapasowe'  =&gt; ['openai', 'openai-fast'],
    ],
    'obraz' =&gt; [
        'najlepsze' =&gt; ['gptimage-large', 'seedream-pro', 'imagen-4'],
        'zapasowe'  =&gt; ['flux', 'gptimage'],
    ],
    // ...
];</pre>
                    </div>
                </section>

                <!-- ════════════════════
                     6. JEZYKI
                ════════════════════ -->
                <section id="sekcja-jezyki" class="docs-sekcja" aria-labelledby="h2-jezyki">
                    <h2 id="h2-jezyki" class="docs-h2"><?= $s('jezyki', 'tytul') ?></h2>

                    <p class="docs-p"><?= htmlspecialchars($s('jezyki', 'opis')) ?></p>

                    <h3 class="docs-h3"><?= $s('jezyki', 'jak_dodac_tytul') ?></h3>

                    <ol class="docs-kroki">
                        <?php foreach ($s('jezyki', 'jak_dodac_kroki') as $krok): ?>
                            <li><?= htmlspecialchars($krok) ?></li>
                        <?php endforeach; ?>
                    </ol>

                    <h4 class="docs-h4">Przyklad pliku jezykowego (de.php)</h4>
                    <div class="docs-kod">
                        <span class="docs-kod__etykieta">jezyk/de.php</span>
                        <pre>&lt;?php
return [
    '_meta' =&gt; [
        'nazwa'    =&gt; 'Deutsch',
        'ikona'    =&gt; '🇩🇪',
        'kierunek' =&gt; 'ltr',
        'kod_html' =&gt; 'de',
    ],
    'naglowek' =&gt; [
        'tytul'    =&gt; '🎬 Traumfilm',
        'podtytul' =&gt; 'Verwandle deinen Traum ...',
    ],
    // ... reszta kluczy
];</pre>
                    </div>

                    <h3 class="docs-h3"><?= $s('jezyki', 'meta_tytul') ?></h3>

                    <div class="docs-tabela-kontener">
                        <table class="docs-tabela">
                            <thead>
                                <tr>
                                    <th scope="col">Pole</th>
                                    <th scope="col">Opis</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($s('jezyki', 'meta_pola') as $pole): ?>
                                    <tr>
                                        <td><code><?= htmlspecialchars($pole['pole']) ?></code></td>
                                        <td><?= htmlspecialchars($pole['opis']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <h3 class="docs-h3"><?= $s('jezyki', 'detekcja_tytul') ?></h3>
                    <p class="docs-p"><?= htmlspecialchars($s('jezyki', 'detekcja_opis')) ?></p>

                    <div class="docs-detekcja" role="list">
                        <div class="docs-detekcja__wiersz docs-detekcja__wiersz--naglowek" role="listitem">
                            <span>#</span>
                            <span>Zrodlo</span>
                            <span>Przyklad</span>
                            <span>Opis</span>
                        </div>
                        <?php foreach ($s('jezyki', 'detekcja_kroki') as $krok): ?>
                            <div class="docs-detekcja__wiersz" role="listitem">
                                <div class="docs-detekcja__priorytet"><?= htmlspecialchars($krok['priorytet']) ?></div>
                                <span><?= htmlspecialchars($krok['zrodlo']) ?></span>
                                <span class="docs-detekcja__kod"><?= htmlspecialchars($krok['przyklad']) ?></span>
                                <span style="font-size: var(--rozmiar-xs); color: var(--kolor-tekst-przygaszony);"><?= htmlspecialchars($krok['opis']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <h3 class="docs-h3"><?= $s('jezyki', 'ai_jezyk_tytul') ?></h3>
                    <p class="docs-p"><?= htmlspecialchars($s('jezyki', 'ai_jezyk_opis')) ?></p>

                    <div class="docs-alert docs-alert--sukces">
                        <span class="docs-alert__ikona">✅</span>
                        <span>AI automatycznie dostosowuje jezyk generowanego scenariusza i narracji do jezyka interfejsu wybranego przez uzytkownika.</span>
                    </div>
                </section>

                <!-- ════════════════════
                     7. API
                ════════════════════ -->
                <section id="sekcja-api" class="docs-sekcja" aria-labelledby="h2-api">
                    <h2 id="h2-api" class="docs-h2"><?= $s('api', 'tytul') ?></h2>

                    <p class="docs-p"><?= htmlspecialchars($s('api', 'opis')) ?></p>

                    <h3 class="docs-h3"><?= $s('api', 'auth_tytul') ?></h3>
                    <p class="docs-p"><?= htmlspecialchars($s('api', 'auth_opis')) ?></p>

                    <div class="docs-kod">
                        <span class="docs-kod__etykieta">HTTP header</span>
                        <pre>Authorization: Bearer sk_TWOJ_KLUCZ_API</pre>
                    </div>

                    <!-- Tabela endpointow -->
                    <div class="docs-tabela-kontener">
                        <table class="docs-tabela">
                            <thead>
                                <tr>
                                    <th scope="col">Metoda</th>
                                    <th scope="col">Endpoint</th>
                                    <th scope="col">Opis</th>
                                    <th scope="col">Klasa PHP</th>
                                    <th scope="col">Typ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($s('api', 'endpointy') as $ep): ?>
                                    <tr>
                                        <td>
                                            <span class="badge-metoda badge-metoda--<?= strtolower($ep['metoda']) ?>">
                                                <?= htmlspecialchars($ep['metoda']) ?>
                                            </span>
                                        </td>
                                        <td><code><?= htmlspecialchars($ep['endpoint']) ?></code></td>
                                        <td><?= htmlspecialchars($ep['opis']) ?></td>
                                        <td><code><?= htmlspecialchars($ep['klasa']) ?></code></td>
                                        <td>
                                            <span class="badge-kategoria badge-kategoria--<?= htmlspecialchars($ep['badge']) ?>">
                                                <?= htmlspecialchars($ep['badge']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Przyklad uzycia API -->
                    <h4 class="docs-h4">Przyklad — generowanie obrazu sceny</h4>
                    <div class="docs-kod">
                        <span class="docs-kod__etykieta">PHP</span>
                        <pre>$api = new Api($klucz, 'https://gen.pollinations.ai');

// Generuj obraz sceny
$dane = $api->generujObraz(
    prompt: 'surreal misty forest with glowing butterflies, cinematic',
    model: 'gptimage-large',
    szerokosc: 1280,
    wysokosc: 720,
    ulepszenie: true
);

file_put_contents('scena_1.jpg', $dane);</pre>
                    </div>

                    <h4 class="docs-h4">Przyklad — transkrypcja nagrania</h4>
                    <div class="docs-kod">
                        <span class="docs-kod__etykieta">PHP</span>
                        <pre>$wynik = $api->transkrybujAudio(
    sciezkaPliku: '/tmp/nagranie_snu.webm',
    jezyk: 'pl',
    model: 'whisper-large-v3'
);

$tekstSnu = $wynik['text'];
// "Snilo mi sie ze lecialem nad oceanem..."</pre>
                    </div>

                    <!-- Bledy -->
                    <h3 class="docs-h3"><?= $s('api', 'bledy_tytul') ?></h3>

                    <div class="docs-tabela-kontener">
                        <table class="docs-tabela">
                            <thead>
                                <tr>
                                    <th scope="col">Kod</th>
                                    <th scope="col">Nazwa</th>
                                    <th scope="col">Opis</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($s('api', 'bledy') as $bl): ?>
                                    <tr>
                                        <td>
                                            <span class="badge-blad badge-blad--<?= $bl['kod'][0] === '5' ? '5xx' : '4xx' ?>">
                                                <?= htmlspecialchars($bl['kod']) ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($bl['nazwa']) ?></td>
                                        <td><?= htmlspecialchars($bl['opis']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Format bledu JSON -->
                    <h4 class="docs-h4">Format odpowiedzi bledu</h4>
                    <div class="docs-kod">
                        <span class="docs-kod__etykieta">JSON</span>
                        <pre>{
  "status": 401,
  "success": false,
  "error": {
    "code": "UNAUTHORIZED",
    "message": "Missing or invalid API key"
  }
}</pre>
                    </div>
                </section>

                <!-- ════════════════════
                     8. PROCES
                ════════════════════ -->
                <section id="sekcja-proces" class="docs-sekcja" aria-labelledby="h2-proces">
                    <h2 id="h2-proces" class="docs-h2"><?= $s('proces', 'tytul') ?></h2>

                    <p class="docs-p"><?= htmlspecialchars($s('proces', 'opis')) ?></p>

                    <div class="docs-proces-kroki">
                        <?php foreach ($s('proces', 'kroki') as $krok): ?>
                            <div class="docs-proces-krok">
                                <div class="docs-proces-krok__nr"><?= htmlspecialchars($krok['nr']) ?></div>
                                <div class="docs-proces-krok__tresc">
                                    <div class="docs-proces-krok__tytul"><?= htmlspecialchars($krok['tytul']) ?></div>
                                    <div class="docs-proces-krok__opis"><?= htmlspecialchars($krok['opis']) ?></div>
                                    <div class="docs-proces-krok__meta">
                                        <span class="docs-proces-krok__ajax"><code><?= htmlspecialchars($krok['ajax']) ?></code></span>
                                        <span class="docs-proces-krok__czas">⏱ <?= htmlspecialchars($krok['czas']) ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Diagram przeplywu -->
                    <h4 class="docs-h4">Diagram przeplywu danych</h4>
                    <div class="docs-kod">
                        <span class="docs-kod__etykieta">ASCII diagram</span>
                        <pre>Uzytkownik
    │
    ├── wpisuje tekst snu
    │   └── [walidacja JS + PHP]
    │
    └── nagrywa glos snu
        └── MediaRecorder API
            └── POST /v1/audio/transcriptions
                └── tekst snu

Tekst snu
    │
    └── POST /v1/chat/completions  (model: openai-large / claude / gemini)
        └── scenariusz.json
            ├── tytul, gatunek, nastroj
            └── sceny[4]
                ├── opis_wizualny
                ├── narracja
                ├── nastroj_muzyczny
                └── opis_wideo

Dla kazdej sceny (x4):
    │
    ├── GET /image/{opis_wizualny}   → scena_N.jpg
    ├── GET /audio/{narracja}        → scena_N.mp3 (narracja)
    ├── GET /audio/{nastroj}         → scena_N.mp3 (muzyka)
    └── GET /video/{opis_wideo}      → scena_N.mp4 (opcjonalnie)

Wynik:
    └── Odtwarzacz HTML
        ├── Pokaz slajdow (obrazy)
        ├── Narracja glosowa (synchronizacja)
        └── Muzyka tla (0.25 vol)</pre>
                    </div>
                </section>

                <!-- ════════════════════
                     9. SEO
                ════════════════════ -->
                <section id="sekcja-seo" class="docs-sekcja" aria-labelledby="h2-seo">
                    <h2 id="h2-seo" class="docs-h2"><?= $s('seo', 'tytul') ?></h2>

                    <div class="docs-trzy-kolumny">
                        <!-- SEO -->
                        <div class="docs-lista-kolumna">
                            <div class="docs-lista-kolumna__tytul">🔍 <?= $s('seo', 'seo_tytul') ?></div>
                            <ul class="docs-lista">
                                <?php foreach ($s('seo', 'seo_lista') as $p): ?>
                                    <li><?= htmlspecialchars($p) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <!-- Dostepnosc -->
                        <div class="docs-lista-kolumna">
                            <div class="docs-lista-kolumna__tytul">♿ <?= $s('seo', 'a11y_tytul') ?></div>
                            <ul class="docs-lista">
                                <?php foreach ($s('seo', 'a11y_lista') as $p): ?>
                                    <li><?= htmlspecialchars($p) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <!-- RWD -->
                        <div class="docs-lista-kolumna">
                            <div class="docs-lista-kolumna__tytul">📱 <?= $s('seo', 'rwd_tytul') ?></div>
                            <ul class="docs-lista">
                                <?php foreach ($s('seo', 'rwd_lista') as $p): ?>
                                    <li><?= htmlspecialchars($p) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Hreflang przyklad -->
                    <h4 class="docs-h4">Automatyczne generowanie hreflang</h4>
                    <div class="docs-kod">
                        <span class="docs-kod__etykieta">HTML output (auto)</span>
                        <pre>&lt;link rel="alternate" hreflang="pl"
      href="https://twoja-domena.pl/?jezyk=pl" /&gt;
&lt;link rel="alternate" hreflang="en-GB"
      href="https://twoja-domena.pl/?jezyk=en" /&gt;
&lt;link rel="alternate" hreflang="x-default"
      href="https://twoja-domena.pl/" /&gt;</pre>
                    </div>
                </section>

                <!-- ════════════════════
                     10. FAQ
                ════════════════════ -->
                <section id="sekcja-faq" class="docs-sekcja" aria-labelledby="h2-faq">
                    <h2 id="h2-faq" class="docs-h2"><?= $s('faq', 'tytul') ?></h2>

                    <div class="docs-faq">
                        <?php foreach ($s('faq', 'pytania') as $i => $pq): ?>
                            <div class="docs-faq__pytanie" id="faq-<?= $i ?>">
                                <button
                                    class="docs-faq__pytanie-przycisk"
                                    aria-expanded="false"
                                    aria-controls="faq-odp-<?= $i ?>">
                                    <?= htmlspecialchars($pq['q']) ?>
                                    <span class="docs-faq__strzalka" aria-hidden="true">▾</span>
                                </button>
                                <div
                                    class="docs-faq__odpowiedz"
                                    id="faq-odp-<?= $i ?>"
                                    role="region">
                                    <?= htmlspecialchars($pq['a']) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>

                <!-- ════════════════════
                     11. BEZPIECZENSTWO
                ════════════════════ -->
                <section id="sekcja-bezpieczenstwo" class="docs-sekcja" aria-labelledby="h2-bezp">
                    <h2 id="h2-bezp" class="docs-h2"><?= $s('bezpieczenstwo', 'tytul') ?></h2>

                    <div class="docs-bezp-siatka">
                        <?php foreach ($s('bezpieczenstwo', 'lista') as $poz): ?>
                            <div class="docs-bezp-karta">
                                <div class="docs-bezp-karta__tytul"><?= htmlspecialchars($poz['tytul']) ?></div>
                                <div class="docs-bezp-karta__opis"><?= htmlspecialchars($poz['opis']) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <h4 class="docs-h4">Checklist bezpieczenstwa przed wdrozeniem</h4>
                    <ul class="docs-lista">
                        <li>✅ Klucz <code>sk_</code> tylko w <code>konfiguracja/klucz_api.php</code></li>
                        <li>✅ Katalog <code>konfiguracja/</code> zablokowany w <code>.htaccess</code></li>
                        <li>✅ Katalog <code>klasy/</code> zablokowany w <code>.htaccess</code></li>
                        <li>✅ <code>Options -Indexes</code> — brak listowania katalogow</li>
                        <li>✅ Naglowki HTTP bezpieczenstwa ustawione</li>
                        <li>✅ HTTPS wlaczony na serwerze produkcyjnym</li>
                        <li>✅ PHP <code>display_errors = Off</code> w produkcji</li>
                        <li>✅ Folder <code>projekty/</code> ma uprawnienia 755, nie 777</li>
                    </ul>

                    <div class="docs-alert docs-alert--ostrzezenie">
                        <span class="docs-alert__ikona">⚠️</span>
                        <span>Regularnie czys folder <code>projekty/</code> z wygenerowanych plikow — szczegolnie plikow wideo MP4, ktore moga zajmowac duzo miejsca na dysku.</span>
                    </div>
                </section>

            </main>
            <!-- koniec docs-tresc -->

        </div>
        <!-- koniec docs-layout -->
    </div>
    <!-- koniec kontener -->

    <!-- ══ STOPKA ══ -->
    <footer class="kontener stopka">
        <p class="stopka__tekst"><?= $j('stopka.tekst') ?></p>
        <p class="stopka__prawa"><?= $j('stopka.prawa', ['rok' => $rok]) ?></p>
        <div class="stopka__technologie">
            <span class="stopka__tech-badge">Pollinations AI</span>
            <span class="stopka__tech-badge">PHP</span>
            <span class="stopka__tech-badge">JavaScript</span>
            <span class="stopka__tech-badge">CSS3</span>
        </div>
    </footer>

    <!-- ══ JavaScript ══ -->
    <script>
    (function () {
        'use strict';

        // ── Menu jezyka ──
        const przycisk = document.getElementById('przycisk-jezyka');
        const lista = document.getElementById('lista-jezykow');

        if (przycisk && lista) {
            przycisk.addEventListener('click', function (e) {
                e.stopPropagation();
                const aktywna = lista.classList.toggle('wybor-jezyka__lista--aktywna');
                przycisk.setAttribute('aria-expanded', aktywna);
            });
            document.addEventListener('click', function () {
                lista.classList.remove('wybor-jezyka__lista--aktywna');
                przycisk.setAttribute('aria-expanded', 'false');
            });
        }

        // ── FAQ Accordion ──
        document.querySelectorAll('.docs-faq__pytanie-przycisk').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const pytanie = btn.closest('.docs-faq__pytanie');
                const czyAktywne = pytanie.classList.contains('docs-faq__pytanie--aktywne');

                // Zamknij wszystkie
                document.querySelectorAll('.docs-faq__pytanie--aktywne').forEach(function (el) {
                    el.classList.remove('docs-faq__pytanie--aktywne');
                    el.querySelector('.docs-faq__pytanie-przycisk').setAttribute('aria-expanded', 'false');
                });

                // Otworz klikniete jesli bylo zamkniete
                if (!czyAktywne) {
                    pytanie.classList.add('docs-faq__pytanie--aktywne');
                    btn.setAttribute('aria-expanded', 'true');
                }
            });
        });

        // ── Aktywny link w sidebar (Intersection Observer) ──
        const linki = document.querySelectorAll('.docs-nav__link');
        const sekcje = document.querySelectorAll('.docs-sekcja');

        if ('IntersectionObserver' in window && sekcje.length > 0) {
            const obs = new IntersectionObserver(function (wpisy) {
                wpisy.forEach(function (wpis) {
                    if (wpis.isIntersecting) {
                        const id = wpis.target.id;
                        linki.forEach(function (link) {
                            link.classList.toggle(
                                'docs-nav__link--aktywny',
                                link.getAttribute('href') === '#' + id
                            );
                        });
                    }
                });
            }, { rootMargin: '-20% 0px -75% 0px' });

            sekcje.forEach(function (s) { obs.observe(s); });
        }

        // ── Plyn przewijanie dla linkow kotwicowych ──
        document.querySelectorAll('a[href^="#"]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                const cel = document.querySelector(link.getAttribute('href'));
                if (cel) {
                    e.preventDefault();
                    cel.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    cel.setAttribute('tabindex', '-1');
                    cel.focus({ preventScroll: true });
                }
            });
        });

    })();
    </script>
</body>
</html>