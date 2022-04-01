const mix = require('laravel-mix');

// auth
mix.sass("resources/sass/auth/index.sass", "public/css/auth.css").options({
    postCss: [
        require("autoprefixer"),
        // require(...)
    ],
});

// site
// mix.js("resources/js/site/index.js", "public/js/site.js");
// mix.sass("resources/sass/site.sass", "public/css/site.css").options({
//     postCss: [
//         require("autoprefixer"),
//         // require(...)
//     ],
// });

// admin
// mix.js("resources/js/admin/index.js", "public/js/admin.js");
// mix.sass("resources/sass/admin/index.sass", "public/css/admin.css").options({
//     postCss: [
//         require("autoprefixer"),
//         // require(...)
//     ],
// });

if (!mix.inProduction()) {
    mix.browserSync("dance.test");
}

if (mix.inProduction()) {
    mix.version();
}
