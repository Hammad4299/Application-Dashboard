var path = require('path');
var webpack = require('webpack');
var urljoin = require('url-join');
var CopyWebpackPlugin = require('copy-webpack-plugin');
const ExtractTextPlugin = require("extract-text-webpack-plugin");
var AssetsPlugin = require('assets-webpack-plugin');
var assetsPluginInstance = new AssetsPlugin({
});

const { TsConfigPathsPlugin } = require('awesome-typescript-loader');

let paths = require('./webpack-path-base.config')();

paths.toCopy = [
    {from: 'images', to: paths.images},
];

paths.toCopy.map(function (item) {
    item.from = path.join(paths.src,item.from);
    item.to = path.join(paths.contentOutput,item.to);
});

const extractSass = new ExtractTextPlugin({
    filename: "css/generated/[name].[contenthash].min.css",
    disable: false,
    allChunks: true
});

//https://webpack.js.org/plugins/commons-chunk-plugin/
//http://stackoverflow.com/questions/39548175/can-someone-explain-webpacks-commonschunkplugin

module.exports = function () {
    return {
        devtool: 'source-map',  //For debugging purposes
        resolve: {
            extensions: [".ts", ".tsx", ".js", ".json"],
            plugins: [
                new TsConfigPathsPlugin(/* { tsconfig, compiler } */)
            ]
        },
        entry: {
            'commons': path.join(paths.src,'js/entrypoints/common.js'),
            'moneymaker/user': path.join(paths.src,'js/entrypoints/moneymaker/user.js'),
            'moneymaker/transaction': path.join(paths.src,'js/entrypoints/moneymaker/transaction.js'),
            'moneymaker/commons': path.join(paths.src,'js/entrypoints/common.js'),
        },
        output: {
            path: paths.contentOutput,
            filename: 'js/generated/[name].[chunkhash].js',
            publicPath: paths.public
        },
        plugins: [
            extractSass,    //Separate css
            assetsPluginInstance,
            new CopyWebpackPlugin(paths.toCopy),
            new webpack.optimize.CommonsChunkPlugin({
                name: "moneymaker/commons",                                                        //If same as entry name, it will overrite entry content
                minChunks: 2,
                chunks: ['moneymaker/user','moneymaker/transaction','moneymaker/commons']
            }),
            new webpack.optimize.CommonsChunkPlugin({
                name: "commons",                                                        //If same as entry name, it will overrite entry content
                minChunks: 2,
                chunks: ["commons","moneymaker/commons"]
            }),
            //For separate all 3rd party vendor from your code
            //Don't specify vendor entrypoint in your common chunks.
            //      Important, If you put it here, then any common code between vendor chunk and other will be moved from vendor chunk to "common" and then following vendor chunk will be left without that
            //Create separate common chunk for vendor with only entry points (in "name" property instead of chunks)for vendor ccntent. Set minChunks to "infinity".
            //      Don't put anything else except whats already in entry point. It move any common code which was already part of vendor in vendor chunk and remove it from other chunks
            new webpack.optimize.CommonsChunkPlugin({
                name: "manifest"
            }),
            new webpack.optimize.OccurrenceOrderPlugin()
        ],
        module: {
            rules: [
                {
                    test: /\.[s]*css$/,
                    use: extractSass.extract({
                        use: [{
                            loader: "css-loader"
                        }, {
                            loader: "sass-loader"
                        }],
                        // use style-loader in development
                        fallback: "style-loader"
                    })
                },
                // All files with a '.ts' or '.tsx' extension will be handled by 'awesome-typescript-loader'.
                {
                    test: /\.ts[x]*|\.js[x]*$/,
                    loader: "awesome-typescript-loader",
                    exclude: /node_modules/
                },
                // All output '.js' files will have any sourcemaps re-processed by 'source-map-loader'.
                { enforce: "pre", test: /\.js$/, loader: "source-map-loader" },
                {
                    test: /\.(png|jpg|svg|bmp|gif)$/,
                    loader: 'url-loader',
                    options: {
                        limit: 10000,
                        name: urljoin(paths.images,'[name].[ext]'),
                    }
                },
                {
                    test: /\.(ttf|woff|woff2|otf|eot)$/,
                    loader: 'file-loader',
                    options: {
                        name: urljoin(paths.font,'[name].[ext]'),
                    },
                },
            ]
        },
         externals: {
             moment: 'moment',
             bootstrap: "bootstrap",
             flatpickr: "flatpickr",
             'moment-duration-format': 'moment-duration-format',
             jQuery: "jquery"
         }
    };
}