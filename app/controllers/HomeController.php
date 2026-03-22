<?php
class HomeController {
    public function index(): void {
        $pdo = Database::pdo();

        $latest = $pdo->query("
            SELECT s.id, p.name AS product, m.name AS market, s.price_rs, s.price_date
            FROM price_submissions s
            JOIN products p ON p.id = s.product_id
            JOIN markets  m ON m.id = s.market_id
            WHERE s.status = 'approved'
            ORDER BY s.price_date DESC, s.submitted_at DESC
            LIMIT 10
        ")->fetchAll();

        $stats = $pdo->query("
            SELECT
              (SELECT COUNT(*) FROM price_submissions WHERE status = 'approved') AS total_prices,
              (SELECT COUNT(*) FROM markets)  AS total_markets,
              (SELECT COUNT(*) FROM products) AS total_products
        ")->fetch();

        view('pages/home', ['latest' => $latest, 'stats' => $stats]);
    }
}
