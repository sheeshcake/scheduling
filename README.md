# Scheduling System

## Changes
- Updated to Final
- Added database and seed
- Added Login for admin
- Added Faculty CRUD
- Added Subject CRUD

---

## Installation

- Download and extract this repo
- Open the folder
- Open CMD
- Type and Enter `composer install`
- Rename the `.env.example` to `.env`
- In CMD Type and Enter `php artisan key:generate`
- Create a `scheduling` table in phpmyadmin
- In CMD Type and Enter `php artisan migrate:fresh --seed`
- and `php artisan serve` to serve your applicaiton
- and open your application `127.0.0.1:8000`
