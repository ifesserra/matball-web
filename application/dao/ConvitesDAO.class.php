<?php
require_once('Crud.class.php');
require_once "$ROOT/application/Functions.php";

class ConvitesDAO extends Crud{
    public static $table = 'convites';
    
    public static function getAllByUser($usuario_id){
        return parent::sqlFetchAll(
                "SELECT c.grupo_id AS grupo_id, g.nome AS grupo_nome, ".
                "  g.tipo AS grupo_tipo, u.login AS administrador_login, ".
                "  DATE_FORMAT(dthr_convite, '%Y-%m-%d') AS dt_convite ".
                "FROM convites as c ".
                "INNER JOIN grupos AS g ".
                "  ON g.id = c.grupo_id ".
                "INNER JOIN usuarios AS u ".
                "  ON u.id = g.administrador_id ".
                "WHERE c.usuario_id = $usuario_id"
        );
    }
}
