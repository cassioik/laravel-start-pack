## Laravel Start Pack

Laravel framework with DDD and TDD.

docker-compose with laravel, mysql, nginx and redis.

Copy .env-example, create .env file and update database data.

```yml
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel_start_pack_db
DB_USERNAME=root
DB_PASSWORD=root
```


`docker-compose up -d`

`docker-compose exec app composer install`

`docker-compose exec app php artisan key:generate`

`docker-compose exec app php artisan migrate`