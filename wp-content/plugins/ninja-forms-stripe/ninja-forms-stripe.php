<?php

/*
 * Plugin Name: Ninja Forms - Stripe
 * Plugin URI: http://ninjaforms.com/downloads/stripe
 * Description: Allows for integration with the Stripe payment gateway.
 * Version: 3.0.14
 * Author: The WP Ninjas
 * Author URI: http://ninjaforms.com
 * Text Domain: ninja-forms-stripe
 * Domain Path: /lang/
 *
 * Copyright 2014 WP Ninjas.
*/

if( version_compare( get_option( 'ninja_forms_version', '0.0.0' ), '3', '<' ) || get_option( 'ninja_forms_load_deprecated', FALSE ) ) {

    define( 'NF_STRIPE_DIR', plugin_dir_path( __FILE__ ) . 'deprecated/' );
    define( 'NF_STRIPE_URL', plugins_url().'/'.basename( dirname( __FILE__ ) ) . '/deprecated' );
    define( 'NF_STRIPE_VERSION', '3.0.14' );
    define( 'NF_STRIPE_DEBUG', false );

    /**
     * @since 3.0
     */
    define( 'NF_STRIPE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

    include 'deprecated/stripe.php';

} else {

    include plugin_dir_path( __FILE__ ) . 'includes/deprecated.php';
    /**
     * Class NF_Stripe
     */
    final class NF_Stripe
    {
        const VERSION = '3.0.14';
        const SLUG    = 'stripe';
        const NAME    = 'Stripe';
        const AUTHOR  = 'The WP Ninjas';
        const PREFIX  = 'NF_Stripe';

        /**
         * @var NF_Stripe
         * @since 3.0
         */
        private static $instance;

        /**
         * Plugin Directory
         *
         * @since 3.0
         * @var string $dir
         */
        public static $dir = '';

        /**
         * Plugin URL
         *
         * @since 3.0
         * @var string $url
         */
        public static $url = '';

        /**
         * Main Plugin Instance
         *
         * Insures that only one instance of a plugin class exists in memory at any one
         * time. Also prevents needing to define globals all over the place.
         *
         * @since 3.0
         * @static
         * @static var array $instance
         * @return NF_Stripe Highlander Instance
         */
        public static function instance()
        {
            if (!isset(self::$instance) && !(self::$instance instanceof NF_Stripe)) {
                self::$instance = new NF_Stripe();

                self::$dir = plugin_dir_path(__FILE__);

                self::$url = plugin_dir_url(__FILE__);

                /*
                 * Register our autoloader
                 */
                spl_autoload_register(array(self::$instance, 'autoloader'));
            }
            return self::$instance;
        }

        public function __construct()
        {
            add_filter( 'ninja_forms_enable_credit_card_fields', '__return_true' );

            add_action( 'admin_init', array( $this, 'setup_license') );

            add_action( 'ninja_forms_loaded', array( $this, 'setup_admin' ) );

            add_filter( 'ninja_forms_register_payment_gateways', array( $this, 'register_payment_gateways' ) );

            add_filter( 'nf_subs_csv_extra_values', array( $this, 'export_transaction_data' ), 10, 3 );

            // Register the ajax function for updating keys from the action
	        add_action( 'wp_ajax_nf_stripe_update_keys', array( $this, 'update_keys' ) );
        }

	    /**
	     * Update the keys from the modal in the payment collection action
	     */
        public function update_keys()
        {
	        // Bail if user can't manage options.
	        if( ! current_user_can( 'manage_options' ) ) return false;

	        // Verify nonce.
	        check_ajax_referer( 'ninja_forms_builder_nonce', 'security' );

	        // Setup our response array.
	        $response = array(
		        'valid_key'     => "1",
		        'message'       => '',
	        );

	        // Set variables to check for minimum amount of keys
	        $test_secret = false;
	        $test_publishable = false;
	        $live_secret = false;
	        $live_publishable = false;


	        //Update settings key.
	        if( $_REQUEST[ 'test_secret_key' ] &&
	            0 < strlen( $_REQUEST[ 'test_secret_key' ] ) ) {
		        Ninja_Forms()->update_setting( 'stripe_test_secret_key',
			        esc_html( $_REQUEST['test_secret_key'] ) );

		        $test_secret = true;
	        }

	        if( $_REQUEST[ 'test_publishable_key' ] &&
	            0 < strlen( $_REQUEST[ 'test_publishable_key' ] ) ) {
		        Ninja_Forms()->update_setting( 'stripe_test_publishable_key',
			        esc_html( $_REQUEST['test_publishable_key'] ) );

		        $test_publishable = true;
	        }

	        if( $_REQUEST[ 'live_secret_key' ] &&
	            0 < strlen( $_REQUEST[ 'live_secret_key' ] ) ) {
		        Ninja_Forms()->update_setting( 'stripe_live_secret_key',
			        esc_html( $_REQUEST['test_secret_key'] ) );

		        $live_secret = true;
	        }

	        if( $_REQUEST[ 'live_publishable_key' ] &&
	            0 < strlen( $_REQUEST[ 'live_publishable_key' ] ) ) {
		        Ninja_Forms()->update_setting( 'stripe_live_publishable_key',
			        esc_html( $_REQUEST['live_publishable_key'] ) );

		        $live_publishable = true;
	        }

	        if ( ! ( $test_secret && $test_publishable )
	             && ! ( $live_secret && $live_publishable ) ) {
	        	$response[ 'valid_key' ] = "0";
	        	$response[ 'message' ] = sprintf( __( "You either need both a test secret key
	        	    and test publishable key, or both a live secret key and a
	        	    live publishable key to continue." ) );
	        }

	        // Send our json encoded response and die.
	        echo json_encode( $response );
	        die();
        }

        /**
         * Setup Admin
         *
         * Setup admin classes for Ninja Forms and WordPress.
         */
        public function setup_admin()
        {
            Ninja_Forms()->merge_tags[ 'stripe' ] = new NF_Stripe_MergeTags();
	        unset( Ninja_Forms()->fields[ 'creditcard' ] );

            if( ! is_admin() ) return;

            new NF_Stripe_Admin_Settings();
            new NF_Stripe_Admin_Metaboxes_Submission();
        }

        /**
         * Register Payment Gateways
         *
         * Register payment gateways with the Collect Payment action.
         *
         * @param array $payment_gateways
         * @return array $payment_gateways
         */
        public function register_payment_gateways($payment_gateways)
        {
            $payment_gateways[ 'stripe' ] = new NF_Stripe_PaymentGateway();

            return $payment_gateways;
        }

        /**
         * Template
         *
         * @param string $file_name
         * @param array $data
         */
        public static function template( $file_name = '', array $data = array() )
        {
            if( ! $file_name ) return;

            extract( $data );

            include self::$dir . 'includes/Templates/' . $file_name;
        }

        /**
         * Config
         *
         * @param $file_name
         * @return mixed
         */
        public static function config( $file_name )
        {
            return include self::$dir . 'includes/Config/' . $file_name . '.php';
        }

        /**
         * Autoloader
         *
         * Loads files using the class name to mimic the folder structure.
         *
         * @param $class_name
         */
        public function autoloader($class_name)
        {
            if (class_exists($class_name)) return;

            if ( false === strpos( $class_name, self::PREFIX ) ) return;

            $class_name = str_replace( self::PREFIX, '', $class_name );
            $classes_dir = realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR;
            $class_file = str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php';

            if (file_exists($classes_dir . $class_file)) {
                require_once $classes_dir . $class_file;
            }
        }
        
        /**
         * Hook Into Submission Exports.
         * 
         * @since 3.0
         * 
         * @param array $csv_array
         * @param array $subs
         * @param int $form_id
         * @return array
         */
        public function export_transaction_data( $csv_array, $subs, $form_id )
        {
            $add_transactions = false;
            $actions = Ninja_Forms()->form($form_id)->get_actions();
            // Loop over our actions to see if PayPal exists.
            foreach( $actions as $action ) {
                $settings = $action->get_settings();
                if( 'collectpayment' == $settings[ 'type' ] && 'stripe' == $settings[ 'payment_gateways' ] ) {
                    $add_transactions = true;
                }
            }
            
            // If we didn't find a PayPal action, bail.
            if( ! $add_transactions ) return $csv_array;
            
            // Add our labels.
            $csv_array[ 0 ][ 0 ][ 'stripe_customer_id' ] = __( 'Stripe Customer ID', 'ninja-forms-stripe' );
            $csv_array[ 0 ][ 0 ][ 'stripe_charge_id' ] = __( 'Stripe Charge ID', 'ninja-forms-stripe' );
            $csv_array[ 0 ][ 0 ][ 'stripe_brand' ] = __( 'Card', 'ninja-forms-stripe' );
            // Add our values.
            $i = 0;
            foreach( $subs as $sub ) {
                $csv_array[ 1 ][ 0 ][ $i ][ 'stripe_customer_id' ] = $sub->get_extra_value( 'stripe_customer_id' );
                $csv_array[ 1 ][ 0 ][ $i ][ 'stripe_charge_id' ] = $sub->get_extra_value( 'stripe_charge_id' );
                $csv_array[ 1 ][ 0 ][ $i ][ 'stripe_brand' ] = $sub->get_extra_value( 'stripe_brand' );
                $i++;
            }
            return $csv_array;
            
        }

        /*
         * Required methods for all extension.
         */

        public function setup_license()
        {
            if ( ! class_exists( 'NF_Extension_Updater' ) ) return;

            new NF_Extension_Updater( self::NAME, self::VERSION, self::AUTHOR, __FILE__, self::SLUG );
        }
    }

    /**
     * The main function responsible for returning The Highlander Plugin
     * Instance to functions everywhere.
     *
     * Use this function like you would a global variable, except without needing
     * to declare the global.
     *
     * @since 3.0
     * @return NF_Stripe Highlander Instance
     */
    function NF_Stripe()
    {
        return NF_Stripe::instance();
    }

    NF_Stripe();

}


add_filter( 'ninja_forms_after_upgrade_settings', 'NF_Stripe_Upgrade' );
function NF_Stripe_Upgrade( $data ){

    $stripe_settings = get_option( 'ninja_forms_stripe' );
    
    $new_settings = array(

        // Transaction Currency
        'stripe_currency'             => $stripe_settings[ 'currency' ],

        // Test Credentials
        'stripe_test_secret_key'      => $stripe_settings[ 'test_secret_key' ],
        'stripe_test_publishable_key' => $stripe_settings[ 'test_publishable_key' ],

        // Live Credentials
        'stripe_live_secret_key'      => $stripe_settings[ 'live_secret_key' ],
        'stripe_live_publishable_key' => $stripe_settings[ 'live_publishable_key' ],
    );

    // Check for current settings and overwrite.
    $current_settings = Ninja_Forms()->get_settings();
    foreach( $new_settings as $setting => &$value ) {
        if( isset( $current_settings[ $setting ] ) && !empty( $current_settings[ $setting ] ) ) {
            $value = $current_settings[ $setting ];
        }
    }
    
    Ninja_Forms()->update_settings( $new_settings );

    if( ! isset( $data[ 'settings' ][ 'stripe' ] ) &&
        (
            ! isset( $data[ 'settings' ][ 'stripe_default_total' ] ) ||
            ! isset( $data[ 'settings' ][ 'stripe_recurring_plan' ] )
        )
    ) return $data;

    $action = array(
        'active'                     => $data[ 'settings' ][ 'stripe' ],
        'label'                      => __( 'Stripe', 'ninja-forms-stripe' ),
        'type'                       => 'collectpayment',
        'stripe_test_mode'           => $data[ 'settings' ][ 'stripe_test_mode' ],
        'payment_gateways'           => 'stripe',
        'payment_total'              => $data[ 'settings' ][ 'stripe_default_total' ],
        'stripe_customer_email'      => '', // TBD by User Billing Info (Ninja Forms v2.9.x)
        'stripe_recurring_plan'      => $data[ 'settings' ][ 'stripe_recurring_plan' ],
        'stripe_product_description' => $data[ 'settings' ][ 'stripe_desc' ]
    );



    foreach( $data[ 'fields' ] as $field ) {

        if( ! isset( $field[ 'type' ] ) ) continue;

        if( '_calc' == $field[ 'type' ] || 'calc' == $field[ 'type' ] ) {
            if ( isset( $field[ 'calc_name' ] ) && 'total' == $field[ 'calc_name' ] ) {
                $action[ 'payment_total' ] = '{calc:calc_' . $field[ 'id' ] . '}';
            }
        }
        
        if( 'email' != $field[ 'type' ] ) continue;

        if( ! isset( $field[ 'user_info_field_group_name' ] ) ) continue;
        if( 'billing' != $field[ 'user_info_field_group_name' ] ) continue;

        $action[ 'stripe_customer_email' ] = '{field:' . $field[ 'key' ] . '}';
    }

    unset( $data[ 'settings' ][ 'stripe' ] );
    unset( $data[ 'settings' ][ 'stripe_test_mode' ] );
    unset( $data[ 'settings' ][ 'stripe_desc' ] );
    unset( $data[ 'settings' ][ 'stripe_default_total' ] );
    unset( $data[ 'settings' ][ 'stripe_recurring_plan' ] );

    array_push( $data[ 'actions' ], $action );

    return $data;
}
