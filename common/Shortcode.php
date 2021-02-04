<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 2/3/21
 * Time: 5:41 PM
 */

namespace Elhelper\common;


abstract class Shortcode extends Base {

	public function __construct() {
		add_shortcode( $this->get_name(), [ $this, 'render_shortcode' ] );
		//enqueue
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	abstract protected function get_name();

	abstract function render_shortcode( $attr = [], $content = '' );

	public function enqueue_scripts() {

	}

}