<?php
/**
 * Glowny generator filmow ze snow
 * Koordynuje caly proces: scenariusz → obrazy → wideo → narracja → muzyka → zapis
 */

require_once __DIR__ . '/Api.php';

class GeneratorFilmu
{
    private Api $api;
    private array $modele;
    private string $katalogProjektu;
    private string $idProjektu;

    public function __construct(Api $api, array $modele)
    {
        $this->api    = $api;
        $this->modele = $modele;
    }

    /**
     * Buduje pelna liste do fallbacku: najlepsze (losowo) + zapasowe (bez duplikatow)
     */
    private function listaFallback(string $kategoria): array
    {
        $najlepsze = $this->modele[$kategoria]['najlepsze'] ?? [];
        $zapasowe  = $this->modele[$kategoria]['zapasowe']  ?? [];
        shuffle($najlepsze);
        shuffle($zapasowe);
        return array_values(array_unique(array_merge($najlepsze, $zapasowe))) ?: ['openai'];
    }

    /**
     * Buduje liste glosow: najpierw zadany typ (losowo), potem pozostale jako fallback
     */
    private function listaGlosow(string $typGlosu): array
    {
        $glosy = $this->modele['glosy'][$typGlosu] ?? ['nova'];
        shuffle($glosy);

        $pozostale = [];
        foreach ($this->modele['glosy'] ?? [] as $typ => $lista) {
            if ($typ !== $typGlosu) {
                $pozostale = array_merge($pozostale, $lista);
            }
        }
        shuffle($pozostale);

        return array_values(array_unique(array_merge($glosy, $pozostale)));
    }

    /**
     * Probuje $wywolanie kolejno dla kazdego elementu listy.
     * Przy RuntimeException przechodzi do nastepnego elementu.
     */
    private function sprobujZListy(array $lista, callable $wywolanie): mixed
    {
        $ostatniBlad = null;
        foreach ($lista as $element) {
            try {
                return $wywolanie($element);
            } catch (RuntimeException $e) {
                $ostatniBlad = $e;
            }
        }
        throw $ostatniBlad ?? new RuntimeException('Brak dostepnych modeli/glosow');
    }

    /**
     * Tworzy folder projektu i zwraca ID
     */
    public function inicjalizujProjekt(): string
    {
        $this->idProjektu      = 'sen_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4));
        $this->katalogProjektu = __DIR__ . '/../projekty/' . $this->idProjektu;

        if (!is_dir($this->katalogProjektu)) {
            mkdir($this->katalogProjektu, 0755, true);
            mkdir($this->katalogProjektu . '/obrazy',   0755, true);
            mkdir($this->katalogProjektu . '/narracja', 0755, true);
            mkdir($this->katalogProjektu . '/muzyka',   0755, true);
            mkdir($this->katalogProjektu . '/wideo',    0755, true);
        }

        return $this->idProjektu;
    }

    public function ustawProjekt(string $id): void
    {
        $this->idProjektu      = $id;
        $this->katalogProjektu = __DIR__ . '/../projekty/' . $id;
    }

