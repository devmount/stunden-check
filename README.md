# StundenCheck

StundenCheck is an open source web application for managing participation in initiative institutions.

![Screenshot Dashboard](https://user-images.githubusercontent.com/5441654/212422524-e5ce5ee9-7da0-4c6e-ac78-502c25abb097.png)

## Setup

Prerequisites:

- PHP 8.2 or later
- Composer 2.4 or later

```bash
git clone https://github.com/devmount/stunden-check # Get project files
cd stunden-check               # Switch to app directory
composer install               # Install dependencies
cp .env.example .env           # Init environment configuration
touch database/database.sqlite # Create database file (only when using SQlite)
php artisan migrate            # Create database structure
php artisan key:generate       # Build a secure key for the app
php artisan db:seed            # Create initial parameters, categories and admin user
npm i                          # Install frontend dependencies
```

## Development

If you don't want to start with an empty database, you can generate test accounts with fake data:

```bash
php artisan db:seed --class=TestDataSeeder # Fill database with fake test data
```

To start a local development server, run:

```bash
php artisan serve # Start dev webserver
npm run dev       # Start dev frontend with hot module reload (HMR)
```

Now you can log in on <http://localhost:8000> with the initial admin user credentials (email: `admin@example.com`, password: `Joh.3,16`).

## Production

To build the application for production, run:

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache # Combine all configuration files into a single, cached file
php artisan route:cache  # Reduce all route registrations into a single method call within a cached file
php artisan view:cache   # Precompile all blade views
npm run build
```

In `.env` set `APP_DEBUG` to false and `APP_URL` to your production url. Change more values here if needed.

The webserver should be configured to serve the `public/` directory as root.

## License

This project is based on the Laravel framework open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
