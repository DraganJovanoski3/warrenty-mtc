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
npm install && npm run build
chmod -R 775 storage bootstrap/cache
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
