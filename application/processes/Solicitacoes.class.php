<?php

include_once 'Controller.class.php';
require_once "$ROOT/application/dao/SolicitacoesDAO.class.php";
require_once "$ROOT/application/dao/GruposUsuariosDAO.class.php";
require_once "$ROOT/application/dao/GruposDAO.class.php";

class Solicitacoes extends Controller{
    function __construct() {
        parent::__construct();
    }
    
    public function listByUser($object) {
        $this->object = SolicitacoesDAO::getAllByUser($object->usuario_id);
    }
    
    public function delete($object) {
        try{
            if(SolicitacoesDAO::delete([
                'grupo_id' => $object->grupo_id,
                'usuario_id' => $object->usuario_id]) == 0){
                throw new Exception("Não foi possível excluir a Solicitação!");
            }

            $this->cdMessage = Controller::MESSAGE_SUCCESS;
            $this->message = "Solicitação excluída com sucesso!";
            
        } catch (Exception $e){
            $this->cdMessage = Controller::MESSAGE_DANGER;
            $this->message = $e->getMessage();
        }
    }
    
    public function insert($object) {
        try{            
            if(GruposDAO::isMember($object->grupo_id, $object->usuario_id)){
                throw new Exception("Você já é membro desse grupo!");
            }
            
            SolicitacoesDAO::insert([
                'grupo_id' => $object->grupo_id,
                'usuario_id' => $object->usuario_id,
                Functions::sqlCurrentTimeStamp()
            ]);

            $this->cdMessage = Controller::MESSAGE_SUCCESS;
            $this->message = "Solicitação enviada com sucesso!";
            
        } catch (Exception $ex){
            $this->cdMessage = Controller::MESSAGE_DANGER;
            if($ex->getCode() == 23000){
                if(strpos($ex->getMessage(), 'constraint violation')){
                    $this->message = "Você já solicitou entrada nesse grupo!";
                }
            }
            else{
                $this->message = $ex->getMessage();
            }
        }
    }
    
    public function listByGroup($object) {
        $this->object = SolicitacoesDAO::getAllByGroup($object->grupo_id);
    }
    
    public function reject($object) {
        try{
            if(SolicitacoesDAO::delete([
                'grupo_id' => $object->grupo_id,
                'usuario_id' => $object->usuario_id]) == 0){
                throw new Exception("ERRO: Não foi possível rejeitar a solicitação!");
            }

            $this->cdMessage = Controller::MESSAGE_SUCCESS;
            $this->message = "Solicitação rejeitada.";
            $this->object['link'] = "view-grupo.php?id=$object->grupo_id";
            
        } catch (Exception $e){
            $this->cdMessage = Controller::MESSAGE_DANGER;
            $this->message = $e->getMessage();
        }
    }
    
    public function accept($object) {
        try{
            if(!GruposDAO::isMember($object->grupo_id, $object->usuario_id)){
                if(!DB::beginTransaction()){
                    throw new Exception ("ERRO ao aceitar a solicitação!");
                }
                
                GruposUsuariosDAO::insert([
                    'grupo_id' => $object->grupo_id,
                    'usuario_id' => $object->usuario_id,
                    Functions::sqlCurrentTimeStamp()
                ]);
            }
            
            if(SolicitacoesDAO::delete([
                'grupo_id' => $object->grupo_id,
                'usuario_id' => $object->usuario_id]) == 0){
                throw new Exception("ERRO: Não foi possível excluir a solicitação!");
            }
            
            if(DB::inTransaction() && !DB::commit()){
                throw new Exception ("ERRO ao aceitar a solicitação!");
            }

            $this->cdMessage = Controller::MESSAGE_SUCCESS;
            $this->message = "A solicitação foi aceita.";
            $this->object['link'] = "view-grupo.php?id=$object->grupo_id";
            
        } catch (Exception $e){
            $this->cdMessage = Controller::MESSAGE_DANGER;
            $this->message = $e->getMessage();
            
            if(DB::inTransaction()){
                DB::rollBack();
            }
        }
    }
}
