<?php

date_default_timezone_set('America/Sao_Paulo');

class Functions {
    // dd/mm/aaaa => aaaa-mm-dd
    public static function date2sqlDate($ddmmaaaa){
        return implode('-', array_reverse(explode('/', $ddmmaaaa)));
    }
    
    // aaaa-mm-dd => dd/mm/aaaa
    public static function sqlDate2date($ddmmaaaa){
        return implode('/', array_reverse(explode('-', $ddmmaaaa)));
    }
    
    public static function sqlCurrentTimeStamp(){
        return date('Y-m-d H:i:s');
    }

    public static function sqlCurrentDate(){
        return date('Y-m-d');
    }

    public static function base64Img2Png($b64, $path){
        $b64 = str_replace('data:image/png;base64,', '', $b64);
        $b64 = str_replace(' ', '+', $b64);
        return file_put_contents($path, base64_decode($b64));
    }

    public static function sumSecondsInSqlTime($sqlTime, $seconds){
        $dtTime = new DateTime($sqlTime);
        $dtTime->add( new DateInterval("PT".$seconds."S") );

        return $dtTime->format('H:i:s');
    }
}
