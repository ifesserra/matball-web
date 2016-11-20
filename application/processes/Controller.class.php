<?php

$ROOT = dirname(__DIR__, 2);

abstract class Controller {
    protected $response;
    protected $object;
    
    // Success = 0 (No Message)
    // Success = 1000 - 1999
    // Info    = 2000 - 2999
    // Warning = 3000 - 3999
    // Danger  = 4000 - 4999
    protected $cdMessage;
    protected $message;
    
    const MESSAGE_SUCCESS_EMPTY = 0;
    const MESSAGE_SUCCESS       = 1000;
    const MESSAGE_INFO          = 2000;
    const MESSAGE_WARNING       = 3000;
    const MESSAGE_DANGER        = 4000;

    public function __construct(){
        $this->cdMessage = self::MESSAGE_SUCCESS_EMPTY;
        $this->message = "";
        $this->object = [];
    }
    
    public function getResponse(){
        $this->response = [];
        $this->response['cd_message'] = $this->cdMessage;
        $this->response['message'] = $this->message;
        $this->response['object'] = $this->object;
        
        return json_encode($this->response);
    }
}
