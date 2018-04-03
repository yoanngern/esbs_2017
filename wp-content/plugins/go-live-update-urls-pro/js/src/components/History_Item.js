import React, {Component} from 'react';
import PropTypes from 'prop-types';
import bindAll from 'lodash/bindAll';
import styles from './history-item.pcss';
import Item from "../ducks/history/History_Item";
import {I18N} from "../globals/config";

class History_Item extends Component {
	constructor(props) {
		super(props);
		this.state = {};

		bindAll( this, 'update_url' );
	}

	update_url(){
		let {item, update_url} = this.props;
		update_url( item.get_old_url(), item.get_new_url() );
	}

	render() {
		let {item} = this.props;
		return (
			<div className={styles.wrap}>
				<div className={styles.old} data-type="old">
					{item.get_old_url()}
				</div>
				<div className={styles.new} data-type="new">
					{item.get_new_url()}
				</div>
				<div className={styles.date} data-type="date">
					{item.get_date()}
				</div>
				<div className={styles.action}>
					<span className="button-primary" title={I18N.use_this_history} onClick={this.update_url} data-type="use">
						{I18N.use}
						</span>
				</div>
			</div>
		);
	}
}

History_Item.propTypes = {
	item: PropTypes.instanceOf(Item).isRequired,
	update_url : PropTypes.func.isRequired,
};

History_Item.defaultProps = {};


export default History_Item;
