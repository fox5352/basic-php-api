<?php 

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $file_name = __DIR__."/products.json";
    
    $file_data = read_file($file_name);
    $products = json_decode($file_data, true)['products'];
    $found_product = "product not found";

    foreach ($products as $product) {
        if ($product['id'] == $params['id']) {
            $found_product = $product;
            break;
        }
    }

    $data = [
        "statue"=> "success",
        "message"=> "Product retrieved successfully",
        "product"=> $found_product
    ];

    header('Content-Type: application/json');

    echo json_encode($data);
}else {
    $data = [
        "status"=> "error",
        "message"=> "Invalid request method. Only GET is allowed."
    ];
    header('Content-Type: application/json');
    echo json_encode($data);
}

?>