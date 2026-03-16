<?php
/**
 * Strona "Jak to dziala?" — Film ze Snu
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/klasy/Jezyk.php';

$jezyk = new Jezyk(__DIR__ . '/jezyk');
$j = function (string $klucz, array $p = []) use ($jezyk) {
    return $jezyk->t($klucz, $p);
};

$bazaUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
    . '://' . $_SERVER['HTTP_HOST'] . '/jak-to-dziala';

$rok = date('Y');
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($jezyk->pobierzKodHtml()) ?>" dir="<?= $jezyk->pobierzKierunek() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($j('jak_dziala.opis')) ?>">

    <meta property="og:title"       content="<?= htmlspecialchars($j('jak_dziala.tytul')) ?> — <?= htmlspecialchars($j('naglowek.tytul')) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($j('jak_dziala.opis')) ?>">
    <meta property="og:type"        content="website">
    <meta property="og:url"         content="<?= htmlspecialchars($bazaUrl) ?>">

    <?= $jezyk->generujHreflang($bazaUrl) ?>

    <title><?= htmlspecialchars($j('jak_dziala.tytul')) ?> — <?= htmlspecialchars($j('naglowek.tytul')) ?></title>

    <link rel="stylesheet" href="/wyglad/zmienne.css">
    <link rel="stylesheet" href="/wyglad/glowny.css">
    <link rel="stylesheet" href="/wyglad/naglowek.css">
    <link rel="stylesheet" href="/wyglad/menu.css">
    <link rel="stylesheet" href="/wyglad/stopka.css">
    <link rel="stylesheet" href="/wyglad/sny.css">
</head>
<body>
    <a href="#tresc-glowna" class="sr-only"><?= $j('menu.strona_glowna') ?></a>

    <!-- ══ NAWIGACJA ══ -->
    <?php require __DIR__ . '/fragmenty/nawigacja.php'; ?>

    <!-- ══ NAGLOWEK ══ -->
    <header class="kontener naglowek naglowek--maly">
        <h1 class="naglowek__tytul naglowek__tytul--maly"><?= $j('jak_dziala.tytul') ?></h1>
        <p class="naglowek__podtytul"><?= $j('jak_dziala.opis') ?></p>
    </header>

    <!-- ══ TRESC ══ -->
    <main id="tresc-glowna" class="kontener kontener--waski" style="padding-bottom: var(--odstep-2xl);">

        <!-- Kroki -->
        <section class="jak-dziala__kroki sekcja" aria-label="<?= $j('jak_dziala.tytul') ?>">
            <?php
            $kroki = [
                ['jak_dziala.krok_1_tytul', 'jak_dziala.krok_1_opis', '✍️'],
                ['jak_dziala.krok_2_tytul', 'jak_dziala.krok_2_opis', '🤖'],
                ['jak_dziala.krok_3_tytul', 'jak_dziala.krok_3_opis', '🖼️'],
                ['jak_dziala.krok_4_tytul', 'jak_dziala.krok_4_opis', '🎤'],
                ['jak_dziala.krok_5_tytul', 'jak_dziala.krok_5_opis', '🎬'],
                ['jak_dziala.krok_6_tytul', 'jak_dziala.krok_6_opis', '🌙'],
            ];
            foreach ($kroki as [$tytulKey, $opisKey, $ikona]):
            ?>
            <article class="jak-dziala__krok">
                <div class="jak-dziala__krok-ikona" aria-hidden="true"><?= $ikona ?></div>
                <div class="jak-dziala__krok-tresc">
                    <h2 class="jak-dziala__krok-tytul"><?= htmlspecialchars($j($tytulKey)) ?></h2>
                    <p class="jak-dziala__krok-opis"><?= htmlspecialchars($j($opisKey)) ?></p>
                </div>
            </article>
            <?php endforeach; ?>
        </section>

        <!-- Technologie -->
        <section class="jak-dziala__tech sekcja">
            <h2 class="jak-dziala__sekcja-tytul"><?= htmlspecialchars($j('jak_dziala.technologie_tytul')) ?></h2>
            <p class="jak-dziala__sekcja-opis"><?= htmlspecialchars($j('jak_dziala.technologie_opis')) ?></p>
            <div class="jak-dziala__odznaki">
                <span class="stopka__tech-badge">Pollinations AI</span>
                <span class="stopka__tech-badge">PHP</span>
                <span class="stopka__tech-badge">JavaScript</span>
                <span class="stopka__tech-badge">CSS3</span>
                <span class="stopka__tech-badge">HTML5</span>
            </div>
        </section>

        <!-- FAQ -->
        <section class="jak-dziala__faq sekcja">
            <h2 class="jak-dziala__sekcja-tytul"><?= htmlspecialchars($j('jak_dziala.faq_tytul')) ?></h2>
            <?php
            $faqLista = [
                ['jak_dziala.faq_1_pytanie', 'jak_dziala.faq_1_odpowiedz'],
                ['jak_dziala.faq_2_pytanie', 'jak_dziala.faq_2_odpowiedz'],
                ['jak_dziala.faq_3_pytanie', 'jak_dziala.faq_3_odpowiedz'],
            ];
            foreach ($faqLista as $i => [$pytKey, $odpKey]):
            ?>
            <details class="jak-dziala__faq-element">
                <summary class="jak-dziala__faq-pytanie"><?= htmlspecialchars($j($pytKey)) ?></summary>
                <p class="jak-dziala__faq-odpowiedz"><?= htmlspecialchars($j($odpKey)) ?></p>
            </details>
            <?php endforeach; ?>
        </section>

        <!-- CTA -->
        <div class="jak-dziala__cta">
            <a href="/" class="jak-dziala__przycisk">✨ <?= htmlspecialchars($j('formularz.stworz')) ?></a>
        </div>

    </main>

    <!-- ══ STOPKA ══ -->
    <footer class="kontener stopka">
        <p class="stopka__tekst"><?= $j('stopka.tekst') ?></p>
        <p class="stopka__prawa"><?= $j('stopka.prawa', ['rok' => $rok]) ?></p>
    </footer>

    <script>
    // Jezyk dla nawigacji
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
