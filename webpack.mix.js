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

let uiDependencies = [
    'jquery-modal',
];


// mix.stylus('resources/stylus/app.styl', 'public/css', {
//     use: [
//         require('@fortawesome/fontawesome-free')(),
//         require('jquery-modal')(),
//     ]
// });



uiDependencies.forEach(folder => {
    // require(${folder});
    // mix.use(${folder});
    // mix.copyDirectory(`./node_modules/${folder}`,`./public/bower_components/${folder}`);
});
