<?php

class Controller{
    function __construct(){
        $this->view = new View();
    }
	
	function getModel($model){
        require_once "application/models/" . $model;
    }
}