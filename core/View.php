<?php
namespace app\core;

class View {
	public string $title = '';

	public function renderView( $view, $params = [] ) {
		$viewContent   = $this->viewContent( $view, $params );
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