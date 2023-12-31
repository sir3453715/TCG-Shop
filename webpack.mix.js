const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.js('resources/js/admin/admin.js', 'public/js/admin')
    .js('resources/js/admin/app.js', 'public/js/admin')
    .sass('resources/sass/admin/admin.scss','public/css/admin');

mix.sass('resources/sass/admin/custom-admin.scss','public/css/admin');