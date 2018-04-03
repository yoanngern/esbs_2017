let webpack           = require( 'webpack' );
let path              = require( 'path' );
let DEBUG             = process.env.NODE_ENV !== 'production';
let ExtractTextPlugin = require( 'extract-text-webpack-plugin' );
let WebpackCleanupPlugin = require('webpack-cleanup-plugin');
//configs for things like _themepath
let config = require("./package.json");
try {
	let local_config = require( '../local-config.json' );
	for( var attr in local_config ){
		config[attr] = local_config[attr];
	}
} catch( e ){}

let entry     = [];
let cssloader = "";
let devtool   = "";
let output = {};

let plugins = [
	new webpack.ProvidePlugin( {
		jQuery : 'jquery',
		$ : 'jquery',
	} ), new webpack.DefinePlugin( {
		'process.env' : {
			'NODE_ENV' : JSON.stringify( process.env.NODE_ENV )
		}
	} ), new ExtractTextPlugin( {
		filename : 'master.min.css',
		allChunks : true
	} ),
];

if( DEBUG ){
	entry   = [
		'react-hot-loader/patch',
		'webpack-dev-server/client?http://localhost:3000',
		'webpack/hot/only-dev-server',
		//'babel-polyfill', conflicts with WPSEO so added to index.js instead
		'./src/index.js'
	];

	output = {
		path : path.resolve( __dirname, 'dist' ),
		filename : 'master.min.js',
		publicPath : 'http://localhost:3000/js/dist/',
		chunkFilename: '[name].js'
	};

	devtool = 'eval-source-map';
	plugins.push( new webpack.HotModuleReplacementPlugin() );
	plugins.push(  new webpack.NamedModulesPlugin() );
	plugins.push( new webpack.NoEmitOnErrorsPlugin() );

	cssloader = 'style-loader!css-loader?modules&importLoaders=1&localIdentName=[name]__[local]__[hash:base64:5]!postcss-loader';

} else {
	plugins.push( new WebpackCleanupPlugin() );

	devtool   = false;
	entry     = [
		//'babel-polyfill', conflicts with WPSEO so added to index.js instead'babel-polyfill',
		'./src/index'
	];
	cssloader = ExtractTextPlugin.extract( {
		use : 'css-loader?modules&importLoaders=1&localIdentName=[name]__[local]__[hash:base64:5]!postcss-loader'
	} );
	output = {
		path : path.resolve( __dirname, 'dist' ),
		filename : 'master.min.js',
		publicPath : config._themepath + 'js/dist/',
		chunkFilename: '[name].[chunkhash].js'
	};
}


module.exports = {
	devtool : devtool,
	entry : entry,
	externals : {
		jquery : 'jQuery'
	},
	output : output,
	resolve : {
		extensions : ['.js', '.jsx', 'json', '.pcss'],
		modules : [
			path.resolve( __dirname, 'src' ),
			'node_modules'
		]
	},
	plugins : plugins,
	module : {
		rules: [
			{
				test : /\.js$/,
				use : ['babel-loader'],
				include : path.resolve( __dirname, 'src' ),
				exclude: /node_modules/,
			},
			{
				test : /\.pcss$/,
				loader : cssloader
			}
		]
	}
};
