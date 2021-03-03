## Project setup
 - create a database like: mysql -uroot -proot -Bse "CREATE DATABASE books CHARACTER SET utf8 COLLATE utf8_unicode_ci;"
 - git clone git@github.com:misterspelik/books-api.git api
 - cd api
 - cp .env.example .env
 - composer install
 - php artisan key:generate
 - php artisan jwt:secret
 - php artisan migrate --seed
 - php artisan serve

## Test Credentians

For test admin user test credentials are:
L: admin
P: password