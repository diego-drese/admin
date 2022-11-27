# Aerd
To execute docker container, see readme file in docker folder.

## Aerd commands inside docker
Run commands

### Intall composer
composer install -vvv

### Copy files from packages
php artisan vendor:publish --tag=0 --force

### Make a file .env from .env.example
cp .env.example .env

### Run cache command
php artisan optimize

### Run migrate command
php artisan migrate

### Run seed command
php artisan db:seed

### Run command to generated permissions from routes
php artisan Aerd:PRP

### To Create new resources uses
php artisan Aerd:CR