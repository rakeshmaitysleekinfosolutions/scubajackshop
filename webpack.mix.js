let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass('src/sass/app.scss', 'dist/app.css')
    .sass('src/sass/modal.scss','dist/modal.css')
    .js('src/js/app.js', 'xampp/htdocs/workspace/scubajackshop/dist/app.js')
    .js('src/js/login.js', 'xampp/htdocs/workspace/scubajackshop/dist/login.js')
    .js('src/js/payment.js', 'xampp/htdocs/workspace/scubajackshop/dist/payment.js')
    .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'dist/webfonts');
