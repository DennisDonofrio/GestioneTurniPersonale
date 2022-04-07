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
     * Scrive in un file log predefinito il messaggio con la relativa ora e utente. 
     * Serve per tenere traccia di tutte le operazioni andate a buon fine
     * 
     * @param String $msg -> messaggio da inserire nel log
     */
    public function writeLog($msg){
        if($puntatore = fopen('application/logs/log.log', "a")){
            $user = isset($_SESSION['id']) ? $_SESSION['id'] : "undefined";
            $str = date("Y/m/d H:i:s") . " user_id=" . $user . ": " . $msg;
            fwrite($puntatore, $str . PHP_EOL);
        }
    }

    /**
     * Scrive in un file log di errore predefinito il messaggio con la relativa ora e utente. 
     * Serve per tenere traccia di tutti gli errori avvenuti.
     * 
     * @param String $msg -> messaggio da inserire nel log di errore
     */
    public function writeErrorLog($msg){
        if($puntatore = fopen('application/logs/logError.log', "a")){
            $user = isset($_SESSION['id']) ? $_SESSION['id'] : "undefined";
            $str = date("Y/m/d H:i:s") . " user_id=" . $user . ": " . $msg;
            fwrite($puntatore, $str . PHP_EOL);
        }
    }
}