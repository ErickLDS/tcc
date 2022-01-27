const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.styles(['resources/css/config.css', 'resources/css/base.css', 'resources/css/menu.css'], 'public/css/global.css')

    .js('resources/js/app.js', 'public/js')
    .postCss('resources/css/index.css', 'public/css/app.css')

    .js('resources/js/login.js', 'public/js')
    .postCss('resources/css/login.css', 'public/css/login.css')

    .js('resources/js/minhaConta.js', 'public/js')
    .postCss('resources/css/minhaConta.css', 'public/css/minhaConta.css')

    .js('resources/js/verPedido.js', 'public/js')
    .postCss('resources/css/verPedido.css', 'public/css/verPedido.css')

    .js('resources/js/montarChurros.js', 'public/js')
    .styles(['resources/css/montarChurros.css',
        'resources/css/slider.css'], 
        'public/css/montarChurros.css')

    .js('resources/js/finalizar.js', 'public/js')
    .styles(['resources/css/finalizar.css',
        'resources/css/slider.css'],
        'public/css/finalizar.css')

    .js('resources/js/politicas.js', 'public/js')

    .js('resources/js/dashboard.js', 'public/js')
    .postCss('resources/css/dashboard.css', 'public/css/dashboard.css')

    .js('resources/js/loginAdm.js', 'public/js')
    .postCss('resources/css/loginAdm.css', 'public/css/loginAdm.css')

    .js('resources/js/confirmarEmail.js', 'public/js')
    .postCss('resources/css/confirmarEmail.css', 'public/css/confirmarEmail.css')

    .js('resources/js/redefinirSenha.js', 'public/js')
    .postCss('resources/css/redefinirSenha.css', 'public/css/redefinirSenha.css')
    

    .js('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', 'public/bootstrap')
    .postCss('node_modules/bootstrap/dist/css/bootstrap.min.css', 'public/bootstrap')

    .js('node_modules/@fortawesome/fontawesome-free/js/fontawesome.js', 'public/fontawesome')
    .postCss('node_modules/@fortawesome/fontawesome-free/css/fontawesome.css', 'public/fontawesome')
    .js('node_modules/@fortawesome/fontawesome-free/js/solid.js', 'public/fontawesome')
    .postCss('node_modules/@fortawesome/fontawesome-free/css/solid.css', 'public/fontawesome')
    .js('node_modules/@fortawesome/fontawesome-free/js/brands.js', 'public/fontawesome')
    .postCss('node_modules/@fortawesome/fontawesome-free/css/brands.css', 'public/fontawesome')

    .vue();
