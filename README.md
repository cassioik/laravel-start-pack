# Laravel Start Pack

## Laravel framework with DDD and TDD.

docker-compose with laravel, mysql, nginx and redis.

## Run project:

Copy .env-example, create .env file and update database data.

```yml
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel_start_pack_db
DB_USERNAME=root
DB_PASSWORD=root
```

Run the project:

`docker-compose up -d`

Install dependencies

`docker-compose exec app composer install`

Set the application key 

`docker-compose exec app php artisan key:generate`

Migrate database

`docker-compose exec app php artisan migrate`

Run tests

`docker-compose exec app php artisan test`

## Customize:

Database is created the first time you run the project, you can change the name in the file `.docker/mysql/initdb.sql`, remember to change the name in `.env` file too.

## Details:

Uncommented DB_CONNECTION and DB_DATABASE on file `phpunit.xml` to run tests in sqlite

Use trait `Illuminate\Foundation\Testing\RefreshDatabase` in file `tests/TestCase.php` to refresh test database everytime it runs

Defined how to render and the code for custom exceptions in file `app/Exceptions/Handler.php`