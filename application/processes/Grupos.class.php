<?php

include_once 'Controller.class.php';
require_once "$ROOT/application/dao/GruposDAO.class.php";
require_once "$ROOT/application/dao/GruposUsuariosDAO.class.php";

class Grupos extends Controller{
    function __construct() {
        parent::__construct();
    }
    
    public function insert($object) {
        try {
            if(!DB::beginTransaction()){
                throw new Exception ("ERRO ao iniciar o cadastro");
            }
            
            $id = GruposDAO::insert([
                NULL, $object->id, $object->nome, $object->tipo, Functions::sqlCurrentTimeStamp()]);

            if(empty($id)){
                throw new Exception("ERRO ao realizar o cadastro");
            }
            
            if(GruposUsuariosDAO::insert([$id, $object->id, Functions::sqlCurrentTimeStamp()], false) == null){
                throw new Exception("ERRO ao realizar o cadastro");
            }
            
            if(!DB::commit()){
                throw new Exception ("Erro ao efetivar o cadastro.");
            }

            $this->cdMessage = Controller::MESSAGE_SUCCESS;
            $this->message = "Seu grupo foi criado com sucesso!";
            $this->object['link'] = 'list-grupos.php';

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
}
