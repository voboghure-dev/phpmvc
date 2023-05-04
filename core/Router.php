<?php
namespace app\core;

use app\core\exceptions\NotFoundException;

class Router {
	public Request $request;
	public Response $response;
	protected array $routes = [];

	public function __construct( Request $request, Response $response ) {
		$this->request  = $request;
		$this->response = $response;
	}

	public function get( $path, $callback ) {
		$this->routes['get'][$path] = $callback;
	}

	public function post( $path, $callback ) {
		$this->routes['post'][$path] = $callback;
	}

	public function resolve() {
		$path     = $this->request->getPath();
		$method   = $this->request->method();
		$callback = $this->routes[$method][$path] ?? false;
		if ( $callback === false ) {
			throw new NotFoundException();
		}
		if ( is_string( $callback ) ) {
			return $this->renderView( $callback );
		}
		if ( is_array( $callback ) ) {
			/** @var Controller $controller */
			$controller                   = new $callback[0]();
			Application::$app->controller = $controller;
			$controller->action           = $callback[1];
			$callback[0]                  = $controller;

			foreach ( $controller->getMiddlewares() as $middleware ) {
				$middleware->execute();
			}
		}

		return call_user_func( $callback, $this->request, $this->response );
	}

	public function renderView( $view, $params = [] ) {
		$layoutContent = $this->layoutContent();
		$viewContent   = $this->viewContent( $view, $params );

		return str_replace( '{{content}}', $viewContent, $layoutContent );
	}

	public function renderContent( $viewContent ) {
		$layoutContent = $this->layoutContent();

		return str_replace( '{{content}}', $viewContent, $layoutContent );
	}

	protected function layoutContent() {
		$layout = Application::$app->layout;
		if ( Application::$app->controller ) {
			$layout = Application::$app->controller->layout;
		}
		ob_start();
		include_once Application::$ROOT_PATH . "/views/layouts/$layout.php";

		return ob_get_clean();
	}

	protected function viewContent( $view, $params ) {
		foreach ( $params as $key => $value ) {
			$$key = $value;
		}

		ob_start();
		include_once Application::$ROOT_PATH . "/views/$view.php";

		return ob_get_clean();
	}

}