<?php

namespace app\controllers;

use app\core\Controller;

class SiteController extends Controller {
	public function home() {
		$params = [
			'name' => 'VoboGhure',
		];

		// return Application::$app->router->renderView( 'home', $params );
		return $this->render( 'home', $params );
	}

	public function contact() {
		return $this->render( 'contact' );
	}

	public function handleContact() {
		return "Handling submitted data";
	}
}