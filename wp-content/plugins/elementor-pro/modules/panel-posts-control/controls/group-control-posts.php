<?php
namespace ElementorPro\Modules\PanelPostsControl\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Group_Control_Posts extends Group_Control_Base {

	const INLINE_MAX_RESULTS = 15;

	public static function get_type() {
		return 'posts';
	}

	public static function on_export_remove_setting_from_element( $element, $control_id ) {
		unset( $element['settings'][ $control_id . '_posts_ids' ] );
		unset( $element['settings'][ $control_id . '_authors' ] );

		foreach ( self::get_post_types() as $post_type => $label ) {
			$taxonomy_filter_args = [
				'show_in_nav_menus' => true,
				'object_type' => [ $post_type ],
			];

			$taxonomies = get_taxonomies( $taxonomy_filter_args, 'objects' );

			foreach ( $taxonomies as $taxonomy => $object ) {
				unset( $element['settings'][ $control_id . '_' . $taxonomy . '_ids' ] );
			}
		}

		return $element;
	}

	protected function _get_controls( $args ) {
		$defaults = [
			// Available controls: post_type | taxonomies | authors
			'exclude_controls' => [],
		];

		$args = wp_parse_args( $args, $defaults );

		$controls = [];

		$post_types = self::get_post_types( $args );

		$post_types_options = $post_types;
		$post_types_options['by_id'] = _x( 'Manual Selection', 'Posts Query Control', 'elementor-pro' );

		if ( ! in_array( 'post_type', $args['exclude_controls'] ) ) {
			$controls['post_type'] = [
				'label' => _x( 'Source', 'Posts Query Control', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => key( $post_types ),
				'options' => $post_types_options,
			];

			$controls['posts_ids'] = [
				'label' => _x( 'Search & Select', 'Posts Query Control', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT2,
				'post_type' => '',
				'options' => [],
				'label_block' => true,
				'multiple' => true,
				'filter_type' => 'by_id',
				'object_type' => array_keys( $post_types ),
				'condition' => [
					'post_type' => 'by_id',
				],
			];
		}

		if ( ! in_array( 'taxonomies', $args['exclude_controls'] ) ) {
			$taxonomy_filter_args = [
				'show_in_nav_menus' => true,
			];

			if ( ! empty( $args['post_type'] ) ) {
				$taxonomy_filter_args['object_type'] = [ $args['post_type'] ];
			}

			$taxonomies = get_taxonomies( $taxonomy_filter_args, 'objects' );

			foreach ( $taxonomies as $taxonomy => $object ) {
				$taxonomy_args = [
					'label' => $object->label,
					'type' => Controls_Manager::SELECT2,
					'label_block' => true,
					'multiple' => true,
					'object_type' => $taxonomy,
					'condition' => [
						'post_type' => $object->object_type,
					],
				];

				$count = wp_count_terms( $taxonomy );
				$options = [];

				// For large websites, use Ajax to search
				if ( $count > self::INLINE_MAX_RESULTS ) {
					$taxonomy_args['filter_type'] = 'taxonomy';
					$taxonomy_args['options'] = [];
				} else {
					$terms = get_terms( $taxonomy );

					foreach ( $terms as $term ) {
						$options[ $term->term_id ] = $term->name;
					}

					$taxonomy_args['options'] = $options;
				}

				$controls[ $taxonomy . '_ids' ] = $taxonomy_args;
			}
		}

		if ( ! in_array( 'authors', $args['exclude_controls'] ) ) {
			$author_args = [
				'label' => _x( 'Author', 'Posts Query Control', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'default' => [],
				'condition' => [
					'post_type!' => 'by_id',
				],
			];

			$user_query = new \WP_User_Query( [ 'role' => 'Author', 'fields' => 'ID' ] );

			// For large websites, use Ajax to search
			if ( $user_query->get_total() > self::INLINE_MAX_RESULTS ) {
				$author_args['filter_type'] = 'author';
				$author_args['options'] = [];
			} else {
				$author_args['options'] = $this->get_authors();
			}

			$controls['authors'] = $author_args;
		}

		return $controls;
	}

	private function get_authors() {
		$user_query = new \WP_User_Query(
			[
				'who' => 'authors',
				'has_published_posts' => true,
				'fields' => [
					'ID',
					'display_name',
				],
			]
		);

		$authors = [];

		foreach ( $user_query->get_results() as $result ) {
			$authors[ $result->ID ] = $result->display_name;
		}

		return $authors;
	}

	private static function get_post_types( $args = [] ) {
		$post_type_args = [
			'show_in_nav_menus' => true,
		];

		if ( ! empty( $args['post_type'] ) ) {
			$post_type_args['name'] = $args['post_type'];
		}

		$_post_types = get_post_types( $post_type_args , 'objects' );

		$post_types  = [];

		foreach ( $_post_types as $post_type => $object ) {
			$post_types[ $post_type ] = $object->label;
		}

		return $post_types;
	}
}
