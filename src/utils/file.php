<?php

function read_file(&$file_name) { 
    // Open the file for reading
    $fp = fopen($file_name, "r") or die("Unable to open file!");
    // Get the file size
    $file_size = filesize($file_name);
    // Read the contents of the file
    $data = fread($fp, $file_size);
    // Close the file
    fclose($fp);

    return $data;
}

?>