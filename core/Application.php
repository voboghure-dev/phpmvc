<?php
namespace app\core;

class Application {
	public static string $ROOT_PATH;
	public Request $request;
	public Response $response;
	public Session $session;
	public Database $db;
	public Router $router;
	public static Application $app;
	public  ? Controller $controller = null;
	public  ? DbModel $user;
	public string $userClass;
	public string $layout = 'main';

	public function __construct( $rootPath, array $config ) {
		self::$ROOT_PATH = $rootPath;
		self::$app       = $this;
		$this->request   = new Request();
		$this->response  = new Response();
		$this->session   = new Session();
		$this->router    = new Router( $this->request, $this->response );
		$this->db        = new Database( $config['db'] );
		$this->userClass = $config['userClass'];

		$primaryValue = $this->session->get( 'user' );
		if ( $primaryValue ) {
			$primaryKey = $this->userClass::primaryKey();
			$this->user = $this->userClass::findOne( [$primaryKey => $primaryValue] );
		} else {
			$this->user = null;
		}

	}

	public function run() {
		echo $this->router->resolve();
	}

	public function getController() {
		return $this->controller;
	}

	public function setController( Controller $controller ) {
		$this->controller = $controller;
	}

	public static function isGuest() {
		return  ! self::$app->user;
	}

	public function login( DbModel $user ) {
		$this->user   = $user;
		$primaryKey   = $user->primaryKey();
		$primaryValue = $user->{$primaryKey};
		$this->session->set( 'user', $primaryValue );

		return true;
	}

	public function logout() {
		$this->user = null;
		$this->session->remove( 'user' );
	}
}