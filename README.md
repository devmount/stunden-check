# StundenCheck

## Development

Prerequisites:

- PHP 8.0 or later
- Composer 2.4 or later

```bash
git clone https://github.com/devmount/stunden-check # get files
cd stunden-check               # switch to app directory
composer install               # install dependencies
cp .env.example .env           # init environment configuration
touch database/database.sqlite # create database file
php artisan migrate            # create database structure
php artisan key:generate       # build a secure key for the app
php artisan serve              # start dev webserver
```

## License

This project is based on the Laravel framework open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
