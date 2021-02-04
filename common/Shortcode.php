<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 2/3/21
 * Time: 5:41 PM
 */

namespace Elhelper\common;


abstract class Shortcode extends Base {

	private $_view;

	public function __construct() {
		add_shortcode( $this->get_name(), [ $this, 'render_shortcode' ] );
		//enqueue
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	abstract protected function get_name();

	abstract function render_shortcode( $attr = [], $content = '' );

	public function enqueue_scripts() {

	}

	/**
	 * https://packagist.org/packages/typisttech/wp-kses-view
	 * Render WPKsesView
	 * return Views template with context
	 *
	 *
	 */
	public function render( $template, $params = [], $allowed_html = [] ) {
		return $this->get_view( $template, $allowed_html )->render( (object) $params );
	}

	/**
	 * https://packagist.org/packages/typisttech/wp-kses-view
	 * Init \TypistTech\WPKsesView\View
	 * return $this->_view
	 */
	public function get_view( $template, $allowed_html = [] ) {

		$allowed_html = ! empty( $allowed_html ) ? $allowed_html : wp_kses_allowed_html( 'post' );

		$this->_view = new \TypistTech\WPKsesView\View( $template, $allowed_html );

		return $this->_view;
	}

	/**
	 * https://packagist.org/packages/typisttech/wp-kses-view
	 * Render Html by WPKsesView
	 * return html with context
	 */
	public function renderHtml( $template, $params = [], $allowed_html = [] ) {
		return $this->get_view( $template, $allowed_html )->toHtml( (object) $params );
	}

}