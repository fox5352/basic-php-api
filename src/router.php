<?php
$route = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$params = [];

function url_matcher($url, $routes){
    global $params;  // Make $params available in this scope

    foreach ($routes as $pattern => $result) {
        // Replace placeholders `{id}` with regex patterns
        $regex = str_replace(['{id}'], ['([^/]+)'], $pattern);

        // Add delimiters and ensure exact match from start to end
        $regex = "#^" . $regex . "$#";

        // Check if the current route matches the pattern
        if (preg_match($regex, $url, $matches)) {
            // Extract parameters from the matched route
            preg_match_all("#\{([a-zA-Z0-9_]+)\}#", $pattern, $param_names);
            array_shift($matches);  // Remove the full match (at index 0)

            // Store the parameters in the $params array
            foreach ($param_names[1] as $index => $param_name) {
                $params[$param_name] = $matches[$index];
            }

            return $result;
        }
    }

    return $routes['*']; // No matching route found
}

$matchedRoute = url_matcher($route, $routes);
?>