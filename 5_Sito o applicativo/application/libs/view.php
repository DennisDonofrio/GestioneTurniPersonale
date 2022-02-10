<?php

class View
{
    function __construct(){

    }


    //usage: $this->view->render('<view>'[,<include>, array('<key>' => <value>)]);
    public function render($name, $onlyIncludeBody = false, $data = array()){
        if($onlyIncludeBody){
            require "application/views/" . $name . ".php";
        }else{
            require 'application/views/header.php';
            require "application/views/" . $name . ".php";
            require 'application/views/footer.php';
        }
    }
	
	public function locate($path){
		header("Location: " . URL . $path);
	}
}


?>