const mix = require('laravel-mix');

mix.copyDirectory('node_modules/tinymce/icons', 'public/modules/tinymce/icons');
mix.copyDirectory('node_modules/tinymce/plugins', 'public/modules/tinymce/plugins');
mix.copyDirectory('node_modules/tinymce/skins', 'public/modules/tinymce/skins');
mix.copyDirectory('node_modules/tinymce/themes', 'public/modules/tinymce/themes');
mix.copy('node_modules/tinymce/tinymce.min.js', 'public/modules/tinymce/tinymce.min.js');
mix.copy('node_modules/tinymce-i18n/langs5/pl.js', 'public/modules/tinymce/langs/pl.js');

mix.copy('node_modules/@fortawesome/fontawesome-free/js/all.min.js', 'public/modules/fontawesome-free/all.js');

mix.js('resources/js/app.js', 'public/js');
mix.sass('resources/sass/app.scss', 'public/css');
mix.sourceMaps();
mix.version();
