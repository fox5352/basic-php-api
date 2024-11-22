<?php
require_once "router.php";
require_once "./page.php";

$routes = [
    "/" => "./pages/home/index.php",
    "/products" => "./pages/products/index.php",
    "/products/{id}" => "./pages/products/[id]/index.php",
    "NotFound" => "./pages/404/index.php"
];

$route_classes = [
    "/" => "HomePage",
    "/products" => "ProductsPage",
    "/products/{id}" => "ProductId",
    "NotFound" => "NotFound", 
];

class Server extends Router {
    public function __construct($routes, $route_classes) {
        parent::__construct($routes, $route_classes);
    }

    function middleware() {
        if (!isset($_SESSION['reqCount'])) {
            $_SESSION['reqCount'] = 0;
        }
        if (!isset($_SESSION['lastRequestTime'])) {
            $_SESSION['lastRequestTime'] = time();
        }
    
        // Check if a minute has passed since the last request
        if (time() - $_SESSION['lastRequestTime'] >= 60) {
            // Reset the counter if a minute has passed
            $_SESSION['reqCount'] = 0;
            $_SESSION['lastRequestTime'] = time();
        }
    
        // If more than 15 requests have been made in the last minute, block the request
        if ($_SESSION['reqCount'] >= 15) {
    
            // die();
            // Alternatively, you can return an error response to the client
            $data = [
                "status"=> "error",
                "message"=> "Too many requests. Please try again in a minute."
            ];
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        }
    }

    public function run() {
        session_start();
        $this->middleware();
        $this->route();
    }
}

$server = new Server($routes, $route_classes);
$server->run();;
?>
