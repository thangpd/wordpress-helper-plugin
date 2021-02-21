<?php
/**
 * Date: 2/19/21
 * Time: 10:16 AM
 */


function callAPI( $method, $url, $data = false, $raw_body = '' ) {
	$curl = curl_init();
	switch ( $method ) {
		case "POST":
			curl_setopt( $curl, CURLOPT_POST, 1 );

			if ( $data ) {
				$raw_body = json_encode( $raw_body );
				curl_setopt( $curl, CURLOPT_POSTFIELDS, $raw_body );
				$url = sprintf( "%s?%s", $url, http_build_query( $data ) );
				curl_setopt( $curl, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json' ) );
			}
			break;
		case "PUT":
			curl_setopt( $curl, CURLOPT_PUT, 1 );
			break;
		default:
			if ( $data ) {
				$url = sprintf( "%s?%s", $url, http_build_query( $data ) );
			}
	}

	// Optional Authentication:
	curl_setopt( $curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
	curl_setopt( $curl, CURLOPT_USERPWD, "username:password" );

	curl_setopt( $curl, CURLOPT_URL, $url );
	curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );

	$result = curl_exec( $curl );

	curl_close( $curl );

	return $result;
}


$url = 'https://openapi.zalo.me/v2.0/oa/getoa';
$res=callAPI( 'GET', $url, [ 'access_token' => 'access-token' ] );


echo '<pre>';
print_r($res);
echo '</pre>';

