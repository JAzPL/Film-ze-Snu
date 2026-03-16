<?php
/**
 * Wspolny fragment nawigacji — uzywany na wszystkich podstronach
 * Wymaga: $jezyk (obiekt Jezyk), $j (closure)
 */

$_aktualnaSciezka = $_SERVER['REQUEST_URI'] ?? '/';
$_czyAktywna = function (string $sciezka) use ($_aktualnaSciezka): string {
    return (strpos($_aktualnaSciezka, $sciezka) === 0) ? ' nawigacja__link--aktywna' : '';
};
?>
<nav class="kontener nawigacja" role="navigation" aria-label="<?= htmlspecialchars($j('menu.strona_glowna')) ?>">
    <a href="/" class="nawigacja__logo">🎬 <?= htmlspecialchars($j('naglowek.tytul')) ?></a>

    <ul class="nawigacja__menu">
        <li><a href="/"               class="nawigacja__link<?= $_czyAktywna('/') === ' nawigacja__link--aktywna' && strlen(parse_url($_aktualnaSciezka, PHP_URL_PATH)) <= 1 ? ' nawigacja__link--aktywna' : '' ?>"><?= htmlspecialchars($j('menu.strona_glowna')) ?></a></li>
        <li><a href="/jak-to-dziala"  class="nawigacja__link<?= $_czyAktywna('/jak-to-dziala') ?>"><?= htmlspecialchars($j('menu.jak_dziala')) ?></a></li>
        <li><a href="/sny"            class="nawigacja__link<?= $_czyAktywna('/sny') ?>"><?= htmlspecialchars($j('menu.sny')) ?></a></li>
        <li><a href="/sny/wszystkie"  class="nawigacja__link<?= $_czyAktywna('/sny/wszystkie') ?>"><?= htmlspecialchars($j('menu.wszystkie_sny')) ?></a></li>

        <!-- Wybor jezyka -->
        <li class="wybor-jezyka">
            <button class="wybor-jezyka__przycisk" id="przycisk-jezyka" aria-expanded="false" aria-haspopup="true">
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
                           class="wybor-jezyka__opcja<?= $kod === $aktualny ? ' wybor-jezyka__opcja--aktywna' : '' ?>"
                           role="menuitem"
                           lang="<?= htmlspecialchars($dane['kod_html']) ?>">
                            <?= htmlspecialchars($dane['ikona'] . ' ' . $dane['nazwa']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
    </ul>
</nav>
