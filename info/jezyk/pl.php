<?php
/**
 * Polski — jezyk glowny
 */

return [
    '_meta' => [
        'nazwa'    => 'Polski',
        'ikona'    => '🇵🇱',
        'kierunek' => 'ltr',
        'kod_html' => 'pl',
    ],

    'strona' => [
        'tytul'        => 'Film ze Snu — Generator AI',
        'opis'         => 'Zamien swoj sen w krotki film przy pomocy sztucznej inteligencji. Scenariusz, obrazy, wideo, narracja i muzyka — wszystko tworzone przez AI.',
        'slowa_klucze' => 'AI, film, sen, generator, sztuczna inteligencja, Pollinations',
    ],

    'naglowek' => [
        'tytul'    => '🎬 Film ze Snu',
        'podtytul' => 'Zamien swoj sen w dzielo filmowe AI',
    ],

    'menu' => [
        'strona_glowna' => 'Strona glowna',
        'jak_dziala'    => 'Jak to dziala?',
        'galeria'       => 'Galeria',
        'dokumentacja'  => 'Dokumentacja',
        'jezyk'         => 'Jezyk',
    ],

    'formularz' => [
        'tytul'        => 'Opisz swoj sen',
        'placeholder'  => 'Zamknij oczy i przypomnij sobie swoj sen... Opisz go jak najdokladniej: co widziales, slyszales, czules? Jakie kolory, miejsca, postacie sie pojawily?',
        'lub'          => 'lub',
        'nagraj_sen'   => '🎙️ Nagraj opis snu',
        'nagrywanie'   => '⏹️ Zatrzymaj nagrywanie',
        'typ_glosu'    => 'Typ narracji',
        'glos_meski'   => '🎭 Meski narrator',
        'glos_zenski'  => '🎭 Zenski narrator',
        'glos_tajemny' => '🌙 Tajemniczy glos',
        'generuj_wideo' => 'Generuj rowniez klipy wideo',
        'stworz'       => '✨ Stworz film z mojego snu',
        'wymagane'     => 'Opisz swoj sen — minimum 20 znakow',
    ],

    'postep' => [
        'tytul'        => 'Tworzenie filmu...',
        'inicjalizacja' => '🎬 Inicjalizacja projektu...',
        'scenariusz'   => '📝 AI pisze scenariusz...',
        'obraz'        => '🖼️ Generowanie obrazu sceny {numer}...',
        'narracja'     => '🎤 Nagrywanie narracji sceny {numer}...',
        'muzyka'       => '🎵 Kompozycja muzyki sceny {numer}...',
        'wideo'        => '🎬 Renderowanie wideo sceny {numer}...',
        'gotowe'       => '✅ Film gotowy!',
        'blad'         => '❌ Wystapil blad: {komunikat}',
        'cierpliwosci' => 'To moze potrwac kilka minut — AI tworzy dzielo sztuki...',
    ],

    'sceny' => [
        'scena'            => 'Scena {numer}',
        'model_obrazu'     => 'Model obrazu',
        'model_wideo'      => 'Model wideo',
        'glos'             => 'Glos',
        'odtworz_narracje' => '▶️ Narracja',
        'odtworz_muzyke'   => '🎵 Muzyka',
        'odtworz_wideo'    => '🎬 Wideo',
    ],

    'odtwarzacz' => [
        'tytul'       => 'Odtwarzacz filmu',
        'odtworz'     => '▶️ Odtworz calosc',
        'pauza'       => '⏸️ Pauza',
        'nastepna'    => '⏭️ Nastepna scena',
        'poprzednia'  => '⏮️ Poprzednia scena',
        'pelny_ekran' => '🔳 Pelny ekran',
    ],

    'informacje' => [
        'tytul_filmu' => 'Tytul',
        'gatunek'     => 'Gatunek',
        'nastroj'     => 'Nastroj',
        'modele'      => 'Uzyte modele AI',
        'id_projektu' => 'ID projektu',
    ],

    'stopka' => [
        'tekst'       => 'Stworzone z pomoca Pollinations AI',
        'prawa'       => '© {rok} Film ze Snu. Wszystkie prawa zastrzezone.',
        'technologie' => 'Technologie',
    ],

    'bledy' => [
        'brak_opisu'     => 'Wprowadz opis snu.',
        'za_krotki'      => 'Opis snu jest za krotki — minimum 20 znakow.',
        'blad_serwera'   => 'Blad serwera. Sprobuj ponownie pozniej.',
        'blad_api'       => 'Blad komunikacji z AI. Sprawdz klucz API.',
        'brak_mikrofonu' => 'Brak dostepu do mikrofonu.',
    ],

    // ════════════════════════════════════
    //  DOKUMENTACJA
    // ════════════════════════════════════
    'docs' => [
        'tytul_strony'    => 'Dokumentacja — Film ze Snu',
        'opis_strony'     => 'Kompletna dokumentacja aplikacji Film ze Snu. Instalacja, konfiguracja, API, dodawanie jezykow i architektura projektu.',
        'slowa_klucze'    => 'dokumentacja, instalacja, konfiguracja, API, PHP, Pollinations',

        'tytul'           => '📖 Dokumentacja',
        'podtytul'        => 'Wszystko co musisz wiedziec o aplikacji Film ze Snu',
        'spis_tresci'     => 'Spis tresci',
        'wroc'            => '← Wróc do aplikacji',

        'sekcje' => [

            // ── 1. O APLIKACJI ──
            'o_aplikacji' => [
                'tytul' => '1. O aplikacji',
                'opis'  => 'Film ze Snu to w pelni wielojezyczna aplikacja webowa napisana w PHP, ktora zamienia opis snu uzytkownika w krotki film multimedialny za pomoca sztucznej inteligencji. Aplikacja korzysta z Pollinations AI — bezplatnej platformy AI z dostepem do wielu modeli.',
                'co_robi' => 'Co robi aplikacja?',
                'kroki' => [
                    '🎙️ Przyjmuje opis snu (tekst lub nagranie glosowe)',
                    '📝 AI generuje gotowy scenariusz filmowy z 4 scenami',
                    '🖼️ Dla kazdej sceny tworzy obraz w jakosci kinowej',
                    '🎤 Nagrywa narracje glosowa do kazdej sceny',
                    '🎵 Komponuje podkladowe tlo muzyczne',
                    '🎬 Opcjonalnie — generuje klip wideo dla kazdej sceny',
                    '▶️ Laczy wszystko w interaktywny odtwarzacz filmowy',
                ],
                'technologie_tytul' => 'Uzyte technologie',
                'technologie' => [
                    ['nazwa' => 'PHP 8.1+',          'opis' => 'Backend, logika aplikacji, komunikacja z API'],
                    ['nazwa' => 'Pollinations AI',    'opis' => 'Generowanie tekstu, obrazow, wideo, mowy i muzyki'],
                    ['nazwa' => 'JavaScript (ES6+)',  'opis' => 'Interfejs uzytkownika, AJAX, odtwarzacz'],
                    ['nazwa' => 'CSS3 + Custom Props','opis' => 'Responsywny wyglad, animacje, motyw'],
                    ['nazwa' => 'Web Audio API',      'opis' => 'Nagrywanie dzwieku w przegladarce'],
                    ['nazwa' => 'MediaRecorder API',  'opis' => 'Rejestracja nagrania glosowego opisu snu'],
                ],
            ],

            // ── 2. WYMAGANIA ──
            'wymagania' => [
                'tytul'          => '2. Wymagania systemowe',
                'serwer_tytul'   => 'Wymagania serwera',
                'serwer' => [
                    ['nazwa' => 'PHP',        'wersja' => '8.1 lub nowszy',  'opis' => 'Wymagane rozszerzenia: curl, json, mbstring, fileinfo'],
                    ['nazwa' => 'Web server', 'wersja' => 'Apache / Nginx',  'opis' => 'Apache: mod_rewrite wlaczony; Nginx: try_files'],
                    ['nazwa' => 'HTTPS',      'wersja' => 'Zalecany',        'opis' => 'Wymagany do dzialania MediaRecorder API w przegladarce'],
                    ['nazwa' => 'Dysk',       'wersja' => '1 GB+',           'opis' => 'Na pliki wygenerowanych projektow (obrazy, audio, wideo)'],
                    ['nazwa' => 'PHP timeout','wersja' => 'min. 300s',       'opis' => 'Generowanie wideo moze trwac nawet kilka minut'],
                ],
                'przegladarka_tytul' => 'Wymagania przegladarki',
                'przegladarka' => [
                    'Chrome / Edge 88+',
                    'Firefox 85+',
                    'Safari 15+',
                    'Obslugi JavaScript (ES6+)',
                    'Obslugi MediaRecorder API (nagrywanie glosu)',
                    'Obslugi Fullscreen API (pelny ekran odtwarzacza)',
                ],
                'api_tytul' => 'Klucz API Pollinations',
                'api_opis'  => 'Wymagany jest klucz API z portalu Pollinations. Zalecamy uzycie klucza Secret (sk_) do zastosowan po stronie serwera — nie ma on limitow czestotliwosci zapytan.',
                'api_kroki' => [
                    'Przejdz na strone enter.pollinations.ai',
                    'Zarejestruj sie lub zaloguj',
                    'Przejdz do sekcji API Keys',
                    'Kliknij "Create new key" i wybierz typ Secret (sk_)',
                    'Skopiuj klucz i wklej do pliku konfiguracja/klucz_api.php',
                ],
            ],

            // ── 3. INSTALACJA ──
            'instalacja' => [
                'tytul'             => '3. Instalacja',
                'krok1_tytul'       => 'Krok 1 — Pobierz pliki',
                'krok1_opis'        => 'Pobierz wszystkie pliki projektu na swoj serwer lub komputer lokalny.',
                'krok2_tytul'       => 'Krok 2 — Ustaw klucz API',
                'krok2_opis'        => 'Otworz plik konfiguracja/klucz_api.php i wstaw swoj klucz API:',
                'krok3_tytul'       => 'Krok 3 — Uprawnienia folderow',
                'krok3_opis'        => 'Folder projekty/ musi byc zapisywalny przez serwer WWW:',
                'krok4_tytul'       => 'Krok 4 — Konfiguracja serwera',
                'krok4_apache'      => 'Apache: upewnij sie ze mod_rewrite jest wlaczony i AllowOverride All ustawiony dla katalogu.',
                'krok4_nginx'       => 'Nginx: dodaj try_files $uri $uri/ /index.php?$query_string; do konfiguracji vhosta.',
                'krok5_tytul'       => 'Krok 5 — Testowanie',
                'krok5_opis'        => 'Otworz aplikacje w przegladarce. Jesli widzisz strone glowna z formularzem — instalacja przebiegla pomyslnie.',
                'lokalne_php_tytul' => 'Uruchomienie lokalnie (PHP built-in server)',
            ],

            // ── 4. STRUKTURA PLIKOW ──
            'struktura' => [
                'tytul' => '4. Struktura plikow',
                'opis'  => 'Projekt jest podzielony na logiczne katalogi. Kazdy z nich odpowiada za inny aspekt aplikacji.',
                'katalogi' => [
                    [
                        'nazwa' => 'konfiguracja/',
                        'ikona' => '⚙️',
                        'opis'  => 'Pliki konfiguracyjne — klucz API i ustawienia modeli AI. NIE udostepniaj publicznie.',
                        'pliki' => [
                            ['nazwa' => 'klucz_api.php', 'opis' => 'Klucz API Pollinations i bazowy URL'],
                            ['nazwa' => 'modele.php',    'opis' => 'Lista modeli AI, glosow i parametrow generowania'],
                        ],
                    ],
                    [
                        'nazwa' => 'klasy/',
                        'ikona' => '🔧',
                        'opis'  => 'Klasy PHP z logiką aplikacji.',
                        'pliki' => [
                            ['nazwa' => 'Api.php',       'opis' => 'Komunikacja z Pollinations API (cURL, endpointy)'],
                            ['nazwa' => 'Jezyk.php',     'opis' => 'System wielojezyczny — detekcja, ladowanie, tlumaczenia'],
                            ['nazwa' => 'Generator.php', 'opis' => 'Koordynacja generowania scenariusz→obraz→audio→wideo'],
                        ],
                    ],
                    [
                        'nazwa' => 'jezyk/',
                        'ikona' => '🌍',
                        'opis'  => 'Pliki jezykowe. Kazdy plik = jeden jezyk. Dodaj nowy plik aby dodac jezyk.',
                        'pliki' => [
                            ['nazwa' => 'pl.php', 'opis' => 'Jezyk polski (domyslny)'],
                            ['nazwa' => 'en.php', 'opis' => 'Jezyk angielski (Wielka Brytania)'],
                            ['nazwa' => 'xx.php', 'opis' => 'Dowolny nowy jezyk — aplikacja wykryje automatycznie'],
                        ],
                    ],
                    [
                        'nazwa' => 'wyglad/',
                        'ikona' => '🎨',
                        'opis'  => 'Pliki CSS. Kazdy komponent ma swoj oddzielny plik. Style NIE sa w PHP.',
                        'pliki' => [
                            ['nazwa' => 'zmienne.css',     'opis' => 'Zmienne CSS — kolory, czcionki, odstepy'],
                            ['nazwa' => 'glowny.css',      'opis' => 'Reset, baza, kontener, scrollbar'],
                            ['nazwa' => 'naglowek.css',    'opis' => 'Naglowek z tytulem i podtytulem'],
                            ['nazwa' => 'menu.css',        'opis' => 'Nawigacja i wybor jezyka'],
                            ['nazwa' => 'formularz.css',   'opis' => 'Formularz opisu snu i przycisk nagrywania'],
                            ['nazwa' => 'postep.css',      'opis' => 'Pasek postepu z logami'],
                            ['nazwa' => 'sceny.css',       'opis' => 'Karty scen — galeria wygenerowanego filmu'],
                            ['nazwa' => 'odtwarzacz.css',  'opis' => 'Odtwarzacz z kontrolkami'],
                            ['nazwa' => 'stopka.css',      'opis' => 'Stopka strony'],
                            ['nazwa' => 'dokumentacja.css','opis' => 'Style strony dokumentacji'],
                        ],
                    ],
                    [
                        'nazwa' => 'projekty/',
                        'ikona' => '📁',
                        'opis'  => 'Wygenerowane projekty. Kazdy projekt = folder sen_YYYYMMDD_HHMMSS_xxxxxxxx/',
                        'pliki' => [
                            ['nazwa' => 'obrazy/',        'opis' => 'JPG — wygenerowane obrazy scen (1280×720)'],
                            ['nazwa' => 'narracja/',      'opis' => 'MP3 — narracje glosowe kazdej sceny'],
                            ['nazwa' => 'muzyka/',        'opis' => 'MP3 — muzyka tla kazdej sceny'],
                            ['nazwa' => 'wideo/',         'opis' => 'MP4 — klipy wideo kazdej sceny (opcjonalne)'],
                            ['nazwa' => 'scenariusz.json','opis' => 'Pelny scenariusz filmowy w formacie JSON'],
                        ],
                    ],
                ],
            ],

            // ── 5. KONFIGURACJA MODELI ──
            'modele' => [
                'tytul'      => '5. Konfiguracja modeli AI',
                'opis'       => 'Plik konfiguracja/modele.php definiuje ktore modele AI sa uzywane do kazdego zadania. Skrypt automatycznie losuje model z listy "najlepsze" — dzieki temu wyniki sa zawsze roznorodne.',
                'jak_dzialaj_tytul' => 'Jak dziala wybor modelu?',
                'jak_dzialaj' => 'Dla kazdego zadania skrypt probuje kolejno modele z listy "najlepsze" (losowa kolejnosc), a jesli zaden nie odpowie poprawnie — przechodzi do listy "zapasowe". Jesli chcesz uzyc zawsze tego samego modelu — zostaw w tablicy tylko jeden element.',
                'dostepne_tytul' => 'Dostepne modele',
                'tabela' => [
                    'zadanie'    => 'Zadanie',
                    'modele'     => 'Modele (najlepsze)',
                    'opis'       => 'Opis',
                ],
                'modele_lista' => [
                    ['zadanie' => 'Scenariusz (tekst)',  'modele' => 'openai, mistral',                               'opis' => 'Generowanie fabuly, dialogow, opisu scen (zapasowe: openai-fast, gemini-fast)'],
                    ['zadanie' => 'Obraz sceny',         'modele' => 'flux',                                          'opis' => 'Wizualizacja scen, styl kinowy 1280×720 (zapasowy: zimage)'],
                    ['zadanie' => 'Wideo sceny',         'modele' => 'grok-video',                                    'opis' => 'Animacja 4 sek, proporcje 16:9 (darmowy)'],
                    ['zadanie' => 'Narracja (TTS)',      'modele' => 'onyx, alloy, echo, nova, shimmer, fable, verse', 'opis' => 'Glos lektora — meski, zenski lub tajemniczy'],
                    ['zadanie' => 'Muzyka tla',          'modele' => 'elevenmusic',                                   'opis' => 'Instrumentalne tlo muzyczne, 20 sek'],
                    ['zadanie' => 'Transkrypcja',        'modele' => 'whisper-large-v3',                              'opis' => 'Zamiana nagrania glosowego na tekst'],
                ],
            ],

            // ── 6. SYSTEM JEZYKOWY ──
            'jezyki' => [
                'tytul'          => '6. System jezykowy',
                'opis'           => 'Aplikacja obsluguje nieograniczona liczbe jezykow. Wystarczy dodac nowy plik PHP do katalogu jezyk/ — reszta dzieje sie automatycznie.',
                'jak_dodac_tytul' => 'Jak dodac nowy jezyk?',
                'jak_dodac_kroki' => [
                    'Skopiuj plik jezyk/pl.php do jezyk/de.php (lub dowolny kod ISO 639-1)',
                    'Zmien sekcje _meta: nazwa, ikona, kierunek, kod_html',
                    'Przetlumacz wszystkie wartosci w tablicy',
                    'Zapisz plik — jezyk pojawi sie automatycznie w menu wyboru jezyka',
                    'Zadna zmiana w kodzie PHP ani JS nie jest wymagana',
                ],
                'meta_tytul'  => 'Sekcja _meta — opis jezyka',
                'meta_pola' => [
                    ['pole' => 'nazwa',    'opis' => 'Pelna nazwa jezyka wyswietlana w menu (np. Deutsch)'],
                    ['pole' => 'ikona',    'opis' => 'Emoji flagi wyswietlane obok nazwy jezyka (np. 🇩🇪)'],
                    ['pole' => 'kierunek', 'opis' => 'Kierunek tekstu: ltr (lewo→prawo) lub rtl (prawo→lewo, np. arabski)'],
                    ['pole' => 'kod_html', 'opis' => 'Kod jezyka dla atrybutu lang HTML i hreflang SEO (np. de, de-AT)'],
                ],
                'detekcja_tytul' => 'Automatyczna detekcja jezyka',
                'detekcja_opis'  => 'Jezyk uzytkownika jest wykrywany w nastepujacej kolejnosci (najwyzszy priorytet pierwszy):',
                'detekcja_kroki' => [
                    ['priorytet' => '1', 'zrodlo' => 'Parametr URL',    'przyklad' => '?jezyk=en',              'opis' => 'Jawny wybor jezyka przez uzytkownika'],
                    ['priorytet' => '2', 'zrodlo' => 'Sesja PHP',       'przyklad' => '$_SESSION[\'jezyk\']',   'opis' => 'Zapamietany wybor z biezacej sesji'],
                    ['priorytet' => '3', 'zrodlo' => 'Ciasteczko',      'przyklad' => '$_COOKIE[\'jezyk\']',    'opis' => 'Dlugoterminowa preferencja (365 dni)'],
                    ['priorytet' => '4', 'zrodlo' => 'Accept-Language', 'przyklad' => 'HTTP Header',            'opis' => 'Jezyk przegladarki uzytkownika'],
                    ['priorytet' => '5', 'zrodlo' => 'Domyslny',        'przyklad' => 'pl',                     'opis' => 'Jezyk domyslny gdy nic innego nie pasuje'],
                ],
                'ai_jezyk_tytul' => 'Jezyk generowanych tresci',
                'ai_jezyk_opis'  => 'AI automatycznie tworzy scenariusz i narracje w jezyku uzytkownika. Wystarczy ze uzytkownik pisze po angielsku — AI odpowie po angielsku i wygeneruje narracje glosowa w tym samym jezyku.',
            ],

            // ── 7. API — ENDPOINTY ──
            'api' => [
                'tytul'      => '7. Endpointy API',
                'opis'       => 'Aplikacja komunikuje sie z Pollinations AI przez nastepujace endpointy. Wszystkie zapytania wymagaja klucza API w naglowku Authorization.',
                'auth_tytul' => 'Autentykacja',
                'auth_opis'  => 'Klucz API nalezy przekazac w naglowku HTTP:',
                'endpointy' => [
                    [
                        'metoda'   => 'GET',
                        'endpoint' => '/text/{prompt}',
                        'opis'     => 'Generowanie scenariusza filmowego',
                        'klasa'    => 'Api::generujTekst()',
                        'badge'    => 'tekst',
                    ],
                    [
                        'metoda'   => 'POST',
                        'endpoint' => '/v1/chat/completions',
                        'opis'     => 'Generowanie scenariusza (OpenAI-compatible, z JSON mode)',
                        'klasa'    => 'Api::czatUzupelnienie()',
                        'badge'    => 'tekst',
                    ],
                    [
                        'metoda'   => 'GET',
                        'endpoint' => '/image/{prompt}',
                        'opis'     => 'Generowanie obrazu sceny (JPEG 1280×720)',
                        'klasa'    => 'Api::generujObraz()',
                        'badge'    => 'obraz',
                    ],
                    [
                        'metoda'   => 'GET',
                        'endpoint' => '/video/{prompt}',
                        'opis'     => 'Generowanie klipu wideo sceny (MP4)',
                        'klasa'    => 'Api::generujWideo()',
                        'badge'    => 'wideo',
                    ],
                    [
                        'metoda'   => 'GET',
                        'endpoint' => '/audio/{text}',
                        'opis'     => 'Generowanie narracji glosowej (MP3)',
                        'klasa'    => 'Api::generujMowe()',
                        'badge'    => 'audio',
                    ],
                    [
                        'metoda'   => 'GET',
                        'endpoint' => '/audio/{text}?model=elevenmusic',
                        'opis'     => 'Generowanie muzyki instrumentalnej (MP3)',
                        'klasa'    => 'Api::generujMuzyke()',
                        'badge'    => 'muzyka',
                    ],
                    [
                        'metoda'   => 'POST',
                        'endpoint' => '/v1/audio/transcriptions',
                        'opis'     => 'Transkrypcja nagrania glosowego opisu snu',
                        'klasa'    => 'Api::transkrybujAudio()',
                        'badge'    => 'audio',
                    ],
                ],
                'bledy_tytul' => 'Kody bledow API',
                'bledy' => [
                    ['kod' => '400', 'nazwa' => 'Bad Request',           'opis' => 'Nieprawidlowe parametry zapytania'],
                    ['kod' => '401', 'nazwa' => 'Unauthorized',          'opis' => 'Brak lub nieprawidlowy klucz API'],
                    ['kod' => '402', 'nazwa' => 'Payment Required',      'opis' => 'Niewystarczajace saldo pylek (pollen)'],
                    ['kod' => '403', 'nazwa' => 'Forbidden',             'opis' => 'Brak uprawnien do danego modelu'],
                    ['kod' => '429', 'nazwa' => 'Too Many Requests',     'opis' => 'Przekroczono limit zapytan — zwolnij'],
                    ['kod' => '500', 'nazwa' => 'Internal Server Error', 'opis' => 'Blad po stronie Pollinations AI'],
                ],
            ],

            // ── 8. PROCES GENEROWANIA ──
            'proces' => [
                'tytul'    => '8. Proces generowania filmu',
                'opis'     => 'Generowanie przebiega krokowo, a kazdy krok jest osobnym zapytaniem AJAX. Dzieki temu interfejs na biezaco aktualizuje pasek postepu.',
                'kroki' => [
                    [
                        'nr'     => '0',
                        'tytul'  => 'Transkrypcja (opcjonalna)',
                        'opis'   => 'Jesli uzytkownik nagral glos zamiast wpisac tekst — nagranie jest wysylane do Whisper API, ktore zwraca tekst.',
                        'ajax'   => 'krok: "transkrypcja"',
                        'czas'   => '3–10 sek',
                    ],
                    [
                        'nr'     => '1',
                        'tytul'  => 'Scenariusz',
                        'opis'   => 'AI (openai lub mistral) tworzy scenariusz z 4 scenami w formacie JSON: tytul, gatunek, opis wizualny, narracja, nastroj muzyczny, opis ruchu kamery.',
                        'ajax'   => 'krok: "scenariusz"',
                        'czas'   => '5–30 sek',
                    ],
                    [
                        'nr'     => '2',
                        'tytul'  => 'Obraz sceny × 4',
                        'opis'   => 'Dla kazdej sceny generowany jest obraz kinowy (JPEG, 1280×720). Uzywa modelu flux (zapasowy: zimage).',
                        'ajax'   => 'krok: "obraz"',
                        'czas'   => '5–30 sek / scena',
                    ],
                    [
                        'nr'     => '3',
                        'tytul'  => 'Narracja glosowa × 4',
                        'opis'   => 'Tekst narracji z scenariusza jest konwertowany na mowe przez model TTS. Glos jest losowany z wybranej kategorii (meski / zenski / tajemniczy).',
                        'ajax'   => 'krok: "narracja"',
                        'czas'   => '3–8 sek / scena',
                    ],
                    [
                        'nr'     => '4',
                        'tytul'  => 'Muzyka tla × 4',
                        'opis'   => 'Dla kazdej sceny generowana jest 20-sekundowa instrumentalna muzyka tla przez model ElevenMusic. Nastroj muzyczny pochodzi ze scenariusza.',
                        'ajax'   => 'krok: "muzyka"',
                        'czas'   => '10–20 sek / scena',
                    ],
                    [
                        'nr'     => '5',
                        'tytul'  => 'Wideo sceny × 4 (opcjonalne)',
                        'opis'   => 'Generowanie 4-sekundowego klipu wideo dla kazdej sceny. Moze trwac dlugo — dlatego jest opcjonalne. Model grok-video (darmowy w Pollinations).',
                        'ajax'   => 'krok: "wideo"',
                        'czas'   => '60–180 sek / scena',
                    ],
                ],
            ],

            // ── 9. SEO I DOSTEPNOSC ──
            'seo' => [
                'tytul' => '9. SEO i dostepnosc',
                'seo_tytul' => 'Optymalizacja SEO',
                'seo_lista' => [
                    'Tagi meta: title, description, keywords — wielojezyczne',
                    'Open Graph — tytuł, opis, URL, locale dla kazdego jezyka',
                    'Hreflang — automatycznie generowany dla kazdego pliku jezykowego',
                    'Structured Data (JSON-LD) — WebApplication schema',
                    'Semantyczny HTML5 — header, nav, main, section, article, footer',
                    'robots.txt — blokuje katalogi konfiguracja/ klasy/ projekty/',
                    'Przyjazne URL — brak dynamicznych parametrow w glownym URL',
                ],
                'a11y_tytul' => 'Dostepnosc (WCAG 2.1)',
                'a11y_lista' => [
                    'Atrybut lang na tagu html — poprawny dla kazdego jezyka (w tym RTL)',
                    'Atrybut dir — ltr lub rtl w zaleznosci od jezyka',
                    'Klasa .sr-only — tresci tylko dla czytnikow ekranu (np. "Przejdz do tresci")',
                    ':focus-visible — widoczny focus dla uzytkownikow klawiatury',
                    'ARIA: role, aria-label, aria-expanded, aria-live, aria-describedby',
                    'Semantyczne przyciski (button) zamiast divow — pelna obsluga klawiatury',
                    'Atrybuty alt na wszystkich obrazach — generowane dynamicznie z tytulu sceny',
                    'Kontrast kolorow — minimum 4.5:1 dla tekstu normalnego',
                    'loading="lazy" na obrazach scen — optymalizacja wydajnosci',
                ],
                'rwd_tytul' => 'Responsywnosc (RWD)',
                'rwd_lista' => [
                    'Mobile-first CSS — style podstawowe dla malych ekranow, @media dla wiekszych',
                    'Viewport meta tag — width=device-width, initial-scale=1.0',
                    'CSS Grid i Flexbox — elastyczny uklad bez sztywnych szerokosc',
                    'aspect-ratio: 16/9 — poprawny wspolczynnik na wszystkich ekranach',
                    'Breakpointy: 640px (telefon), 768px (tablet), 1024px (desktop)',
                    'Czcionka systemowa — brak zewnetrznych fontow = szybsze ladowanie',
                ],
            ],

            // ── 10. FAQ ──
            'faq' => [
                'tytul' => '10. Czesto zadawane pytania (FAQ)',
                'pytania' => [
                    [
                        'q' => 'Czy aplikacja jest darmowa?',
                        'a' => 'Tak — Pollinations AI oferuje darmowy dostep do modeli AI. Klucz API typu Secret (sk_) jest bezplatny i nie ma limitow czestotliwosci. Niektore premium modele moga wymagac zakupu "pylkow" (pollen).',
                    ],
                    [
                        'q' => 'Jak dlugo trwa generowanie filmu?',
                        'a' => 'Bez wideo: okolo 2–5 minut. Z wideo: 10–20 minut. Wideo jest opcjonalne i domyslnie wylaczone — mozna je wlaczyc checkboxem w formularzu.',
                    ],
                    [
                        'q' => 'Gdzie sa zapisywane wygenerowane pliki?',
                        'a' => 'Wszystkie pliki sa zapisywane w katalogu projekty/ na serwerze. Kazdy projekt ma unikalny folder (sen_YYYYMMDD_HHMMSS_xxxxxxxx) zawierajacy obrazy, audio i wideo.',
                    ],
                    [
                        'q' => 'Jak dodac nowy jezyk?',
                        'a' => 'Skopiuj jezyk/pl.php do jezyk/de.php (lub inny kod ISO 639-1), zmien _meta i przetlumacz wartosci. Jezyk pojawi sie automatycznie w menu — zadna zmiana w kodzie nie jest potrzebna.',
                    ],
                    [
                        'q' => 'Czy moge zmienic uklad CSS?',
                        'a' => 'Tak — wszystkie style sa w katalogu wyglad/. Kazdy komponent ma swoj plik CSS. Zmienne globalne (kolory, czcionki, odstepy) sa w wyglad/zmienne.css — wystarczy zmienic je w jednym miejscu.',
                    ],
                    [
                        'q' => 'Czy aplikacja dziala bez HTTPS?',
                        'a' => 'Czesc funkcji dziala, ale nagrywanie glosowe (MediaRecorder API) wymaga HTTPS lub localhost. Bez HTTPS uzytkownik moze nadal wpisywac opis recznie.',
                    ],
                    [
                        'q' => 'Co jesli model AI zwroci nieprawidlowy JSON?',
                        'a' => 'Klasa Api::czatUzupelnienie() uzywa json_object mode. Generator::generujScenariusz() dodatkowo czyści odpowiedz z bloków markdown i sprawdza json_last_error(). Jesli parsing sie nie uda, wyrzucany jest RuntimeException z komunikatem bledu.',
                    ],
                    [
                        'q' => 'Czy moge uzyc wlasnego ElevenLabs voice ID?',
                        'a' => 'Tak — endpoint POST /v1/audio/speech akceptuje zarowno predefiniowane nazwy glosow (nova, onyx...) jak i wlasne UUID z dashboardu ElevenLabs.',
                    ],
                ],
            ],

            // ── 11. BEZPIECZENSTWO ──
            'bezpieczenstwo' => [
                'tytul' => '11. Bezpieczenstwo',
                'lista' => [
                    [
                        'tytul' => 'Ochrona klucza API',
                        'opis'  => 'Klucz sk_ jest przechowywany wylacznie w konfiguracja/klucz_api.php, ktory jest zablokowany przez .htaccess i robots.txt. Nigdy nie wystawiaj go po stronie klienta.',
                    ],
                    [
                        'tytul' => 'Directory Traversal',
                        'opis'  => 'Funkcja walidujProjekt() w przetwarzanie.php sprawdza ID projektu regexem [^a-zA-Z0-9_] i weryfikuje czy katalog istnieje — zapobiega atakowi "../../../".',
                    ],
                    [
                        'tytul' => 'Blokada katalogow',
                        'opis'  => '.htaccess blokuje bezposredni dostep HTTP do konfiguracja/ i klasy/. Tylko pliki mediow w projekty/ sa publicznie dostepne.',
                    ],
                    [
                        'tytul' => 'Naglowki HTTP',
                        'opis'  => 'X-Content-Type-Options, X-Frame-Options, X-XSS-Protection i Referrer-Policy sa ustawione w .htaccess — chronia przed typowymi atakami XSS i clickjacking.',
                    ],
                    [
                        'tytul' => 'Walidacja danych wejsciowych',
                        'opis'  => 'Opis snu jest walidowany po stronie klienta (JS) i serwera (PHP) — minimalna dlugosc 20 znakow, brak XSS dzieki htmlspecialchars() przy wyswietlaniu.',
                    ],
                    [
                        'tytul' => 'Timeout cURL',
                        'opis'  => 'Wszystkie zapytania do API maja timeout 300 sekund — zapobiega wiecznym zawieszeniom serwera.',
                    ],
                ],
            ],

        ], // koniec sekcje
    ], // koniec docs
];