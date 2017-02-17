<?php
namespace ElementorPro\Modules\Woocommerce\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use ElementorPro\Modules\PanelPostsControl\Controls\Group_Control_Posts;
use ElementorPro\Modules\PanelPostsControl\Module;
use ElementorPro\Modules\Woocommerce\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Products extends Widget_Base {

	/**
	 * @var \WP_Query
	 */
	private $query = null;

	protected $_has_template_content = false;

	public function get_name() {
		return 'wc-products';
	}

	public function get_title() {
		return __( 'Woo - Products', 'elementor-pro' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_categories() {
		return [ 'pro-elements' ];
	}

	public function on_export( $element ) {
		$element = Group_Control_Posts::on_export_remove_setting_from_element( $element, 'posts' );
		return $element;
	}

	public function get_query() {
		return $this->query;
	}

	protected function _register_skins() {
		$this->add_skin( new Skins\Skin_Classic( $this ) );
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_filter',
			[
				'label' => __( 'Query', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			Group_Control_Posts::get_type(),
			[
				'name' => 'posts',
				'post_type' => 'product',
			]
		);

		$this->add_control(
			'filter_by',
			[
				'label' => __( 'Filter By', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'elementor-pro' ),
					'featured' => __( 'Featured', 'elementor-pro' ),
					'sale' => __( 'Sale', 'elementor-pro' ),
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order by', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date' => __( 'Date', 'elementor-pro' ),
					'title' => __( 'Title', 'elementor-pro' ),
					'price' => __( 'Price', 'elementor-pro' ),
					'popularity' => __( 'Popularity', 'elementor-pro' ),
					'rating' => __( 'Rating', 'elementor-pro' ),
					'rand' => __( 'Random', 'elementor-pro' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc'  => __( 'ASC', 'elementor-pro' ),
					'desc' => __( 'DESC', 'elementor-pro' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Products Count', 'elementor-pro' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '4',
			]
		);

		$this->end_controls_section();
	}

	public function query_posts() {
		$settings = $this->get_settings();
		$query_args = Module::get_query_args( 'posts', $settings );

		// Default ordering args
		$ordering_args = WC()->query->get_catalog_ordering_args( $settings['orderby'], $settings['order'] );

		$query_args['orderby'] = $ordering_args['orderby'];
		$query_args['order'] = $ordering_args['order'];
		$query_args['meta_query'] = [
			[
				'key' => '_visibility',
				'value' => [ 'catalog', 'visible' ],
				'compare' => 'IN',
			],
		];

		if ( ! empty( $ordering_args['meta_key'] ) ) {
			$query_args['meta_key'] = $ordering_args['meta_key'];
		}

		if ( 'featured' === $settings['filter_by'] ) {
			// From WooCommerce `featured_products` shortcode
			$query_args['meta_query'][] = [
				'key' => '_featured',
				'value' => 'yes',
			];
		}

		if ( 'sale' === $settings['filter_by'] ) {
			// From WooCommerce `sale_products` shortcode
			$query_args['post__in'] = array_merge( [ 0 ], wc_get_product_ids_on_sale() );
		}

		$this->query = new \WP_Query( $query_args );
	}

	public function render_plain_content() {}
}
