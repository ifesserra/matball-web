<?php
$ROOT = dirname(__DIR__, 2);
require_once "$ROOT/application/dao/UsuariosDAO.class.php";

class RestrictedSession{
    
    public static function start(){
        if(!isset($_SESSION)){
            session_start();
        }
    }
    
    public static function destroy(){
        session_destroy();
    }

    public static function isLogged(){
        self::start();
        if(isset($_SESSION['id']) && isset($_SESSION['senha'])){
            return true;
        }
        
        self::destroy();
        return false;
    }
    
    public static function login($user, $pass){
        $row = UsuariosDAO::findByUserPass($user, sha1($pass));

        if(empty($row)){
            return false;
        }
        
        self::start();
        
        $_SESSION['id'] = $row->id;
        $_SESSION['login'] = $row->login;
        $_SESSION['senha'] = $pass;
        $_SESSION['nome'] = $row->nome;
        $_SESSION['url_foto'] = $row->url_foto;
        
        return true;
    }
    
    public static function logout(){
        self::start();
        unset($_SESSION['id']);
        unset($_SESSION['login']);
        unset($_SESSION['senha']);
        unset($_SESSION['nome']);
        unset($_SESSION['url_foto']);
        self::destroy();
    }
    
    public static function getID(){ return $_SESSION['id']; }
    public static function getLogin(){ return $_SESSION['login']; }
    public static function getSenha(){ return $_SESSION['senha']; }
    public static function getNome(){ return $_SESSION['nome']; }
    public static function getUrlFoto(){ return $_SESSION['url_foto']; }
}
