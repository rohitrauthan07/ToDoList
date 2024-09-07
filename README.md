# Laravel Project

This is a Laravel project built using PHP 8.2.12 and Laravel 9+.

## Requirements

- PHP 8.2.12
- Laravel 9+
- Composer
- A web server (Apache, Nginx, etc.)
- Database (MySQL)

## Installation

1. Clone the repository:
   git clone https://github.com/rohitrauthan07/ToDoList.git
   cd ToDoList
2. composer install
3. cp .env.example .env
4. php artisan key:generate
5. Environment Configuration
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=todo_list
    DB_USERNAME=root
    DB_PASSWORD=
5. php artisan migrate
6. php artisan serve







