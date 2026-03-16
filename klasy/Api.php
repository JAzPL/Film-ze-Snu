<?php
/**
 * Klasa komunikacji z Pollinations API
 */

class Api
{
    private string $kluczApi;
    private string $bazaUrl;
    private int $czasOczekiwania;

    public function __construct(string $kluczApi, string $bazaUrl, int $czasOczekiwania = 300)
    {
        $this->kluczApi       = $kluczApi;
        $this->bazaUrl        = rtrim($bazaUrl, '/');
        $this->czasOczekiwania = $czasOczekiwania;
    }

    /**
     * Generowanie tekstu przez GET /text/{prompt}
     */
    public function generujTekst(string $prompt, string $model, bool $json = false, ?string $systemowy = null): string
    {
        $parametry = [
            'model' => $model,
            'json'  => $json ? 'true' : 'false',
        ];

        if ($systemowy !== null) {
            $parametry['system'] = $systemowy;
        }

        $url = $this->bazaUrl . '/text/' . rawurlencode($prompt) . '?' . http_build_query($parametry);

        return $this->zapytanieGet($url);
    }

    /**
     * Generowanie tekstu przez POST /v1/chat/completions (OpenAI-compatible)
     */
    public function czatUzupelnienie(array $wiadomosci, string $model, bool $json = false): array
    {
        $dane = [
            'model'    => $model,
            'messages' => $wiadomosci,
        ];

        if ($json) {
            $dane['response_format'] = ['type' => 'json_object'];
        }

        $url = $this->bazaUrl . '/v1/chat/completions';
        $odpowiedz = $this->zapytaniePost($url, $dane);

        return json_decode($odpowiedz, true);
    }

    /**
     * Generowanie obrazu przez GET /image/{prompt}
     */
    public function generujObraz(
        string $prompt,
        string $model,
        int $szerokosc = 1280,
        int $wysokosc = 720,
        bool $ulepszenie = true,
        ?string $negatywny = null,
        bool $przezroczystosc = false
    ): string {
        $parametry = [
            'model'   => $model,
            'width'   => $szerokosc,
            'height'  => $wysokosc,
            'enhance' => $ulepszenie ? 'true' : 'false',
            'seed'    => -1,
        ];

        if ($negatywny !== null) {
            $parametry['negative_prompt'] = $negatywny;
        }

        if ($przezroczystosc) {
            $parametry['transparent'] = 'true';
        }

        $url = $this->bazaUrl . '/image/' . rawurlencode($prompt) . '?' . http_build_query($parametry);

        return $this->zapytanieGetBinarne($url);
    }

    /**
     * Generowanie wideo przez GET /video/{prompt}
     */
    public function generujWideo(
        string $prompt,
        string $model,
        int $czasSek = 4,
        string $proporcje = '16:9',
        bool $dzwiek = true,
        ?string $obrazReferencyjny = null
    ): string {
        $parametry = [
            'model'       => $model,
            'duration'    => $czasSek,
            'aspectRatio' => $proporcje,
            'audio'       => $dzwiek ? 'true' : 'false',
            'enhance'     => 'true',
            'seed'        => -1,
        ];

        if ($obrazReferencyjny !== null) {
            $parametry['image'] = $obrazReferencyjny;
        }

        $url = $this->bazaUrl . '/video/' . rawurlencode($prompt) . '?' . http_build_query($parametry);

        return $this->zapytanieGetBinarne($url);
    }

    /**
     * Generowanie mowy (TTS) przez GET /audio/{text}
     */
    public function generujMowe(string $tekst, string $glos = 'nova', string $format = 'mp3'): string
    {
        $parametry = [
            'voice'           => $glos,
            'response_format' => $format,
        ];

        $url = $this->bazaUrl . '/audio/' . rawurlencode($tekst) . '?' . http_build_query($parametry);

        return $this->zapytanieGetBinarne($url);
    }

    /**
     * Generowanie muzyki przez GET /audio/{text} z model=elevenmusic
     */
    public function generujMuzyke(string $opis, int $czasSek = 20, bool $instrumentalna = true): string
    {
        $parametry = [
            'model'        => 'elevenmusic',
            'duration'     => $czasSek,
            'instrumental' => $instrumentalna ? 'true' : 'false',
        ];

        $url = $this->bazaUrl . '/audio/' . rawurlencode($opis) . '?' . http_build_query($parametry);

        return $this->zapytanieGetBinarne($url);
    }

