import Test from './Test';
import {I18N} from '../../globals/config';

/**
 * Mock Test class which is an error state
 * Can be used in place of a normal Test object
 * as an Error
 *
 */
export default class Error extends Test {
	constructor(){
		let error = {
			test : 'error',
			result : false,
			label : I18N.something_wrong,
			message : I18N.could_not_run,
			fix_available : false,
		};
		super( error );
	}
}