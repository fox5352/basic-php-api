<?php 
    // Initialize session variables for tracking requests if they don't exist
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
?>