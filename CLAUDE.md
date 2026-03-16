# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**Market Prices MU** — A PHP/MySQL web app for tracking fruit and vegetable prices across Mauritian markets, with a Python Flask microservice for ML-based price prediction. This is an academic final project (PFE).

## Setup & Running

**Database:**
```bash
mysql -u root -e "CREATE DATABASE market_prices_mu;"
mysql -u root market_prices_mu < database/schema.sql
mysql -u root market_prices_mu < database/002_password_resets.sql
mysql -u root market_prices_mu < database/seed.sql
```

**ML microservice** (required for price predictions):
```bash
cd ml_service
python -m venv .venv
source .venv/Scripts/activate   # Windows/MINGW64
pip install -r requirements.txt
python app.py                    # Listens on http://127.0.0.1:5055
```

**Web app:** Served by XAMPP at `http://localhost/market-prices/public/`

**Test credentials:**
- Admin: `admin@market.mu` / `Admin@12345`
- User: `user@market.mu` / `User@12345`

There is no build step — no npm, Composer, or webpack.

## Architecture

### Request Flow
`public/index.php` → `app/controllers/Routes.php` (switch on `$_GET['page']`) → Controller → View

### MVC Structure
- **`app/config/`** — `app.php` (app settings, SMTP, ML URL) and `database.php` (PDO credentials)
- **`app/models/`** — `Database.php` (PDO singleton), `Auth.php` (session + CSRF), `I18n.php` (translations), `Mailer.php` (native SMTP, no external lib), `Config.php` (static config loader)
- **`app/controllers/`** — `HomeController`, `AuthController`, `PriceController`, `AdminController`
- **`app/views/`** — PHP templates; `layouts/header.php` + `footer.php` wrap all pages; `lang/` holds translation arrays for `fr`, `en`, `mfe`

### Key Patterns
- **Database:** `Database::pdo()` returns a PDO singleton; all queries use prepared statements.
- **Auth guards:** `requireLogin()` and `requireAdmin()` are called at the top of protected controller methods.
- **CSRF:** Tokens generated and verified through `Auth` class; must be present on all POST forms.
- **Views:** Rendered via a `view($template, $data)` helper that `extract()`s data into scope.
- **ML integration:** `PriceController::predict()` fetches historical approved prices from DB, POSTs JSON to the Flask service at `ml_service_url`, and renders the response.

### Price Submission Workflow
- Submissions from trusted users (`is_trusted = 1`) are auto-approved.
- Regular users' submissions go to `status = 'pending'` for admin review via `/admin/pending`.

### ML Service (`ml_service/app.py`)
- Flask on port 5055, single endpoint `POST /predict`.
- Algorithm: Ridge regression (λ=0.01) with time trend + seasonal one-hot encoding.
- Requires minimum 6 historical data points; returns predicted price, confidence score, and residual std.

## Routes Reference

| URL | Controller Method |
|-----|------------------|
| `/` or `/home` | `HomeController::index()` |
| `/prices` | `PriceController::index()` |
| `/prices/submit` | `PriceController::submit()` |
| `/prices/predict` | `PriceController::predict()` |
| `/admin` | `AdminController::dashboard()` |
| `/admin/pending` | `AdminController::pending()` |
| `/admin/approve` \| `/admin/reject` | `AdminController::approve/reject()` |
| `/login`, `/register`, `/forgot-password`, `/reset-password`, `/change-password` | `AuthController` |

## Configuration Notes
- `app/config/app.php` contains SMTP credentials and the ML service URL — do not commit changes to this file with real secrets.
- `base_url` in `app/config/app.php` must match the XAMPP virtual path (`/market-prices/public`).
- URL rewriting relies on `.htaccess`; Apache `mod_rewrite` must be enabled.
