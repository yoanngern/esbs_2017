import {createAction} from 'redux-actions';
import Test from './tests/Test';
import Error from './tests/Error';
import {each, isUndefined} from 'lodash';

export const GET_RESULTS = "GET_RESULTS";
export const getResults  = createAction( GET_RESULTS );

export const ERROR_RESULTS = "ERROR_RESULTS";
export const errorResults  = createAction( ERROR_RESULTS );

export const FIX_ISSUE = "FIX_ISSUE";
export const fixIssue  = createAction( FIX_ISSUE );

export const SHOW_LOADING = "SHOW_LOADING";
export const showLoading  = createAction( SHOW_LOADING );

const INITIAL_STATE = {};

export default function results( state = INITIAL_STATE, action ){
	const {payload} = action;
	let tests       = {};
	switch ( action.type ){
		case ERROR_RESULTS:
			tests['error'] = new Error();
			return tests;

		case FIX_ISSUE :
			return {
				...state,
				[payload.results.test] : new Test( payload.results ),
			};

		case GET_RESULTS:
			each( payload, ( test ) =>{
				tests[test.test] = new Test( test );
			} );

			return tests;

		/**
		 * @todo remove this hardcoded domain test id crap
		 *       maybe query which items should be loading based on ?
		 *       get_result() === 'warning' ?
		 */
		case SHOW_LOADING :
			state[payload].set_loading( true );
			if( !isUndefined( state.Go_Live_Update_URLS_Pro_Tests_Domain ) ){
				state.Go_Live_Update_URLS_Pro_Tests_Domain.set_loading( true );
				return {
					...state,
					[payload] : state[payload],
					Go_Live_Update_URLS_Pro_Tests_Domain : state.Go_Live_Update_URLS_Pro_Tests_Domain
				};

			}
			return {
				...state,
				[payload] : state[payload],
			};

	}
	return state;
}



