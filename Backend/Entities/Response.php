<?php

class Response
{

    private $header;
    private $status;
    private $data;

    function __construct($header, $status, $data)
    {
        $this->header = $header;
        $this->status = $status;
        $this->data = $data; 
        header($this->header);
        http_response_code($this->status);
    }

    function sendJson()
    {
        echo (json_encode($this->data));
    }

    function sendHtml(){
        echo $this->data;
    }


}
