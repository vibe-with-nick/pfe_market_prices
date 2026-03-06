# Market Price Tracker Mauritius (PHP/MySQL) + Prédiction ML

Plateforme web de suivi des prix des fruits/légumes dans les marchés mauriciens (Quatre Bornes, Port Louis, Flacq, etc.).
- Consultation des prix actuels + historique
- Contribution communautaire (soumission de prix)
- Modération/admin
- Prédiction (micro-service Python) basée sur l'historique et la saison

## Tech
- PHP 8+ (PDO) + MySQL/MariaDB
- Bootstrap 5
- Micro-service Python (Flask) pour la prédiction

## Installation (XAMPP)
1. Copiez ce dossier dans `htdocs/market-prices/`
2. Créez une base `market_prices_mu` dans phpMyAdmin
3. Importez `database/schema.sql` puis `database/seed.sql`
4. Ouvrez `app/config/app.php` et `app/config/database.php` et adaptez vos identifiants
5. Lancez le serveur ML :
   - `cd ml_service`
   - `python -m venv .venv`
   - Windows: `.venv\Scripts\activate`
   - `pip install -r requirements.txt`
   - `python app.py`
6. Ouvrez : `http://localhost/market-prices/public/`

## Comptes de test
- Admin: admin@market.mu / Admin@12345
- Utilisateur: user@market.mu / User@12345
