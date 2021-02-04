<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 2/4/21
 * Time: 11:02 AM
 */

namespace Elhelper\shortcode;


use Elhelper\common\Shortcode;

class TestShortcode extends Shortcode {


	function enqueue_scripts() {
//		wp_register_script();
//		wp_register_style();
	}

	public function render_shortcode( $attr = [], $content = '' ) {

		return 'ok';

	}

	protected function get_name() {
		// TODO: Implement get_name() method.
		return 'test_el_shortcode';
	}


}