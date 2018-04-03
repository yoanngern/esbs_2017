import React from 'react';
import ReactDOM from 'react-dom';
import {I18N} from '../globals/config';
import Thickbox from '../components/modals/thickbox';

export default class ThickboxLoader {
	constructor(){
		$( 'body' ).append( '<div id="thickbox-place-holder"></div>' );
		/**
		 * Only needed if the element which triggers the modal lives outside the
		 * react world.
		 * If inside the react work just add on onclick handler like so onClick={ThickboxLoader.open_share_modal}
		 */
		//$( '#load-assignment' ).on( 'click', ThickboxLoader.open_share_modal );
	}

	/**
	 * Use this for basic not so heavy ones.
	 *
	 * @param Component
	 * @param {string} $title
	 * @param args
	 * @param {function} onClose
	 * @param {int} $height
	 * @param {int} $width;
	 *
	 */
	static open_modal( Component, $title, args = {}, onClose = () => {}, $height = 540, $width = 600 ){
		ReactDOM.render(
			<Thickbox width={$width} height={$height} title={$title} key={Date.now() + 'thickbox'} onClose={onClose}>
				<Component {...args}/>
			</Thickbox>, document.getElementById( "thickbox-place-holder" ) );
	}

}