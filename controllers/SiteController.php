<?php
namespace app\controllers;

use voboghure\phpmvc\Application;
use voboghure\phpmvc\Controller;
use voboghure\phpmvc\Request;
use voboghure\phpmvc\Response;
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
				Application::$app->session->setFlash( 'success', 'Thanks for contacting with us' );

				return $response->redirect( '/contact' );
			}
		}

		return $this->render( 'contact', [
			'model' => $contactForm,
		] );
	}
}