export default class Test {
	constructor( test ){
		this.test          = test.test;
		this.result        = test.result;
		this.label         = test.label;
		this.message       = test.message;
		this.fix_available = test.fix_available;
		this.loading       = false;
	}

	set_loading( $loading ){
		this.loading = $loading;
	}

	is_loading(){
		return Boolean( this.loading );
	}

	get_test_id(){
		return this.test;
	}

	get_result(){
		switch ( this.result ){
			case 'unknown':
				return 'warning';
			case true:
				return 'pass';
			case false:
				return 'fail';
		}
	}

	get_label(){
		return this.label;
	}

	get_message(){
		return this.message;
	}

	has_fix(){
		return Boolean( this.fix_available );
	}

}