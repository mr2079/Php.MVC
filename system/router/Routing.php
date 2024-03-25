<?php

namespace System\Router;

use ReflectionMethod;

class Routing {
    private $current_route;
    private $method_field;
    private $routes;
    private $values = [];

    public function __construct() {
        $this->current_route = explode('/', CURRENT_ROUTE);
        $this->method_field = $this->methodField();
        global $routes;
        $this->routes = $routes;
    }

    public function run() {
        $matchResult = $this->match();

        if (empty($matchResult)) {
            $this->notFound();
        }

        $controllerPath = str_replace('\\', '/', $matchResult['controller']);
        $path = BASE_DIR . '/app/http/controllers/' . $controllerPath . '.php';
        if (!file_exists($path)) {
            $this->notFound();
        }

        $controller = "\App\Http\Controllers\\" . $matchResult['controller'];
        $object = new $controller();
        if (!method_exists($object, $matchResult['action'])) {
            $this->notFound();
        }
        $reflection = new ReflectionMethod($controller, $matchResult['action']);
        $paramsCount = $reflection->getNumberOfParameters();
        if ($paramsCount > count($this->values)) {
            $this->notFound();
        }

        call_user_func_array(array($object, $matchResult['action']), $this->values);
    }

    public function match() {
        $reservedRoutes = $this->routes[$this->method_field];

        foreach ($reservedRoutes as $route) {
            if ($this->compare(($route["url"]))) {
                return ["controller" => $route["controller"], "action" => $route["action"]];
            }
            $this->values = [];
        }

        return [];
    }

    private function compare($reservedRoutePath) : bool {
        if (trim($reservedRoutePath, '/') === '') {
            return trim($this->current_route[0],'/') === '' ? true : false;
        }

        $reservedRoutePathArray = explode('/', $reservedRoutePath);
        if (sizeof($reservedRoutePathArray) != sizeof($this->current_route)) {
            return false;
        }

        foreach ($this->current_route as $index => $currentRouteElement) {
            $reservedRoutePathElement = $reservedRoutePath[$index];

            if ($reservedRoutePathElement != $currentRouteElement) {
                return false;
            }

            if (substr($reservedRoutePathElement, 0, 1) == "{"
                && substr($reservedRoutePathElement, -1) == "}") {
                    array_push($this->values, $currentRouteElement);
                }
        }

        return true;
    }

    public function notFound() {
        http_response_code(404);
        include __DIR__ . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR .'404.php';
    }

    public function methodField() {
        $method_field = strtolower($_SERVER['REQUEST_METHOD']);

        if ($method_field == 'post') {
            if (isset($_POST['_method'])) {
                if ($_POST['_method'] == 'put') {
                    $method_field = 'put';
                } else if ($_POST['_method'] == 'delete') {
                    $method_field = 'delete';
                }
            }
        }

        return $method_field;
    }
}