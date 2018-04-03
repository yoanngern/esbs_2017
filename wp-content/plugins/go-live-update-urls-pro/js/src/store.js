import thunk from 'redux-thunk';
import createLogger from 'redux-logger'
import { createStore, applyMiddleware } from 'redux'
import rootReducer from './ducks/index'

const middlewares = [thunk]; // lets us dispatch() functions

if (process.env.NODE_ENV !== 'production') {
	const logger = createLogger(); // neat middleware that logs actions
	middlewares.push(logger);
}

export default function configureStore(initialState) {
	return createStore(
		rootReducer,
		initialState,
		applyMiddleware( ...middlewares )
	);
}