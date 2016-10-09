<?php
require_once('Crud.class.php');
require_once "$ROOT/application/Functions.php";

class UsuariosDAO extends Crud{
    public static $table = 'usuarios';
    
    public static function findByUserPass($user, $pass){
        $r = parent::findByColumns(['login' => $user, 'senha' => sha1($pass)]);
        if(!empty($r)){
            return $r[0];
        }
        
        return null;
    }
    
    public static function insertFoto($id, $base64Img){
        $urlFoto = "data/fotos/$id.png";
        $root = dirname(__DIR__, 2);
        
        if(!file_exists("$root/data/fotos")){
            if(!file_exists("$root/data")){
                mkdir("$root/data");
            }
            
            mkdir("$root/data/fotos");
        }

        if(Functions::base64Img2Png($base64Img, "$root/$urlFoto")){
            return parent::update(['id' => $id], ['url_foto' => $urlFoto]);
        }
        
        return 0;
    }
}
