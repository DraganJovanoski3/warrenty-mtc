# MTC Warranty Tracker

Laravel app for **Installation Information & Proof of Application** — login-only access, product catalog, analytics, and Excel export.

Made by **Dragan Jovanoski — DD Solutions** · [https://ddsolutions.com.mk/](https://ddsolutions.com.mk/)

## Features

- Login-only (registration disabled)
- Installation form: customer/company, truck, part & purchase
- Products catalog — products appear in the form dropdown
- Analytics dashboard (by product, by month, KPIs)
- Excel (.xlsx) export with filters: product, date from/to
- Ready for subdomain deploy on XAMPP / shared hosting

## Local setup (XAMPP)

1. Point a vhost / subdomain document root to `public/`  
   Example: `https://warranty.mtc.local` → `c:\xampp\htdocs\warrenty-mtc\public`

2. Copy env and install (already done if you used Composer create-project):

```bash
composer install
cp .env.example .env   # if needed
php artisan key:generate
```

3. Database — default is **SQLite** (`database/database.sqlite`). For MySQL on XAMPP, set in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mtc_warranty
DB_USERNAME=root
DB_PASSWORD=
```

4. Migrate & seed:

```bash
php artisan migrate --seed
npm install && npm run build
```

5. Default login:

- **Email:** `admin@mtc.local`
- **Password:** `password`

Change this password after first login.

## Live: mtctruckparts.com/warranty (WordPress + Laravel)

Keep the full Laravel app in `~/warranty.mtctruckparts.com/`. Serve only its `public` folder at `mtctruckparts.com/warranty` so WordPress stays on the main domain.

### 1. App `.env` (inside `warranty.mtctruckparts.com`)

```env
APP_URL=https://mtctruckparts.com/warranty
ASSET_URL=https://mtctruckparts.com/warranty
SESSION_PATH=/warranty
```

Then:

```bash
php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan storage:link
```

### 2. Symlink (preferred, SSH)

From inside the WordPress site folder (`mtctruckparts.com`):

```bash
# remove a wrong/empty warranty folder first if needed
rm -rf warranty
ln -s ../../warranty.mtctruckparts.com/public warranty
```

Adjust the relative path until it points at `warranty.mtctruckparts.com/public`.

### 3. If symlink is blocked (File Manager)

Create folder `mtctruckparts.com/warranty/` with:

**`.htaccess`** — copy from Laravel `public/.htaccess`

**`index.php`** — bootstrap the existing app (paths relative to your layout):

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$laravelRoot = __DIR__.'/../../warranty.mtctruckparts.com';

if (file_exists($maintenance = $laravelRoot.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $laravelRoot.'/vendor/autoload.php';

/** @var Application $app */
$app = require_once $laravelRoot.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
```

Also copy (or symlink) into that folder: `build/`, `logo.png`, and any other public assets. Prefer keeping assets only in `warranty.mtctruckparts.com/public` when using a real symlink.

### 4. WordPress `.htaccess`

If `/warranty` is rewritten by WP permalinks, add **before** the WordPress rules:

```apache
RewriteRule ^warranty($|/) - [L]
```

A real `warranty` directory/symlink usually wins without this.

### 5. Check

- https://mtctruckparts.com/warranty — public form
- https://mtctruckparts.com/warranty/login — staff login
- Logo: `/warranty/logo.png`
- Proof photos: `/warranty/media/...`

Generated links use `APP_URL`. The old subdomain can keep the same document root; optional later: redirect subdomain → `/warranty`.

## Live server / subdomain (fixes 403)

**Best setup:** in cPanel / hosting, set the subdomain document root to:

`.../warrenty-mtc/public`

Not the project root folder.

Then on the server:

```bash
composer install --no-dev --optimize-autoloader
cp .env.example .env
# edit .env: APP_URL, DB_*, APP_DEBUG=false
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm install && npm run build
chmod -R 775 storage bootstrap/cache
# ensure storage/app/public is writable (VIN / mileage proof photos)
```

If you still get **403 Forbidden**:

1. Document root must be `public` (or use the root `.htaccess` that routes into `public/`)
2. Do not leave `Options` directives that the host blocks (already removed from `public/.htaccess`)
3. Make sure `public/index.php` and `public/.htaccess` were uploaded
4. `storage` and `bootstrap/cache` must be writable by the web user

## Menu

| Page | Purpose |
|------|---------|
| Analytics | Product / period stats |
| New Installation | Main input form |
| Records | List + filter installations |
| Products | Add / edit parts |
| Excel Export | Download filtered .xlsx |
