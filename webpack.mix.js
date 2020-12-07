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
    .js('src/js/app.js', 'xampp/htdocs/workspace/scubajackshop/dist/app.js')
    .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'dist/webfonts');
