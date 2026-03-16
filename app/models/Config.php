<?php
/**
 * Chargeur de configuration avec cache statique.
 * Le fichier app/config/app.php n'est lu qu'une seule fois par requête.
 */
class Config {
    private static ?array $data = null;

    public static function all(): array {
        if (self::$data === null) {
            self::$data = require __DIR__ . '/../config/app.php';
        }
        return self::$data;
    }

    public static function get(string $key, mixed $default = null): mixed {
        return self::all()[$key] ?? $default;
    }
}
