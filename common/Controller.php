<?php
/**
 * Date: 12/2/20
 * Time: 9:05 AM
 */

namespace Elhelper\common;


abstract class Controller extends Singleton {
	public $view_path = '';

	public function templateInclude( $template ) {
		return $template;
	}

/*	public function render( $path ) {
		static::enqueue_scripts_general();

		return static::$_instance->view_path . 'views' . DIRECTORY_SEPARATOR . $path;
	}*/

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


	public static function enqueue_scripts_general() {

	}

}