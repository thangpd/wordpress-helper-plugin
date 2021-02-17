<?php
/**
 * Date: 12/2/20
 * Time: 9:05 AM
 */

namespace Elhelper\common;


abstract class Controller extends Singleton {
	public $view_path = '';

	public static function enqueue_scripts_general() {

	}
	/**
	 * Always return string path for template_include hook.
	 */
		public function render( $path ) {
			static::enqueue_scripts_general();

			return static::$_instance->view_path . 'views' . DIRECTORY_SEPARATOR . $path;
		}

	public function templateInclude( $template ) {
		return $template;
	}


}