<?php

add_action( 'acf/init', 'my_acf_init' );

function my_acf_init() {

	if ( function_exists( 'acf_add_options_page' ) ) {


		/**
		 * Social networks
		 */
		acf_add_options_sub_page( array(
			'page_title'  => __( 'Social networks', 'my_text_domain' ),
			'menu_title'  => __( 'Social networks', 'my_text_domain' ),
			'parent_slug' => 'themes.php',
			'menu_slug'   => 'social',
			'capability'  => 'delete_pages',
			'autoload'    => true,

		) );


		/**
		 * ESBS settings
		 */
		acf_add_options_sub_page( array(
			'page_title'  => __( 'ESBS settings', 'my_text_domain' ),
			'menu_title'  => __( 'ESBS', 'my_text_domain' ),
			'parent_slug' => 'options-general.php',
			'menu_slug'   => 'esbs',
			'capability'  => 'delete_pages',
			'autoload'    => true,

		) );

	}

}
