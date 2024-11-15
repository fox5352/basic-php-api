<?php 
$file_name = __DIR__ . "/products.json";  // Use __DIR__ to get the current directory path

$file_data = read_file($file_name);
$products = json_decode($file_data, true)['products'];

$data = [
    "statue"=> "success",
    "message"=> "Products retrieved successfully",
    "products"=> $products,
    "total_products"=> count($products)  // Count the number of products in the array
];

header('Content-Type: application/json');

echo json_encode($data);
?>
