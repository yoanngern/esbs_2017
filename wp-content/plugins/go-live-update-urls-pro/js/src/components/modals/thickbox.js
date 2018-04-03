import React, {Component} from 'react';
import PropTypes from 'prop-types';
import styles from './thickbox.pcss';

class Thickbox extends Component {

	constructor( props ){
		super( props );
		this.state = {
			title : props.title
		};
		this.close.bind( this );
	}

	change_title( $title ){
		this.setState( {
			title : $title
		} );
	}

	close(){
		this.props.close();
	}

	close_button(){
		if( typeof( this.props.onClose ) === 'function' ){
			this.props.onClose();
		}
		this.close();
	}

	render(){
		if( !this.props.is_open ){
			return null;
		}

		let $left = this.props.width / 2;
		let $top  = this.props.height / 2;


		let window_styles = {
			width : this.props.width + 'px',
			height : this.props.height + 'px',
			margin : '-' + $top + 'px 0 0 -' + $left + 'px',
		};

		return (
			<div>
				<div className={styles.overlay}/>
				<div className={styles.window} style={window_styles}>
					{this.state.title !== '' && <div className={styles.title}>
						<div className={styles.window_title} dangerouslySetInnerHTML={{__html : this.state.title}}/>
						<div className={styles.close}>
							<a href="#" onClick={this.close_button.bind( this )}>
								<span className={styles.close_icon + ' dashicons dashicons-no'}/>
							</a>
						</div>
					</div>}

					<div className={styles.content}>
						{/* Add the close method as a prop to each child so we can close inner components */}
						{React.cloneElement( this.props.children, {
							close : this.close.bind( this ),
							change_title : this.change_title.bind( this )
						} )}
					</div>
				</div>
			</div>
		);

	}
}

Thickbox.propTypes = {
	title : PropTypes.string.isRequired, //send '' to remove the title bar
	children : PropTypes.object.isRequired,
	onClose : PropTypes.func, //run an outside method when close button clicked
	is_open : PropTypes.bool.isRequired,
	close : PropTypes.func.isRequired,
};

Thickbox.defaultProps = {
	title : '',
	children : {}
};

export default Thickbox;