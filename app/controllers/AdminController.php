<?php
class AdminController {

    private function requireAdmin(): void {
        if (!Auth::check()) redirectTo('/login');
        if (!Auth::isAdmin()) { http_response_code(403); exit('Accès refusé'); }
    }

    public function dashboard(): void {
        $this->requireAdmin();
        $pdo   = Database::pdo();
        $stats = [
            'users'    => (int)$pdo->query("SELECT COUNT(*) c FROM users")->fetch()['c'],
            'markets'  => (int)$pdo->query("SELECT COUNT(*) c FROM markets")->fetch()['c'],
            'products' => (int)$pdo->query("SELECT COUNT(*) c FROM products")->fetch()['c'],
            'pending'  => (int)$pdo->query("SELECT COUNT(*) c FROM price_submissions WHERE status='pending'")->fetch()['c'],
        ];
        view('admin/dashboard', compact('stats'));
    }

    public function pending(): void {
        $this->requireAdmin();
        $rows = Database::pdo()->query("
            SELECT s.id, s.price_date, s.price_rs, p.name AS product,
                   m.name AS market, u.name AS contributor
            FROM price_submissions s
            JOIN products p ON p.id = s.product_id
            JOIN markets  m ON m.id = s.market_id
            JOIN users    u ON u.id = s.user_id
            WHERE s.status = 'pending'
            ORDER BY s.submitted_at ASC
        ")->fetchAll();
        view('admin/pending', compact('rows'));
    }

    /** Approve a pending submission. */
    public function approve(): void { $this->review('approved'); }

    /** Reject a pending submission. */
    public function reject(): void  { $this->review('rejected'); }

    private function review(string $status): void {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirectTo('/admin/pending');
        Auth::verifyCsrf();
        $id = (int)($_POST['id'] ?? 0);
        Database::pdo()
            ->prepare("UPDATE price_submissions SET status=?, reviewed_at=NOW() WHERE id=?")
            ->execute([$status, $id]);
        redirectTo('/admin/pending');
    }

    public function products(): void {
        $this->requireAdmin();
        $pdo = Database::pdo();
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Auth::verifyCsrf();
            $name     = trim($_POST['name'] ?? '');
            $category = $_POST['category'] ?? '';
            $unit     = trim($_POST['unit'] ?? 'kg');

            if ($name === '' || !in_array($category, ['fruit', 'legume'], true)) {
                $error = 'Nom et catégorie sont obligatoires.';
            } else {
                $exists = $pdo->prepare("SELECT id FROM products WHERE LOWER(name) = LOWER(?) LIMIT 1");
                $exists->execute([$name]);
                if ($exists->fetch()) {
                    $error = 'Ce produit existe déjà.';
                } else {
                    $pdo->prepare("INSERT INTO products (name, category, unit, is_active) VALUES (?, ?, ?, 1)")
                        ->execute([$name, $category, $unit ?: 'kg']);
                    redirectTo('/admin/products');
                }
            }
        }

        $products = $pdo->query("SELECT * FROM products ORDER BY category, name")->fetchAll();
        view('admin/products', compact('products', 'error'));
    }

    public function toggleProduct(): void {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirectTo('/admin/products');
        Auth::verifyCsrf();
        $id = (int)($_POST['id'] ?? 0);
        $pdo = Database::pdo();
        $current = $pdo->prepare("SELECT is_active FROM products WHERE id = ?");
        $current->execute([$id]);
        $row = $current->fetch();
        if ($row) {
            $pdo->prepare("UPDATE products SET is_active = ? WHERE id = ?")
                ->execute([$row['is_active'] ? 0 : 1, $id]);
        }
        redirectTo('/admin/products');
    }
}