    /**
     * KROK 1: Generuj scenariusz filmowy z opisu snu (z polem wstep)
     */
    public function generujScenariusz(string $opisSnu, string $jezykUzytkownika = 'pl'): array
    {
        $jezykNazwa = $jezykUzytkownika === 'pl' ? 'polski' : 'English';

        $systemowy = "You are a visionary film director and screenwriter specializing in dream-based surreal cinema. "
            . "You create vivid, emotionally powerful scenes. Always respond in {$jezykNazwa} language. "
            . "Return ONLY valid JSON, no markdown.";

        $prompt = "Based on this dream description, create a cinematic short film screenplay with exactly 4 scenes.\n\n"
            . "Dream: \"{$opisSnu}\"\n\n"
            . "Return JSON in this exact format:\n"
            . "{\n"
            . "  \"tytul\": \"Film title\",\n"
            . "  \"gatunek\": \"Genre\",\n"
            . "  \"nastroj\": \"Overall mood\",\n"
            . "  \"wstep\": \"A poetic 3-5 sentence introduction to this dream story in {$jezykNazwa}, written in the style of magical realism — evocative, atmospheric, drawing the reader into the dream world. This will be shown as a public preview of the dream.\",\n"
            . "  \"sceny\": [\n"
            . "    {\n"
            . "      \"numer\": 1,\n"
            . "      \"tytul_sceny\": \"Scene title\",\n"
            . "      \"opis_wizualny\": \"Detailed visual description for image generation in English, cinematic, specific colors, lighting, camera angle\",\n"
            . "      \"narracja\": \"Poetic narration text in {$jezykNazwa} to be spoken aloud (2-3 sentences)\",\n"
            . "      \"nastroj_muzyczny\": \"Music mood description in English for music generation (e.g. ethereal ambient with soft piano)\",\n"
            . "      \"opis_wideo\": \"Brief video motion description in English (e.g. slow camera pan across misty landscape)\"\n"
            . "    }\n"
            . "  ]\n"
            . "}";

        $wiadomosci = [
            ['role' => 'system', 'content' => $systemowy],
            ['role' => 'user',   'content' => $prompt],
        ];

        $lista = $this->listaFallback('tekst');

        $wynik = $this->sprobujZListy($lista, function (string $model) use ($wiadomosci) {
            $odpowiedz = $this->api->czatUzupelnienie($wiadomosci, $model, true);
            $tresc = $odpowiedz['choices'][0]['message']['content'] ?? '';

            $tresc = preg_replace('/^```(?:json)?\s*/m', '', $tresc);
            $tresc = preg_replace('/\s*```\s*$/m', '', $tresc);
            $tresc = trim($tresc);

            $poczatek = strpos($tresc, '{');
            $koniec   = strrpos($tresc, '}');
            if ($poczatek !== false && $koniec !== false && $poczatek < $koniec) {
                $tresc = substr($tresc, $poczatek, $koniec - $poczatek + 1);
            }

            $scenariusz = json_decode($tresc, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new RuntimeException("Blad parsowania JSON (model: {$model}): " . json_last_error_msg());
            }

            return ['dane' => $scenariusz, 'model' => $model];
        });

        $scenariusz = $wynik['dane'];

        file_put_contents(
            $this->katalogProjektu . '/scenariusz.json',
            json_encode($scenariusz, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );

        $scenariusz['_model_tekst'] = $wynik['model'];

        return $scenariusz;
    }

    /**
     * KROK 2: Generuj obraz dla sceny
     */
    public function generujObrazSceny(int $numerSceny, string $opisWizualny): array
    {
        $prompt    = $opisWizualny . ", dreamlike surreal atmosphere, cinematic lighting, 8k quality, film still";
        $negatywny = "text, watermark, logo, blurry, low quality, distorted, ugly";
        $lista     = $this->listaFallback('obraz');

        $wynik = $this->sprobujZListy($lista, function (string $model) use ($prompt, $negatywny) {
            return [
                'dane'  => $this->api->generujObraz(
                    $prompt, $model,
                    $this->modele['obraz_szerokosc'] ?? 1280,
                    $this->modele['obraz_wysokosc']  ?? 720,
                    true, $negatywny
                ),
                'model' => $model,
            ];
        });

        $plik = "obrazy/scena_{$numerSceny}.jpg";
        file_put_contents($this->katalogProjektu . '/' . $plik, $wynik['dane']);

        return [
            'plik'  => $plik,
            'model' => $wynik['model'],
        ];
    }

    /**
     * KROK 3: Generuj narracje glosowa dla sceny
     */
    public function generujNarracjeSceny(int $numerSceny, string $tekstNarracji, string $typGlosu = 'narracja_tajemna'): array
    {
        $lista = $this->listaGlosow($typGlosu);

        $wynik = $this->sprobujZListy($lista, function (string $glos) use ($tekstNarracji) {
            return [
                'dane' => $this->api->generujMowe($tekstNarracji, $glos, 'mp3'),
                'glos' => $glos,
            ];
        });

        $plik = "narracja/scena_{$numerSceny}.mp3";
        file_put_contents($this->katalogProjektu . '/' . $plik, $wynik['dane']);

        return [
            'plik' => $plik,
            'glos' => $wynik['glos'],
        ];
    }

    /**
     * KROK 4: Generuj muzyke tla dla sceny
     */
    public function generujMuzykeSceny(int $numerSceny, string $nastrojMuzyczny): array
    {
        $opis = $nastrojMuzyczny . ", cinematic film score, atmospheric";
        $czas = $this->modele['muzyka']['czas_sek'] ?? 20;

        $dane = $this->api->generujMuzyke($opis, $czas, true);

        $plik = "muzyka/scena_{$numerSceny}.mp3";
        file_put_contents($this->katalogProjektu . '/' . $plik, $dane);

        return [
            'plik' => $plik,
        ];
    }

    /**
     * KROK 5: Generuj wideo dla sceny
     */
    public function generujWideoSceny(int $numerSceny, string $opisWideo, ?string $sciezkaObrazu = null): array
    {
        $prompt = $opisWideo . ", dreamlike surreal cinematic";
        $lista  = $this->listaFallback('wideo');

        $wynik = $this->sprobujZListy($lista, function (string $model) use ($prompt) {
            return [
                'dane'  => $this->api->generujWideo(
                    $prompt, $model,
                    $this->modele['wideo_czas_sek']  ?? 4,
                    $this->modele['wideo_proporcje'] ?? '16:9',
                    $this->modele['wideo_dzwiek']    ?? true,
                    null
                ),
                'model' => $model,
            ];
        });

        $plik = "wideo/scena_{$numerSceny}.mp4";
        file_put_contents($this->katalogProjektu . '/' . $plik, $wynik['dane']);

        return [
            'plik'  => $plik,
            'model' => $wynik['model'],
        ];
    }

    /**
     * KROK 6: Zapisz sen do publicznego archiwum pliki/sny/
     */
    public function zapiszSen(array $daneSnu, string $jezyk = 'pl'): array
    {
        $data    = date('Y/m/d');
        $tytul   = $daneSnu['tytul'] ?? 'sen';
        $slug    = $this->slugify($tytul);

        $katGrafika = __DIR__ . '/../pliki/sny/grafika/' . $data;
        $katFilm    = __DIR__ . '/../pliki/sny/film/'    . $data;
        $katDane    = __DIR__ . '/../pliki/sny/dane/'    . $data;

        // Unikalny slug (unikanie kolizji tego samego dnia)
        $slug = $this->unikalnySlug($slug, $katDane);

        foreach ([$katGrafika, $katFilm, $katDane] as $kat) {
            if (!is_dir($kat)) {
                mkdir($kat, 0755, true);
            }
        }

        // Zapisz obraz sceny 1 jako WebP
        $zrodloObraz = $this->katalogProjektu . '/obrazy/scena_1.jpg';
        $docelObraz  = $katGrafika . '/' . $slug . '.webp';
        $urlObraz    = null;

        if (file_exists($zrodloObraz)) {
            if ($this->konwertujNaWebp($zrodloObraz, $docelObraz)) {
                $urlObraz = 'pliki/sny/grafika/' . $data . '/' . $slug . '.webp';
            }
        }

        // Zapisz wideo sceny 1 (jesli istnieje)
        $zrodloFilm = $this->katalogProjektu . '/wideo/scena_1.mp4';
        $urlFilm    = null;

        if (file_exists($zrodloFilm)) {
            $docelFilm = $katFilm . '/' . $slug . '.mp4';
            if (copy($zrodloFilm, $docelFilm)) {
                $urlFilm = 'pliki/sny/film/' . $data . '/' . $slug . '.mp4';
            }
        }

        // Zbierz dane scen (sciezki wzgledne od roota)
        $sceny = [];
        foreach ($daneSnu['sceny'] ?? [] as $scena) {
            $sceny[] = [
                'numer'        => $scena['numer']        ?? 0,
                'tytul'        => $scena['tytul']        ?? '',
                'narracja'     => $scena['narracja']     ?? '',
                'obraz'        => $scena['obraz']        ?? null,
                'narracja_plik' => $scena['narracja_plik'] ?? null,
                'muzyka_plik'  => $scena['muzyka_plik']  ?? null,
                'wideo_plik'   => $scena['wideo_plik']   ?? null,
            ];
        }

        // Metadane snu
        $meta = [
            'slug'        => $slug,
            'tytul'       => $daneSnu['tytul']   ?? '',
            'wstep'       => $daneSnu['wstep']   ?? '',
            'gatunek'     => $daneSnu['gatunek'] ?? '',
            'nastroj'     => $daneSnu['nastroj'] ?? '',
            'jezyk'       => $jezyk,
            'data'        => date('Y-m-d'),
            'czas'        => date('H:i:s'),
            'id_projektu' => $this->idProjektu,
            'obraz'       => $urlObraz,
            'film'        => $urlFilm,
            'sceny'       => $sceny,
        ];

        file_put_contents(
            $katDane . '/' . $slug . '.json',
            json_encode($meta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );

        return [
            'slug'  => $slug,
            'url'   => 'sny/' . $data . '/' . $slug,
            'obraz' => $urlObraz,
            'film'  => $urlFilm,
        ];
    }

    /**
     * Zamienia tytul na slug URL (obsługa polskich znaków)
     */
    private function slugify(string $tekst): string
    {
        $mapa = [
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n',
            'ó' => 'o', 'ś' => 's', 'ź' => 'z', 'ż' => 'z',
            'Ą' => 'a', 'Ć' => 'c', 'Ę' => 'e', 'Ł' => 'l', 'Ń' => 'n',
            'Ó' => 'o', 'Ś' => 's', 'Ź' => 'z', 'Ż' => 'z',
        ];
        $tekst = mb_strtolower(strtr($tekst, $mapa), 'UTF-8');
        $tekst = preg_replace('/[^a-z0-9]+/', '-', $tekst);
        $tekst = trim($tekst, '-');
        return $tekst ?: 'sen';
    }

    /**
     * Zwraca unikalny slug przez dodanie sufixu jesli plik juz istnieje
     */
    private function unikalnySlug(string $slug, string $katalog): string
    {
        if (!file_exists($katalog . '/' . $slug . '.json')) {
            return $slug;
        }
        $i = 2;
        while (file_exists($katalog . '/' . $slug . '-' . $i . '.json')) {
            $i++;
        }
        return $slug . '-' . $i;
    }

    /**
     * Konwersja obrazu do formatu WebP przy uzyciu GD
     */
    private function konwertujNaWebp(string $zrodlo, string $cel): bool
    {
        if (!function_exists('imagewebp') || !function_exists('imagecreatefromstring')) {
            // Fallback: kopiuj jako jpg jesli brak GD
            $celJpg = preg_replace('/\.webp$/', '.jpg', $cel);
            return copy($zrodlo, $celJpg);
        }

        $im = imagecreatefromstring(file_get_contents($zrodlo));
        if ($im === false) {
            return copy($zrodlo, $cel . '.jpg');
        }

        $wynik = imagewebp($im, $cel, 85);
        imagedestroy($im);
        return $wynik;
    }

    /**
     * Transkrypcja nagrania glosowego snu
     */
    public function transkrybujSen(string $sciezkaAudio, string $jezyk = 'pl'): string
    {
        $wynik = $this->api->transkrybujAudio($sciezkaAudio, $jezyk);
        return $wynik['text'] ?? '';
    }

    /**
     * Pobierz sciezke projektu (wzgledna dla URL)
     */
    public function pobierzUrlProjektu(): string
    {
        return 'projekty/' . $this->idProjektu;
    }

    public function pobierzIdProjektu(): string
    {
        return $this->idProjektu;
    }
}
