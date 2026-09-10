<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Engine
{
    protected $CI;
    
    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function urlServer()
    {
        return 'http://192.168.15.99/';
    }
    private function json_output($status_code, $arrayMessage)
    {
        $this->output->set_status_header($status_code);
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($arrayMessage, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function output($status_code, $arrayMessage)
    {

        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json; charset=utf-8");

        $status = array(
            200 => '200 OK',
            201 => '201 CREATED',
            400 => '400 Bad Request',
            422 => 'Unprocessable Entity',
            500 => '500 Internal Server Error'
            );
        header('Status: '.$status[$status_code]);
        
        echo json_encode($arrayMessage);

    }
}


/* End of file Engine.php and path \application\libraries\Engine.php */
