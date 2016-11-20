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

    $receiver = new Receiver($arrayInput);
    $json = $receiver->process();
    echo $json;
} catch (Exception $e){
    exit($e->getMessage());
}

class Receiver{
    private $input;
    
    function __construct($input) {
        $this->input = $input;
    }
    
    public function process(){
        if(!isset($this->input['call'])){
            throw new UnexpectedValueException('ERRO DE CHAMADA');
        }

        $call = json_decode($this->input['call']);

        if(empty($call) || !(isset($call->service) && isset($call->operation) && isset($call->object))){
            throw new InvalidArgumentException('ERRO DE PARAMETROS');
        }

        include_once './processes/' . $call->service . '.class.php';

        $controller = new $call->service();
        $reflectionMethod = new ReflectionMethod($call->service, $call->operation);
        $reflectionMethod->invoke($controller, $call->object);
        return $controller->getResponse();
    }
}
