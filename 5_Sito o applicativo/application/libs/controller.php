<?php

session_start();

class Controller{
    public function __construct(){
        $this->view = new View();
    }
	
	public function getModel($model){
        require_once "application/models/" . $model;
    }

    public function locate($path){
		header("Location: " . URL . $path);
	}

    public function writeLog($msg){
        if($puntatore = fopen('application/logs/log.log', "a")){
            $user = isset($_SESSION['id']) ? $_SESSION['id'] : "undefined";
            $str = date("Y/m/d H:i:s") . " user_id=" . $user . ": " . $msg;
            fwrite($puntatore, $str . PHP_EOL);
        }
    }

    public function writeErrorLog($msg){
        if($puntatore = fopen('application/logs/logError.log', "a")){
            $user = isset($_SESSION['id']) ? $_SESSION['id'] : "undefined";
            $str = date("Y/m/d H:i:s") . " user_id=" . $user . ": " . $msg;
            fwrite($puntatore, $str . PHP_EOL);
        }
    }
}