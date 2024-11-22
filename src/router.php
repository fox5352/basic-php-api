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

        // Iterate over each route pattern
        foreach ($this->routes as $pattern => $controller) {
            // Replace placeholders {id}, {name}, etc., with regex to capture the values
            $regex = preg_replace_callback("#\{([a-zA-Z0-9_]+)\}#", function($matches) {
                // For each placeholder, replace with a regex capturing group (e.g., (.+) for any characters)
                return "([^/]+)"; // Capture any non-slash characters
            }, $pattern);

            // Ensure the regex starts and ends with anchors to match the entire URL path
            $regex = "#^" . $regex . "$#";

            // Check if the URL matches the pattern
            if (preg_match($regex, $url, $matches)) {
                // Extract the parameter names from the route pattern
                preg_match_all("#\{([a-zA-Z0-9_]+)\}#", $pattern, $param_names);

                // Remove the full match (the entire URL) from the match results
                array_shift($matches);

                // Map the parameters to the $this->params array
                foreach ($param_names[1] as $index => $param_name) {
                    // The parameter value is in the $matches array
                    $this->params[$param_name] = $matches[$index];
                }

                // Set the controller and pattern for this match
                $buffer = $controller;
                $pattern_buffer = $pattern;
            }
        }

        // Require the controller file
        require_once $buffer;

        // Instantiate the corresponding class and render the page
        if (isset($this->route_classes[$pattern_buffer]) && class_exists($this->route_classes[$pattern_buffer])) {
            $class_name = $this->route_classes[$pattern_buffer];
            $class = new $class_name($this->params);
            $class->render(); // Call the render method of the corresponding page class
        } else {
            throw new Exception("Page Class not valid: $buffer => $pattern_buffer");
        }
    }
}
?>
