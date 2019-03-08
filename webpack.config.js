/*
    Webpack Encore configuration.

        https://github.com/symfony/webpack-encore/blob/master/index.js
        https://symfony.com/doc/3.4/frontend/encore/legacy-apps.html

*/

var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/build')
    .addEntry('app', './app/Resources/assets/js/app.js')
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
    );

module.exports = Encore.getWebpackConfig();
