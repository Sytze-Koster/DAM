var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */



elixir(function(mix) {
    mix.sass('app.sass');
    mix.sass('invoice/bever/style.sass', 'public/css/invoice/bever/style.css');
    mix.scriptsIn('resources/assets/js', 'public/js/main.js');
});
