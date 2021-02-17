<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 2/17/21
 * Time: 1:29 PM
 */

namespace Elhelper\shortcode\zaloApi;

use Elhelper\common\Shortcode;
use Elhelper\Elhelper_Plugin;

class ZaloApiShortcode extends Shortcode {
	function render_shortcode( $attr = [], $content = '' ) {
		Elhelper_Plugin::instance()->wpackio_enqueue( 'testapp', 'zaloApiShortcode' );

		$template_path = plugin_dir_path( __FILE__ ) . 'views/test-shortcode/index.php';

		return $this->render( $template_path, [ 'context' => 'test' ] );
	}

	protected function get_name() {
		// TODO: Implement get_name() method.
		return 'zaloapi_shortcode';
	}

}