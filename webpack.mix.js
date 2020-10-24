let mix = require("laravel-mix");

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

mix.styles(
    [
        "resources/assets/plantilla/css/bootstrap.css",
        "resources/assets/plantilla/css/bootstrap-extended.css",
        "resources/assets/plantilla/css/colors.css",
        "resources/assets/plantilla/css/components.css",
        "resources/assets/plantilla/css/palette-gradient.css",
        "resources/assets/plantilla/css/styleNew.css",
        "resources/assets/plantilla/css/vendors.min.css",
        "resources/assets/plantilla/css/vertical-menu.css",
        "resources/assets/plantilla/css/toastr.css"
    ],
    "public/css/plantilla.css"
)
    .scripts(
        [
            "resources/assets/plantilla/js/vendors.min.js",
            "resources/assets/plantilla/js/applicacion.js",
            "resources/assets/plantilla/js/app-menu.js",
            "resources/assets/plantilla/js/components.js",
            "resources/assets/plantilla/js/toastr.js",
            "resources/assets/plantilla/js/sweetalert2.all.min.js"
        ],
        "public/js/plantilla.js"
    )
    .js(["resources/assets/js/app.js"], "public/js/app.js");
