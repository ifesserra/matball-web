<?php
$ROOT = dirname(__DIR__, 2);
require_once "$ROOT/config/db.php";

class DB{
    private static $instance;
    
    public static function getInstance(){
        if(!isset(self::$instance)){
            try{
                $opt = array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
                );

                $strConnection = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
                self::$instance = new PDO($strConnection, DB_USER, DB_PASS, $opt);
                
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        
        return self::$instance;
    }
    
    public static function prepare($sql){
        //echo("$sql<BR>");
        return self::getInstance()->prepare($sql);
    }
    
    public static function lastInsertId(){
        return self::getInstance()->lastInsertId();
    }
    
    public static function closeConnection(){
        self::$instance = null;
    }
    
    public static function beginTransaction(){
        return self::getInstance()->beginTransaction();
    }
    
    public static function inTransaction(){
        return self::getInstance()->inTransaction();
    }
    
    public static function commit(){
        return self::getInstance()->commit();
    }
    
    public static function rollBack(){
        return self::getInstance()->rollBack();
    }
}
