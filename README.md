# 🏨 Hotel Reservation System

A hotel reservation system built with **Laravel**, providing role-based access for administrators and clerks to manage reservations effectively.

---

## 🚀 Features

-   User authentication & role management (Admin & Clerk).
-   Manage hotel reservations with an interactive dashboard.
-   Database migrations & seeders for quick setup.
-   Bootstrap UI scaffolding for front-end design.

---

## 🛠️ Installation

Clone the repository and install dependencies:

```bash
git clone https://github.com/your-username/hotel-reservation-system.git
cd hotel-reservation-system
composer install
npm install && npm run dev


# ⚙️ Environment Setup

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_reservation
DB_USERNAME=root
DB_PASSWORD=


## Generate application key:
php artisan key:generate

## Run migrations and seeders:
php artisan migrate:fresh --seed


## 🎨 UI Scaffolding


composer require laravel/ui
php artisan ui bootstrap
npm install && npm run dev


## ▶️ Run the Project

## Start the development server:

php artisan serve

## Compile frontend assets (in another terminal):

npm run dev

Now visit: http://localhost:8000


## 👤 Default Users

After seeding, the system comes with two default users:

Role	Email	              Password

Admin	admin@hotel.com	      password
Clerk	clerk@hotel.com	      password


## 🤝 Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you’d like to change.
```
