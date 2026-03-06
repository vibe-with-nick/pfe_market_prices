<?php
class I18n {
    public static function lang(): string {
        $app = require __DIR__ . '/../config/app.php';
        Auth::start();
        $l = $_GET['lang'] ?? ($_SESSION['user']['lang'] ?? $app['default_lang']);
        if (!in_array($l, ['fr','en','mfe'], true)) $l='fr';
        return $l;
    }
    public static function t(string $key): string {
        $lang = self::lang();
        $dict = require __DIR__ . "/../views/lang/{$lang}.php";
        return $dict[$key] ?? $key;
    }
}
