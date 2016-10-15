<?php
require_once('Crud.class.php');
require_once "$ROOT/application/Functions.php";

class LocaisDAO extends Crud{
    public static $table = 'locais';
    
    public static function getIdByColumns($pais, $estado, $cidade){
        $r = parent::findByColumns(['pais' => $pais, 'estado' => $estado, 'cidade' => $cidade]);
        if(!empty($r)){
            return $r[0];
        }
        
        return null;
    }
}
