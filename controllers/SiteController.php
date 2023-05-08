<?php
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\ContactForm;

class SiteController extends Controller {
	public function home() {
		$params = [
			'name' => 'VoboGhure',
		];

		return $this->render( 'home', $params );
	}

	public function contact( Request $request, Response $response ) {
		$contactForm = new ContactForm();
		if ( $request->isPost() ) {
			$contactForm->loadData( $request->getBody() );
			if ( $contactForm->validate() && $contactForm->send() ) {
				Application::$app->session->setFlash( 'success', 'Your message sent' );

				return $response->redirect( '/contact' );
			}
		}

		return $this->render( 'contact', [
			'model' => $contactForm,
		] );
	}

}