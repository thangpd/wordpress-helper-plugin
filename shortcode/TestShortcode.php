<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 2/4/21
 * Time: 11:02 AM
 */

namespace Elhelper\shortcode;


use Elhelper\common\Shortcode;
use Elhelper\Elhelper_Plugin;

class TestShortcode extends Shortcode {


	function enqueue_scripts() {
//		wp_register_script();
//		wp_register_style();
	}

	public function render_shortcode( $attr = [], $content = '' ) {
		Elhelper_Plugin::instance()->wpackio_enqueue( 'testapp', 'test_shortcode' );
		$res_html = <<<HTML
		<div class="test">ok
		</div>
HTML;

		return $res_html;

	}

	protected function get_name() {
		// TODO: Implement get_name() method.
		return 'test_el_shortcode';
	}


}