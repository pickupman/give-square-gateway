<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://reloadedpd.com
 * @since      1.0.0
 *
 * @package    Give_Square_Gateway
 * @subpackage Give_Square_Gateway/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Give_Square_Gateway
 * @subpackage Give_Square_Gateway/admin
 * @author     Joe McFrederick <jomcfred@gmail.com>
 */
class Give_Square_Gateway_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Give_Square_Gateway_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Give_Square_Gateway_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/give-square-gateway-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Give_Square_Gateway_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Give_Square_Gateway_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/give-square-gateway-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function give_square_add_settings( $settings ) {
		//Vars
		$prefix = '_give_';

		$is_gateway_active = give_is_gateway_active( 'square' );

		//this gateway isn't active
		if ( ! $is_gateway_active ) {
			//return settings and bounce
			return $settings;
		}

		//Fields
		$check_settings = array(
			array(
				'name' => esc_html__( 'Square.com', 'give' ),
				'desc' => '',
				'type' => 'give_title',
				'id'   => 'give_title_gateway_settings_10',
			),
			array(
				'id'          => 'square_application_id',
				'name'        => esc_attr__( 'Square Application ID', 'give' ),
				'desc'        => esc_attr__( 'Enter the application from your Square.com account.', 'give' ),
				'default'     => esc_attr__( '', 'give' ),
				'row_classes' => 'give-subfield',
				'type'        => 'text'
			),
		);

		return array_merge( $settings, $check_settings );
	}

}
