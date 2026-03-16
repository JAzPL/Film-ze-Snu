<?php
/**
 * English (United Kingdom)
 */

return [
    '_meta' => [
        'nazwa'    => 'English (UK)',
        'ikona'    => '🇬🇧',
        'kierunek' => 'ltr',
        'kod_html' => 'en-GB',
    ],

    'strona' => [
        'tytul'        => 'Dream Film — AI Generator',
        'opis'         => 'Transform your dream into a short film using artificial intelligence. Screenplay, images, video, narration, and music — all created by AI.',
        'slowa_klucze' => 'AI, film, dream, generator, artificial intelligence, Pollinations',
    ],

    'naglowek' => [
        'tytul'    => '🎬 Dream Film',
        'podtytul' => 'Turn your dream into an AI cinematic masterpiece',
    ],

    'menu' => [
        'strona_glowna' => 'Home',
        'jak_dziala'    => 'How it works',
        'galeria'       => 'Gallery',
        'dokumentacja'  => 'Documentation',
        'jezyk'         => 'Language',
    ],

    'formularz' => [
        'tytul'         => 'Describe your dream',
        'placeholder'   => 'Close your eyes and recall your dream... Describe it in as much detail as possible: what did you see, hear, feel? What colours, places, and characters appeared?',
        'lub'           => 'or',
        'nagraj_sen'    => '🎙️ Record your dream',
        'nagrywanie'    => '⏹️ Stop recording',
        'typ_glosu'     => 'Narration type',
        'glos_meski'    => '🎭 Male narrator',
        'glos_zenski'   => '🎭 Female narrator',
        'glos_tajemny'  => '🌙 Mysterious voice',
        'generuj_wideo' => 'Also generate video clips',
        'stworz'        => '✨ Create a film from my dream',
        'wymagane'      => 'Describe your dream — at least 20 characters',
    ],

    'postep' => [
        'tytul'         => 'Creating your film...',
        'inicjalizacja' => '🎬 Initialising project...',
        'scenariusz'    => '📝 AI is writing the screenplay...',
        'obraz'         => '🖼️ Generating image for scene {numer}...',
        'narracja'      => '🎤 Recording narration for scene {numer}...',
        'muzyka'        => '🎵 Composing music for scene {numer}...',
        'wideo'         => '🎬 Rendering video for scene {numer}...',
        'gotowe'        => '✅ Film is ready!',
        'blad'          => '❌ An error occurred: {komunikat}',
        'cierpliwosci'  => 'This may take a few minutes — AI is creating a work of art...',
    ],

    'sceny' => [
        'scena'            => 'Scene {numer}',
        'model_obrazu'     => 'Image model',
        'model_wideo'      => 'Video model',
        'glos'             => 'Voice',
        'odtworz_narracje' => '▶️ Narration',
        'odtworz_muzyke'   => '🎵 Music',
        'odtworz_wideo'    => '🎬 Video',
    ],

    'odtwarzacz' => [
        'tytul'       => 'Film player',
        'odtworz'     => '▶️ Play all',
        'pauza'       => '⏸️ Pause',
        'nastepna'    => '⏭️ Next scene',
        'poprzednia'  => '⏮️ Previous scene',
        'pelny_ekran' => '🔳 Full screen',
    ],

    'informacje' => [
        'tytul_filmu' => 'Title',
        'gatunek'     => 'Genre',
        'nastroj'     => 'Mood',
        'modele'      => 'AI models used',
        'id_projektu' => 'Project ID',
    ],

    'stopka' => [
        'tekst'       => 'Created with Pollinations AI',
        'prawa'       => '© {rok} Dream Film. All rights reserved.',
        'technologie' => 'Technologies',
    ],

    'bledy' => [
        'brak_opisu'     => 'Please enter a dream description.',
        'za_krotki'      => 'Dream description is too short — minimum 20 characters.',
        'blad_serwera'   => 'Server error. Please try again later.',
        'blad_api'       => 'AI communication error. Please check the API key.',
        'brak_mikrofonu' => 'Microphone access denied.',
    ],

    // ════════════════════════════════════
    //  DOCUMENTATION
    // ════════════════════════════════════
    'docs' => [
        'tytul_strony'  => 'Documentation — Dream Film',
        'opis_strony'   => 'Complete documentation for the Dream Film application. Installation, configuration, API, adding languages, and project architecture.',
        'slowa_klucze'  => 'documentation, installation, configuration, API, PHP, Pollinations',

        'tytul'         => '📖 Documentation',
        'podtytul'      => 'Everything you need to know about the Dream Film application',
        'spis_tresci'   => 'Table of contents',
        'wroc'          => '← Back to application',

        'sekcje' => [

            'o_aplikacji' => [
                'tytul' => '1. About the application',
                'opis'  => 'Dream Film is a fully multilingual web application written in PHP that transforms a user\'s dream description into a short multimedia film using artificial intelligence. The application uses Pollinations AI — a free AI platform with access to many models.',
                'co_robi' => 'What does the application do?',
                'kroki' => [
                    '🎙️ Accepts a dream description (text or voice recording)',
                    '📝 AI generates a complete film screenplay with 4 scenes',
                    '🖼️ Creates a cinematic image for each scene',
                    '🎤 Records a voice narration for each scene',
                    '🎵 Composes background music',
                    '🎬 Optionally — generates a video clip for each scene',
                    '▶️ Combines everything into an interactive film player',
                ],
                'technologie_tytul' => 'Technologies used',
                'technologie' => [
                    ['nazwa' => 'PHP 8.1+',           'opis' => 'Backend, application logic, API communication'],
                    ['nazwa' => 'Pollinations AI',     'opis' => 'Text, image, video, speech and music generation'],
                    ['nazwa' => 'JavaScript (ES6+)',   'opis' => 'User interface, AJAX, film player'],
                    ['nazwa' => 'CSS3 + Custom Props', 'opis' => 'Responsive design, animations, dark theme'],
                    ['nazwa' => 'Web Audio API',       'opis' => 'In-browser audio recording'],
                    ['nazwa' => 'MediaRecorder API',   'opis' => 'Voice recording of dream description'],
                ],
            ],

            'wymagania' => [
                'tytul'          => '2. System requirements',
                'serwer_tytul'   => 'Server requirements',
                'serwer' => [
                    ['nazwa' => 'PHP',         'wersja' => '8.1 or newer',    'opis' => 'Required extensions: curl, json, mbstring, fileinfo'],
                    ['nazwa' => 'Web server',  'wersja' => 'Apache / Nginx',  'opis' => 'Apache: mod_rewrite enabled; Nginx: try_files'],
                    ['nazwa' => 'HTTPS',       'wersja' => 'Recommended',     'opis' => 'Required for MediaRecorder API in the browser'],
                    ['nazwa' => 'Disc space',  'wersja' => '1 GB+',           'opis' => 'For generated project files (images, audio, video)'],
                    ['nazwa' => 'PHP timeout', 'wersja' => 'min. 300s',       'opis' => 'Video generation may take several minutes'],
                ],
                'przegladarka_tytul' => 'Browser requirements',
                'przegladarka' => [
                    'Chrome / Edge 88+',
                    'Firefox 85+',
                    'Safari 15+',
                    'JavaScript support (ES6+)',
                    'MediaRecorder API support (voice recording)',
                    'Fullscreen API support (player full screen)',
                ],
                'api_tytul' => 'Pollinations API key',
                'api_opis'  => 'An API key from the Pollinations portal is required. We recommend using a Secret key (sk_) for server-side applications — it has no rate limits.',
                'api_kroki' => [
                    'Go to enter.pollinations.ai',
                    'Register or sign in',
                    'Navigate to the API Keys section',
                    'Click "Create new key" and select Secret type (sk_)',
                    'Copy the key and paste it into konfiguracja/klucz_api.php',
                ],
            ],

            'instalacja' => [
                'tytul'             => '3. Installation',
                'krok1_tytul'       => 'Step 1 — Download files',
                'krok1_opis'        => 'Download all project files to your server or local computer.',
                'krok2_tytul'       => 'Step 2 — Set the API key',
                'krok2_opis'        => 'Open konfiguracja/klucz_api.php and insert your API key:',
                'krok3_tytul'       => 'Step 3 — Folder permissions',
                'krok3_opis'        => 'The projekty/ folder must be writable by the web server:',
                'krok4_tytul'       => 'Step 4 — Server configuration',
                'krok4_apache'      => 'Apache: ensure mod_rewrite is enabled and AllowOverride All is set for the directory.',
                'krok4_nginx'       => 'Nginx: add try_files $uri $uri/ /index.php?$query_string; to your vhost configuration.',
                'krok5_tytul'       => 'Step 5 — Testing',
                'krok5_opis'        => 'Open the application in your browser. If you see the main page with the form — installation was successful.',
                'lokalne_php_tytul' => 'Run locally (PHP built-in server)',
            ],

            'struktura' => [
                'tytul' => '4. File structure',
                'opis'  => 'The project is divided into logical directories. Each one is responsible for a different aspect of the application.',
                'katalogi' => [
                    [
                        'nazwa' => 'konfiguracja/',
                        'ikona' => '⚙️',
                        'opis'  => 'Configuration files — API key and AI model settings. Do NOT expose publicly.',
                        'pliki' => [
                            ['nazwa' => 'klucz_api.php', 'opis' => 'Pollinations API key and base URL'],
                            ['nazwa' => 'modele.php',    'opis' => 'AI model list, voices and generation parameters'],
                        ],
                    ],
                    [
                        'nazwa' => 'klasy/',
                        'ikona' => '🔧',
                        'opis'  => 'PHP classes containing the application logic.',
                        'pliki' => [
                            ['nazwa' => 'Api.php',       'opis' => 'Pollinations API communication (cURL, endpoints)'],
                            ['nazwa' => 'Jezyk.php',     'opis' => 'Multilingual system — detection, loading, translations'],
                            ['nazwa' => 'Generator.php', 'opis' => 'Generation coordinator: screenplay→image→audio→video'],
                        ],
                    ],
                    [
                        'nazwa' => 'jezyk/',
                        'ikona' => '🌍',
                        'opis'  => 'Language files. One file = one language. Add a new file to add a language.',
                        'pliki' => [
                            ['nazwa' => 'pl.php', 'opis' => 'Polish (default)'],
                            ['nazwa' => 'en.php', 'opis' => 'English (United Kingdom)'],
                            ['nazwa' => 'xx.php', 'opis' => 'Any new language — automatically detected by the application'],
                        ],
                    ],
                    [
                        'nazwa' => 'wyglad/',
                        'ikona' => '🎨',
                        'opis'  => 'CSS files. Each component has its own separate file. Styles are NOT in PHP.',
                        'pliki' => [
                            ['nazwa' => 'zmienne.css',     'opis' => 'CSS variables — colours, fonts, spacing'],
                            ['nazwa' => 'glowny.css',      'opis' => 'Reset, base, container, scrollbar'],
                            ['nazwa' => 'naglowek.css',    'opis' => 'Page header with title and subtitle'],
                            ['nazwa' => 'menu.css',        'opis' => 'Navigation and language selector'],
                            ['nazwa' => 'formularz.css',   'opis' => 'Dream description form and record button'],
                            ['nazwa' => 'postep.css',      'opis' => 'Progress bar with logs'],
                            ['nazwa' => 'sceny.css',       'opis' => 'Scene cards — generated film gallery'],
                            ['nazwa' => 'odtwarzacz.css',  'opis' => 'Film player with controls'],
                            ['nazwa' => 'stopka.css',      'opis' => 'Page footer'],
                            ['nazwa' => 'dokumentacja.css','opis' => 'Documentation page styles'],
                        ],
                    ],
                    [
                        'nazwa' => 'projekty/',
                        'ikona' => '📁',
                        'opis'  => 'Generated projects. Each project = folder sen_YYYYMMDD_HHMMSS_xxxxxxxx/',
                        'pliki' => [
                            ['nazwa' => 'obrazy/',         'opis' => 'JPG — generated scene images (1280×720)'],
                            ['nazwa' => 'narracja/',       'opis' => 'MP3 — voice narrations for each scene'],
                            ['nazwa' => 'muzyka/',         'opis' => 'MP3 — background music for each scene'],
                            ['nazwa' => 'wideo/',          'opis' => 'MP4 — video clips for each scene (optional)'],
                            ['nazwa' => 'scenariusz.json', 'opis' => 'Complete film screenplay in JSON format'],
                        ],
                    ],
                ],
            ],

            'modele' => [
                'tytul'              => '5. AI model configuration',
                'opis'               => 'The file konfiguracja/modele.php defines which AI models are used for each task. The script automatically picks a random model from the "best" list — ensuring varied results every time.',
                'jak_dzialaj_tytul'  => 'How does model selection work?',
                'jak_dzialaj'        => 'For each task the script tries models from the "najlepsze" list in random order, and if none responds correctly — it falls back to the "zapasowe" list. If you always want the same model — leave only one element in the array.',
                'dostepne_tytul'     => 'Available models',
                'tabela' => [
                    'zadanie' => 'Task',
                    'modele'  => 'Models (best)',
                    'opis'    => 'Description',
                ],
                'modele_lista' => [
                    ['zadanie' => 'Screenplay (text)', 'modele' => 'openai, mistral',                                'opis' => 'Plot, dialogue, scene description generation (fallback: openai-fast, gemini-fast)'],
                    ['zadanie' => 'Scene image',       'modele' => 'flux',                                          'opis' => 'Cinematic scene visualisation 1280×720 (fallback: zimage)'],
                    ['zadanie' => 'Scene video',       'modele' => 'grok-video',                                    'opis' => '4 sec animation, 16:9 ratio (free on Pollinations)'],
                    ['zadanie' => 'Narration (TTS)',   'modele' => 'onyx, alloy, echo, nova, shimmer, fable, verse', 'opis' => 'Narrator voice — male, female or mysterious'],
                    ['zadanie' => 'Background music',  'modele' => 'elevenmusic',                                   'opis' => 'Instrumental background track, 20 seconds'],
                    ['zadanie' => 'Transcription',     'modele' => 'whisper-large-v3',                              'opis' => 'Voice recording to text conversion'],
                ],
            ],

            'jezyki' => [
                'tytul'           => '6. Language system',
                'opis'            => 'The application supports an unlimited number of languages. Simply add a new PHP file to the jezyk/ directory — everything else happens automatically.',
                'jak_dodac_tytul' => 'How to add a new language?',
                'jak_dodac_kroki' => [
                    'Copy jezyk/pl.php to jezyk/de.php (or any ISO 639-1 code)',
                    'Change the _meta section: nazwa, ikona, kierunek, kod_html',
                    'Translate all values in the array',
                    'Save the file — the language will appear automatically in the language menu',
                    'No changes to PHP or JS code are required',
                ],
                'meta_tytul' => '_meta section — language descriptor',
                'meta_pola' => [
                    ['pole' => 'nazwa',    'opis' => 'Full language name displayed in the menu (e.g. Deutsch)'],
                    ['pole' => 'ikona',    'opis' => 'Flag emoji displayed next to the language name (e.g. 🇩🇪)'],
                    ['pole' => 'kierunek', 'opis' => 'Text direction: ltr (left→right) or rtl (right→left, e.g. Arabic)'],
                    ['pole' => 'kod_html', 'opis' => 'Language code for HTML lang attribute and SEO hreflang (e.g. de, de-AT)'],
                ],
                'detekcja_tytul' => 'Automatic language detection',
                'detekcja_opis'  => 'The user\'s language is detected in the following order (highest priority first):',
                'detekcja_kroki' => [
                    ['priorytet' => '1', 'zrodlo' => 'URL parameter',    'przyklad' => '?jezyk=en',              'opis' => 'Explicit user language choice'],
                    ['priorytet' => '2', 'zrodlo' => 'PHP session',      'przyklad' => '$_SESSION[\'jezyk\']',   'opis' => 'Choice remembered from current session'],
                    ['priorytet' => '3', 'zrodlo' => 'Cookie',           'przyklad' => '$_COOKIE[\'jezyk\']',    'opis' => 'Long-term preference (365 days)'],
                    ['priorytet' => '4', 'zrodlo' => 'Accept-Language',  'przyklad' => 'HTTP Header',            'opis' => 'User\'s browser language'],
                    ['priorytet' => '5', 'zrodlo' => 'Default',          'przyklad' => 'pl',                     'opis' => 'Default language when nothing else matches'],
                ],
                'ai_jezyk_tytul' => 'Language of generated content',
                'ai_jezyk_opis'  => 'AI automatically creates the screenplay and narration in the user\'s language. If the user writes in English — AI will respond in English and generate the voice narration in English as well.',
            ],

            'api' => [
                'tytul'      => '7. API endpoints',
                'opis'       => 'The application communicates with Pollinations AI via the following endpoints. All requests require an API key in the Authorization header.',
                'auth_tytul' => 'Authentication',
                'auth_opis'  => 'The API key must be passed in the HTTP header:',
                'endpointy' => [
                    ['metoda' => 'GET',  'endpoint' => '/text/{prompt}',                      'opis' => 'Film screenplay generation',                     'klasa' => 'Api::generujTekst()',       'badge' => 'tekst'],
                    ['metoda' => 'POST', 'endpoint' => '/v1/chat/completions',                 'opis' => 'Screenplay generation (OpenAI-compatible, JSON)', 'klasa' => 'Api::czatUzupelnienie()',   'badge' => 'tekst'],
                    ['metoda' => 'GET',  'endpoint' => '/image/{prompt}',                     'opis' => 'Scene image generation (JPEG 1280×720)',           'klasa' => 'Api::generujObraz()',       'badge' => 'obraz'],
                    ['metoda' => 'GET',  'endpoint' => '/video/{prompt}',                     'opis' => 'Scene video clip generation (MP4)',               'klasa' => 'Api::generujWideo()',       'badge' => 'wideo'],
                    ['metoda' => 'GET',  'endpoint' => '/audio/{text}',                       'opis' => 'Voice narration generation (MP3)',                'klasa' => 'Api::generujMowe()',        'badge' => 'audio'],
                    ['metoda' => 'GET',  'endpoint' => '/audio/{text}?model=elevenmusic',     'opis' => 'Instrumental music generation (MP3)',             'klasa' => 'Api::generujMuzyke()',     'badge' => 'muzyka'],
                    ['metoda' => 'POST', 'endpoint' => '/v1/audio/transcriptions',            'opis' => 'Dream voice recording transcription',             'klasa' => 'Api::transkrybujAudio()',  'badge' => 'audio'],
                ],
                'bledy_tytul' => 'API error codes',
                'bledy' => [
                    ['kod' => '400', 'nazwa' => 'Bad Request',           'opis' => 'Invalid request parameters'],
                    ['kod' => '401', 'nazwa' => 'Unauthorized',          'opis' => 'Missing or invalid API key'],
                    ['kod' => '402', 'nazwa' => 'Payment Required',      'opis' => 'Insufficient pollen balance'],
                    ['kod' => '403', 'nazwa' => 'Forbidden',             'opis' => 'No permission for the requested model'],
                    ['kod' => '429', 'nazwa' => 'Too Many Requests',     'opis' => 'Rate limit exceeded — slow down'],
                    ['kod' => '500', 'nazwa' => 'Internal Server Error', 'opis' => 'Error on the Pollinations AI side'],
                ],
            ],

            'proces' => [
                'tytul' => '8. Film generation process',
                'opis'  => 'Generation proceeds step by step, with each step as a separate AJAX request. This allows the interface to update the progress bar in real time.',
                'kroki' => [
                    ['nr' => '0', 'tytul' => 'Transcription (optional)',   'opis' => 'If the user recorded a voice instead of typing — the recording is sent to Whisper API, which returns text.',                                                        'ajax' => 'step: "transkrypcja"', 'czas' => '3–10 sec'],
                    ['nr' => '1', 'tytul' => 'Screenplay',                 'opis' => 'AI (openai or mistral) creates a 4-scene screenplay in JSON format: title, genre, visual description, narration, music mood, camera movement description.',   'ajax' => 'step: "scenariusz"',   'czas' => '5–30 sec'],
                    ['nr' => '2', 'tytul' => 'Scene image × 4',            'opis' => 'A cinematic image (JPEG, 1280×720) is generated for each scene using the flux model (fallback: zimage).', 'ajax' => 'step: "obraz"',        'czas' => '5–30 sec / scene'],
                    ['nr' => '3', 'tytul' => 'Voice narration × 4',        'opis' => 'The narration text from the screenplay is converted to speech by the TTS model. The voice is randomly selected from the chosen category (male / female / mysterious).','ajax' => 'step: "narracja"',     'czas' => '3–8 sec / scene'],
                    ['nr' => '4', 'tytul' => 'Background music × 4',       'opis' => 'A 20-second instrumental background track is generated for each scene by ElevenMusic. The musical mood comes from the screenplay.',                                    'ajax' => 'step: "muzyka"',       'czas' => '10–20 sec / scene'],
                    ['nr' => '5', 'tytul' => 'Scene video × 4 (optional)', 'opis' => 'A 4-second video clip is generated for each scene. This can take a long time — hence it is optional. Uses grok-video model (free on Pollinations).',           'ajax' => 'step: "wideo"',        'czas' => '60–180 sec / scene'],
                ],
            ],

            'seo' => [
                'tytul'      => '9. SEO and accessibility',
                'seo_tytul'  => 'SEO optimisation',
                'seo_lista'  => [
                    'Meta tags: title, description, keywords — multilingual',
                    'Open Graph — title, description, URL, locale for each language',
                    'Hreflang — automatically generated for each language file',
                    'Structured Data (JSON-LD) — WebApplication schema',
                    'Semantic HTML5 — header, nav, main, section, article, footer',
                    'robots.txt — blocks konfiguracja/ klasy/ projekty/ directories',
                    'Clean URLs — no dynamic parameters in the main URL',
                ],
                'a11y_tytul' => 'Accessibility (WCAG 2.1)',
                'a11y_lista' => [
                    'lang attribute on the html tag — correct for each language (including RTL)',
                    'dir attribute — ltr or rtl depending on language',
                    '.sr-only class — content for screen readers only (e.g. "Skip to content")',
                    ':focus-visible — visible focus for keyboard users',
                    'ARIA: role, aria-label, aria-expanded, aria-live, aria-describedby',
                    'Semantic buttons instead of divs — full keyboard support',
                    'alt attributes on all images — dynamically generated from scene title',
                    'Colour contrast — minimum 4.5:1 for normal text',
                    'loading="lazy" on scene images — performance optimisation',
                ],
                'rwd_tytul'  => 'Responsiveness (RWD)',
                'rwd_lista'  => [
                    'Mobile-first CSS — base styles for small screens, @media for larger',
                    'Viewport meta tag — width=device-width, initial-scale=1.0',
                    'CSS Grid and Flexbox — flexible layout without fixed widths',
                    'aspect-ratio: 16/9 — correct ratio on all screens',
                    'Breakpoints: 640px (phone), 768px (tablet), 1024px (desktop)',
                    'System font — no external fonts = faster loading',
                ],
            ],

            'faq' => [
                'tytul'   => '10. Frequently asked questions (FAQ)',
                'pytania' => [
                    ['q' => 'Is the application free?',                      'a' => 'Yes — Pollinations AI offers free access to AI models. The Secret (sk_) API key is free with no rate limits. Some premium models may require purchasing "pollen".'],
                    ['q' => 'How long does film generation take?',            'a' => 'Without video: approximately 2–5 minutes. With video: 10–20 minutes. Video is optional and disabled by default — it can be enabled via the checkbox in the form.'],
                    ['q' => 'Where are the generated files saved?',           'a' => 'All files are saved in the projekty/ directory on the server. Each project has a unique folder (sen_YYYYMMDD_HHMMSS_xxxxxxxx) containing images, audio, and video.'],
                    ['q' => 'How do I add a new language?',                  'a' => 'Copy jezyk/pl.php to jezyk/de.php (or another ISO 639-1 code), change _meta and translate the values. The language will appear automatically in the menu — no code changes needed.'],
                    ['q' => 'Can I change the CSS layout?',                  'a' => 'Yes — all styles are in the wyglad/ directory. Each component has its own CSS file. Global variables (colours, fonts, spacing) are in wyglad/zmienne.css — change them in one place.'],
                    ['q' => 'Does the application work without HTTPS?',      'a' => 'Some features work, but voice recording (MediaRecorder API) requires HTTPS or localhost. Without HTTPS, users can still type the description manually.'],
                    ['q' => 'What if the AI model returns invalid JSON?',    'a' => 'Api::czatUzupelnienie() uses json_object mode. Generator::generujScenariusz() also strips markdown blocks and checks json_last_error(). If parsing fails, a RuntimeException is thrown.'],
                    ['q' => 'Can I use my own ElevenLabs voice ID?',        'a' => 'Yes — the POST /v1/audio/speech endpoint accepts both preset voice names (nova, onyx...) and custom UUIDs from your ElevenLabs dashboard.'],
                ],
            ],

            'bezpieczenstwo' => [
                'tytul' => '11. Security',
                'lista' => [
                    ['tytul' => 'API key protection',      'opis' => 'The sk_ key is stored exclusively in konfiguracja/klucz_api.php, which is blocked by .htaccess and robots.txt. Never expose it client-side.'],
                    ['tytul' => 'Directory Traversal',     'opis' => 'The walidujProjekt() function in przetwarzanie.php checks the project ID with a regex [^a-zA-Z0-9_] and verifies the directory exists — preventing "../../../" attacks.'],
                    ['tytul' => 'Directory blocking',      'opis' => '.htaccess blocks direct HTTP access to konfiguracja/ and klasy/. Only media files in projekty/ are publicly accessible.'],
                    ['tytul' => 'HTTP headers',            'opis' => 'X-Content-Type-Options, X-Frame-Options, X-XSS-Protection and Referrer-Policy are set in .htaccess — protecting against common XSS and clickjacking attacks.'],
                    ['tytul' => 'Input validation',        'opis' => 'The dream description is validated client-side (JS) and server-side (PHP) — minimum 20 characters, XSS prevention via htmlspecialchars() on output.'],
                    ['tytul' => 'cURL timeout',            'opis' => 'All API requests have a 300-second timeout — preventing indefinite server hangs.'],
                ],
            ],

        ], // end sekcje
    ], // end docs
];