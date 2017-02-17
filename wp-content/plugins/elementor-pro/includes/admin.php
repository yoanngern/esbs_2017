<?php
namespace ElementorPro;

use Elementor\Settings;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Admin {

	/**
	 * Enqueue admin styles.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_styles() {
		$suffix = Utils::is_script_debug() ? '' : '.min';

		$direction_suffix = is_rtl() ? '-rtl' : '';

		wp_register_style(
			'elementor-pro-admin',
			ELEMENTOR_PRO_ASSETS_URL . 'css/admin' . $direction_suffix . $suffix . '.css',
			ELEMENTOR_PRO_VERSION
		);

		wp_enqueue_style( 'elementor-pro-admin' );
	}

	public function enqueue_scripts() {
		$suffix = Utils::is_script_debug() ? '' : '.min';

		wp_enqueue_script(
			'elementor-pro-admin',
			ELEMENTOR_PRO_URL . 'assets/js/admin' . $suffix . '.js',
			[],
			ELEMENTOR_PRO_VERSION,
			true
		);

		wp_localize_script(
			'elementor-pro-admin',
			'ElementorProConfig',
			apply_filters( 'elementor_pro/admin/localize_settings', [] )
		);
	}

	public function remove_go_pro_menu() {
		remove_action( 'admin_menu', [ \Elementor\Plugin::instance()->settings, 'register_pro_menu' ], Settings::MENU_PRIORITY_GO_PRO );
	}

	public function plugin_action_links( $links ) {
		unset( $links['go_pro'] );

		return $links;
	}

	public function change_tracker_params( $params ) {
		unset( $params['is_first_time'] );

		return $params;
	}

	/**
	 * Admin constructor.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'admin_menu', [ $this, 'remove_go_pro_menu' ], 0 );

		add_filter( 'plugin_action_links_' . ELEMENTOR_PLUGIN_BASE, [ $this, 'plugin_action_links' ], 50 );
		add_filter( 'elementor/tracker/send_tracking_data_params', [ $this, 'change_tracker_params' ], 200 );
	}
}
