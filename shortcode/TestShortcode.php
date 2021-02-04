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


	public function render_shortcode( $attr = [], $content = '' ) {
		Elhelper_Plugin::instance()->wpackio_enqueue( 'testapp', 'test_shortcode' );
		$res_html = <<<HTML
<div class="r-carousel">
  <div class="r-carousel__item"><img class="r-carousel__img" src="https://image.shutterstock.com/image-vector/example-sign-paper-origami-speech-260nw-1164503347.jpg"/></div>
  <div class="r-carousel__item"><img class="r-carousel__img" src="https://image.shutterstock.com/image-vector/example-sign-paper-origami-speech-260nw-1164503347.jpg"/></div>
  <div class="r-carousel__item"><img class="r-carousel__img" src="https://image.shutterstock.com/image-vector/example-sign-paper-origami-speech-260nw-1164503347.jpg"/></div>
  <div class="r-carousel__item"><img class="r-carousel__img" src="https://image.shutterstock.com/image-vector/example-sign-paper-origami-speech-260nw-1164503347.jpg"/></div>
</div>
HTML;

		return $res_html;
	}

	protected function get_name() {
		// TODO: Implement get_name() method.
		return 'test_el_shortcode';
	}


}