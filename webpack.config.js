var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/bundles/')
    .setPublicPath('/bundles')
    .cleanupOutputBeforeBuild()
    .addEntry('app', './assets/js/main.js')
    .addStyleEntry('global', './assets/css/global.scss')
    .enableSassLoader()
    .autoProvidejQuery()
    .enableSourceMaps(!Encore.isProduction())
    // .enableVersioning()
    .enableSassLoader(function(sassOptions) {}, {
        resolveUrlLoader: false
    })
;

module.exports = Encore.getWebpackConfig();