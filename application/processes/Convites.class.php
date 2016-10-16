<?php

include_once 'Controller.class.php';
require_once "$ROOT/application/dao/ConvitesDAO.class.php";
require_once "$ROOT/application/dao/GruposUsuariosDAO.class.php";
require_once "$ROOT/application/dao/GruposDAO.class.php";

class Convites extends Controller{
    function __construct() {
        parent::__construct();
    }
    
    public function listByUser($object) {
        $this->object = ConvitesDAO::getAllByUser($object->usuario_id);
    }
    
    public function reject($object) {
        try{
            if(ConvitesDAO::delete([
                'grupo_id' => $object->grupo_id,
                'usuario_id' => $object->usuario_id]) == 0){
                throw new Exception("ERRO: Não foi possível rejeitar o convite!");
            }

            $this->cdMessage = Controller::MESSAGE_SUCCESS_EMPTY;
            
        } catch (Exception $e){
            $this->cdMessage = Controller::MESSAGE_DANGER;
            $this->message = $e->getMessage();
        }
    }
    
    public function accept($object) {
        try{
            if(!GruposDAO::isMember($object->grupo_id, $object->usuario_id)){
                if(!DB::beginTransaction()){
                    throw new Exception ("ERRO ao entrar no grupo!");
                }
                
                GruposUsuariosDAO::insert([
                    'grupo_id' => $object->grupo_id,
                    'usuario_id' => $object->usuario_id,
                    Functions::sqlCurrentTimeStamp()
                ]);
            }
            
            if(ConvitesDAO::delete([
                'grupo_id' => $object->grupo_id,
                'usuario_id' => $object->usuario_id]) == 0){
                throw new Exception("ERRO: Não foi possível excluir o convite!");
            }
            
            if(DB::inTransaction() && !DB::commit()){
                throw new Exception ("ERRO ao entrar no grupo!");
            }

            $this->cdMessage = Controller::MESSAGE_SUCCESS;
            $this->message = "Agora você é membro desse grupo!";
            
        } catch (Exception $e){
            $this->cdMessage = Controller::MESSAGE_DANGER;
            $this->message = $e->getMessage();
            
            if(DB::inTransaction()){
                DB::rollBack();
            }
        }
    }
}
