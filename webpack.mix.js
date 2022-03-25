const mix = require('laravel-mix');



mix.sass('resources/sass/app.scss', 'public/css')
   .sass('resources/sass/material-dashboard.scss', 'public/css')
   .sass('resources/sass/material-dashboard-vue.scss', 'public/css')
   .sass('resources/sass/material-kit.scss', 'public/css')
   .js('resources/js/app.js', 'public/js');

