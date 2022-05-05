<?php

class Pianifica extends Controller{

    /**
     * Questa funzione fa scegliere il negozio di cui si
     * vuole pianificare l'orario
     */
    public function index(){
        parent::getModel('negozio_model.php');
        $model = new NegozioModel();
        $this->view->render("pianifica/index.php", false, array("negozi" => $model->ottieniNegozi()));
    }

    /**
     * Questa funzione serve per pianificare l'orario
     */
    public function pianificaOrario(){
        parent::getModel('pianifica_model.php');
        $model = new PianificaModel();
        $negozio = AntiCsScript::check($_POST['negozio']);
        $inizio = AntiCsScript::check($_POST['inizio']);
        $fine = AntiCsScript::check($_POST['fine']);
        $result = $model->pianifica($negozio, $inizio, $fine);
        if(is_bool($result)){
            Log::writeLog("Pianificazione avvenuta per negozio con id $negozio da $inizio a $fine");
            parent::locate("/");
        }else{
            Log::writeErrorLog("Errori! $result");
			parent::getModel('negozio_model.php');
			$model = new NegozioModel();
			$this->view->render("pianifica/index.php", false, array("errore" => $result, "negozi" => $model->ottieniNegozi()));
        }
    }

}

?>