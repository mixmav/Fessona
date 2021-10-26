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

mix.js('resources/js/app.js', 'public/js').vue()
 .extract([
	 'jquery',
	 'lodash',
	 'vue',
	 'vue-quill-editor',
	 'vue-ripple-directive',
	 'vue-router',
	 'vuex',
	 'particles.js',
	 'tone',
	 'swiper',
	 'vue-awesome-swiper',
	 'vue-cookie',
	 'vue-toastification',
	 'vue-scrollto'
 ])
.sass('resources/scss/app.scss', 'public/css')

.disableNotifications()

.browserSync({
	notify: false,
	proxy: 'localhost',
});

if (mix.inProduction()) {
	mix.version();
}
