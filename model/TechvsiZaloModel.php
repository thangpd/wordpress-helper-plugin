<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 2/18/21
 * Time: 1:39 PM
 */

namespace Elhelper\model;

use Elhelper\common\Model;
use Elhelper\inc\HelperShortcode;

class TechvsiZaloModel extends Model {

	private $access_token;
	private $oaId;

	public function __construct( $access_token, $oaId ) {
		$this->access_token = $access_token;
		$this->oaId         = $oaId;
	}

	public function call_remote_api( $url, $method, $params = [] ) {
		$http     = new \WP_Http();
		$default  = [ 'access_token' => $this->access_token ];
		$params   = array_merge( $params, $default );
		$response = $http->request( $url, array( 'method' => $method, 'body' => $params ) );

		return $response;
	}

	public function getOAInformation() {
		$res = get_transient( 'oa_information' );
		if ( ! $res ) {
			$url = 'https://openapi.zalo.me/v2.0/oa/getoa';
			$res = HelperShortcode::callAPI( 'GET', $url, [ 'access_token' => $this->access_token ] );
			$res = json_decode( $res );
			if ( ! empty( $res ) && $res->message == 'Success' ) {
				set_transient( 'oa_information', json_encode( $res ), 3600 * 24 );
				$res = json_encode( $res );
			}
		}

		return json_decode( $res );
	}

	public function getListSubscribers() {
//		$url = 'https://openapi.zalo.me/v2.0/oa/getfollowers?access_token=<ACCESS_TOKEN>&data={"offset":0,"count":5}';
		$url    = 'https://openapi.zalo.me/v2.0/oa/getfollowers';
		$data   = [ 'offset' => 0, 'count' => 5 ];
		$method = 'GET';
		$res    = HelperShortcode::callAPI( $method, $url,
			[
				'data'         => json_encode( $data ),
				'access_token' => $this->access_token
			] );

		return json_decode( $res );
	}

	public function sendMessageToListRecipient() {
		$url      = 'https://openapi.zalo.me/v2.0/oa/message';
		$method   = 'POST';
		$raw_body = [
			'recipient' => [ 'user_id' => "1470895957446547852" ],
			'message'   => [
				'text' => 'TechvsiZalo test',
			],
		];
		$res      = HelperShortcode::callAPI( $method, $url, [
			'access_token' => $this->access_token,
		], $raw_body );

		var_dump( $res );

	}


}