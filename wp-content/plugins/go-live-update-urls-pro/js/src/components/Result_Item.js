import React, {Component} from 'react';
import PropTypes from 'prop-types';
import Test from '../ducks/tests/Test';
import Dashicon from './elements/Dashicon';
import bindAll from 'lodash/bindAll';

import styles from './result-item.pcss';
import classNames from 'classnames';
import {I18N} from '../globals/config';

class Result_Item extends Component {
	constructor( props ){
		super( props );
		this.state = {};

		bindAll( this, 'get_icon', 'get_fix', 'fix_issue', 'get_loading' );

	}

	get_icon(){
		let {item} = this.props;
		if( item.is_loading() ){
			return null;
		}
		switch ( item.get_result() ){
			case 'pass':
				return ( <Dashicon icon="yes" class={styles.icon} title={I18N.pass}/> );
			case 'fail':
				return ( <Dashicon icon="warning" class={styles.icon} title={I18N.fail}/> );
			case 'warning':
				return ( <Dashicon icon="editor-help" class={styles.icon} title={I18N.unknown}/> );
		}
	}

	get_fix(){
		let {item} = this.props;


		if( item.is_loading() || 'fail' !== item.get_result() || !item.has_fix() ){
			return null;
		}

		return (
			<a
				title={I18N.click_to_fix}
				onClick={this.fix_issue}
				className={styles.fix + ' button button-primary'}>
				{I18N.fix}
				</a>

		);
	}

	get_loading(){
		let {item} = this.props;
		if( !item.is_loading() ){
			return null;
		}
		return (
			<span className={styles.loading + ' spinner is-active'}/>
		);
	}


	fix_issue(){
		this.props.fix_issue( this.props.item.get_test_id() );
	}



	render(){
		let {item} = this.props;
		let $class = classNames({
			description : true,
			[styles.message] : true,
			[styles[item.get_result()]] : true
		});

		return (
			<div className={styles.wrap} id={item.get_test_id()}>
				{item.get_label()}
				{this.get_icon()}
				{this.get_loading()}
				{this.get_fix()}
				{!item.is_loading() && <p className={$class}>
					{item.get_message()}
				</p>}
			</div>
		);
	}
}

Result_Item.propTypes = {
	item : PropTypes.instanceOf( Test ).isRequired,
	fix_issue: PropTypes.func.isRequired,
};

Result_Item.defaultProps = {};


export default Result_Item;