<?php
/**
 * Date: 12/1/20
 * Time: 5:34 PM
 */

define( 'WP_HELPER_PATH', plugin_dir_path( __FILE__ ) );


return [
	'enqueue_scripts' => [
		'register' => [
			'script' => [
				'jquery-md5-js'                     => [
					plugins_url( '/assets/lib/jquery-lib/jquery.md5.js', __FILE__ ),
					array( 'jquery' ),
				],
				'html5lightbox'                     => [
					plugins_url( '/assets/lib/html5lightbox/html5lightbox.js', __FILE__ ),
					[ 'jquery' ]
				],
				'bootstrap'                         => [
					plugins_url( '/assets/lib/bootstrap/js/bootstrap.min.js', __FILE__ ),
					array( 'jquery' )
				],
				'jquery-validate'                   => [
					'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js',
					array( 'jquery' )
				],
				'jquery-validate-additional-method' => [
					'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js',
					array(
						'jquery',
						'jquery-validate'
					)
				]
			],
			'style'  => [
				'bootstrap'        => [
					plugins_url( '/assets/lib/bootstrap/css/bootstrap.min.css', __FILE__ ),
				],
				'font-awesome-all' => [
					plugins_url( '/assets/lib/fontawesome/css/all.css', __FILE__ ),
				],
				'font-awesome'     => [
					plugins_url( '/assets/lib/fontawesome/css/fontawesome.css', __FILE__ ),
				],
			],
		],
		'enqueue'  => [
			'script' => [
				'elhelper-script' => [
					'src'              => plugins_url( '/assets/js/el-helper-plugin.js', __FILE__ ),
					'dep'              => array( 'jquery' ),
					'ver'              => '',
					'in_footer'        => '',
					'locallize_script' => [
						'ajax_object' => [
							'ajax_url' => admin_url( 'admin-ajax.php' ),
							'we_value' => 1234
						]
					],
				],
			],
			'style'  => [
				'elhelper-style' => [
					'src'       => plugins_url( '/assets/css/el-helper-style.css', __FILE__ ),
					'dep'       => '',
					'ver'       => '',
					'in_footer' => '',
				]
			],
		],
	]
];