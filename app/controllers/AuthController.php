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
                $error = I18n::t('auth.invalid_credentials');
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
            if ($name==='' || strlen($name)<3) $errors[]=I18n::t('auth.invalid_name');
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[]=I18n::t('auth.invalid_email');
            if (strlen($password)<8) $errors[]=I18n::t('auth.new_password_short');

            $stmt = $pdo->prepare("SELECT id FROM users WHERE email=? LIMIT 1");
            $stmt->execute([$email]);
            if ($stmt->fetch()) $errors[]=I18n::t('auth.email_taken');

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

    public function forgotPassword(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Auth::verifyCsrf();
            $email = trim($_POST['email'] ?? '');

            // Toujours afficher le même message pour ne pas révéler
            // si un email est enregistré ou non (anti-énumération).
            $success = I18n::t('auth.reset_email_sent');

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $pdo  = Database::pdo();
                $stmt = $pdo->prepare("SELECT id, name FROM users WHERE email = ? LIMIT 1");
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if ($user) {
                    $plainToken = bin2hex(random_bytes(32));
                    $tokenHash  = hash('sha256', $plainToken);
                    $expiresAt  = date('Y-m-d H:i:s', time() + 3600);

                    // Un seul token actif par utilisateur
                    $pdo->prepare("DELETE FROM password_resets WHERE user_id = ?")
                        ->execute([$user['id']]);

                    $pdo->prepare(
                        "INSERT INTO password_resets (user_id, token_hash, expires_at) VALUES (?, ?, ?)"
                    )->execute([$user['id'], $tokenHash, $expiresAt]);

                    $scheme   = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
                    $host     = $_SERVER['HTTP_HOST'];
                    $resetUrl = $scheme . '://' . $host . Config::get('base_url')
                              . '/reset-password?token=' . urlencode($plainToken);

                    Mailer::sendPasswordReset($email, $user['name'], $resetUrl);
                }
            }

            view('auth/forgot-password', compact('success'));
            return;
        }

        view('auth/forgot-password');
    }

    public function resetPassword(): void {
        $token = trim($_GET['token'] ?? '');

        if ($token === '') {
            redirectTo('/login');
            return;
        }

        $pdo       = Database::pdo();
        $tokenHash = hash('sha256', $token);

        $stmt = $pdo->prepare(
            "SELECT pr.id, pr.user_id, u.name, u.email
             FROM password_resets pr
             JOIN users u ON u.id = pr.user_id
             WHERE pr.token_hash = ? AND pr.expires_at > NOW()
             LIMIT 1"
        );
        $stmt->execute([$tokenHash]);
        $reset = $stmt->fetch();

        if (!$reset) {
            $error = I18n::t('auth.reset_token_invalid');
            view('auth/reset-password', compact('error'));
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Auth::verifyCsrf();
            $newPassword     = $_POST['new_password']     ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (strlen($newPassword) < 8) {
                $error = I18n::t('auth.new_password_short');
                view('auth/reset-password', compact('error', 'token'));
                return;
            }

            if ($newPassword !== $confirmPassword) {
                $error = I18n::t('auth.passwords_not_match');
                view('auth/reset-password', compact('error', 'token'));
                return;
            }

            $hash = password_hash($newPassword, PASSWORD_DEFAULT);
            $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?")
                ->execute([$hash, $reset['user_id']]);

            // Token à usage unique : on le supprime immédiatement
            $pdo->prepare("DELETE FROM password_resets WHERE id = ?")
                ->execute([$reset['id']]);

            $success = I18n::t('auth.password_reset_success');
            view('auth/reset-password', compact('success'));
            return;
        }

        view('auth/reset-password', compact('token'));
    }

    public function changePassword(): void {
        if (!Auth::check()) {
            redirectTo('/login');
            return;
        }

        $pdo = Database::pdo();
        $user = Auth::user();

        if ($_SERVER['REQUEST_METHOD']==='POST') {
            Auth::verifyCsrf();
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Get current password hash from database
            $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id=? LIMIT 1");
            $stmt->execute([$user['id']]);
            $u = $stmt->fetch();

            if (!$u || !password_verify($currentPassword, $u['password_hash'])) {
                $error = I18n::t('auth.wrong_current_password');
                view('auth/change-password', compact('error'));
                return;
            }

            if ($newPassword !== $confirmPassword) {
                $error = I18n::t('auth.passwords_not_match');
                view('auth/change-password', compact('error'));
                return;
            }

            if (strlen($newPassword) < 8) {
                $error = I18n::t('auth.new_password_short');
                view('auth/change-password', compact('error'));
                return;
            }

            // Update password
            $hash = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password_hash=? WHERE id=?");
            $stmt->execute([$hash, $user['id']]);

            $success = I18n::t('auth.password_changed');
            view('auth/change-password', compact('success'));
            return;
        }

        view('auth/change-password');
    }
}
