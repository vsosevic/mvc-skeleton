<?php

/**
* 
*/
class Router
{	
	private $routes;

	public function __construct()
	{
		$routesPath = ROOT.'/config/routes.php';
		$this->routes = include($routesPath);
	}

	/**
	* Returns request string
	*/
	private function getURI() 
	{
		//Geting link request
		if (!empty($_SERVER['REQUEST_URI'])) {
			return trim($_SERVER['REQUEST_URI'], '/');
		}
	}

	public function run()
	{
		$uri = $this->getURI();

		foreach ($this->routes as $uriPattern => $path) {

			if (preg_match("~$uriPattern~", $uri)) {

				//Getting parameters from ulr
				$internalRoute = preg_replace("~$uriPattern~", $path, $uri);

				//Defining controllers and actions
				$segments = explode('/', $internalRoute);

				$controllerName = array_shift($segments).'Controller';
				$controllerName = ucfirst($controllerName);

				$actionName = 'action' . ucfirst(array_shift($segments));

				$parameters = $segments;

				//Apply particular controller file
				$controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

				if (file_exists($controllerFile)) {
					include_once($controllerFile);
				}

				$controllerObject = new $controllerName;

				//Giving array as params to objects' action
				$result = call_user_func_array(array($controllerObject, $actionName), $parameters);

				if ($result !== null) {
					break;
				}
			}
		}
	}
}