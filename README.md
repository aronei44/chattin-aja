# Aplikasi Chat

## Stack

- Laravel 8
- ReactJs
- InertiaJs

## Deskripsi

Aplikasi Chat yang menggunakan Backend Laravel dan Frontend React. Namun, karena saya malas untuk membuat API. maka ditambahkanlah InertiaJs sebagai penghubung.

## Instalasi


Persiapan Laravel
~~~
git clone https://github.com/aronei44/chatting-aja.git
cd chatting-aja
composer install or composer update
cp .env.example .env
php artisan key generate
~~~

silahkan siapkan database sesuai yang ada dalam .env

Persiapan database
~~~
php artisan migrate --seed
~~~

Persiapan React
~~~
npm install && npm run dev
npm run dev
~~~

Menjalankan server. Buka 2 terminal yang membuka project ini.

Pada terminal pertama:
~~~
php artisan serve
~~~

Pada terminal 2:
~~~
npm run watch
~~~
