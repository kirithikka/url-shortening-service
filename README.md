Laravel URL shortening service

## Steps
- Create(if already not present) .env file in the root of the application. Copy the contents from .env.example to .env.
- Create a new DB and use this DB in the .env DB_DATABASE constants.

Run the following commands:
```bash
composer install
php artisan key:generate
php artisan migrate
```

To run the server, run
```bash
php artisan serve
```