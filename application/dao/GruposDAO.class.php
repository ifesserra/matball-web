<?php
require_once('Crud.class.php');
require_once('GruposUsuariosDAO.class.php');
require_once "$ROOT/application/Functions.php";

class GruposDAO extends Crud{
    public static $table = 'grupos';
    
    public static function getAllByUser($usuario_id){
        return parent::sqlFetchAll(
                "SELECT g.id AS grupo_id, g.nome AS grupo_nome, g.tipo AS grupo_tipo, ".
                "  g.administrador_id AS administrador_id, ".
                "  DATE_FORMAT(g.dthr_insert, '%Y-%m-%d') AS dt_criacao, ".
                "  DATE_FORMAT(gu.dthr_insert, '%Y-%m-%d') AS dt_entrada, ".
                "  m.usuario_id AS moderador_id, u.login AS administrador_login,".
                "  (SELECT COUNT(*) FROM grupos_usuarios AS _gu WHERE _gu.grupo_id = g.id) AS grupo_membros ".
                "FROM grupos_usuarios AS gu ".
                "INNER JOIN grupos AS g ".
                "  ON g.id = gu.grupo_id ".
                "INNER JOIN usuarios AS u ".
                "  ON g.administrador_id = u.id ".
                "LEFT JOIN moderadores AS m ".
                "  ON m.grupo_id = gu.grupo_id AND m.usuario_id = gu.usuario_id ".
                "WHERE gu.usuario_id = $usuario_id"
        );
    }
    
    public static function getAllVisible(){
        return parent::sqlFetchAll(
                "SELECT g.id AS grupo_id, g.nome AS grupo_nome, g.tipo AS grupo_tipo, ".
                "  g.administrador_id AS administrador_id, u.login AS administrador_login,".
                "  (SELECT COUNT(*) FROM grupos_usuarios AS _gu WHERE _gu.grupo_id = g.id) AS grupo_membros ".
                "FROM grupos AS g ".
                "INNER JOIN usuarios AS u ".
                "  ON g.administrador_id = u.id ".
                "WHERE g.tipo > 0"
        );
    }
    
    public static function isMember($grupo_id, $usuario_id){
        $gruposUsuarios = GruposUsuariosDAO::findById([
            'grupo_id' => $grupo_id,
            'usuario_id' => $usuario_id,
        ]);

        if(empty($gruposUsuarios)){
            return false;
        }
        
        return true;
    }
}
