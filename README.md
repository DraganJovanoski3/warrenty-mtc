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

## Subdomain notes

- Set `APP_URL` to your subdomain URL in `.env`
- Document root must be the `public` folder
- Ensure `storage/` and `bootstrap/cache/` are writable

## Menu

| Page | Purpose |
|------|---------|
| Analytics | Product / period stats |
| New Installation | Main input form |
| Records | List + filter installations |
| Products | Add / edit parts |
| Excel Export | Download filtered .xlsx |
