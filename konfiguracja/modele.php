<?php
/**
 * Konfiguracja modeli AI
 * 
 * Modele pogrupowane wg jakosci - skrypt losowo wybiera
 * z najlepszych dostepnych modeli dla kazdego zadania.
 */

return [

    // ── Modele tekstowe (generowanie scenariusza) ──
    // Zrodlo: gen.pollinations.ai/models (2026-03-16)
    // Platne (paid_only:true): openai-large, claude, claude-large, gemini, grok, gemini-large
    'tekst' => [
        // Darmowe - najlepsze do generowania narracyjnego scenariusza
        // deepseek usunieto - model rozumujacy, zwraca tekst przed JSON
        'najlepsze' => ['openai', 'mistral'],
        // Zapasowe ultraszybkie
        'zapasowe'  => ['openai-fast', 'gemini-fast'],
    ],

    // ── Modele obrazow (wizualizacja scen) ──
    // Zrodlo: gen.pollinations.ai/image/models (2026-03-16)
    // Endpoint: GET gen.pollinations.ai/image/{prompt}
    // negative_prompt i seed obslugiwa: flux, zimage
    'obraz' => [
        'najlepsze' => ['flux'],
        'zapasowe'  => ['zimage'],
    ],

    // ── Modele wideo (animacja scen) ──
    // Darmowe: grok-video (alias: grok-imagine-video)
    'wideo' => [
        'najlepsze' => ['grok-video'],
        'zapasowe'  => ['grok-video'],
    ],

    // ── Glosy narracji (pogrupowane wg charakteru) ──
    // Zrodlo: gen.pollinations.ai/models -> openai-audio -> voices (2026-03-16)
    // Dostepne: alloy, echo, fable, onyx, nova, shimmer, coral, verse, ballad, ash, sage, amuch, dan
    'glosy' => [
        'narracja_meska'   => ['onyx', 'alloy', 'echo'],
        'narracja_zenska'  => ['nova', 'shimmer', 'coral', 'sage'],
        'narracja_tajemna' => ['echo', 'ash', 'fable', 'verse', 'ballad'],
    ],

    // ── Muzyka ──
    'muzyka' => [
        'model'    => 'elevenmusic',
        'czas_sek' => 20,
    ],

    // ── Ustawienia obrazu ──
    'obraz_szerokosc' => 1280,
    'obraz_wysokosc'  => 720,

    // ── Ustawienia wideo ──
    'wideo_czas_sek'    => 4,
    'wideo_proporcje'   => '16:9',
    'wideo_dzwiek'      => true,
];