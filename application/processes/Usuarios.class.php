<?php

include_once 'Controller.class.php';
include_once 'RestrictedSession.class.php';

require_once "$ROOT/application/dao/UsuariosDAO.class.php";
require_once "$ROOT/application/dao/LocaisDAO.class.php";
require_once "$ROOT/application/dao/RecordesDAO.class.php";

class Usuarios extends Controller{
    function __construct() {
        parent::__construct();
    }
    
    public function login($object) {
        if(RestrictedSession::login($object->user, $object->password)){
            $this->object['link'] = 'application/view/home-usuario.php';
        }
        else {
            $this->cdMessage = Controller::MESSAGE_DANGER;
            $this->message = "Dados inválidos.";
        }
    }
    
    public function logout($object) {
        if(RestrictedSession::isLogged()){
            RestrictedSession::logout();
            $this->object['link'] = '../../index.php';
        }
    }
    
    public function insert($object) {
        try {
            if(!DB::beginTransaction()){
                throw new Exception ("ERRO ao iniciar o cadastro");
            }

            $local = LocaisDAO::getIdByColumns($object->pais, $object->estado, $object->cidade);

            if(empty($local)){
                $local_id = LocaisDAO::insert([
                    null, $object->pais, $object->estado, $object->cidade
                ]);

                if(empty($local_id)){
                    throw new Exception("ERRO ao cadastrar endereço");
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
                throw new Exception("ERRO ao realizar o cadastro");
            }

            UsuariosDAO::insertFoto($id, $object->base64Img);
            
            if(!DB::commit()){
                throw new Exception ("Erro ao efetivar o cadastro.");
            }

            $this->cdMessage = Controller::MESSAGE_SUCCESS;
            $this->message = "Seu cadastro foi realizado com sucesso, realize login!";
            $this->object['link'] = '../../index.php';

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
    }

    public function update($object) {
        try {
            $usuario = UsuariosDAO::findByIdJoinLocal($object->id);
            if(empty($usuario)){
                throw new Exception("Usuário inexistente.");
            }
            
            $arrayDataUpdate = [];
            if(!empty($object->senha_nova)){
                if(sha1($object->senha_atual) != $usuario->senha){
                    throw new Exception ("Senha atual incorreta.");
                }
                
                $arrayDataUpdate['senha'] = sha1($object->senha_nova);
            }
            
            if(!DB::beginTransaction()){
                throw new Exception ("ERRO ao iniciar a atualização");
            }
            
            if($usuario->pais != $object->pais || $usuario->estado != $object->estado || $usuario->cidade != $object->cidade){
                $local = LocaisDAO::getIdByColumns($object->pais, $object->estado, $object->cidade);

                if(empty($local)){
                    $arrayDataUpdate['local_id'] = LocaisDAO::insert([
                        null, $object->pais, $object->estado, $object->cidade]);

                    if(empty($arrayDataUpdate['local_id'])){
                        throw new Exception("ERRO ao atualizar endereço");
                    }
                }
                else{
                    $arrayDataUpdate['local_id'] = $local->id;
                }
            }
            
            $arrayDataUpdate['nome'] = $object->nome;
            $arrayDataUpdate['dt_nascimento'] = Functions::date2sqlDate($object->dt_nascimento);
            $arrayDataUpdate['escola'] = $object->escola;
            $arrayDataUpdate['tipo_escola'] = $object->tipo_escola;
            
            UsuariosDAO::update(['id' => $object->id], $arrayDataUpdate);
            
            if(!empty($object->base64Img)){
                if(!UsuariosDAO::saveFoto($object->id . '.png', $object->base64Img)){
                    throw new Exception("ERRO ao gravar a foto de perfil.");
                }
            }
            
            if(!DB::commit()){
                throw new Exception ("Erro ao efetivar a atualização.");
            }

            $this->cdMessage = Controller::MESSAGE_SUCCESS;
            $this->message = "Seu cadastro foi atualizado com sucesso.";
            $this->object['link'] = '../../index.php';

        } catch (Exception $ex) {
            $this->cdMessage = Controller::MESSAGE_DANGER;
            $this->message = $ex->getMessage();

            if(DB::inTransaction()){
                DB::rollBack();
            }
        }
    }

    public function findById($object) {
        try {
            $usuario = UsuariosDAO::findByIdJoinLocal($object->id);

            if(empty($usuario)){
                throw new Exception("Usuário inexistente.");
            }

            unset($usuario->senha);
            $this->object = $usuario;
        } catch (Exception $ex) {
            $this->cdMessage = Controller::MESSAGE_DANGER;
            $this->message = $ex->getMessage();
        }
    }
}
