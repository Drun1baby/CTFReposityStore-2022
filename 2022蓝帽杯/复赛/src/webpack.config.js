var path = require('path');
var webpack = require('webpack');
module.exports = {
    entry: './js/app.js',
    output: {
        // path: '/dist',
        path: __dirname + '/dist',
        filename: 'bundle.js'
    },
    module:{
        rules: [
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude:  __dirname + "/node_modules",
                options: {
                    presets: ['@babel/preset-react']
                  }
              },
           

        ]
    }
}