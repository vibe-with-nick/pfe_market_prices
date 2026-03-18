<?php
require __DIR__ . '/../models/Mailer.php';
require __DIR__ . '/HomeController.php';
require __DIR__ . '/AuthController.php';
require __DIR__ . '/PriceController.php';
require __DIR__ . '/AdminController.php';

$home = new HomeController();
$auth = new AuthController();
$price = new PriceController();
$admin = new AdminController();

switch ($route) {
    case '/':
    case '/home': $home->index(); break;
    case '/login': $auth->login(); break;
    case '/register': $auth->register(); break;
    case '/logout': $auth->logout(); break;
    case '/forgot-password': $auth->forgotPassword(); break;
    case '/reset-password':  $auth->resetPassword();  break;
    case '/change-password': $auth->changePassword(); break;
    case '/prices': $price->index(); break;
    case '/prices/submit': $price->submit(); break;
    case '/prices/predict': $price->predict(); break;
    case '/admin': $admin->dashboard(); break;
    case '/admin/pending': $admin->pending(); break;
    case '/admin/approve': $admin->approve(); break;
    case '/admin/reject': $admin->reject(); break;
    case '/admin/products': $admin->products(); break;
    case '/admin/products/toggle': $admin->toggleProduct(); break;
    default:
        http_response_code(404);
        view('pages/404', ['route'=>$route]);
}
