<?php

session_start();

class Controller{
    public function __construct(){
        $this->view = new View();
    }
	
    /**
     * Fa un require del model che ha il nome passato come argomento
     * 
     * @param String $model -> nome del model da richiamare
     */
	public function getModel($model){
        require_once "application/models/" . $model;
    }

    /**
     * Reinderizza alla pagina passata come argomento
     * 
     * @param String $path -> la path in cui si trova la pagina
     */
    public function locate($path){
		header("Location: " . URL . $path);
	}

    /**
     * Verifica se l'utente è loggato. 
     * Torna 1 se è un dipendente
     * Torna 2 se è un datore
     * Torna 3 se è un amministratore
     */
    public function isLogged(){
        if(!empty($_SESSION['id'])){
            return $_SESSION['role'];
        }else{
            return -1;
        }
    }
}