const mix = require('laravel-mix');

// auth
mix .js("resources/js/auth/index.js", "public/js/auth.js")
    .vue()
    .sass("resources/sass/auth/index.sass", "public/css/auth.css")
    .version();

// admin
mix .js("resources/js/admin/index.js", "public/js/admin.js")
    .sass("resources/sass/admin/index.sass", "public/css/admin.css")
    .version();

mix.copy('node_modules/chart.js/dist/chart.js', 'public/js/chart.js');

if (!mix.inProduction()) {
    mix.browserSync("dance.test");
}
