<?php
require_once('Crud.class.php');
require_once "$ROOT/application/Functions.php";

class UsuariosDAO extends Crud{
    public static $table = 'usuarios';
    
    public static function findByUserPass($user, $pass){
        $r = parent::findByColumns(['login' => $user, 'senha' => $pass]);
        if(!empty($r)){
            return $r[0];
        }
        
        return null;
    }

    public static function findByIdPass($user, $pass){
        $r = parent::findByColumns(['id' => $user, 'senha' => $pass]);
        if(!empty($r)){
            return $r[0];
        }
        
        return null;
    }
    
    public static function saveFoto($nameFile, $base64Img){
        $root = dirname(__DIR__, 2);
        $dir = "$root/data/fotos";
        
        if(!file_exists($dir)){
            if(!file_exists(dirname($dir))){
                mkdir(dirname($dir));
            }
            
            mkdir($dir);
        }

        if(Functions::base64Img2Png($base64Img, "$dir/$nameFile")){
            return true;
        }
        
        return false;
    }
    
    public static function insertFoto($id, $base64Img){
        $nameFile = "$id.png";
        $urlFoto = "data/fotos/$nameFile";

        if(self::saveFoto($nameFile, $base64Img)){
            return parent::update(['id' => $id], ['url_foto' => $urlFoto]);
        }
        
        return 0;
    }
    
    public static function findByIdJoinLocal($id){
        return parent::sqlFetch(
            "SELECT u.id, u.nome, u.email, u.login, u.url_foto, u.senha,".
                   "DATE_FORMAT(u.dt_nascimento, '%d/%m/%Y') AS dt_nascimento, ".
                   "u.escola, u.tipo_escola, l.pais, l.estado, l.cidade ".
            "FROM usuarios AS u " .
            "LEFT JOIN locais AS l ON l.id = u.local_id ".
            "WHERE u.id = $id"
        );
    }
}
