var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()

    .enableSassLoader()
    .enableVersioning(false)

    .addEntry('js/app', './assets/js/app.js')

    .addStyleEntry('css/app', ['./assets/scss/app.scss'])

;

module.exports = Encore.getWebpackConfig();