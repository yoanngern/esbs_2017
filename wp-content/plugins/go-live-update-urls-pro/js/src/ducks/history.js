import {createAction} from 'redux-actions';
import {each, isUndefined} from 'lodash';
import Item from "./history/History_Item";

export const GET_HISTORY = "GET_HISTORY";
export const getHistory = createAction(GET_HISTORY);

export const EMPTY_HISTORY = "EMPTY_HISTORY";
export const emptyHistory = createAction(EMPTY_HISTORY);

const INITIAL_STATE = {
	empty_history: false,
	items: {},
};

export default function history(state = INITIAL_STATE, action) {
	const {payload} = action;
	let history = {};
	switch (action.type) {
		case GET_HISTORY:
			each(payload, (item) => {
				history[item.id] = new Item(item);
			});
			return {
				...state,
				items: history
			};
		case EMPTY_HISTORY:
			return {
				...state,
				items: {},
				empty_history: true,
			};
	}
	return state;
}
