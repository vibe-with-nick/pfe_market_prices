<?php
class AuthController {
    public function login(): void {
        $pdo = Database::pdo();

        if ($_SERVER['REQUEST_METHOD']==='POST') {
            Auth::verifyCsrf();
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $stmt = $pdo->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
            $stmt->execute([$email]);
            $u = $stmt->fetch();

            if (!$u || !password_verify($password, $u['password_hash'])) {
                $error = "Identifiants invalides.";
                view('auth/login', compact('error'));
                return;
            }

            Auth::login([
                'id'=>$u['id'], 'name'=>$u['name'], 'email'=>$u['email'], 'role'=>$u['role'], 'lang'=>$u['lang']
            ]);
            redirectTo($u['role']==='admin' ? '/admin' : '/prices');
        }

        view('auth/login');
    }

    public function register(): void {
        $pdo = Database::pdo();

        if ($_SERVER['REQUEST_METHOD']==='POST') {
            Auth::verifyCsrf();
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $lang = $_POST['lang'] ?? 'fr';

            $errors=[];
            if ($name==='' || strlen($name)<3) $errors[]="Nom invalide.";
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[]="Email invalide.";
            if (strlen($password)<8) $errors[]="Mot de passe min 8 caractères.";

            $stmt = $pdo->prepare("SELECT id FROM users WHERE email=? LIMIT 1");
            $stmt->execute([$email]);
            if ($stmt->fetch()) $errors[]="Email déjà utilisé.";

            if ($errors) { view('auth/register', ['errors'=>$errors]); return; }

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name,email,password_hash,role,lang,created_at) VALUES (?,?,?,?,?,NOW())");
            $stmt->execute([$name,$email,$hash,'user',$lang]);

            Auth::login([
                'id'=>$pdo->lastInsertId(), 'name'=>$name, 'email'=>$email, 'role'=>'user', 'lang'=>$lang
            ]);
            redirectTo('/prices');
        }

        view('auth/register');
    }

    public function logout(): void {
        Auth::logout();
        redirectTo('/home');
    }
}
