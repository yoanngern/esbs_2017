if (!global._babelPolyfill) {
	require('babel-polyfill');
}

import App from './containers/App';
import ThickboxLoader from './util/thickbox-loader';
import ReactDOM from 'react-dom';
import React from 'react';
import {Provider} from 'react-redux';
import configureStore from './store';

//make sure hot module reloading is working
if( module.hot ){
	module.hot.accept();
}

ReactDOM.render( <Provider store={configureStore()}>
	<App key={Math.random()}/>
</Provider>, document.getElementById( 'go-live-update-urls/url-fields' ) );

new ThickboxLoader();
