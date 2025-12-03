
---

## README.md (Final)

```markdown
# GOPTN — Web App Starter (Laravel + Tailwind)

Project ini dibuat menggunakan **Laravel 12**, **MySQL**, dan **Tailwind CSS** dengan dukungan **Vite Auto Reload**.  
Selengkpanya baca Documentations API Endpoinnya di: https://documenter.getpostman.com/view/32171174/2sB3dMxBE8 
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

Semua tools berjalan normal pada environment Windows menggunakan Laragon.

---

## Tech Stack

- Laravel 12
- MySQL

---

## 🔧 Instalasi & Setup Project

### Clone repo ini
```bash
composer composer install
cd goptn
````

### Setup Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=goptn_db
DB_USERNAME=root
DB_PASSWORD=
```

Buat database:

```sql
CREATE DATABASE goptn_db;
```

Jalankan migrasi:

```bash
php artisan migrate
```

---

## Menjalankan Project

```bash
php artisan serve
```

Akses aplikasi API di postman atau lainnya:

```
http://127.0.0.1:8000
```

```
