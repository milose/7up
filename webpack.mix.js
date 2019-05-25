const mix = require('laravel-mix')
const tailwindcss = require('tailwindcss')

require('laravel-mix-purgecss')

mix.disableNotifications()

if (mix.inProduction()) {
  mix.version()
}

mix.js('resources/js/vendor.js', 'public/js')
mix.js('resources/js/app.js', 'public/js')

mix
  .sass('resources/sass/app.sass', 'public/css')
  .options({
    processCssUrls: false,
    postCss: [tailwindcss('./tailwind.config.js')]
  })
  .purgeCss()
