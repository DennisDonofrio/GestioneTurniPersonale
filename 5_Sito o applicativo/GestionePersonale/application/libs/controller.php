<?php

session_start();

class Controller{
    function __construct(){
        $this->view = new View();
    }
	
	function getModel($model){
        require_once "application/models/" . $model;
    }

    public function locate($path){
		header("Location: " . URL . $path);
	}
}