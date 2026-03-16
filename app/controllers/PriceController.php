<?php
class PriceController {

    private function requireLogin(): void {
        if (!Auth::check()) redirectTo('/login');
    }

    /** Charge marchés et produits — utilisé par index, submit et predict. */
    private function loadCatalogue(): array {
        $pdo = Database::pdo();
        return [
            'markets'  => $pdo->query("SELECT id,name,region FROM markets ORDER BY name")->fetchAll(),
            'products' => $pdo->query("SELECT id,name,category,unit FROM products ORDER BY name")->fetchAll(),
        ];
    }

    public function index(): void {
        $pdo = Database::pdo();
        ['markets' => $markets, 'products' => $products] = $this->loadCatalogue();

        $marketId  = $_GET['market_id']  ?? '';
        $productId = $_GET['product_id'] ?? '';

        $where  = ["s.status='approved'"];
        $params = [];
        if ($marketId  !== '') { $where[] = "s.market_id=?";  $params[] = $marketId; }
        if ($productId !== '') { $where[] = "s.product_id=?"; $params[] = $productId; }

        $stmt = $pdo->prepare("
            SELECT s.id, p.name AS product, p.unit, m.name AS market, m.region,
                   s.price_rs, s.price_date, u.name AS contributor
            FROM price_submissions s
            JOIN products p ON p.id = s.product_id
            JOIN markets  m ON m.id = s.market_id
            JOIN users    u ON u.id = s.user_id
            WHERE " . implode(' AND ', $where) . "
            ORDER BY s.price_date DESC, s.submitted_at DESC
            LIMIT 200
        ");
        $stmt->execute($params);
        $rows = $stmt->fetchAll();

        view('prices/index', compact('markets', 'products', 'rows', 'marketId', 'productId'));
    }

    public function submit(): void {
        $this->requireLogin();
        ['markets' => $markets, 'products' => $products] = $this->loadCatalogue();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Auth::verifyCsrf();
            $marketId  = (int)($_POST['market_id']  ?? 0);
            $productId = (int)($_POST['product_id'] ?? 0);
            $priceRs   = (float)($_POST['price_rs']  ?? 0);
            $priceDate = $_POST['price_date'] ?? date('Y-m-d');
            $source    = trim($_POST['source'] ?? '');
            $note      = trim($_POST['note']   ?? '');

            $errors = [];
            if ($marketId  <= 0) $errors[] = "Marché requis.";
            if ($productId <= 0) $errors[] = "Produit requis.";
            if ($priceRs   <= 0) $errors[] = "Prix invalide.";
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $priceDate)) $errors[] = "Date invalide.";

            if ($errors) {
                view('prices/submit', compact('markets', 'products', 'errors'));
                return;
            }

            $pdo  = Database::pdo();
            $u    = Auth::user();
            $trusted = (int)$pdo->query("SELECT is_trusted FROM users WHERE id=" . (int)$u['id'])->fetch()['is_trusted'];
            $status  = $trusted ? 'approved' : 'pending';

            $pdo->prepare(
                "INSERT INTO price_submissions (user_id,market_id,product_id,price_rs,price_date,source,note,status,submitted_at)
                 VALUES (?,?,?,?,?,?,?,?,NOW())"
            )->execute([$u['id'], $marketId, $productId, $priceRs, $priceDate, $source, $note, $status]);

            redirectTo('/prices');
        }

        view('prices/submit', compact('markets', 'products'));
    }

    public function predict(): void {
        ['markets' => $markets, 'products' => $products] = $this->loadCatalogue();

        $marketId  = (int)($_GET['market_id']  ?? 0);
        $productId = (int)($_GET['product_id'] ?? 0);

        $prediction = null;
        $history    = [];

        if ($marketId > 0 && $productId > 0) {
            $pdo  = Database::pdo();
            $stmt = $pdo->prepare(
                "SELECT price_date, price_rs FROM price_submissions
                 WHERE status='approved' AND market_id=? AND product_id=?
                 ORDER BY price_date ASC"
            );
            $stmt->execute([$marketId, $productId]);

            foreach ($stmt->fetchAll() as $r) {
                $history[] = ['date' => $r['price_date'], 'price' => (float)$r['price_rs']];
            }

            $payload = [
                'series'      => $history,
                'target_date' => date('Y-m-d', strtotime('+7 days')),
                'season'      => $this->season((int)date('m')),
            ];
            $prediction = $this->callMl(Config::get('ml_service_url'), $payload);
        }

        view('prices/predict', compact('markets', 'products', 'marketId', 'productId', 'prediction', 'history'));
    }

    private function season(int $m): string {
        if (in_array($m, [12, 1, 2], true)) return 'summer';
        if (in_array($m, [3,  4, 5], true)) return 'autumn';
        if (in_array($m, [6,  7, 8], true)) return 'winter';
        return 'spring';
    }

    private function callMl(string $url, array $payload): ?array {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_TIMEOUT        => 8,
        ]);
        $resp = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_error($ch);
        curl_close($ch);

        if ($resp === false || $code !== 200) {
            return ['ok' => false, 'message' => "ML indisponible: {$err} (HTTP {$code})"];
        }
        return json_decode($resp, true) ?: ['ok' => false, 'message' => 'Réponse ML invalide'];
    }
}
