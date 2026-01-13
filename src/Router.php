<?php
namespace App;

class Router {
    protected $routes = [];

    public function get($uri, $controller) {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller) {
        $this->routes['POST'][$uri] = $controller;
    }

    public function dispatch() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if ($uri !== '/') {
            $uri = rtrim($uri, '/');
        }
        // Remove trailing slash if necessary or handle subdirectories
        // For simple local dev 'php -S', URI might be '/' or '/index.php'
        
        $method = $_SERVER['REQUEST_METHOD'];

        if (array_key_exists($uri, $this->routes[$method])) {
            $controllerAction = $this->routes[$method][$uri];
            $this->callAction(...explode('@', $controllerAction));
        } else {
            // Check for default '/' if uri is empty or index.php
            if (($uri === '/' || $uri === '/index.php') && isset($this->routes[$method]['/'])) {
                $controllerAction = $this->routes[$method]['/'];
                $this->callAction(...explode('@', $controllerAction));
                return;
            }
            
            http_response_code(404);
            echo "404 Not Found";
        }
    }

    protected function callAction($controller, $action) {
        $controller = "App\\Controllers\\{$controller}";
        $controllerInstance = new $controller;
        
        if (!method_exists($controllerInstance, $action)) {
            throw new \Exception("{$controller} does not respond to the {$action} action.");
        }

        $controllerInstance->$action();
    }
}
