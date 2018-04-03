import {createAction} from 'redux-actions';
import {CONFIG} from '../globals/config';

export const UPDATE_OLD_URL = "UPDATE_OLD_URL";
export const update_old_url = createAction( UPDATE_OLD_URL );

export const UPDATE_NEW_URL = "UPDATE_NEW_URL";
export const update_new_url = createAction( UPDATE_NEW_URL );

const INITIAL_STATE = {
	old : CONFIG.old_url,
	new : CONFIG.new_url,
};

export default function results( state = INITIAL_STATE, action ){
	switch ( action.type ){
		case UPDATE_OLD_URL:
			return {
				...state,
				old : action.payload
			};

		case UPDATE_NEW_URL:
			return {
				...state,
				new : action.payload
			};
	}

	return state;
}