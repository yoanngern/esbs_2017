import {ACTIONS} from '../globals/config';
import {errorResults, getResults, fixIssue, showLoading} from './results';
import {update_new_url} from './url';
import {emptyHistory, getHistory} from "./history";

export default class Requests {
	constructor(){
		return function( dispatch, getState ){
			this.dispatch = dispatch;
			this.getState = getState;
			return this;
		}.bind( this );
	}

	getTestResults( $clear = true ){
		if( $clear ){
			//clear old ones
			this.dispatch( getResults( {} ) );
		}

		let data = {
			action : ACTIONS.get_results,
			new_url : this.getState().url.new,
			old_url : this.getState().url.old,
		};
		$.post( ajaxurl, data, ( response ) =>{
			if( response.success ){
				this.dispatch( getResults( response.data ) );
			} else {
				this._fail();
			}
		} ).fail( this._fail );
	}

	getHistory(){
		let data = {
			action : ACTIONS.get_history,
		};
		$.post( ajaxurl, data, ( response ) =>{
			if( response.success ){
				if( 0 === response.data.length ){
					this._empty_history();
				} else {
					this.dispatch(getHistory(response.data));
				}
			} else {
				this._empty_history();
			}
		} ).fail( this._empty_history );
	}


	fixIssue( $test_id ){
		let data = {
			action : ACTIONS.get_fixed,
			test : $test_id,
			new_url : this.getState().url.new,
			old_url : this.getState().url.old,
		};
		this.dispatch( showLoading( $test_id ) );

		$.post( ajaxurl, data, ( response ) =>{
			if( response.success ){
				this.dispatch( update_new_url( response.data.fixed ) );
				this.dispatch( fixIssue( response.data ) );
				this.getTestResults( false );
			} else {
				this._fail()
			}
		} ).fail( this._fail );
	}

    _fail(){
	    this.dispatch( errorResults() );
    }

    _empty_history() {
		this.dispatch( emptyHistory() );
	}
}
