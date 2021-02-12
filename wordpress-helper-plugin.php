<?php
/*
 Plugin Name: Wordpress Helper Plugin
 Plugin URI: https://wordpress.org/plugins/
 Description: Custom Template Of Elementor
 Author: Thangpd
 Version: 1.0
 Author URI: https://thangpd.info/
 Text Domain: elhelper
 */

namespace Elhelper;
require __DIR__ . '/vendor/autoload.php';
$config = require __DIR__ . '/config.php';
require_once __DIR__ . '/Elhelper.php';
Elhelper_Plugin::instance( $config );
