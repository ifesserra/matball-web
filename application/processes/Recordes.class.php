<?php

include_once 'Controller.class.php';
require_once "$ROOT/application/dao/RecordesDAO.class.php";
require_once "$ROOT/application/Functions.php";

class Recordes extends Controller{
    
    public static function verifyAndUpdate($usuario_id, $pontos, $nivel, $dateTime){
        $recorde = RecordesDAO::findById( ['usuario_id' => $usuario_id] );

        if(!empty($recorde)){
            $newValues = [];

            if( $pontos > intval($recorde->pontos_max) ){
                $newValues['dthr_pontos_max'] = $dateTime;
                $newValues['pontos_max'] = $pontos;
            }

            if( $nivel > intval($recorde->nivel_max) ){
                $newValues['dthr_nivel_max'] = $dateTime;
                $newValues['nivel_max'] = $nivel;
            }

            if(count($newValues) > 0){
                RecordesDAO::update(
                    ['usuario_id' => $usuario_id], $newValues);
                
                return true;
            }

            return false;
        }
    }
}
