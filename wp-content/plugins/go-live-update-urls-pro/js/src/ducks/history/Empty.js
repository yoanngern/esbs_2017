import History_Item from "./History_Item";
import {I18N} from "../../globals/config";

export default class Empty extends History_Item{
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
