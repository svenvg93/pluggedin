# PluggedIn - Device Tracker

A self-hosted Laravel application to track device counts built with Filament.

## About

PluggedIn is a device tracking application that allows you to monitor and manage device counts in your environment. Built on Laravel 12 with Filament 4 for a modern, intuitive admin interface.

## Tech Stack

- **PHP** 8.2+
- **Laravel** 12
- **Filament** 4.1
- **SQLite** (default database)

## Installation

### Requirements

- PHP 8.2 or higher
- Composer
- Node.js & NPM

### Setup

1. Clone the repository:
```bash
git clone <repository-url>
cd pluggedin
```

2. Install dependencies:
```bash
composer install
npm install
```

3. Set up your environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Create and migrate the database:
```bash
touch database/database.sqlite
php artisan migrate
```

5. Build frontend assets:
```bash
npm run build
```

## Development

Start the development environment with a single command:

```bash
composer run dev
```

This will concurrently run:
- Laravel development server
- Queue worker
- Laravel Pail (log viewer)
- Vite dev server

## Testing

Run the test suite:

```bash
composer test
```

Or run tests directly:

```bash
php artisan test
```

## Docker

Docker support is available for easy deployment. See the Dockerfile for more details.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
