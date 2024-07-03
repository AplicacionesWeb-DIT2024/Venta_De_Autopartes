const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .react()
    .sass('resources/sass/app.scss', 'public/css');

// Opcional: Configuración de Babel si es necesario
mix.babelConfig({
    presets: ['@babel/preset-env', '@babel/preset-react']
});


