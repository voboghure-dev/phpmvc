<?php
namespace app\controllers;

use app\models\LoginAPI;
use Firebase\JWT\JWT;
use voboghure\phpmvc\Controller;
use voboghure\phpmvc\Request;
use voboghure\phpmvc\Response;

class APIController extends Controller {
	public function login( Request $request, Response $response ) {
		header( "Access-Control-Allow-Origin: *" );
		header( "Access-Control-Allow-Methods: POST" );
		header( "Content-type: application/json; charset=utf-8" );

		$loginAPI = new LoginAPI();
		if ( $request->isPost() ) {
			$loginAPI->loadData( $request->getBody() );
			/** @var app\models\User $user */
			if ( $loginAPI->validate() && ( $user = $loginAPI->login() ) ) {
				$data = [
					'id'    => $user->id,
					'name'  => $user->getDisplayName(),
					'email' => $user->email,
				];

				$key     = 'abcdefg';
				$payload = [
					'iss'  => 'http://phpmvc.local/',
					'aud'  => 'http://phpmvc.local/',
					'iat'  => time(),
					'nbf'  => time() + 10,
					'data' => $data,
				];

				$jwt = JWT::encode( $payload, $key, 'HS256' );

				return $jwt;
			}
		}
	}
}