<?php
class Auth {
    public static function start(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
    }
    public static function user(): ?array { self::start(); return $_SESSION['user'] ?? null; }
    public static function check(): bool { return self::user() !== null; }
    public static function isAdmin(): bool { $u=self::user(); return $u && $u['role']==='admin'; }

    public static function login(array $user): void {
        self::start();
        $_SESSION['user'] = $user;
        session_regenerate_id(true);
    }
    public static function logout(): void {
        self::start();
        $_SESSION = [];
        session_destroy();
    }
    public static function csrfToken(): string {
        self::start();
        if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
        return $_SESSION['csrf'];
    }
    public static function verifyCsrf(): void {
        self::start();
        $t = $_POST['csrf'] ?? '';
        if (!$t || !hash_equals($_SESSION['csrf'] ?? '', $t)) { http_response_code(403); exit('CSRF invalide'); }
    }
}
