<?php
require_once('Crud.class.php');
require_once "$ROOT/application/Functions.php";

class RecordesDAO extends Crud{
    public static $table = 'recordes';
    
    public static function getRanking($usuario_id = null){
        $sql = "SELECT r.usuario_id, u.login, r.posicao, ".
                     "(SELECT COUNT(*) FROM recordes) AS total, ".
                     "DATE_FORMAT(r.dthr_pontos_max, '%H:%i - %d/%m/%Y') AS dthr_pontos_max, r.pontos_max, ".
                     "DATE_FORMAT(r.dthr_nivel_max, '%H:%i - %d/%m/%Y') AS dthr_nivel_max, r.nivel_max ".
               "FROM (SELECT usuario_id, @rownum := @rownum + 1 AS posicao, ".
                     "dthr_pontos_max, pontos_max, dthr_nivel_max, nivel_max ".
                     "FROM recordes JOIN (SELECT @rownum := 0) AS rownum ".
                     "ORDER BY pontos_max desc, nivel_max desc) AS r ".
               "INNER JOIN usuarios AS u ON r.usuario_id = u.id";
        
        if($usuario_id != null){
            $sql .= " WHERE r.usuario_id = $usuario_id";
            return parent::sqlFetch($sql);
        }
        
        return parent::sqlFetchAll($sql);
    }
}
