# StundenCheck

## Setup

Prerequisites:

- PHP 8.1 or later
- Composer 2.4 or later

```bash
git clone https://github.com/devmount/stunden-check # get files
cd stunden-check               # switch to app directory
composer install               # install dependencies
cp .env.example .env           # init environment configuration
touch database/database.sqlite # create database file
php artisan migrate            # create database structure
php artisan key:generate       # build a secure key for the app
php artisan db:seed            # create initial parameters, categories and admin user
```

## Development

To start a local development server, run:

```bash
php artisan serve # start dev webserver
```

Now you can log in on <http://localhost:8000> with the initial admin user credentials (email: `admin@example.com`, password: `Joh.3,16`).

If you don't want to start with an empty database, you can generate test accounts with fake data:

```bash
php artisan db:seed --class=TestDataSeeder # Fill database with fake test data
```

## Production

To build the application for production, run:

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache # combine all configuration files into a single, cached file
php artisan route:cache  # reduce all route registrations into a single method call within a cached file
php artisan view:cache   # precompile all blade views
npm run build
```

In `.env` set `APP_DEBUG` to false and `APP_URL` to your production url. Change more values if needed.

The webserver should be configured to serve the `public/` directory as root.

## License

This project is based on the Laravel framework open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
