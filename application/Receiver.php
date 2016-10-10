<?php

// Esse receiver espera um json no índice 'call' com o seguinte layout:
// service  : string que diz qual serviço está chamando
// operation: int que diz qual operação
// object   : objeto a ser passado para o serviço

$isPost;
$arrayInput;

try{
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $isPost = true;
        $arrayInput = $_POST;
    }
    else{
        $isPost = false;
        $arrayInput = $_GET;
    }

    if(!isset($arrayInput['call'])){
        throw new Exception('ERRO DE CHAMADA', 1);
    }

    $call = json_decode($arrayInput['call']);

    //print_r($call);

    if(empty($call) || !(isset($call->service) && isset($call->operation) && isset($call->object))){
        throw new Exception('ERRO DE PARAMETROS', 1);
    }

    include_once './controller/' . $call->service . '.class.php';

    $controller = new $call->service();
    $reflectionMethod = new ReflectionMethod($call->service, $call->operation);
    $reflectionMethod->invoke($controller, $call->object);
    $controller->sendResponse();
} catch (Exception $e){
    exit($e->getMessage());
}
