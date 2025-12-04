# Library Management System (Laravel 12)

A simple and clean **Library Management System** built using **Laravel 12**, following MVC architecture, proper routing, controllers, migrations, and CRUD operations.

This README will guide any user on how to set up the project from scratch and start the Laravel server.

---

## **Requirements**

* PHP >= 8.2
* Composer
* MySQL / MariaDB
* Node.js & NPM
* Laravel 12

---

## **1. Clone the Repository**

```bash
git clone https://github.com/dev-talha-lab/library-MS.git
cd library-MS
```

---

## **2. Install PHP Dependencies**

```bash
composer install
```

---

## **3. Install Node Dependencies**

```bash
npm install
```

(Optional) Build assets:

```bash
npm run dev
```

---

## **4. Create Environment File**

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

---

## **5. Configure Database accordingly (give your root password)**

Open `.env` and update:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=library_MS
DB_USERNAME=root
DB_PASSWORD=
```

Create the database:

```bash
sudo mysql -u root -p
CREATE DATABASE library_MS;
EXIT;
```

---

## **6. Run Migrations**

```bash
php artisan migrate
```

If you want to reset & run again:

```bash
php artisan migrate:fresh
```

---

## **7. Run Seeder (Optional)**

```bash
php artisan db:seed
```

---

## **8. Start the Laravel Server**

```bash
php artisan serve
```

Server will start at:

```
http://127.0.0.1:8000
```

---

### Permissions Error (Linux)?

```bash
sudo chmod -R 775 storage bootstrap/cache
```

---

## **12. License**

MIT License

---
