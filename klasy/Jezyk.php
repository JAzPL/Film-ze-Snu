<?php
/**
 * System wielojezyczny z automatycznym wykrywaniem plikow jezykowych
 * i detekcja jezyka przegladarki
 */

class Jezyk
{
    private string $katalogJezykow;
    private string $domyslnyJezyk = 'pl';
    private string $aktualnyJezyk;
    private array $tlumaczenia = [];
    private array $dostepneJezyki = [];

    public function __construct(string $katalogJezykow)
    {
        $this->katalogJezykow = rtrim($katalogJezykow, '/');
        $this->skanujDostepneJezyki();
        $this->aktualnyJezyk = $this->wykryjJezyk();
        $this->zaladujTlumaczenia();
    }

    /**
     * Automatyczne skanowanie katalogu jezyk/ w poszukiwaniu plikow *.php
     */
    private function skanujDostepneJezyki(): void
    {
        $pliki = glob($this->katalogJezykow . '/*.php');

        foreach ($pliki as $plik) {
            $kod = pathinfo($plik, PATHINFO_FILENAME);
            $dane = require $plik;

            if (is_array($dane) && isset($dane['_meta']['nazwa'])) {
                $this->dostepneJezyki[$kod] = [
                    'nazwa'    => $dane['_meta']['nazwa'],
                    'ikona'    => $dane['_meta']['ikona'] ?? '',
                    'kierunek' => $dane['_meta']['kierunek'] ?? 'ltr',
                    'kod_html' => $dane['_meta']['kod_html'] ?? $kod,
                ];
            }
        }
    }

    /**
     * Wykrywanie jezyka: parametr URL > sesja > ciasteczko > przegladarka > domyslny
     */
    private function wykryjJezyk(): string
    {
        // 1. Parametr URL (?jezyk=en)
        if (isset($_GET['jezyk']) && $this->czyDostepny($_GET['jezyk'])) {
            $jezyk = $_GET['jezyk'];
            $this->zapiszWybor($jezyk);
            return $jezyk;
        }

        // 2. Sesja
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['jezyk']) && $this->czyDostepny($_SESSION['jezyk'])) {
            // Odswiezaj cookie aby przedluzac waznosc preferencji
            $this->zapiszWybor($_SESSION['jezyk']);
            return $_SESSION['jezyk'];
        }

        // 3. Ciasteczko
        if (isset($_COOKIE['jezyk']) && $this->czyDostepny($_COOKIE['jezyk'])) {
            // Zapisz tez do sesji i odswiezaj cookie
            $this->zapiszWybor($_COOKIE['jezyk']);
            return $_COOKIE['jezyk'];
        }

        // 4. Naglowek Accept-Language przegladarki
        $jezykPrzegladarki = $this->wykryjJezykPrzegladarki();
        if ($jezykPrzegladarki !== null) {
            $this->zapiszWybor($jezykPrzegladarki);
            return $jezykPrzegladarki;
        }

        // 5. Domyslny
        return $this->domyslnyJezyk;
    }

    /**
     * Parsowanie naglowka Accept-Language
     */
    private function wykryjJezykPrzegladarki(): ?string
    {
        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return null;
        }

        $naglowek = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $jezyki = [];

        // Parsuj np. "pl-PL,pl;q=0.9,en-GB;q=0.8,en;q=0.7"
        preg_match_all('/([a-zA-Z]{1,8}(?:-[a-zA-Z]{1,8})?)(?:\s*;\s*q\s*=\s*(1(?:\.0{0,3})?|0(?:\.\d{0,3})))?/', $naglowek, $dopasowania);

        foreach ($dopasowania[1] as $i => $kod) {
            $priorytet = isset($dopasowania[2][$i]) && $dopasowania[2][$i] !== ''
                ? (float) $dopasowania[2][$i]
                : 1.0;
            $jezyki[$kod] = $priorytet;
        }

        arsort($jezyki);

        foreach ($jezyki as $kod => $priorytet) {
            // Dokladne dopasowanie (np. "pl")
            $kodKrotki = strtolower(substr($kod, 0, 2));
            if ($this->czyDostepny($kodKrotki)) {
                return $kodKrotki;
            }
        }

        return null;
    }

    private function zapiszWybor(string $jezyk): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['jezyk'] = $jezyk;
        setcookie('jezyk', $jezyk, time() + 365 * 24 * 3600, '/', '', false, true);
    }

    private function czyDostepny(string $kod): bool
    {
        return isset($this->dostepneJezyki[$kod]);
    }

    private function zaladujTlumaczenia(): void
    {
        $plik = $this->katalogJezykow . '/' . $this->aktualnyJezyk . '.php';
        if (file_exists($plik)) {
            $this->tlumaczenia = require $plik;
        }
    }

    /**
     * Pobierz tlumaczenie po kluczu (dot notation: 'naglowek.tytul')
     */
    public function t(string $klucz, array $parametry = []): string
    {
        $czesci = explode('.', $klucz);
        $wartosc = $this->tlumaczenia;

        foreach ($czesci as $czesc) {
            if (is_array($wartosc) && isset($wartosc[$czesc])) {
                $wartosc = $wartosc[$czesc];
            } else {
                return $klucz; // Zwroc klucz jesli brak tlumaczenia
            }
        }

        if (!is_string($wartosc)) {
            return $klucz;
        }

        // Podmiana parametrow {nazwa}
        foreach ($parametry as $nazwa => $zawartosc) {
            $wartosc = str_replace('{' . $nazwa . '}', $zawartosc, $wartosc);
        }

        return $wartosc;
    }

    public function pobierzAktualny(): string
    {
        return $this->aktualnyJezyk;
    }

    public function pobierzKodHtml(): string
    {
        return $this->dostepneJezyki[$this->aktualnyJezyk]['kod_html'] ?? $this->aktualnyJezyk;
    }

    public function pobierzKierunek(): string
    {
        return $this->dostepneJezyki[$this->aktualnyJezyk]['kierunek'] ?? 'ltr';
    }

    public function pobierzDostepne(): array
    {
        return $this->dostepneJezyki;
    }

    /**
     * Generuje tagi hreflang dla SEO
     */
    public function generujHreflang(string $bazaUrl): string
    {
        $tagi = '';
        foreach ($this->dostepneJezyki as $kod => $dane) {
            $kodHtml = $dane['kod_html'];
            $tagi .= '<link rel="alternate" hreflang="' . htmlspecialchars($kodHtml) . '" '
                    . 'href="' . htmlspecialchars($bazaUrl . '?jezyk=' . $kod) . '" />' . "\n";
        }
        $tagi .= '<link rel="alternate" hreflang="x-default" '
                . 'href="' . htmlspecialchars($bazaUrl) . '" />' . "\n";
        return $tagi;
    }

    /**
     * Eksportuje tlumaczenia do JSON (dla JavaScript)
     */
    public function eksportujDoJson(): string
    {
        $doEksportu = $this->tlumaczenia;
        unset($doEksportu['_meta']);
        return json_encode($doEksportu, JSON_UNESCAPED_UNICODE);
    }
}