<?php

include_once 'Controller.class.php';
require_once "$ROOT/application/dao/ConvitesDAO.class.php";
require_once "$ROOT/application/dao/GruposUsuariosDAO.class.php";
require_once "$ROOT/application/dao/GruposDAO.class.php";

class ConvitesException extends Exception {}

class Convites extends Controller{
    
    public function listByUser($object) {
        $this->object = ConvitesDAO::getAllByUser($object->usuario_id);
    }
    
    public function reject($object) {
        try{
            ConvitesDAO::delete([
                'grupo_id' => $object->grupo_id,
                'usuario_id' => $object->usuario_id ]);

            $this->cdMessage = Controller::MESSAGE_SUCCESS_EMPTY;
            
        } catch (Exception $e){
            $this->cdMessage = Controller::MESSAGE_DANGER;
            $this->message = $e->getMessage();
        }
    }
    
    public function accept($object) {
        try{
            if(!GruposDAO::isMember($object->grupo_id, $object->usuario_id)){
                DB::beginTransaction();
                
                GruposUsuariosDAO::insert([
                    'grupo_id' => $object->grupo_id,
                    'usuario_id' => $object->usuario_id,
                    Functions::sqlCurrentTimeStamp()
                ]);
            }
            
            ConvitesDAO::delete([
                'grupo_id' => $object->grupo_id,
                'usuario_id' => $object->usuario_id ]);
            
            if(DB::inTransaction()){
                DB::commit();
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
    
    public function insert($object) {
        try{
            if(GruposDAO::isMember($object->grupo_id, $object->usuario_id)){
                throw new ConvitesException("Esse usuário já é membro do grupo!");
            }
            
            ConvitesDAO::insert([
                'grupo_id' => $object->grupo_id,
                'usuario_id' => $object->usuario_id,
                Functions::sqlCurrentTimeStamp()
            ]);

            $this->cdMessage = Controller::MESSAGE_SUCCESS;
            $this->message = "Convite enviado com sucesso!";
            $this->object['link'] = "view-grupo.php?id=$object->grupo_id";
            
        } catch (Exception $ex){
            $this->cdMessage = Controller::MESSAGE_DANGER;

            if($ex->getCode() == 23000){
                if(strpos($ex->getMessage(), 'constraint violation')){
                    $this->message = "Já existe um convite para esse usuário!";
                }
            }
            else{
                $this->message = $ex->getMessage();
            }
        }
    }
}
