<?php
$data = [
    "status" => "success",
    "message" => "Data processed successfully",
    "routes" => [
        "products" => [
            "desc"=> "route has a list of products",
            "methods"=> ["GET"],
            "status" => "working"
        ],
        "products/id"=> [
            "desc"=> "route has a single product",
            "methods"=> ["GET"],
            "status" => "working"
        ],
        "featuredProducts" => [
            "desc"=> "route has a list of featured products",
            "methods"=> ["GET"],
            "status" => "out of order"
        ],
        "orders" => [
            "desc"=> "route has a list of orders",
            "methods"=> ["GET"],
            "status" => "out of order"
        ],
        "orders/id"=> [
            "desc"=> "route has a single order",
            "methods"=> ["GET"],
            "status" => "out of order"
        ],
        "users" => [
            "desc"=> "route has a list of users",
            "methods"=> ["GET"],
            "status" => "out"
        ],
    ]
    ];

header('Content-Type: application/json');

echo json_encode($data);
?>