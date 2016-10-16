<?php
require_once('Crud.class.php');
require_once "$ROOT/application/Functions.php";

class SolicitacoesDAO extends Crud{
    public static $table = 'solicitacoes';
    
    public static function getAllByUser($usuario_id){
        return parent::sqlFetchAll(
                "SELECT s.grupo_id AS grupo_id, g.nome AS grupo_nome, ".
                "  g.tipo AS grupo_tipo, u.nome AS administrador_nome, ".
                "  DATE_FORMAT(dthr_solicitacao, '%Y-%m-%d') AS dt_solicitacao ".
                "FROM solicitacoes as s ".
                "INNER JOIN grupos AS g ".
                "  ON g.id = s.grupo_id ".
                "INNER JOIN usuarios AS u ".
                "  ON u.id = g.administrador_id ".
                "WHERE s.usuario_id = $usuario_id"
        );
    }
}
