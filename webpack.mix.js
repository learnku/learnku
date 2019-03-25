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

mix.js('resources/assets/js/learnku.js', 'public/js')
    .sass('resources/assets/sass/learnku.scss', 'public/css')
    .version()
    .copyDirectory('resources/assets/ext', 'public/ext');
