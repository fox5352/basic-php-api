<?php
    include_once "./utils/file.php";

    session_start();
    // TODO: add a req tracker to the session data to allow only 15requests min
    include './middleware.php'; 

    $routes = [
        "/" => "./pages/home/index.php",
        "/products" => "./pages/products/index.php",
        "/products/{id}" => "./pages/products/[id]/index.php",
        "*" => "./pages/404/index.php",
    ];

    include("./router.php");

   include $matchedRoute
?>