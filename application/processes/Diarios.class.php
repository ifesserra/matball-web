<?php

include_once 'Controller.class.php';
require_once "$ROOT/application/dao/DiariosDAO.class.php";

class Diarios extends Controller{
    function __construct() {
        parent::__construct();
    }
    
    public function listByUser($object) {
        $this->object = DiariosDAO::getAllByUser($object->usuario_id);
    }
}
