const mix = require('laravel-mix');
mix.webpackConfig({
    resolve: {
        alias: {
            'vue-router$': 'vue-router/dist/vue-router.common.js'
        }
    },
    stats: {
        children: true
    },
    // output: {
    //     publicPath: '/',
    //     filename: '[name].[chunkhash:10].js',
    //     chunkFilename : '[name].[chunkhash:10].js'
    // }
});

if (mix.inProduction()) {
    mix.version();
}

mix.disableNotifications();
mix.options({
    processCssUrls: false
});

mix.vue({version: 2});

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

mix.js('resources/js/vue.js', 'public/lib/vue/vue-chunk.js');
//h5
//mix.js('resources/apps/h5/index.js', 'public/dist/h5');
//后台
mix.js('resources/apps/admin/app.js', 'public/dist/admin').vue();
mix.js('resources/apps/home/app.js', 'public/dist/home').vue();
mix.js('resources/apps/web/vendor.js', 'public/dist/web').vue();
mix.js('resources/apps/web/runtime.js', 'public/dist/web').vue();
mix.js('resources/apps/web/cart.js', 'public/dist/web').vue();
mix.js('resources/apps/web/product.js', 'public/dist/web').vue();
mix.js('resources/apps/web/orders.js', 'public/dist/web').vue();
mix.js('resources/apps/web/checkout.js', 'public/dist/web').vue();
mix.js('resources/apps/web/lottery/checkout.js', 'public/dist/lottery').vue();
mix.js('resources/apps/pos/index.js', 'public/dist/pos').vue();
//sass
mix.sass('resources/sass/bootstrap.scss', 'public/lib/bootstrap/bootstrap.min.css');
// mix.sass('resources/sass/element-ui.scss', 'public/lib/element');
mix.sass('resources/sass/admin/index.scss', 'public/dist/admin');
mix.sass('resources/sass/web/index.scss', 'public/dist/web');
mix.sass('resources/sass/web/invoice.scss', 'public/dist/web');
mix.sass('resources/sass/home/index.scss', 'public/dist/home');
mix.sass('resources/sass/h5/index.scss', 'public/dist/h5');
mix.sass('resources/sass/pos/index.scss', 'public/dist/pos');
