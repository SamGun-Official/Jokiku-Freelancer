# Project-SDP-2022

Install all the dependencies using composer

    composer install

If Error, run :

    composer update

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Create a Storage Link

    php artisan storage:link
