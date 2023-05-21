<?php
namespace app\controllers;

use app\models\LoginAPI;
use app\models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use voboghure\phpmvc\Controller;
use voboghure\phpmvc\Request;
use voboghure\phpmvc\Response;

class APIController extends Controller {
	/**
	 * Authenticate user and get JWT token
	 *
	 * @param Request $request
	 * @param Response $response
	 *
	 * @return JWT $jwt
	 */
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

				$key     = $_ENV['JWT_KEY'];
				$payload = [
					'iss'  => 'http://phpmvc.local/',
					'aud'  => 'users',
					'iat'  => time(),
					'nbf'  => time() + 10,
					'data' => $data,
				];

				$jwt = JWT::encode( $payload, $key, 'HS256' );

				return $jwt;
			}
		}
	}

	/**
	 * Add new user
	 *
	 * @param Request $request
	 * @param Response $response
	 *
	 * @return void
	 */
	public function add_user( Request $request, Response $response ) {
		header( "Access-Control-Allow-Origin: *" );
		header( "Access-Control-Allow-Methods: POST" );
		header( "Content-type: application/json; charset=utf-8" );

		if ( $request->isPost() ) {
			$headers = getallheaders();
			$jwt     = $headers['Authorization'];
			$key     = $_ENV['JWT_KEY'];
			$decoded_data = JWT::decode( $jwt, new Key( $key, 'HS256' ) );

			$user = new User();
			$user->loadData( $request->getBody() );
			// print_r($user); die;
			if ( $user->validate() && $user->save() ) {
				return 'Done';
			} else {
				return 'Die';
			}
		}
	}
}