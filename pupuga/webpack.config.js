'use strict';

const params = require("./assets/src/js/config.json");

const srcDir = '/assets/src/';
const distDir = '/assets/dist/';

const points = ['main', 'account', 'admin', 'login'];

const path = require('path');
const webpack = require('webpack');
const {CleanWebpackPlugin} = require('clean-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = (env, options) => {

    const production = (options.mode === 'production');

    return {

        mode: options.mode,

        entry: (() => {
            let entry = {};
            points.map((item) => {
                let path = '.' + srcDir + item + '.js';
                let name = item.replace(new RegExp('/', 'g'), '-');
                entry[name] = path;
            });

            return entry;
        })(),

        output: {
            path: __dirname + distDir,
            filename: '[name].js'
        },

        optimization: {
            /*splitChunks: {chunks: 'all'},*/
            minimize: production
        },

        devtool: production ? false : 'source-map',

        watchOptions: {
            aggregateTimeout: 100
        },

        plugins: [
            new CleanWebpackPlugin(),
            new webpack.DefinePlugin({
                PRODUCTION: JSON.stringify(production)
            }),
            new MiniCssExtractPlugin(),
            new CopyWebpackPlugin({patterns: [{from: '.' + srcDir + 'static'}]}),
        ],

        module: {
            rules: [
                {
                    test: /\.m?js$/,
                    exclude: /(node_modules)/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            "presets": [
                                [
                                    "@babel/preset-env",
                                    {
                                        "targets": {
                                            "browsers": ["last 2 versions"]
                                        }
                                    }
                                ]
                            ]
                        }
                    }
                },
                {
                    test: /\.scss$/,
                    use: [
                        MiniCssExtractPlugin.loader,
                        {
                            loader: 'css-loader',
                            options: {sourceMap: !production},
                        },
                        {
                            loader: 'postcss-loader',
                            options: {
                                postcssOptions: {
                                    plugins: [
                                        require('autoprefixer')({
                                            overrideBrowserslist: ['> 2%']
                                        })
                                    ],
                                    sourceMap: !production,
                                }
                            }
                        },
                        {
                            loader: 'sass-loader',
                            options: {sourceMap: !production},
                        },
                        {
                            loader: "@epegzz/sass-vars-loader",
                            options: {
                                syntax: 'scss',
                                vars: params
                            }
                        }
                    ],
                },
                {
                    test: /\.css$/,
                    use: [
                        MiniCssExtractPlugin.loader,
                        'css-loader',
                        {
                            loader: 'postcss-loader',
                            options: {
                                postcssOptions: {
                                    plugins: [
                                        require('cssnano')({
                                            preset: [
                                                'default',
                                                {discardComments: {removeAll: true}}
                                            ],
                                        }),
                                    ],
                                }
                            }
                        }
                    ],
                },
                {
                    test: /\.(eot|svg|ttf|woff|woff2)$/i,
                    exclude: /(images)/,
                    use: [
                        {
                            loader: 'file-loader',
                            options: {
                                name: '[name].[ext]'
                            }
                        }
                    ]
                },
                {
                    test: /\.(cur|gif|png|jpe?g|svg)$/i,
                    exclude: /(fonts)/,
                    use: [
                        {
                            loader: 'url-loader',
                            options: {
                                limit: 4096,
                                name: '[name].[ext]'
                            }
                        }
                    ]
                }
            ]
        },
        resolve: {
            extensions: ['.js', '.json']
        },
    }
}