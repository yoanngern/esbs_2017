<?php

if( function_exists('acf_add_local_field_group') ):

	acf_add_local_field_group(array(
		'key' => 'group_58dd1d20d4c31',
		'title' => 'Blog start',
		'fields' => array(
			array(
				'key' => 'field_5a8d7aed38012',
				'label' => 'Source URL',
				'name' => 'source_url',
				'type' => 'url',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '60',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'acf_after_title',
		'style' => 'seamless',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

endif;