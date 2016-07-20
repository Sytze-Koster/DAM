# DAM
DAM Administration Management is a tool written in Laravel 5.2 for self-employed entrepreneurs to track time and generate invoices. Lastly, DAM makes it easy to do your declaration to the tax authorities.

## Functionality
- Time tracking
- 'Project management'
- Generate invoices
- Record invoices
- Two Factor Authentication
- Use of 'effective dates' for customer & company information

## Requirements
- PHP >= 5.5.9 (why not use 7.0?)
- wkhtmltopdf binary
- MySQL or SQLite database

## To Do
Shoot your ideas, wishes and issues as an [issue](https://github.com/beverio/DAM/issues). Or contribute! ;-)

## Installation
Run
```cp .env.example .env```
to create your own config file. Set up your database credentials in that very same file.

Run
```composer install
npm install```
to install and download all dependencies.

Run
```php artisan key:generate```
to generate an application key.

Run
```php artisan migrate```
to set-up the database tables.

Make your own invoice template at `resources/views/pdf/invoice/[TEMPLATE_NAME].blade.php`, you can make your own SASS stylesheet at `resources/assets/sass/invoice/[TEMPLATE_NAME]/style.sass`.
If you need an image for your invoice, place it at `public/i/invoice/[TEMPLATE_NAME]/`.

Add `mix.sass('invoice/[TEMPLATE_NAME]/style.sass', 'public/css/invoice/[TEMPLATE_NAME]/style.css');` to your `gulpfile.js`.

Run
```gulp```
to compile your stylesheet. You can find your stylesheet at `public/css/invoice/[TEMPLATE_NAME]/style.css`

Navigate to the application and fill out the form. Make sure to create your own invoice template first, so you can select it in the form directly.

## License
DAM is open-sourced software licensed under the [MITlicense](http://opensource.org/licenses/MIT).
