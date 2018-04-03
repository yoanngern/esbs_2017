module.exports = {
	plugins: {
		'postcss-import': {},
		'postcss-inline-comment' : {},
		'postcss-mixins' : {},
		'postcss-custom-properties' : {},
		'postcss-custom-media': {},
		'postcss-quantity-queries': {},
		'postcss-aspect-ratio': {},
		'postcss-cssnext': {
			browsers: ['last 3 versions', 'ie 10'],
		},
		'postcss-nested' : {},
		'lost': {},
	},
};