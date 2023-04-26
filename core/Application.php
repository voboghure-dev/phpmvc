<?php
namespace app\core;

class Application {
	public static string $ROOT_PATH;
	public Request $request;
	public Response $response;
	public Database $db;
	public Router $router;
	public static Application $app;
	public Controller $controller;

	public function __construct( $rootPath, array $config ) {
		self::$ROOT_PATH = $rootPath;
		self::$app       = $this;
		$this->request   = new Request();
		$this->response  = new Response();
		$this->router    = new Router( $this->request, $this->response );
		$this->db        = new Database( $config['db'] );
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
}