<?php

include_once 'Controller.class.php';
include_once 'RestrictedSession.class.php';

require_once "$ROOT/application/model/UsuariosDAO.class.php";
require_once "$ROOT/application/model/LocaisDAO.class.php";
require_once "$ROOT/application/model/RecordesDAO.class.php";

class Usuarios extends Controller{
    function __construct() {
        parent::__construct();
    }
    
    public function process($operation, $object) {
        switch ($operation){
            case 'login':
                if(RestrictedSession::login($object->user, $object->password)){
                    $this->object['link'] = 'application/view/home-usuario.php';
                }
                else {
                    $this->cdMessage = Controller::MESSAGE_DANGER;
                    $this->message = "Dados inválidos.";
                }
                
                break;
                
            case 'logout':
                if(RestrictedSession::isLogged()){
                    RestrictedSession::logout();
                    $this->object['link'] = '../../index.php';
                }
                
                break;
                
            case 'insert':
                try {
                    if(!DB::beginTransaction()){
                        throw new Exception ("ERRO ao iniciar o cadastro", 1);
                    }
                
                    $local = LocaisDAO::getIdByColumns($object->pais, $object->estado, $object->cidade);
                    
                    if(empty($local)){
                        $local_id = LocaisDAO::insert([
                            null, $object->pais, $object->estado, $object->cidade
                        ]);
                        
                        if(empty($local_id)){
                            throw new Exception("ERRO ao cadastrar endereço", 1);
                        }
                    }
                    else{
                        $local_id = $local->id;
                    }
                
                    $id = UsuariosDAO::insert([
                        NULL, $object->nome, $object->email, $object->login, sha1($object->senha),
                        Functions::date2sqlDate($object->dt_nascimento), '', $local_id,
                        $object->escola, $object->tipo_escola, Functions::sqlCurrentTimeStamp()]);
                    
                    if(empty($id) || RecordesDAO::insert([$id, 0, 0, 0, 0]) == NULL){
                        throw new Exception("ERRO ao realizar o cadastro", 1);
                    }
                    
                    UsuariosDAO::insertFoto($id, $object->base64Img);

                    $this->cdMessage = Controller::MESSAGE_SUCCESS;
                    $this->message = "Seu cadastro foi realizado com sucesso, realize login!";
                    $this->object['link'] = '../../index.php';
                    
                    if(!DB::commit()){
                        throw new Exception ("Erro ao efetivar o cadastro.", 0);
                    }
                    
                } catch (Exception $ex) {
                    $this->cdMessage = Controller::MESSAGE_DANGER;
                    if($ex->getCode() == 23000){
                        if(strpos($ex->getMessage(), 'email')){
                            $this->message = "Já existe uma conta para esse email.";
                        }
                        else if(strpos($ex->getMessage(), 'login')){
                            $this->message = "Esse Login não está disponível.";
                        }
                    }
                    else{
                        $this->message = $ex->getMessage();
                    }
                    
                    if(DB::inTransaction()){
                        DB::rollBack();
                    }
                }
                
                break;
            
            default:
                $this->cdMessage = Controller::MESSAGE_DANGER;
                $this->message = "Serviço inválido.";
        }
    }
}
