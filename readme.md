# Calendar

## Install

``` bash
# Install Dependencies
composer install

# Run Migrations
php artisan migrate

# Add virtual host if using Apache

# If you get an error about an encryption key
php artisan key:generate

# If no .env file
cp .env-example .env

# Install JS Dependencies
npm install

# Watch Files
npm run watch
```

## Endpoints

### Show Events
``` bash
GET api/events
```

### Add Events
``` bash
Post api/events
```
