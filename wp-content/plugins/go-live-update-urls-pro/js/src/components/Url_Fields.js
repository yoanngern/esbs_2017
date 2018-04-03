import React, {Component} from 'react';
import PropTypes from 'prop-types';
import bindAll from 'lodash/bindAll';
import {CONFIG, I18N} from '../globals/config';
import styles from './Url_Fields.pcss';

class Url_Fields extends Component {
	constructor(props) {
		super(props);
		this.state = {
			history_tooltip: false,
			test_tooltip: false,
		};
		bindAll(this, 'update_old_url', 'update_new_url', 'display_tooltip', 'hide_tooltip');
	}

	update_old_url(ev) {
		this.props.update_old_url(ev.target.value);
	}

	update_new_url(ev) {
		this.props.update_new_url(ev.target.value);
	}

	display_tooltip($which) {
		this.setState({
			[$which]: true,
		});
	}

	hide_tooltip($which) {
		this.setState({
			[$which]: false,
		});
	}


	render() {
		let $disabled = null;
		if (this.props.old_url === '' || this.props.new_url === '') {
			$disabled = 'disabled';
		}

		return (
			<tbody className={styles.wrap}>
			<tr>
				<th scope="row">
					<label htmlFor={CONFIG.fields.old_url}>
						{I18N.old_url}
					</label>
				</th>
				<td className="regular-text">
					<input
						name={CONFIG.fields.old_url}
						type="text"
						id="go-live-react-old-url-field"
						value={this.props.old_url}
						className="regular-text"
						title={I18N.old_url}
						onChange={this.update_old_url}/>
				</td>
				<td className={styles.history}>
					{this.state.history_tooltip && <div className={styles.tooltip}>
						{I18N.history_description}
					</div>}
					<span className="dashicons dashicons-backup button-primary"
						  onMouseOver={this.display_tooltip.bind(this, 'history_tooltip')}
						  onMouseOut={this.hide_tooltip.bind(this, 'history_tooltip')}
						  onClick={this.props.open_history_modal}
						  id="go-live-update-urls-pro/react/history-icon"/>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label htmlFor={CONFIG.fields.new_url}>
						{I18N.new_url}
					</label>
				</th>
				<td>
					<input
						name={CONFIG.fields.new_url}
						type="text"
						id="go-live-react-new-url-field"
						value={this.props.new_url}
						className="regular-text"
						title={I18N.new_url}
						onChange={this.update_new_url}/>
				</td>
				<td className={styles.test}>
					{this.state.test_tooltip && <div className={styles.tooltip}>
						{I18N.test_button_instructions}
					</div>}
					<button className="dashicons
dashicons-shield button-primary" onClick={this.props.open_test_modal} disabled={$disabled}
							id="go-live-react-test-new-url"
							onMouseOver={this.display_tooltip.bind(this, 'test_tooltip')}
							onMouseOut={this.hide_tooltip.bind(this, 'test_tooltip')}>
					</button>

				</td>
			</tr>
			</tbody>
		);
	}
}

Url_Fields.propTypes = {
	old_url: PropTypes.string.isRequired,
	new_url: PropTypes.string.isRequired,
	update_old_url: PropTypes.func.isRequired,
	update_new_url: PropTypes.func.isRequired,
	open_test_modal: PropTypes.func.isRequired,
	open_history_modal: PropTypes.func.isRequired,
};

Url_Fields.defaultProps = {
	old_url: '',
	new_url: '',
};


export default Url_Fields;
