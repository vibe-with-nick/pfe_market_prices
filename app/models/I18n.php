<?php
class I18n {
    private static string $lang = '';
    private static array  $dict = [];

    public static function lang(): string {
        if (self::$lang === '') {
            Auth::start();
            $default = Config::get('default_lang', 'fr');
            if (isset($_GET['lang']) && in_array($_GET['lang'], ['fr', 'en', 'mfe'], true)) {
                $_SESSION['lang'] = $_GET['lang'];
            }
            $l = $_SESSION['lang'] ?? ($_SESSION['user']['lang'] ?? $default);
            self::$lang = in_array($l, ['fr', 'en', 'mfe'], true) ? $l : 'fr';
        }
        return self::$lang;
    }

    public static function t(string $key): string {
        if (self::$dict === []) {
            self::$dict = require __DIR__ . '/../views/lang/' . self::lang() . '.php';
        }
        return self::$dict[$key] ?? $key;
    }
}
