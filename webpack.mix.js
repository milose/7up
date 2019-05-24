const mix = require('laravel-mix')

mix
  .js('resources/js/vendor.js', 'public/js')
  .js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
