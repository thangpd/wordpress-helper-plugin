<?php
/**
 * Date: 2/17/21
 * Time: 1:31 PM
 */

?>

zalo api shortcode

<?php
/**
 * Date: 2/2/21
 * Time: 4:37 PM
 */
echo 'thuanpham';
ini_set( 'display_errors', 1 );
ini_set( 'display_startup_errors', 1 );
error_reporting( E_ALL );

$return_file = fopen( 'return.txt', 'w' ) or die ( "unable to open return file!" );
fwrite( $return_file, 'test' );
fwrite( $return_file, json_encode( $_SERVER ) );
fwrite( $return_file, json_encode( $_GET ) );
fwrite( $return_file, json_encode( $_POST ) );

fclose( $return_file );


$myfile = fopen( "log.txt", "w" ) or die( "Unable to open file!" );

echo '<pre>';
print_r( $_SERVER );
echo '</pre>';


use Zalo\Zalo;


$callBackUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

fwrite( $myfile, $callBackUrl );

$config = array(
	'app_id'       => ! empty( $_GET['app_id'] ) ? $_GET['app_id'] : 'app_id_null',
	'app_secret'   => ! empty( $_GET['app_secret'] ) ? $_GET['app_secret'] : 'app_secret_null',
	'callback_url' => $callBackUrl
);
echo '<pre>';
echo 'config<br>';
print_r( $config );
echo '</pre>';


$zalo = new Zalo( $config );
echo '<pre>';
echo 'zalo object<br>';
print_r( $zalo );
echo '</pre>';

$helper = $zalo->getRedirectLoginHelper();
echo '<pre>';
echo 'helper';
print_r( $helper );
echo '</pre>';


$loginUrl = $helper->getLoginUrl( $callBackUrl ); // This is login url

echo '<pre>';
echo 'login url <br>';
print_r( $loginUrl );
echo '</pre>';


$oauthCode = isset( $_GET['code'] ) ? $_GET['code'] : "THIS NOT CALLBACK PAGE !!!"; // get oauthoauth code from url params
echo '<pre>';
echo 'oauthCode<br>';
print_r( $oauthCode );
echo '</pre>';

//$accessToken = $helper->getAccessToken( $callBackUrl ); // get access token
//echo '<pre>';
//echo 'accesstoken<br>';
//print_r( $accessToken );
//echo '</pre>';
//fwrite( $myfile, $accessToken );


//if ( $accessToken != null ) {
//	$expires = $accessToken->getExpiresAt(); // get expires time
//	fwrite( $myfile, $expires );
//
//}

echo 'close file';
echo '<br>';
fclose( $myfile );

echo 'done';