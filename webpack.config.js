/*
    Webpack Encore configuration.

*/

var Encore = require('@symfony/webpack-encore');

Encore
    // directory where compiled assets will be stored
    .setOutputPath('web/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */
    .addEntry('app', './app/Resources/assets/js/app.js')
    //.addEntry('page1', './app/Resources/assets/js/page1.js')
    //.addEntry('page2', './app/Resources/assets/js/page2.js')

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()
    //.disableSingleRuntimeChunk()

    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you use Sass/SCSS files
    .enableSassLoader()

    // uncomment to use PostCSSLoader
    .enablePostCssLoader(
        (options) => {
            options.config = {
                // the directory where the postcss.config.js file is stored
                path: 'app/Resources/assets'
            };
        }
    )

    // Fixes jQuery plug-ins that expect jQuery to be global.
    // https://symfony.com/doc/3.4/frontend/encore/legacy-apps.html
    //.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
