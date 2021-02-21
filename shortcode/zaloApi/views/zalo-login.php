<?php
/**
 * Date: 2/17/21
 * Time: 1:31 PM
 */

?>

    zalo Social api shortcode
<?php

use Zalo\Zalo;

$callBackUrl = home_url() . '/access-token';
echo '<pre>';
print_r( $callBackUrl );
echo '</pre>';

$config = array(
	'app_id'       => ! empty( $_GET['app_id'] ) ? $_GET['app_id'] : 'app_id_null',
	'app_secret'   => ! empty( $_GET['app_secret'] ) ? $_GET['app_secret'] : 'app_secret_null',
	'callback_url' => $callBackUrl
);
echo '<pre>';
echo 'config<br>';
print_r( $config );
echo '</pre>';


try {
	$zalo = new Zalo( $config );
} catch ( \Zalo\Exceptions\ZaloSDKException $exception ) {
	throw new \Zalo\Exceptions\ZaloSDKException( 'lỗi' );
}
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

?>