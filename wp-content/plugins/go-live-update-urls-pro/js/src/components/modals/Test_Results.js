import React, {Component} from 'react';
import PropTypes from 'prop-types';
import Result_Item from '../Result_Item';
import isEmpty from 'lodash/isEmpty';
import styles from './test-results.pcss';
import {I18N} from '../../globals/config';

class Test_Results extends Component {
	constructor( props ){
		super( props );
		this.state = {};
	}

	render(){
		let {results} = this.props;
		return (
			<div className={styles.wrap}>
				{isEmpty( results ) && <div className={styles.loading + " spinner is-active"} />}
				{Object.keys( results ).map( ($test_id) => {
					return(
						<span key={$test_id}>
							<Result_Item item={results[$test_id]} fix_issue={this.props.fix_issue}/>
							<hr/>
						</span>
					);
				})}
				<a className={styles.button + ' button-primary'} onClick={this.props.close}>
					{I18N.close}
				</a>
			</div>
		);
	}
}

Test_Results.propTypes = {
	results : PropTypes.object.isRequired,
	fix_issue : PropTypes.func.isRequired
};

Test_Results.defaultProps = {};


export default Test_Results;
