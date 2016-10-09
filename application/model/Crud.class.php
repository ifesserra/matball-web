<?php
require_once('DB.class.php');

abstract class Crud{

    // Métodos CRUD
    
    // OBECE A ORDEM DA TABELA
    public static function insert($arrayValue, $returnId = true){
        $strValues = "";
        foreach($arrayValue as $value){
            if(gettype($value) == 'string'){
                $strValues .= "'$value',";
            }
            else if(gettype($value) == 'NULL'){
                $strValues .= "NULL,";
            }
            else{
                $strValues .= $value . ',';
            }
        }
        
        $strValues = substr($strValues, 0, -1);
        
        $sql = "INSERT INTO " . static::$table . " VALUES($strValues)";
        
        $statement = DB::prepare($sql);
        
        if($statement->execute()){
            // Retorna o ID
            if($returnId){
                return DB::lastInsertId();
            }
            
            return true;
        }
        else{
            return NULL;
        }
    }

    public static function update($arrayPkValue, $arrayFieldValues){
        $attributions = self::makeAttributions($arrayFieldValues);
        $logicalExpression = self::makeLogicalExpression($arrayPkValue);
        
        $sql = "UPDATE " . static::$table . " SET $attributions WHERE $logicalExpression";
        return self::sqlExec($sql);
    }
    
    public static function findById($arrayPkValue, $isJson = false){
        $sql = "SELECT * FROM " . static::$table . " WHERE " . self::makeLogicalExpression($arrayPkValue);
        return self::sqlFetch($sql, $isJson);
    }
    
    public static function findAll($isJson = false){
        $sql = "SELECT * FROM " . static::$table;
        return self::sqlFetchAll($sql, $isJson);
    }
    
    // Retorna o número de linhas afetadas
    public static function delete($arrayPkValue){
        $sql = "DELETE FROM " . static::$table . " WHERE " . self::makeLogicalExpression($arrayPkValue);
        return DB::getInstance()->exec($sql);
    }
    
    // Métodos de pesquisa
    
    public static function findByColumns($arrayColValue, $isJson = false){
        $sql = "SELECT * FROM " . static::$table . " WHERE " . self::makeLogicalExpression($arrayColValue);
        return self::sqlFetchAll($sql, $isJson);
    }
    
    // Métodos assessórios
    
    public static function query($sql, $isFethAll, $isJson){
        $statement = DB::prepare($sql);
        $statement->execute();
        
        if($isJson){
            if($isFethAll)
                $r = $statement->fetchAll(PDO::FETCH_ASSOC);
            else
                $r = $statement->fetch(PDO::FETCH_ASSOC);
            
            if(!empty($r))
                $r = json_encode($r);
        }
        else{
            if($isFethAll)
                $r = $statement->fetchAll();
            else
                $r = $statement->fetch();
        }
        
        $statement->closeCursor();
        return $r;
    }
    
    public static function sqlFetch($sql, $isJson = false){
        return self::query($sql, false, $isJson);
    }
    
    public static function sqlFetchAll($sql, $isJson = false){
        return self::query($sql, true, $isJson);
    }
    
    
    public static function sqlExec($sql){
        $statement = DB::prepare($sql);
        
        // Retorna o ID ou número de linhas afetadas
        if($statement->execute())
            return DB::lastInsertId();
        else
            return null;
    }
    
    
    public static function makeLogicalExpression($arrayFieldValue, $and = true){
        $operator = $and ? 'AND':'OR';
        $where = '';
        foreach ($arrayFieldValue as $fild => $value){
            $where .= " $fild=";
            
            if(gettype($value) == 'string'){
                $where .= "'$value' $operator";
            }
            else if(gettype($value) == 'NULL'){
                $where .= "NULL $operator";
            }
            else{
                $where .= $value . " $operator";
            }
        }
        
        return rtrim($where, $operator);
    }
    
    public static function makeAttributions($arrayFieldValue){
        $attributions = "";
        
        foreach($arrayFieldValue as $fild => $value){            
            if(gettype($value) == 'string'){
                $attributions .= "$fild='$value',";
            }
            else if(gettype($value) == 'NULL'){
                $attributions .= "$fild=NULL,";
            }
            else{
                $attributions .= "$fild=$value,";
            }
        }
        
        return substr($attributions, 0, -1);
    }
    
    public static function getArrayFieldValue($tableName, $arrayValue){
        $sql = "SHOW COLUMNS FROM $tableName";
        $rows = self::sqlFetchAll($sql);
        $arrayFV = [];
        
        $length = count($rows);
        for($i = 0; $i < $length; $i++){
            $arrayFV[$rows[$i]->Field] = $arrayValue[$i];
        }
        
        return $arrayFV;
    }
}