    /**
     * Transkrypcja audio POST /v1/audio/transcriptions
     */
    public function transkrybujAudio(string $sciezkaPliku, string $jezyk = 'pl', string $model = 'whisper-large-v3'): array
    {
        $url = $this->bazaUrl . '/v1/audio/transcriptions';

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => $this->czasOczekiwania,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $this->kluczApi,
            ],
            CURLOPT_POSTFIELDS     => [
                'file'     => new CURLFile($sciezkaPliku),
                'model'    => $model,
                'language' => $jezyk,
                'response_format' => 'json',
            ],
        ]);

        $odpowiedz = curl_exec($ch);
        $kod = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $blad = curl_error($ch);
        curl_close($ch);

        if ($blad) {
            throw new RuntimeException("Blad transkrypcji: {$blad}");
        }
        if ($kod !== 200) {
            throw new RuntimeException("Blad API transkrypcji (HTTP {$kod}): {$odpowiedz}");
        }

        return json_decode($odpowiedz, true);
    }

    /**
     * Pobiera liste dostepnych modeli
     */
    public function pobierzModele(string $typ = 'text'): array
    {
        $url = $this->bazaUrl . '/' . $typ . '/models';
        $odpowiedz = $this->zapytanieGet($url);
        return json_decode($odpowiedz, true) ?: [];
    }

    // ── Metody prywatne ──

    private function zapytanieGet(string $url): string
    {
        $this->log('GET', $url);
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => $this->czasOczekiwania,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $this->kluczApi,
                'Accept: application/json, text/plain',
            ],
        ]);

        $odpowiedz = curl_exec($ch);
        $kod = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $blad = curl_error($ch);
        curl_close($ch);

        $this->log('GET response', ['http' => $kod, 'dlugosc' => strlen($odpowiedz), 'podglad' => substr($odpowiedz, 0, 300)]);

        if ($blad) {
            throw new RuntimeException("Blad polaczenia: {$blad}");
        }
        if ($kod >= 400) {
            throw new RuntimeException("Blad API (HTTP {$kod}): {$odpowiedz}");
        }

        return $odpowiedz;
    }

    private function zapytanieGetBinarne(string $url): string
    {
        $this->log('GET binary', $url);
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => $this->czasOczekiwania,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $this->kluczApi,
            ],
        ]);

        $odpowiedz = curl_exec($ch);
        $kod = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $blad = curl_error($ch);
        curl_close($ch);

        $this->log('GET binary response', ['http' => $kod, 'bajty' => strlen($odpowiedz)]);

        if ($blad) {
            throw new RuntimeException("Blad pobierania: {$blad}");
        }
        if ($kod >= 400) {
            throw new RuntimeException("Blad API (HTTP {$kod})");
        }

        return $odpowiedz;
    }

    private function zapytaniePost(string $url, array $dane): string
    {
        $json = json_encode($dane);
        $this->log('POST', ['url' => $url, 'body' => substr($json, 0, 500)]);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => $this->czasOczekiwania,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $this->kluczApi,
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS     => $json,
        ]);

        $odpowiedz = curl_exec($ch);
        $kod = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $blad = curl_error($ch);
        curl_close($ch);

        $this->log('POST response', ['http' => $kod, 'podglad' => substr($odpowiedz, 0, 500)]);

        if ($blad) {
            throw new RuntimeException("Blad polaczenia POST: {$blad}");
        }
        if ($kod >= 400) {
            throw new RuntimeException("Blad API POST (HTTP {$kod}): {$odpowiedz}");
        }

        return $odpowiedz;
    }

    private function log(string $etykieta, mixed $dane = null): void
    {
        if (!defined('DEBUG') || !DEBUG) return;
        $wpis = '[' . date('Y-m-d H:i:s') . '] [Api:' . $etykieta . '] '
            . (is_string($dane) ? $dane : json_encode($dane, JSON_UNESCAPED_UNICODE))
            . "\n";
        file_put_contents(dirname(__DIR__) . '/debug.log', $wpis, FILE_APPEND | LOCK_EX);
    }
}