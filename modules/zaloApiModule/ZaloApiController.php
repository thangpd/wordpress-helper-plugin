<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 1/25/21
 * Time: 11:12 AM
 */

namespace Elhelper\modules\zaloApiModule;

use Elhelper\common\Controller;
use Elhelper\Elhelper_Plugin;

/**Template include template test
 * How to use:
 *      + check if == post_name
 *      + Include template
 */
class ZaloApiController extends Controller {
	//Override $_instance. If not. It'll have the last object instance is initialized before this class.
	protected static $_instance;

	public function __init() {
//		add_filter( 'template_include', [ $this, 'leefee_template_include' ] );
		$this->view_path = plugin_dir_path( __FILE__ );
		add_action( 'wp_enqueue_scripts', [ $this, 'add_enqueue_scripts' ] );
	}

	public function add_enqueue_scripts() {
		Elhelper_Plugin::instance()->wpackio_enqueue( 'testapp', 'zaloapi' );
	}


	function templateInclude( $template ) {
		//we can't use query arg because can't coverage multiple dimension like : test/test/test
		//add_query_arg( [] ) return request uri when empty array is pass as parameter.
		//if ( str_replace( '/', '', add_query_arg( [] ) ) == 'test' ) {
		$get_queried_object = get_queried_object();
		if ( isset( $get_queried_object ) && $get_queried_object->post_name == 'zaloapi' ) {

//			$plugin_dir_path = plugin_dir_path( __FILE__ ) . 'views/index.php';
//			$template        = $plugin_dir_path;
			$template        = $this->render('index.php');
		}


		return $template;
	}


}