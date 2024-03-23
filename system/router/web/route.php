<?php

namespace System\Router\Web;

class Route {
    public static function get($url, $method, $name = null) {
        $method = explode('@', $method);
        $controller = $method[0];
        $action = $method[1];
        global $routes;
        array_push($routes['get'], 
            array(
                'url' => trim($url, '/ '),
                'controller' => $controller,
                'action' => $action,
                'name' => $name));
    }

    public static function post($url, $method, $name = null) {
        $method = explode('@', $method);
        $controller = $method[0];
        $action = $method[1];
        global $routes;
        array_push($routes['post'], 
            array(
                'url' => trim($url, '/ '),
                'controller' => $controller,
                'action' => $action,
                'name' => $name));
    }

    public static function put($url, $method, $name = null) {
        $method = explode('@', $method);
        $controller = $method[0];
        $action = $method[1];
        global $routes;
        array_push($routes['put'], 
            array(
                'url' => trim($url, '/ '),
                'controller' => $controller,
                'action' => $action,
                'name' => $name));
    }

    public static function delete($url, $method, $name = null) {
        $method = explode('@', $method);
        $controller = $method[0];
        $action = $method[1];
        global $routes;
        array_push($routes['delete'], 
            array(
                'url' => trim($url, '/ '),
                'controller' => $controller,
                'action' => $action,
                'name' => $name));
    }
}