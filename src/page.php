<?php 
require_once "./utils/file.php";

abstract class Page extends FileManger {
    protected $params;  // Store router parameters

    public function __construct($params = []) {
        $this->params = $params;
    }

    abstract public function render();
}

?>