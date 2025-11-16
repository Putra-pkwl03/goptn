
---

## README.md (Final)

```markdown
# GOPTN — Web App Starter (Laravel + Tailwind)

Project ini dibuat menggunakan **Laravel 12**, **MySQL**, dan **Tailwind CSS** dengan dukungan **Vite Auto Reload**.  
Saat ini sudah terdapat tampilan awal dengan struktur komponen (Navbar & Hero).

---

## Environment Versions (Development)

- **Laragon**: v6.0  
- **Laravel Framework**: 12.38.1
- **PHP**: (mengikuti versi Laragon)
```

php -v

```
- **Composer**: 2.4.1
- **MySQL**: 6.x (from Laragon)
- **Node.js**: 24.x
- **Tailwind CSS**: 11.6.2
```

npx tailwindcss -v

````

Semua tools berjalan normal pada environment Windows menggunakan Laragon.

---

## Tech Stack

- Laravel 12
- MySQL
- Tailwind CSS
- Vite Hot Module Reloading (Auto Refresh)
- Blade Components

---

## 🔧 Instalasi & Setup Project

### Create Laravel Project
```bash
composer create-project laravel/laravel goptn
cd goptn
````

### Setup Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=goptn
DB_USERNAME=root
DB_PASSWORD=
```

Buat database:

```sql
CREATE DATABASE goptn;
```

Jalankan migrasi:

```bash
php artisan migrate
```

---

## Setup Tailwind CSS

Jalankan perintah:

```bash
npm install
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```

Pastikan `resources/css/app.css` berisi Tailwind directives:

```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```

Pastikan Vite include CSS & JS:
`resources/views/welcome.blade.php`

```blade
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

---

## Struktur View

```
resources/views/
 ├─ welcome.blade.php     ← main view
 └─ components/
     ├─ navbar.blade.php
     └─ hero.blade.php
```

---

## Menjalankan Project

```bash
npm run dev
php artisan serve
```

Akses aplikasi di browser:

```
http://127.0.0.1:8000
```

---

## Status Project

✔ Setup Laravel
✔ Setup Database
✔ Setup Tailwind Auto Reload
✔ Halaman utama + komponen awal selesai
⬜ Auth (Login/Register)
⬜ Routing Pages
⬜ CRUD & Dashboard

---

```
