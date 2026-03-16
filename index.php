<?php
/**
 * Film ze Snu — Glowna strona aplikacji
 * Generator filmow z opisow snow przy uzyciu AI Pollinations
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
    . '://' . $_SERVER['HTTP_HOST'] . strtok($_SERVER['REQUEST_URI'], '?');

$rok = date('Y');
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($jezyk->pobierzKodHtml()) ?>" dir="<?= $jezyk->pobierzKierunek() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($j('strona.opis')) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($j('strona.slowa_klucze')) ?>">

    <!-- Open Graph -->
    <meta property="og:title" content="<?= htmlspecialchars($j('strona.tytul')) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($j('strona.opis')) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars($bazaUrl) ?>">
    <meta property="og:locale" content="<?= htmlspecialchars($jezyk->pobierzKodHtml()) ?>">

    <!-- Hreflang SEO -->
    <?= $jezyk->generujHreflang($bazaUrl) ?>

    <title><?= htmlspecialchars($j('strona.tytul')) ?></title>

    <!-- Style — kazdy komponent w osobnym pliku -->
    <link rel="stylesheet" href="wyglad/zmienne.css">
    <link rel="stylesheet" href="wyglad/glowny.css">
    <link rel="stylesheet" href="wyglad/naglowek.css">
    <link rel="stylesheet" href="wyglad/menu.css">
    <link rel="stylesheet" href="wyglad/formularz.css">
    <link rel="stylesheet" href="wyglad/postep.css">
    <link rel="stylesheet" href="wyglad/sceny.css">
    <link rel="stylesheet" href="wyglad/odtwarzacz.css">
    <link rel="stylesheet" href="wyglad/stopka.css">
    <link rel="stylesheet" href="wyglad/sny.css">

    <!-- Preconnect -->
    <link rel="preconnect" href="https://gen.pollinations.ai">

    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebApplication",
        "name": "<?= htmlspecialchars($j('strona.tytul')) ?>",
        "description": "<?= htmlspecialchars($j('strona.opis')) ?>",
        "applicationCategory": "MultimediaApplication",
        "operatingSystem": "Web",
        "offers": { "@type": "Offer", "price": "0", "priceCurrency": "PLN" }
    }
    </script>
</head>
<body>
    <a href="#tresc-glowna" class="sr-only"><?= $j('menu.strona_glowna') ?></a>

    <!-- ══ NAWIGACJA ══ -->
    <?php require __DIR__ . '/fragmenty/nawigacja.php'; ?>

    <!-- ══ NAGLOWEK ══ -->
    <header class="kontener naglowek">
        <h1 class="naglowek__tytul"><?= $j('naglowek.tytul') ?></h1>
        <p class="naglowek__podtytul"><?= $j('naglowek.podtytul') ?></p>
    </header>

    <!-- ══ TRESC GLOWNA ══ -->
    <main id="tresc-glowna" class="kontener kontener--waski">

        <!-- Formularz opisu snu -->
        <section class="sekcja" aria-label="<?= $j('formularz.tytul') ?>">
            <form class="formularz-snu" id="formularz-snu" novalidate>

                <h2 class="formularz-snu__tytul"><?= $j('formularz.tytul') ?></h2>

                <div class="formularz-snu__grupa">
                    <label for="opis-snu" class="formularz-snu__etykieta">
                        <?= $j('formularz.tytul') ?>
                    </label>
                    <textarea
                        id="opis-snu"
                        name="opis_snu"
                        class="formularz-snu__tekstarea"
                        placeholder="<?= htmlspecialchars($j('formularz.placeholder')) ?>"
                        required
                        minlength="20"
                        aria-describedby="opis-snu-info"
                    ></textarea>
                    <small id="opis-snu-info" class="formularz-snu__etykieta">
                        <?= $j('formularz.wymagane') ?>
                    </small>
                </div>

                <!-- Nagrywanie glosowe -->
                <div class="formularz-snu__separator"><?= $j('formularz.lub') ?></div>

                <div class="formularz-snu__grupa">
                    <button type="button" class="przycisk-nagrywania" id="przycisk-nagrywania">
                        <?= $j('formularz.nagraj_sen') ?>
                    </button>
                </div>

                <!-- Opcje -->
                <div class="formularz-snu__opcje">
                    <div>
                        <label for="typ-glosu" class="formularz-snu__etykieta"><?= $j('formularz.typ_glosu') ?></label>
                        <select id="typ-glosu" name="typ_glosu" class="formularz-snu__select">
                            <option value="narracja_tajemna"><?= $j('formularz.glos_tajemny') ?></option>
                            <option value="narracja_meska"><?= $j('formularz.glos_meski') ?></option>
                            <option value="narracja_zenska"><?= $j('formularz.glos_zenski') ?></option>
                        </select>
                    </div>

                    <label class="formularz-snu__checkbox-grupa">
                        <input type="checkbox" id="generuj-wideo" name="generuj_wideo" class="formularz-snu__checkbox">
                        <span><?= $j('formularz.generuj_wideo') ?></span>
                    </label>
                </div>

                <button type="submit" class="przycisk-generuj" id="przycisk-generuj">
                    <?= $j('formularz.stworz') ?>
                </button>
            </form>
        </section>

        <!-- Pasek postepu -->
        <section class="postep" id="sekcja-postep" aria-live="polite" aria-label="<?= $j('postep.tytul') ?>">
            <div class="postep__karta">
                <h2 class="postep__tytul"><?= $j('postep.tytul') ?></h2>
                <p class="postep__podtytul"><?= $j('postep.cierpliwosci') ?></p>

                <div class="postep__procent" id="postep-procent">0%</div>
                <div class="postep__pasek-kontener">
                    <div class="postep__pasek" id="postep-pasek" role="progressbar"
                         aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <ul class="postep__logi" id="postep-logi"></ul>
            </div>
        </section>

        <!-- Wynik — odtwarzacz -->
        <section class="odtwarzacz" id="sekcja-odtwarzacz" aria-label="<?= $j('odtwarzacz.tytul') ?>">
            <div class="odtwarzacz__kontener">
                <div class="odtwarzacz__ekran" id="odtwarzacz-ekran">
                    <!-- Obrazy/wideo scen wstawiane przez JS -->
                </div>
                <div class="odtwarzacz__nakladka" id="odtwarzacz-nakladka">
                    <div class="odtwarzacz__tytul-sceny" id="odtwarzacz-tytul-sceny"></div>
                    <div class="odtwarzacz__narracja-tekst" id="odtwarzacz-narracja-tekst"></div>
                </div>
            </div>

            <div class="odtwarzacz__kontrolki">
                <button class="odtwarzacz__przycisk" id="btn-poprzednia">
                    <?= $j('odtwarzacz.poprzednia') ?>
                </button>
                <button class="odtwarzacz__przycisk odtwarzacz__przycisk--glowny" id="btn-odtworz">
                    <?= $j('odtwarzacz.odtworz') ?>
                </button>
                <button class="odtwarzacz__przycisk" id="btn-nastepna">
                    <?= $j('odtwarzacz.nastepna') ?>
                </button>
                <button class="odtwarzacz__przycisk" id="btn-pelny-ekran">
                    <?= $j('odtwarzacz.pelny_ekran') ?>
                </button>
            </div>

            <div class="odtwarzacz__wskaznik" id="odtwarzacz-wskaznik">
                <!-- Kropki scen wstawiane przez JS -->
            </div>
        </section>

        <!-- Wynik — galeria scen -->
        <section class="wynik-filmu" id="sekcja-wynik" aria-label="<?= $j('sceny.scena', ['numer' => '']) ?>">

            <!-- Info o filmie -->
            <div class="film-info" id="film-info">
                <h2 class="film-info__tytul" id="film-tytul"></h2>
                <div class="film-info__meta" id="film-meta"></div>
            </div>

            <!-- Karty scen -->
            <div class="sceny-siatka" id="sceny-siatka">
                <!-- Generowane dynamicznie przez JS -->
            </div>
        </section>
    </main>

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

    <!-- Tlumaczenia dla JS -->
    <script>
        const JEZYK_AKTUALNY = '<?= $jezyk->pobierzAktualny() ?>';
        const TLUMACZENIA = <?= $jezyk->eksportujDoJson() ?>;
    </script>

    <!-- Glowny skrypt aplikacji -->
    <script>
    (function () {
        'use strict';

        // ── Tlumaczenie w JS ──
        function t(klucz, parametry = {}) {
            const czesci = klucz.split('.');
            let wartosc = TLUMACZENIA;
            for (const czesc of czesci) {
                if (wartosc && typeof wartosc === 'object' && czesc in wartosc) {
                    wartosc = wartosc[czesc];
                } else {
                    return klucz;
                }
            }
            if (typeof wartosc !== 'string') return klucz;
            for (const [nazwa, zawartosc] of Object.entries(parametry)) {
                wartosc = wartosc.replaceAll('{' + nazwa + '}', zawartosc);
            }
            return wartosc;
        }

        // ── Elementy DOM ──
        const formularz = document.getElementById('formularz-snu');
        const opisSnu = document.getElementById('opis-snu');
        const przyciskGeneruj = document.getElementById('przycisk-generuj');
        const przyciskNagrywania = document.getElementById('przycisk-nagrywania');
        const typGlosu = document.getElementById('typ-glosu');
        const generujWideo = document.getElementById('generuj-wideo');
        const sekcjaPostep = document.getElementById('sekcja-postep');
        const postepPasek = document.getElementById('postep-pasek');
        const postepProcent = document.getElementById('postep-procent');
        const postepLogi = document.getElementById('postep-logi');
        const sekcjaOdtwarzacz = document.getElementById('sekcja-odtwarzacz');
        const sekcjaWynik = document.getElementById('sekcja-wynik');
        const scenySiatka = document.getElementById('sceny-siatka');
        const filmTytul = document.getElementById('film-tytul');
        const filmMeta = document.getElementById('film-meta');
        const odtwarzaczEkran = document.getElementById('odtwarzacz-ekran');
        const odtwarzaczWskaznik = document.getElementById('odtwarzacz-wskaznik');
        const odtwarzaczTytulSceny = document.getElementById('odtwarzacz-tytul-sceny');
        const odtwarzaczNarracjaTekst = document.getElementById('odtwarzacz-narracja-tekst');

        // ── Stan aplikacji ──
        let daneFilmu = null;
        let aktualnaScena = 0;
        let czyOdtwarzanie = false;
        let audioNarracja = null;
        let audioMuzyka = null;
        let timerOdtwarzania = null;

        // ── Menu jezyka ──
        const przyciskJezyka = document.getElementById('przycisk-jezyka');
        const listaJezykow = document.getElementById('lista-jezykow');

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

        // ── Nagrywanie glosu ──
        let mediaRecorder = null;
        let nagraneDane = [];
        let czyNagrywanie = false;

        przyciskNagrywania.addEventListener('click', async function () {
            if (!czyNagrywanie) {
                try {
                    const strumien = await navigator.mediaDevices.getUserMedia({ audio: true });
                    mediaRecorder = new MediaRecorder(strumien);
                    nagraneDane = [];

                    mediaRecorder.ondataavailable = function (e) {
                        nagraneDane.push(e.data);
                    };

                    mediaRecorder.onstop = async function () {
                        const blob = new Blob(nagraneDane, { type: 'audio/webm' });
                        strumien.getTracks().forEach(t => t.stop());
                        await transkrybujNagranie(blob);
                    };

                    mediaRecorder.start();
                    czyNagrywanie = true;
                    przyciskNagrywania.textContent = t('formularz.nagrywanie');
                    przyciskNagrywania.classList.add('przycisk-nagrywania--aktywny');
                } catch (err) {
                    alert(t('bledy.brak_mikrofonu'));
                }
            } else {
                mediaRecorder.stop();
                czyNagrywanie = false;
                przyciskNagrywania.textContent = t('formularz.nagraj_sen');
                przyciskNagrywania.classList.remove('przycisk-nagrywania--aktywny');
            }
        });

        async function transkrybujNagranie(blob) {
            const dane = new FormData();
            dane.append('audio', blob, 'nagranie_snu.webm');
            dane.append('jezyk', JEZYK_AKTUALNY);

            try {
                przyciskNagrywania.textContent = '⏳ ...';
                const odp = await fetch('przetwarzanie.php', {
                    method: 'POST',
                    headers: { 'X-Krok': 'transkrypcja' },
                    body: dane,
                });
                const wynik = await odp.json();
                if (wynik.sukces && wynik.tekst) {
                    opisSnu.value = wynik.tekst;
                }
            } catch (err) {
                console.error('Blad transkrypcji:', err);
            } finally {
                przyciskNagrywania.textContent = t('formularz.nagraj_sen');
            }
        }

        // ── Postep ──
        let licznikKrokow = 0;
        let maxKrokow = 1;

        function ustawPostep(procent, komunikat) {
            postepPasek.style.width = procent + '%';
            postepPasek.setAttribute('aria-valuenow', procent);
            postepProcent.textContent = Math.round(procent) + '%';

            if (komunikat) {
                const li = document.createElement('li');
                li.className = 'postep__log';
                li.textContent = komunikat;
                postepLogi.appendChild(li);
                postepLogi.scrollTop = postepLogi.scrollHeight;
            }
        }

        function ustawPostepBlad(komunikat) {
            const li = document.createElement('li');
            li.className = 'postep__log postep__log--blad';
            li.textContent = komunikat;
            postepLogi.appendChild(li);
        }

        function ustawPostepSukces(komunikat) {
            const li = document.createElement('li');
            li.className = 'postep__log postep__log--sukces';
            li.textContent = komunikat;
            postepLogi.appendChild(li);
        }

        // ── Zapytanie do backendu ──
        async function zapytanieApi(dane) {
            const odp = await fetch('przetwarzanie.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dane),
            });

            const wynik = await odp.json();

            if (!wynik.sukces) {
                throw new Error(wynik.blad || 'Nieznany blad');
            }

            return wynik;
        }

        // ── GLOWNA LOGIKA GENEROWANIA ──
        formularz.addEventListener('submit', async function (e) {
            e.preventDefault();

            const opis = opisSnu.value.trim();
            if (opis.length < 20) {
                alert(t('bledy.za_krotki'));
                opisSnu.focus();
                return;
            }

            // Pokaz postep
            przyciskGeneruj.disabled = true;
            sekcjaPostep.classList.add('postep--aktywny');
            sekcjaOdtwarzacz.classList.remove('odtwarzacz--aktywny');
            sekcjaWynik.classList.remove('wynik-filmu--aktywny');
            postepLogi.innerHTML = '';

            const czyWideo = generujWideo.checked;

            // Oblicz max krokow: scenariusz(1) + na scene(obraz+narracja+muzyka[+wideo]) + montaz(1) + zapisz(1)
            const krokiNaScene = czyWideo ? 4 : 3;
            maxKrokow = 1 + (4 * krokiNaScene) + 1 + 1;
            licznikKrokow = 0;

            const postepKrok = () => {
                licznikKrokow++;
                return (licznikKrokow / maxKrokow) * 100;
            };

            try {
                // ── KROK 1: Scenariusz ──
                ustawPostep(2, t('postep.scenariusz'));

                const odpScenariusz = await zapytanieApi({
                    krok: 'scenariusz',
                    opis_snu: opis,
                    jezyk: JEZYK_AKTUALNY,
                });

                const scenariusz = odpScenariusz.scenariusz;
                const idProjektu = odpScenariusz.id_projektu;
                const urlProjektu = odpScenariusz.url_projektu;
                const iloscScen = scenariusz.sceny.length;

                // Przelicz kroki (+ 1 dla zapisu)
                maxKrokow = 1 + (iloscScen * krokiNaScene) + 1;
                ustawPostep(postepKrok(), '✅ ' + t('postep.scenariusz') + ' (' + scenariusz.tytul + ')');

                // Przygotuj dane filmu
                daneFilmu = {
                    tytul: scenariusz.tytul,
                    gatunek: scenariusz.gatunek,
                    nastroj: scenariusz.nastroj,
                    idProjektu: idProjektu,
                    urlProjektu: urlProjektu,
                    modelTekst: scenariusz._model_tekst,
                    sceny: [],
                };

                // ── KROK 2-N: Generuj zasoby dla kazdej sceny ──
                for (let i = 0; i < iloscScen; i++) {
                    const scena = scenariusz.sceny[i];
                    const nr = scena.numer || (i + 1);
                    const daneSceny = {
                        numer: nr,
                        tytul: scena.tytul_sceny,
                        narracja: scena.narracja,
                    };

                    // Obraz
                    ustawPostep(postepKrok(), t('postep.obraz', { numer: nr }));
                    const odpObraz = await zapytanieApi({
                        krok: 'obraz',
                        id_projektu: idProjektu,
                        numer_sceny: nr,
                        opis_wizualny: scena.opis_wizualny,
                    });
                    daneSceny.obraz = urlProjektu + '/' + odpObraz.plik;
                    daneSceny.modelObrazu = odpObraz.model;

                    // Narracja
                    ustawPostep(postepKrok(), t('postep.narracja', { numer: nr }));
                    const odpNarracja = await zapytanieApi({
                        krok: 'narracja',
                        id_projektu: idProjektu,
                        numer_sceny: nr,
                        tekst_narracji: scena.narracja,
                        typ_glosu: typGlosu.value,
                    });
                    daneSceny.narracja_plik = urlProjektu + '/' + odpNarracja.plik;
                    daneSceny.glos = odpNarracja.glos;

                    // Muzyka
                    ustawPostep(postepKrok(), t('postep.muzyka', { numer: nr }));
                    const odpMuzyka = await zapytanieApi({
                        krok: 'muzyka',
                        id_projektu: idProjektu,
                        numer_sceny: nr,
                        nastroj_muzyczny: scena.nastroj_muzyczny,
                    });
                    daneSceny.muzyka_plik = urlProjektu + '/' + odpMuzyka.plik;

                    // Wideo (opcjonalnie)
                    if (czyWideo) {
                        ustawPostep(postepKrok(), t('postep.wideo', { numer: nr }));
                        try {
                            const odpWideo = await zapytanieApi({
                                krok: 'wideo',
                                id_projektu: idProjektu,
                                numer_sceny: nr,
                                opis_wideo: scena.opis_wideo,
                                sciezka_obrazu: odpObraz.plik,
                            });
                            daneSceny.wideo_plik = urlProjektu + '/' + odpWideo.plik;
                            daneSceny.modelWideo = odpWideo.model;
                        } catch (err) {
                            ustawPostepBlad('⚠️ Wideo sceny ' + nr + ': ' + err.message);
                        }
                    }

                    daneFilmu.sceny.push(daneSceny);
                }

                // ── KROK MONTAZU ──
                ustawPostep(postepKrok(), t('postep.montaz'));
                try {
                    const odpMontaz = await zapytanieApi({
                        krok: 'montaz',
                        id_projektu: idProjektu,
                    });
                    daneFilmu.filmFinalny = urlProjektu + '/' + odpMontaz.plik;
                } catch (errMontaz) {
                    ustawPostepBlad('⚠️ Montaz: ' + errMontaz.message);
                }

                // ── KROK ZAPISU ──
                ustawPostep(postepKrok(), t('postep.zapisz'));
                try {
                    const odpZapisz = await zapytanieApi({
                        krok: 'zapisz',
                        id_projektu: idProjektu,
                        jezyk: JEZYK_AKTUALNY,
                        dane_snu: {
                            tytul:   scenariusz.tytul,
                            wstep:   scenariusz.wstep   || '',
                            gatunek: scenariusz.gatunek || '',
                            nastroj: scenariusz.nastroj || '',
                            sceny:   daneFilmu.sceny.map(function (s) {
                                return {
                                    numer:        s.numer,
                                    tytul:        s.tytul,
                                    narracja:     s.narracja,
                                    obraz:        s.obraz        || null,
                                    narracja_plik: s.narracja_plik || null,
                                    muzyka_plik:  s.muzyka_plik  || null,
                                    wideo_plik:   s.wideo_plik   || null,
                                };
                            }),
                        },
                    });
                    daneFilmu.urlSnu = odpZapisz.url;
                    daneFilmu.slug   = odpZapisz.slug;
                } catch (errZapis) {
                    // Zapis nie jest krytyczny — nie przerywaj
                    console.warn('Blad zapisu snu:', errZapis.message);
                }

                // ── GOTOWE ──
                ustawPostep(100, t('postep.gotowe'));
                ustawPostepSukces(t('postep.gotowe'));

                // Wyswietl wynik
                wyswietlFilm(daneFilmu);

            } catch (err) {
                ustawPostepBlad(t('postep.blad', { komunikat: err.message }));
                console.error('Blad generowania:', err);
            } finally {
                przyciskGeneruj.disabled = false;
            }
        });

        // ── WYSWIETLANIE FILMU ──
        function wyswietlFilm(dane) {
            // Info
            filmTytul.textContent = dane.tytul;
            const linkSnuHtml = dane.urlSnu
                ? `<a href="/${escHtml(dane.urlSnu)}" class="film-info__link-snu">${t('informacje.link_snu')}</a>`
                : '';
            filmMeta.innerHTML = `
                <span class="film-info__meta-element">🎭 ${escHtml(dane.gatunek)}</span>
                <span class="film-info__meta-element">🌙 ${escHtml(dane.nastroj)}</span>
                <span class="film-info__meta-element">🤖 ${escHtml(dane.modelTekst)}</span>
                <span class="film-info__meta-element">📁 ${escHtml(dane.idProjektu)}</span>
                ${linkSnuHtml}
            `;

            // Karty scen
            scenySiatka.innerHTML = '';
            dane.sceny.forEach(function (scena) {
                const karta = document.createElement('article');
                karta.className = 'scena-karta';

                let wideoHtml = '';
                if (scena.wideo_plik) {
                    wideoHtml = `
                        <button class="przycisk-media" data-akcja="wideo" data-scena="${scena.numer}">
                            ${t('sceny.odtworz_wideo')}
                        </button>
                    `;
                }

                let modelWideoHtml = '';
                if (scena.modelWideo) {
                    modelWideoHtml = `<span class="etykieta-modelu">🎬 ${escHtml(scena.modelWideo)}</span>`;
                }

                karta.innerHTML = `
                    <div class="scena-karta__obraz-kontener">
                        <img src="${escHtml(scena.obraz)}"
                             alt="${t('sceny.scena', { numer: scena.numer })}: ${escHtml(scena.tytul)}"
                             class="scena-karta__obraz"
                             loading="lazy"
                             width="1280"
                             height="720">
                        <span class="scena-karta__numer">${t('sceny.scena', { numer: scena.numer })}</span>
                    </div>
                    <div class="scena-karta__tresc">
                        <h3 class="scena-karta__tytul">${escHtml(scena.tytul)}</h3>
                        <p class="scena-karta__narracja">"${escHtml(scena.narracja)}"</p>

                        <div class="scena-karta__media">
                            <button class="przycisk-media" data-akcja="narracja" data-src="${escHtml(scena.narracja_plik)}">
                                ${t('sceny.odtworz_narracje')}
                            </button>
                            <button class="przycisk-media" data-akcja="muzyka" data-src="${escHtml(scena.muzyka_plik)}">
                                ${t('sceny.odtworz_muzyke')}
                            </button>
                            ${wideoHtml}
                        </div>

                        <div class="scena-karta__modele">
                            <span class="etykieta-modelu">🖼️ ${escHtml(scena.modelObrazu)}</span>
                            <span class="etykieta-modelu">🎤 ${escHtml(scena.glos)}</span>
                            ${modelWideoHtml}
                        </div>

                        ${scena.wideo_plik ? `
                        <div class="scena-karta__wideo" id="wideo-scena-${scena.numer}">
                            <video controls preload="none" width="100%">
                                <source src="${escHtml(scena.wideo_plik)}" type="video/mp4">
                            </video>
                        </div>` : ''}
                    </div>
                `;

                scenySiatka.appendChild(karta);
            });

            // Pokaz sekcje
            sekcjaWynik.classList.add('wynik-filmu--aktywny');
            sekcjaOdtwarzacz.classList.add('odtwarzacz--aktywny');

            // Odtwarzacz — zaladuj ekran
            zbudujOdtwarzacz(dane);

            // Przewin do odtwarzacza
            sekcjaOdtwarzacz.scrollIntoView({ behavior: 'smooth' });
        }

        // ── ODTWARZACZ POKAZU ──
        function zbudujOdtwarzacz(dane) {
            odtwarzaczEkran.innerHTML = '';
            odtwarzaczWskaznik.innerHTML = '';

            dane.sceny.forEach(function (scena, i) {
                // Obraz w odtwarzaczu
                const img = document.createElement('img');
                img.src = scena.obraz;
                img.alt = scena.tytul;
                img.className = 'odtwarzacz__obraz' + (i === 0 ? ' odtwarzacz__obraz--aktywny' : '');
                img.dataset.scena = i;
                odtwarzaczEkran.appendChild(img);

                // Kropka wskaznika
                const kropka = document.createElement('button');
                kropka.className = 'odtwarzacz__kropka' + (i === 0 ? ' odtwarzacz__kropka--aktywna' : '');
                kropka.setAttribute('aria-label', t('sceny.scena', { numer: scena.numer }));
                kropka.addEventListener('click', function () {
                    przejdzDoSceny(i);
                });
                odtwarzaczWskaznik.appendChild(kropka);
            });

            // Ustaw pierwsza scene
            aktualnaScena = 0;
            aktualizujNakladkeOdtwarzacza();
        }

        function przejdzDoSceny(indeks) {
            if (!daneFilmu || indeks < 0 || indeks >= daneFilmu.sceny.length) return;

            // Zatrzymaj biezace audio
            if (audioNarracja) { audioNarracja.pause(); audioNarracja = null; }
            if (audioMuzyka) { audioMuzyka.pause(); audioMuzyka = null; }

            aktualnaScena = indeks;

            // Przelacz obrazy
            document.querySelectorAll('.odtwarzacz__obraz').forEach(function (img, i) {
                img.classList.toggle('odtwarzacz__obraz--aktywny', i === indeks);
            });

            // Przelacz kropki
            document.querySelectorAll('.odtwarzacz__kropka').forEach(function (kropka, i) {
                kropka.classList.toggle('odtwarzacz__kropka--aktywna', i === indeks);
            });

            aktualizujNakladkeOdtwarzacza();

            // Jesli odtwarzanie — graj audio
            if (czyOdtwarzanie) {
                odtworzAudioSceny(indeks);
            }
        }

        function aktualizujNakladkeOdtwarzacza() {
            if (!daneFilmu) return;
            const scena = daneFilmu.sceny[aktualnaScena];
            odtwarzaczTytulSceny.textContent = scena.tytul;
            odtwarzaczNarracjaTekst.textContent = scena.narracja;
        }

        function odtworzAudioSceny(indeks) {
            const scena = daneFilmu.sceny[indeks];

            // Muzyka (ciszej)
            audioMuzyka = new Audio(scena.muzyka_plik);
            audioMuzyka.volume = 0.25;
            audioMuzyka.loop = true;
            audioMuzyka.play().catch(function () {});

            // Narracja (po 1 sekundzie)
            setTimeout(function () {
                audioNarracja = new Audio(scena.narracja_plik);
                audioNarracja.volume = 1.0;
                audioNarracja.play().catch(function () {});

                audioNarracja.onended = function () {
                    // Po 3 sek przejdz do nastepnej sceny
                    timerOdtwarzania = setTimeout(function () {
                        if (aktualnaScena < daneFilmu.sceny.length - 1) {
                            przejdzDoSceny(aktualnaScena + 1);
                        } else {
                            zatrzymajOdtwarzanie();
                        }
                    }, 3000);
                };
            }, 1000);
        }

        function rozpocznijOdtwarzanie() {
            czyOdtwarzanie = true;
            document.getElementById('btn-odtworz').textContent = t('odtwarzacz.pauza');
            przejdzDoSceny(0);
        }

        function zatrzymajOdtwarzanie() {
            czyOdtwarzanie = false;
            if (audioNarracja) { audioNarracja.pause(); audioNarracja = null; }
            if (audioMuzyka) { audioMuzyka.pause(); audioMuzyka = null; }
            if (timerOdtwarzania) { clearTimeout(timerOdtwarzania); timerOdtwarzania = null; }
            document.getElementById('btn-odtworz').textContent = t('odtwarzacz.odtworz');
        }

        // Kontrolki
        document.getElementById('btn-odtworz').addEventListener('click', function () {
            if (czyOdtwarzanie) {
                zatrzymajOdtwarzanie();
            } else {
                rozpocznijOdtwarzanie();
            }
        });

        document.getElementById('btn-nastepna').addEventListener('click', function () {
            if (daneFilmu && aktualnaScena < daneFilmu.sceny.length - 1) {
                przejdzDoSceny(aktualnaScena + 1);
            }
        });

        document.getElementById('btn-poprzednia').addEventListener('click', function () {
            if (daneFilmu && aktualnaScena > 0) {
                przejdzDoSceny(aktualnaScena - 1);
            }
        });

        document.getElementById('btn-pelny-ekran').addEventListener('click', function () {
            const kontener = document.querySelector('.odtwarzacz__kontener');
            if (document.fullscreenElement) {
                document.exitFullscreen();
            } else {
                kontener.requestFullscreen().catch(function () {});
            }
        });

        // ── Przyciski mediow w kartach scen ──
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.przycisk-media');
            if (!btn) return;

            const akcja = btn.dataset.akcja;
            const src = btn.dataset.src;

            if (akcja === 'narracja' || akcja === 'muzyka') {
                // Zatrzymaj inne
                if (audioNarracja) { audioNarracja.pause(); audioNarracja = null; }
                if (audioMuzyka) { audioMuzyka.pause(); audioMuzyka = null; }

                // Odznacz wszystkie
                document.querySelectorAll('.przycisk-media--aktywny').forEach(function (b) {
                    b.classList.remove('przycisk-media--aktywny');
                });

                const audio = new Audio(src);
                audio.play().catch(function () {});
                btn.classList.add('przycisk-media--aktywny');

                audio.onended = function () {
                    btn.classList.remove('przycisk-media--aktywny');
                };

                if (akcja === 'narracja') audioNarracja = audio;
                else audioMuzyka = audio;
            }

            if (akcja === 'wideo') {
                const nr = btn.dataset.scena;
                const div = document.getElementById('wideo-scena-' + nr);
                if (div) {
                    div.classList.toggle('scena-karta__wideo--aktywne');
                }
            }
        });

        // ── Pomocnicze ──
        function escHtml(str) {
            const div = document.createElement('div');
            div.appendChild(document.createTextNode(str || ''));
            return div.innerHTML;
        }

    })();
    </script>
</body>
</html>
