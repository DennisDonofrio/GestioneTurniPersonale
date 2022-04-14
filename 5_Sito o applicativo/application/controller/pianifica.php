<?php

class Pianifica extends Controller{

    public function index(){
        parent::getModel('negozio_model.php');
        $model = new NegozioModel();
        $this->view->render("pianifica/index.php", false, array("negozi" => $model->ottieniNegozi()));
    }

    public function pianificaOrario(){
        parent::getModel('pianifica_model.php');
        $model = new PianificaModel();
        $negozio = $_POST['negozio'];
        $inizio = $_POST['inizio'];
        $fine = $_POST['fine'];
        $model->pianifica($negozio, $inizio, $fine);
    }

}

?>