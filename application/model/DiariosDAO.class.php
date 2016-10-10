<?php
require_once('Crud.class.php');
require_once "$ROOT/application/Functions.php";

class DiariosDAO extends Crud{
    public static $table = 'diarios';
    
    public static function getAllByUser($usuario_id){
        return parent::findByColumns(['usuario_id' => $usuario_id]);
    }
}
