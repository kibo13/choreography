const mix = require('laravel-mix')

// auth
mix .js('resources/js/auth/index.js', 'public/js/auth.js')
    .vue()
    .sass('resources/sass/auth/index.sass', 'public/css/auth.css')
    .version()

// admin
mix .js('resources/js/admin/index.js', 'public/js/admin.js')
    .sass('resources/sass/admin/index.sass', 'public/css/admin.css')
    .version()

// vendors
mix.copy('node_modules/jquery/dist/jquery.min.js', 'public/js/vendors/jquery.min.js')
mix.copy('node_modules/bootstrap/dist/js/bootstrap.min.js', 'public/js/vendors/bootstrap.min.js')
mix.copy('node_modules/datatables.net/js/jquery.dataTables.min.js', 'public/js/vendors/jquery.dataTables.min.js')
mix.copy('node_modules/moment/min/moment.min.js', 'public/js/vendors/moment.min.js')
mix.copy('node_modules/fullcalendar/main.min.js', 'public/js/vendors/fullcalendar.min.js')
mix.copy('node_modules/fullcalendar/main.min.css', 'public/css/fullcalendar.min.css')

if (!mix.inProduction()) {
    mix.browserSync('dance.test')
}
