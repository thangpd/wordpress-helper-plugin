<?php
/*
 Plugin Name: Wordpress Helper Plugin
 Plugin URI: https://wordpress.org/plugins/
 Description: Custom Template Of Elementor
 Author: Thangpd
 Version: 1.0
 Author URI: https://thangpd.info/
 Text Domain: elhelper
 */

namespace Elhelper;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

use Elhelper\modules\reglogCustomer\controller\RegLogController;
use Elhelper\modules\templateInclude\LeefeeTemplateIncludeController;
use Elhelper\shortcode\ElHelperShortcode;
use Elhelper\shortcode\ListingPriceShortcode;
use Elhelper\shortcode\TestShortcode;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main Elementor Test Extension Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
class Elhelper_Plugin {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';
	/**
	 * declare enqueue wpackio scripts/styles
	 */
	public static $enqueue;
	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Elhelper_Plugin The single instance of the class.
	 */
	private static $_instance = null;
	/**
	 * Controllers of all modules;
	 */
	private $controllers;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'init' ] );
		add_action( 'init', function () {
			return load_plugin_textdomain( 'elhelper' );
		} );

		//https://wpack.io/guides/using-wpackio-enqueue/#why-call-it-early
		self::$enqueue = new \WPackio\Enqueue( 'wordpressHelperPlugins', 'dist', '1.0.0', 'plugin', __FILE__ );

	}

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Elhelper_Plugin An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;

	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {

		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			// Add Plugin actions
			add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
			add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );

		}

		//enqueue
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_script' ] );
		add_filter( 'template_include', [ $this, 'summit_template_include' ], 10 );

		//shortcode
		$this->init_shortcode();

		$this->init_controller();

	}

	/**
	 * Init Shortcode
	 * @return void
	 */
	public function init_shortcode() {

		new ElHelperShortcode();
		new ListingPriceShortcode();
		new TestShortcode();
	}

	/**
	 * Init Controller
	 * @return void
	 */
	public function init_controller() {
		$this->controllers = [
			LeefeeTemplateIncludeController::instance(),
			RegLogController::instance(),
		];
	}

	/**
	 * Template include
	 */
	public function summit_template_include( $template ) {
		foreach ( $this->controllers as $controller ) {
			$template = $controller->templateInclude( $template );
		}

		return $template;

	}

	/**
	 * @param $hook
	 */
	function enqueue_script( $hook ) {
		//lib
		wp_register_script( 'jquery-md5-js', plugins_url( '/assets/lib/jquery-lib/jquery.md5.js', __FILE__ ), array( 'jquery' ) );
		wp_register_script( 'html5lightbox', plugins_url( '/assets/lib/html5lightbox/html5lightbox.js', __FILE__ ), [ 'jquery' ] );
		wp_register_script( 'bootstrap', plugins_url( '/assets/lib/bootstrap/js/bootstrap.min.js', __FILE__ ), array( 'jquery' ) );
		wp_register_script( 'jquery-validate', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js', array( 'jquery' ) );
		wp_register_script( 'jquery-validate-additional-method', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js', array(
			'jquery',
			'jquery-validate'
		) );


		wp_register_style( 'slick', plugins_url( '/assets/lib/slick/slick.css', __FILE__ ) );
		wp_register_style( 'slick-theme', plugins_url( '/assets/lib/slick/slick-theme.css', __FILE__ ) );
		wp_register_style( 'bootstrap', plugins_url( '/assets/lib/bootstrap/css/bootstrap.min.css', __FILE__ ) );
		wp_register_style( 'font-awesome-all', plugins_url( '/assets/lib/fontawesome/css/all.css', __FILE__ ) );
		wp_register_style( 'font-awesome', plugins_url( '/assets/lib/fontawesome/css/fontawesome.css', __FILE__ ) );

		//main css js
		wp_enqueue_script( 'elhelper-script', plugins_url( '/assets/js/el-helper-plugin.js', __FILE__ ), array( 'jquery' ) );
		wp_enqueue_style( 'elhelper-style', plugins_url( '/assets/css/el-helper-style.css', __FILE__ ) );
		wp_localize_script( 'elhelper-script', 'ajax_object',
			array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );

		self::$_instance->wpackio_enqueue( 'testapp', 'main', [] );

	}

	public function wpackio_enqueue( $app, $entry, $params = [] ) {
		//wpackio
		self::$enqueue->enqueue( $app, $entry, $params );
	}


	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-test-extension' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'elementor-test-extension' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-test-extension' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-extension' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'elementor-test-extension' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-test-extension' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-extension' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'elementor-test-extension' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementor-test-extension' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_widgets() {

		// Include Widget files
//		require_once( __DIR__ . '/widgets/bhhs-search.php' );

		// Register widget
//		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Bhhs_Search() );

	}

	/**
	 * Init Controls
	 *
	 * Include controls files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_controls() {

		// Include Control files
		require_once( __DIR__ . '/controls/test-control.php' );

		// Register control
//		\Elementor\Plugin::$instance->controls_manager->register_control( 'control-type-', new \Elementor_Test_Control() );

	}


}


Elhelper_Plugin::instance();