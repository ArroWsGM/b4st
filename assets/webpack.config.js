const path = require('path')
const merge = require('webpack-merge')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const BabelMinifyPlugin = require('babel-minify-webpack-plugin')
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin')

const config = {
    entry: {
        vendors: [
            'jquery',
            'slick-carousel',
            'bootstrap/js/dist/dropdown',
            'bootstrap/js/dist/collapse'
        ],
        script: './src/main.js',
        styles: './src/scss/theme/index.scss',
        'styles-admin': './src/scss/admin/index.scss',
        'styles-editor': './src/scss/editor/index.scss'
    },
    output: {
        path: path.resolve(__dirname, './js'),
        filename: '[name].min.js'
        //publicPath: 'js/'
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                use: {
                    loader: 'babel-loader'
                },
                exclude: /node_modules/
            },
            {
                test: require.resolve('jquery'),
                use: [
                    {
                        loader: 'expose-loader',
                        options: 'jQuery'
                    },
                    {
                        loader: 'expose-loader',
                        options: '$'
                    }
                ]
            },
            {
                test: /\.(sa|sc|c)ss$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                        options: { sourceMap: true }
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            sourceMap: true,
                            config: {
                                path: './postcss.config.js'
                            }
                        }
                    },
                    {
                        loader: 'sass-loader',
                        options: { sourceMap: true }
                    }
                ]
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: '../css/[name].min.css'
            // chunkFilename: '[id].optimize.css'
        })

    ]
}

module.exports = (env, options) => {
    let mode = options.mode === 'production'

    config.devtool = mode
                     ? false //'source-map'
                     : 'eval-sourcemap'

    if (mode) {
        let minimize = {
            minimize: true,
            minimizer: [
                new BabelMinifyPlugin(),
                new OptimizeCssAssetsPlugin({
                    assetNameRegExp: /\.optimize\.css$/g,
                    cssProcessor: require('cssnano'),
                    cssProcessorPluginOptions: {
                        preset: ['default', {discardComments: {removeAll: true}}]
                    },
                    canPrint: true
                })
            ],
            usedExports: true,
            sideEffects: true
        }

        config.optimization = merge(config.optimization, minimize)
    }
    return config
}