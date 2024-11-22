<?php 

class NotFound extends Page {
    public function render() {
        $data = [
            "status"=> "error",
            "message"=> "Page not found"
        ];
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
?>