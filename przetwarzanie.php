<?php
/**
 * Punkt wejscia AJAX — obsluguje kroki generowania filmu
 * 
 * Kazdy krok jest osobnym zapytaniem AJAX, aby aktualizowac postep w czasie rzeczywistym
 */

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

// ── TRYB DEBUG (ustaw na false na produkcji) ──
define('DEBUG', true);

ini_set('display_errors', 0); // Bledy PHP nie moga psuć JSON
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/debug.log');

// Przechwytuj fatalne bledy PHP i zapisz do loga + zwroc JSON
register_shutdown_function(function () {
    $blad = error_get_last();
    if ($blad && in_array($blad['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        debugLog('FATAL PHP', $blad['message'] . ' w ' . $blad['file'] . ':' . $blad['line']);
        if (!headers_sent()) {
            http_response_code(500);
            echo json_encode([
                'sukces' => false,
                'blad'   => 'Blad PHP: ' . $blad['message'],
                'plik'   => $blad['file'] . ':' . $blad['line'],
            ], JSON_UNESCAPED_UNICODE);
        }
    }
});

// Sesja
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Zaladuj klasy
require_once __DIR__ . '/klasy/Api.php';
require_once __DIR__ . '/klasy/Generator.php';

// Konfiguracja
$konfApi = require __DIR__ . '/konfiguracja/klucz_api.php';
$konfModele = require __DIR__ . '/konfiguracja/modele.php';

// Inicjalizacja
$api = new Api($konfApi['klucz'], $konfApi['baza_url']);
$generator = new GeneratorFilmu($api, $konfModele);

// Odczytaj dane wejsciowe
// Dla transkrypcji krok jest w naglowku X-Krok (body to FormData, nie JSON)
$rawInput = file_get_contents('php://input');
$wejscie = json_decode($rawInput, true) ?? [];
$krok = $_SERVER['HTTP_X_KROK'] ?? $wejscie['krok'] ?? '';

debugLog('REQUEST', [
    'krok'         => $krok,
    'method'       => $_SERVER['REQUEST_METHOD'],
    'content_type' => $_SERVER['CONTENT_TYPE'] ?? 'brak',
    'wejscie'      => $wejscie,
    'files'        => array_map(fn($f) => ['name' => $f['name'], 'size' => $f['size'], 'error' => $f['error']], $_FILES),
]);

try {
    switch ($krok) {

        // ── KROK 0: Transkrypcja audio (opcjonalnie) ──
        case 'transkrypcja':
            if (!isset($_FILES['audio'])) {
                throw new RuntimeException('Brak pliku audio');
            }

            $jezyk = $_POST['jezyk'] ?? 'pl';
            $tekst = $generator->transkrybujSen($_FILES['audio']['tmp_name'], $jezyk);

            odpowiedzJson(['tekst' => $tekst]);
            break;

        // ── KROK 1: Inicjalizacja + scenariusz ──
        case 'scenariusz':
            $opisSnu = $wejscie['opis_snu'] ?? '';
            $jezyk = $wejscie['jezyk'] ?? 'pl';

            if (mb_strlen($opisSnu) < 20) {
                throw new RuntimeException('Opis snu jest za krotki');
            }

            $idProjektu = $generator->inicjalizujProjekt();
            $scenariusz = $generator->generujScenariusz($opisSnu, $jezyk);

            // Zapisz ID projektu w sesji
            $_SESSION['id_projektu'] = $idProjektu;

            odpowiedzJson([
                'id_projektu' => $idProjektu,
                'scenariusz'  => $scenariusz,
                'url_projektu' => $generator->pobierzUrlProjektu(),
            ]);
            break;

        // ── KROK 2: Generuj obraz sceny ──
        case 'obraz':
            $idProjektu = $wejscie['id_projektu'] ?? '';
            $numerSceny = (int) ($wejscie['numer_sceny'] ?? 0);
            $opisWizualny = $wejscie['opis_wizualny'] ?? '';

            walidujProjekt($idProjektu);
            $generator->ustawProjekt($idProjektu);

            $wynik = $generator->generujObrazSceny($numerSceny, $opisWizualny);

            odpowiedzJson([
                'plik'  => $wynik['plik'],
                'model' => $wynik['model'],
            ]);
            break;

        // ── KROK 3: Generuj narracje glosowa ──
        case 'narracja':
            $idProjektu = $wejscie['id_projektu'] ?? '';
            $numerSceny = (int) ($wejscie['numer_sceny'] ?? 0);
            $tekst = $wejscie['tekst_narracji'] ?? '';
            $typGlosu = $wejscie['typ_glosu'] ?? 'narracja_tajemna';

            walidujProjekt($idProjektu);
            $generator->ustawProjekt($idProjektu);

            $wynik = $generator->generujNarracjeSceny($numerSceny, $tekst, $typGlosu);

            odpowiedzJson([
                'plik' => $wynik['plik'],
                'glos' => $wynik['glos'],
            ]);
            break;

        // ── KROK 4: Generuj muzyke ──
        case 'muzyka':
            $idProjektu = $wejscie['id_projektu'] ?? '';
            $numerSceny = (int) ($wejscie['numer_sceny'] ?? 0);
            $nastroj = $wejscie['nastroj_muzyczny'] ?? '';

            walidujProjekt($idProjektu);
            $generator->ustawProjekt($idProjektu);

            $wynik = $generator->generujMuzykeSceny($numerSceny, $nastroj);

            odpowiedzJson([
                'plik' => $wynik['plik'],
            ]);
            break;

        // ── KROK 5: Generuj wideo (opcjonalnie) ──
        case 'wideo':
            $idProjektu    = $wejscie['id_projektu'] ?? '';
            $numerSceny    = (int) ($wejscie['numer_sceny'] ?? 0);
            $opisWideo     = $wejscie['opis_wideo'] ?? '';
            $sciezkaObrazu = $wejscie['sciezka_obrazu'] ?? null;

            walidujProjekt($idProjektu);
            $generator->ustawProjekt($idProjektu);

            $wynik = $generator->generujWideoSceny($numerSceny, $opisWideo, $sciezkaObrazu);

            odpowiedzJson([
                'plik'  => $wynik['plik'],
                'model' => $wynik['model'],
            ]);
            break;

        // ── KROK 6: Zapisz sen do publicznego archiwum ──
        case 'zapisz':
            $idProjektu = $wejscie['id_projektu'] ?? '';
            $daneSnu    = $wejscie['dane_snu']    ?? [];
            $jezyk      = $wejscie['jezyk']       ?? 'pl';

            walidujProjekt($idProjektu);
            $generator->ustawProjekt($idProjektu);

            $wynik = $generator->zapiszSen($daneSnu, $jezyk);

            odpowiedzJson([
                'slug'  => $wynik['slug'],
                'url'   => $wynik['url'],
                'obraz' => $wynik['obraz'],
                'film'  => $wynik['film'],
            ]);
            break;

        default:
            throw new RuntimeException('Nieznany krok: ' . $krok);
    }

} catch (RuntimeException $e) {
    debugLog('RuntimeException [krok=' . $krok . ']', [
        'komunikat' => $e->getMessage(),
        'plik'      => $e->getFile() . ':' . $e->getLine(),
        'trace'     => $e->getTraceAsString(),
    ]);
    http_response_code(400);
    $odp = ['sukces' => false, 'blad' => $e->getMessage()];
    if (DEBUG) {
        $odp['debug'] = ['plik' => $e->getFile() . ':' . $e->getLine(), 'trace' => explode("\n", $e->getTraceAsString())];
    }
    odpowiedzJson($odp);
} catch (Exception $e) {
    debugLog('Exception [krok=' . $krok . ']', [
        'klasa'     => get_class($e),
        'komunikat' => $e->getMessage(),
        'plik'      => $e->getFile() . ':' . $e->getLine(),
        'trace'     => $e->getTraceAsString(),
    ]);
    http_response_code(500);
    $odp = ['sukces' => false, 'blad' => 'Blad wewnetrzny serwera', 'szczegoly' => $e->getMessage()];
    if (DEBUG) {
        $odp['debug'] = ['klasa' => get_class($e), 'plik' => $e->getFile() . ':' . $e->getLine(), 'trace' => explode("\n", $e->getTraceAsString())];
    }
    odpowiedzJson($odp);
}

// ── Funkcje pomocnicze ──

function debugLog(string $etykieta, mixed $dane = null): void
{
    if (!DEBUG) return;
    $wpis = '[' . date('Y-m-d H:i:s') . '] [' . $etykieta . '] '
        . (is_string($dane) ? $dane : json_encode($dane, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))
        . "\n";
    file_put_contents(__DIR__ . '/debug.log', $wpis, FILE_APPEND | LOCK_EX);
}

function odpowiedzJson(array $dane): void
{
    if (!isset($dane['sukces'])) {
        $dane['sukces'] = true;
    }
    echo json_encode($dane, JSON_UNESCAPED_UNICODE);
    exit;
}

function walidujProjekt(string $id): void
{
    // Ochrona przed directory traversal
    if (empty($id) || preg_match('/[^a-zA-Z0-9_]/', $id)) {
        throw new RuntimeException('Nieprawidlowy identyfikator projektu');
    }

    $sciezka = __DIR__ . '/projekty/' . $id;
    if (!is_dir($sciezka)) {
        throw new RuntimeException('Projekt nie istnieje');
    }
}