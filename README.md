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

## Testing

- Create .env.testing file for testing. 
- Create a new DB for running automated tests. Use this DB name in the .env.testing DB_DATABASE constant.

To run the tests, run
```bash
php artisan test
```

## Details:
- The domain name of the short URLs is not saved in the database since it is constant for all of them. Only the 6 characters are stored.
