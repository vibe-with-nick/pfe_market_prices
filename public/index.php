<?php
require __DIR__ . '/../app/models/Database.php';
require __DIR__ . '/../app/models/Auth.php';
require __DIR__ . '/../app/models/I18n.php';

$app = require __DIR__ . '/../app/config/app.php';
date_default_timezone_set($app['timezone']);
Auth::start();

function view(string $view, array $data = []): void {
    extract($data);
    $app = require __DIR__ . '/../app/config/app.php';
    require __DIR__ . '/../app/views/layouts/header.php';
    require __DIR__ . '/../app/views/' . $view . '.php';
    require __DIR__ . '/../app/views/layouts/footer.php';
}
function redirectTo(string $path): void {
    $app = require __DIR__ . '/../app/config/app.php';
    header('Location: ' . rtrim($app['base_url'],'/') . $path);
    exit;
}

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = rtrim($app['base_url'], '/');
$route = '/' . ltrim(str_replace($base, '', $path), '/');

require __DIR__ . '/../app/controllers/Routes.php';
