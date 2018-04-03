import React, {Component} from 'react';
import PropTypes from 'prop-types';
import {connect} from 'react-redux';

import Url_Fields from '../components/Url_Fields';
import Test_Results from '../components/modals/Test_Results';
import Thickbox from '../components/modals/thickbox';
import Requests from '../ducks/Requests';
import {update_new_url, update_old_url} from '../ducks/url';

import {I18N} from '../globals/config';
import bindAll from 'lodash/bindAll';
import History from "../components/modals/History";


class App extends Component {

	constructor(props) {
		super(props);
		this.state = {
			test_modal_open: false,
			history_modal_open: false,
		};

		bindAll(this, 'open_modal', 'close_modal', 'fix_issue');
	}

	open_modal($which, ev) {
		ev.preventDefault();
		this.setState({
			[$which + '_modal_open']: true
		});
		if( 'test' === $which ) {
			this.props.requests.getTestResults();
		} else {
			this.props.requests.getHistory();
		}
	}

	close_modal($which) {
		this.setState({
			[$which + '_modal_open']: false
		});
	}

	fix_issue($test_id) {
		this.props.requests.fixIssue($test_id);
	}

	render() {
		return (
			<div>
				<table className="form-table">
					<Url_Fields
						new_url={this.props.new_url}
						old_url={this.props.old_url}
						update_old_url={this.props.update_old_url}
						update_new_url={this.props.update_new_url}
						open_test_modal={this.open_modal.bind(this, 'test')}
						open_history_modal={this.open_modal.bind(this, 'history')}
					/>
				</table>

				<hr/>
				<p/>
				<Thickbox width="600" height="540" title={I18N.test_results} is_open={this.state.test_modal_open}
						  close={this.close_modal.bind( this, 'test' )}>
					<Test_Results results={this.props.results} fix_issue={this.fix_issue}/>
				</Thickbox>
				<Thickbox width="800" height="540" title={I18N.history} is_open={this.state.history_modal_open}
						  close={this.close_modal.bind( this, 'history' )}>
					<History
						items={this.props.history}
						empty={this.props.empty_history}
						update_new_url={this.props.update_new_url}
						update_old_url={this.props.update_old_url}
					/>
				</Thickbox>
			</div>

		)
	}
}

App.propTypes = {
	dispatch: PropTypes.func.isRequired,
	requests: PropTypes.object.isRequired,
	results: PropTypes.object.isRequired,
	update_old_url: PropTypes.func.isRequired,
	update_new_url: PropTypes.func.isRequired,
};

App.defaultProps = {};

function mapStateToProps(state) {
	return {
		old_url: state.url.old,
		new_url: state.url.new,
		results: state.results,
		history: state.history.items,
		empty_history: state.history.empty_history,
	}
}

function mapDispatchToProps(dispatch) {
	return {
		requests: dispatch(new Requests()),
		dispatch: dispatch,
		update_old_url: ($url) => {
			dispatch(update_old_url($url));
		},
		update_new_url: ($url) => {
			dispatch(update_new_url($url));
		},

	}
}

export default connect(mapStateToProps, mapDispatchToProps)(App);
