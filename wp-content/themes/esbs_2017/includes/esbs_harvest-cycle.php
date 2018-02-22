<?php

/**
 * Create Harvest Cycle
 */
function create_harvest_cycle() {
	register_post_type( 'esbs_harvest_cycle',
		array(
			'labels'              => array(
				'name'          => __( 'Harvest Cycle' ),
				'singular_name' => __( 'Harvest Cycle' ),
				'add_new'       => 'Add a phase',
				'all_items'     => 'All phases',
				'add_new_item'  => 'Add New Phase',
				'edit_item'     => 'Edit phase',
			),
			'public'              => true,
			'can_export'          => true,
			'show_ui'             => true,
			'_builtin'            => false,
			'has_archive'         => false,
			'publicly_queryable'  => true,
			'query_var'           => true,
			'rewrite'             => array( "slug" => "hc" ),
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'supports'            => array(
				'title',
			),
			'menu_icon'           => 'dashicons-update',
			'exclude_from_search' => false,
		)
	);
}

add_action( 'init', 'create_harvest_cycle' );