import { combineReducers } from 'redux'
import results from './results'
import history from './history'
import url from './url';

const rootReducer = combineReducers({
	history,
	results,
	url,
});

export default rootReducer
