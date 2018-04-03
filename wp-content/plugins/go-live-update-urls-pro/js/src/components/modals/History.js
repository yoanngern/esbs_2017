import React, {Component} from 'react';
import PropTypes from 'prop-types';

import styles from './history.pcss';
import isEmpty from 'lodash/isEmpty';
import isBoolean from 'lodash/isBoolean';
import bindAll from 'lodash/bindAll';
import {I18N} from "../../globals/config";
import History_Item from "../History_Item";

class History extends Component {
	constructor(props) {
		super(props);
		this.state = {};

		bindAll( this, 'update_url' );
	}


	update_url( $old, $new ){
		this.props.update_new_url( $new );
		this.props.update_old_url( $old );
		this.props.close();
	}

	static header_row() {
		return (
			<div className={styles.header}>
				<div className={styles.old}>
					{I18N.old_url}
				</div>
				<div className={styles.new}>
					{I18N.new_url}
				</div>
				<div className={styles.date}>
					{I18N.date}
				</div>
				<div className={styles.action}>
					&nbsp;
				</div>
			</div>
		);
	}

	render() {
		let {items, empty} = this.props;
		return (
			<div className={styles.wrap}>

				{isEmpty(items) && !empty && <div className={styles.loading + " spinner is-active"}/>}
				{empty && <div className={styles.empty}>
					{I18N.history_empty}
					</div>}
				{!empty && !isEmpty(items) && History.header_row()}

				{Object.keys(items).map(($key) => {
					if (isBoolean(items[$key])) {
						return null;
					}
					return (
						<History_Item item={items[$key]} key={$key} update_url={this.update_url}/>
					);
				})}
				<a className={styles.button + ' button-primary'} onClick={this.props.close}>
					{I18N.close}
				</a>
			</div>
		);
	}
}

History.propTypes = {
	items: PropTypes.object.isRequired,
	empty: PropTypes.bool.isRequired,
	update_old_url: PropTypes.func.isRequired,
	update_new_url: PropTypes.func.isRequired,
};

History.defaultProps = {};


export default History;
