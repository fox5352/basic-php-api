<?php 


class ProductId extends Page {
    public function render() {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $file_name = __DIR__."/products.json";
            
            $file_data = $this->read_file($file_name);
            $products = json_decode($file_data, true)['products'];
            $found_product = "product not found";
        
            $id = $this->params['id'];

            foreach ($products as $product) {
                if ($product['id'] == $id) {
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
            http_response_code(200); 
            echo json_encode($data);
        }else {
            $data = [
                "status"=> "error",
                "message"=> "Invalid request method. Only GET is allowed."
            ];
            header('Content-Type: application/json');
            http_response_code(400); 
            echo json_encode($data);
        }
        
    }
}


?>