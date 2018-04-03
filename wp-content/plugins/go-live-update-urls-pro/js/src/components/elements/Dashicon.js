import React from 'react';
import PropTypes from 'prop-types';

import classNames from 'classnames';
import styles from './dashicons.pcss';

/**
 * @link https://developer.wordpress.org/resource/dashicons
 *
 * @example <Dashicon icon="yes" />
 *
 * @param props
 * @returns {XML}
 * @constructor
 */
const Dashicon = ( props ) =>{
	let $classes = {
		'dashicons' : true,
		['dashicons-' + props.icon] : true
	};
	if( typeof(styles[props.icon]) !== 'undefined' ){
		$classes[ styles[props.icon] ] = true;
	}
	if( typeof(props.class) !== 'undefined' ){
		$classes[props.class] = true;
	}
	return (
		<span className={classNames($classes)} title={props.title}/>
	);
};

Dashicon.propTypes = {
	icon : PropTypes.string.isRequired,
	class : PropTypes.string,
	title : PropTypes.string
};

Dashicon.defaultProps = {
	title : ''
};

export default Dashicon;