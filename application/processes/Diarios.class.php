<?php

include_once 'Controller.class.php';
require_once "$ROOT/application/dao/DiariosDAO.class.php";
require_once "$ROOT/application/dao/UsuariosDAO.class.php";
require_once "$ROOT/application/processes/Recordes.class.php";
require_once "$ROOT/application/Functions.php";

class Diarios extends Controller{
    
    public function listByUser($object) {
        $this->object = DiariosDAO::getAllByUser($object->usuario_id);
    }

    public function update($object) {
        $usuario = UsuariosDAO::findByIdPass($object->usuario_id, $object->hash_pass);
        if(empty($usuario)){
            $this->cdMessage = Controller::MESSAGE_DANGER;
            $this->message = "Usuário ou senha inválido.";
            return false;
        }

        $diario = [ 'usuario_id' => $object->usuario_id, 'dt_diario' => $object->data, 
            'nivel_max' => $object->nivel_max, 'pontos_max' => $object->pontos_max,
            'acertos_adicao' => $object->acertos_adicao, 'acertos_subtracao' => $object->acertos_subtracao, 
            'acertos_multiplicacao' => $object->acertos_multiplicacao, 'acertos_divisao' => $object->acertos_divisao,
            'erros_adicao' => $object->erros_adicao, 'erros_subtracao' => $object->erros_subtracao, 
            'erros_multiplicacao' => $object->erros_multiplicacao, 'erros_divisao' => $object->erros_divisao,
            'qtd_jogos' => 1, 'tempo_total' => gmdate('H:i:s', $object->tempo), 'hr_ultimo_jogo' => $object->hora ];

        try{
            DiariosDAO::insert($diario);
        }
        catch (Exception $e){
            // Já inseriu diário hoje. Obtém o registro atual para atualizar
            $diario_bd = DiariosDAO::findById( array_slice($diario, 0, 2, true) );
            
            $diario['nivel_max'] = max( $diario['nivel_max'], intval($diario_bd->nivel_max) );
            $diario['pontos_max'] = max( $diario['pontos_max'], intval($diario_bd->pontos_max) );
            $diario['acertos_adicao'] += intval($diario_bd->acertos_adicao);
            $diario['acertos_subtracao'] += intval($diario_bd->acertos_subtracao);
            $diario['acertos_multiplicacao'] += intval($diario_bd->acertos_multiplicacao);
            $diario['acertos_divisao'] += intval($diario_bd->acertos_divisao);
            $diario['erros_adicao'] += intval($diario_bd->erros_adicao);
            $diario['erros_subtracao'] += intval($diario_bd->erros_subtracao);
            $diario['erros_multiplicacao'] += intval($diario_bd->erros_multiplicacao);
            $diario['erros_divisao'] += intval($diario_bd->erros_divisao);

            $diario['qtd_jogos'] = intval($diario_bd->qtd_jogos) + 1;
            $diario['tempo_total'] = Functions::sumSecondsInSqlTime( $diario_bd->tempo_total, $object->tempo );

            $arrayPkValue = array_slice($diario, 0, 2, true);
            unset( $diario['usuario_id'], $diario['dt_diario'] );

            DiariosDAO::update( $arrayPkValue, $diario );
        }

        $isRecord = Recordes::verifyAndUpdate(
            $object->usuario_id, $object->pontos_max, $object->nivel_max,
            $object->data . ' ' . $object->hora);

        $this->object['recorde'] = $isRecord;
    }
}
