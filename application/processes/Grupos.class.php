<?php

include_once 'Controller.class.php';
require_once "$ROOT/application/dao/GruposDAO.class.php";
require_once "$ROOT/application/dao/GruposUsuariosDAO.class.php";

class Grupos extends Controller{
    
    public function insert($object) {
        try {
            DB::beginTransaction();
            
            $id = GruposDAO::insert([
                NULL, $object->id, $object->nome, $object->tipo, Functions::sqlCurrentTimeStamp() ]);
            
            GruposUsuariosDAO::insert([
                $id, $object->id, Functions::sqlCurrentTimeStamp()], false );
            
            DB::commit();

            $this->cdMessage = Controller::MESSAGE_SUCCESS;
            $this->message = "Seu grupo foi criado com sucesso!";
            $this->object['link'] = "view-grupo.php?id=$id";

        } catch (Exception $ex) {
            $this->cdMessage = Controller::MESSAGE_DANGER;
            if($ex->getCode() == 23000){
                if(strpos($ex->getMessage(), 'nome')){
                    $this->message = "Já existe um grupo com esse nome.";
                }
            }
            else{
                $this->message = $ex->getMessage();
            }

            if(DB::inTransaction()){
                DB::rollBack();
            }
        }
    }
    
    public function listByUser($object) {
        $this->object = GruposDAO::getAllByUser($object->usuario_id);
    }
    
    public function listAllVisible($object) {
        $this->object = GruposDAO::getAllVisible();
    }
    
    public function addMember($object) {
        try{
            GruposUsuariosDAO::insert([
                'grupo_id' => $object->grupo_id,
                'usuario_id' => $object->usuario_id,
                Functions::sqlCurrentTimeStamp()
            ]);

            $this->cdMessage = Controller::MESSAGE_SUCCESS;
            $this->message = "Agora você é membro desse grupo!";
            
        } catch (Exception $ex){
            $this->cdMessage = Controller::MESSAGE_DANGER;
            if($ex->getCode() == 23000){
                if(strpos($ex->getMessage(), 'constraint violation')){
                    $this->message = "Você já é membro desse grupo!";
                }
            }
            else{
                $this->message = $ex->getMessage();
            }
        }
    }

    public function listUsersOfGroup($object) {
        $this->object = GruposDAO::getUsersOfGroup($object->grupo_id);
    }
}
