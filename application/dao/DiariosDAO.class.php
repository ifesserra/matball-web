<?php
require_once('Crud.class.php');
require_once "$ROOT/application/Functions.php";

class DiariosDAO extends Crud{
    public static $table = 'diarios';
    
    public static function getAllByUser($usuario_id){
        return parent::findByColumns(['usuario_id' => $usuario_id]);
    }
    
    public static function getLastByUser($usuario_id){
        return parent::sqlFetch(
            "SELECT * FROM diarios ".
            "WHERE usuario_id = $usuario_id AND dt_diario = CURRENT_DATE()"
        );
    }
    
    public static function getRankingToday($usuario_id = null){
        $sql = "SELECT r.usuario_id, u.login, r.posicao, ".
                     "r.pontos_max, r.nivel_max, r.qtd_jogos, r.tempo_total, r.hr_ultimo_jogo, ".
                     "r.acertos_adicao, r.acertos_subtracao, r.acertos_multiplicacao, r.acertos_divisao, ".
                     "r.erros_adicao, r.erros_subtracao, r.erros_multiplicacao, r.erros_divisao ".
               "FROM (SELECT usuario_id, @rownum := @rownum + 1 AS posicao, ".
                     "pontos_max, nivel_max, qtd_jogos, tempo_total, hr_ultimo_jogo, ".
                     "acertos_adicao, acertos_subtracao, acertos_multiplicacao, acertos_divisao, ".
                     "erros_adicao, erros_subtracao, erros_multiplicacao, erros_divisao ".
                     "FROM diarios JOIN (SELECT @rownum := 0) AS rownum ".
                     "WHERE dt_diario = CURRENT_DATE() ".
                     "ORDER BY pontos_max desc, nivel_max desc) AS r ".
               "INNER JOIN usuarios AS u ON r.usuario_id = u.id";
        
        if($usuario_id != null){
            $sql .= " WHERE r.usuario_id = $usuario_id";
            return parent::sqlFetch($sql);
        }
        
        return parent::sqlFetchAll($sql);
    }
}
