<?php

class Router {
    protected $params;
    protected $routes;
    protected $route_classes;
    public function __construct($routes, $route_classes) {
        $this->params = []; 
        $this->routes = $routes;
        $this->route_classes = $route_classes;
    }

    public function get_param($str) {
        return $this->route($str);
    }

    public function route() {
        $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $buffer = $this->routes['NotFound'];
        $pattern_buffer = "NotFound";

        foreach ($this->routes as $pattern => $controller){
            //replace placeholders {**} with regex patterns
            $regex = str_replace(["{id}"], ['([^/]+)'], $pattern);
            
            $regex = "#^" . $regex. "$#";

            // check of current route matches the pattern
            if (preg_match($regex, $url, $matches)) {
                // Extract parameters from the matched route
                preg_match_all("#\{([a-zA-Z0-9_]+)\}#", $pattern, $param_names);
                array_shift($matches);  // Remove the full match (at index 0)
                // Store the parameters in the $params array
                foreach ($param_names[1] as $index => $param_name) {
                    $this->params[$param_name] = $matches[$index];
                }

                $buffer = $controller;
                $pattern_buffer = $pattern;
            }
        }

        require_once $buffer;

        if (isset($this->route_classes[$pattern_buffer]) && class_exists($this->route_classes[$pattern_buffer])) {
            $class_name = $this->route_classes[$pattern_buffer];
            $class = new $class_name($this->params);
            $class->render();  // Call the render method of the corresponding page class
        }else {
            $str = "Page Class not valid :". $buffer . "=>". $pattern_buffer;
            return throw new Exception($str, 1);
        }
    }
}
?>
