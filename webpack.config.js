/*
    Webpack Encore configuration.

        https://github.com/symfony/webpack-encore/blob/master/index.js
        https://symfony.com/doc/3.4/frontend/encore/legacy-apps.html

*/
var path = require('path');
var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/build')
    .addEntry('app', './app/Resources/assets/js/app.js')
    .autoProvidejQuery()
    //.enableSingleRuntimeChunk()
    .disableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableSassLoader()
    .enablePostCssLoader(
        (options) => {
            options.config = {
                // the directory where the postcss.config.js file is stored
                path: 'app/Resources/assets'
            };
        }
    )
    .copyFiles([
        {from: './node_modules/ckeditor/', to: 'ckeditor/[path][name].[ext]', pattern: /\.(js|css)$/, includeSubdirectories: false},
        {from: './node_modules/ckeditor/adapters', to: 'ckeditor/adapters/[path][name].[ext]'},
        {from: './node_modules/ckeditor/lang', to: 'ckeditor/lang/[path][name].[ext]'},
        {from: './node_modules/ckeditor/plugins', to: 'ckeditor/plugins/[path][name].[ext]'},
        {from: './node_modules/ckeditor/skins', to: 'ckeditor/skins/[path][name].[ext]'}
    ])
    .addLoader({test: /\.json$/i, include: [path.resolve(__dirname, 'node_modules/ckeditor')], loader: 'raw-loader', type: 'javascript/auto'})
;

module.exports = [
    Encore.getWebpackConfig()
];
