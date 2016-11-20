<?php

include_once 'Controller.class.php';
include_once 'RestrictedSession.class.php';

require_once "$ROOT/application/dao/UsuariosDAO.class.php";
require_once "$ROOT/application/dao/LocaisDAO.class.php";
require_once "$ROOT/application/dao/RecordesDAO.class.php";

class UsuarioNotFoundException extends Exception {
    function __construct(){
        parent::__construct("Usuário inexistente.");
    }
}

class UsuarioInvalidPassException extends Exception {}

class Usuarios extends Controller{
    
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
            DB::beginTransaction();

            $local = LocaisDAO::getIdByColumns($object->pais, $object->estado, $object->cidade);

            if(empty($local)){
                $local_id = LocaisDAO::insert([
                    null, $object->pais, $object->estado, $object->cidade ]);
            }
            else{
                $local_id = $local->id;
            }

            $id = UsuariosDAO::insert([
                NULL, $object->nome, $object->email, $object->login, sha1($object->senha),
                Functions::date2sqlDate($object->dt_nascimento), '', $local_id,
                $object->escola, $object->tipo_escola, Functions::sqlCurrentTimeStamp()]);

            RecordesDAO::insert([$id, 0, 0, 0, 0], false);

            UsuariosDAO::insertFoto($id, $object->base64Img);
            
            DB::commit();

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
                throw new UsuarioNotFoundException();
            }
            
            $arrayDataUpdate = [];
            if(!empty($object->senha_nova)){
                if(sha1($object->senha_atual) != $usuario->senha){
                    throw new UsuarioInvalidPassException ("Senha atual incorreta.");
                }
                
                $arrayDataUpdate['senha'] = sha1($object->senha_nova);
            }
            
            DB::beginTransaction();
            
            if($usuario->pais != $object->pais || $usuario->estado != $object->estado || $usuario->cidade != $object->cidade){
                $local = LocaisDAO::getIdByColumns($object->pais, $object->estado, $object->cidade);

                if(empty($local)){
                    $arrayDataUpdate['local_id'] = LocaisDAO::insert([
                        null, $object->pais, $object->estado, $object->cidade ]);
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
                UsuariosDAO::saveFoto($object->id . '.png', $object->base64Img);
            }
            
            DB::commit();

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
                throw new UsuarioNotFoundException();
            }

            unset($usuario->senha);
            $this->object = $usuario;
        } catch (Exception $ex) {
            $this->cdMessage = Controller::MESSAGE_DANGER;
            $this->message = $ex->getMessage();
        }
    }
    
    public function findByLogin($object) {
        try {
            $r = UsuariosDAO::findByColumns(['login' => $object->login]);

            if(empty($r)){
                throw new UsuarioNotFoundException();
            }

            $usuario = $r[0];
            unset($usuario->senha);
            $this->object = $usuario;
        } catch (Exception $ex) {
            $this->cdMessage = Controller::MESSAGE_DANGER;
            $this->message = $ex->getMessage();
        }
    }

    public function validateUserPass($object) {
        $usuario = UsuariosDAO::findByUserPass($object->user, $object->hash_pass);

        if(empty($usuario)){
            $this->cdMessage = Controller::MESSAGE_DANGER;
            $this->message = "Usuário ou senha inválido.";
        }
        else{
            $this->object['usuario_id'] = intval($usuario->id);
        }
    }
}
