<?php

class Negozio extends Controller{

    function index(){
        if(isset($_SESSION['role'])){
            if($_SESSION['role'] == 2){
                $this->view->render("gestioneNegozi/index.php");
            }else{
                $this->view->render("home/index.php");
            }
        }else{
            $this->locate("login");
        }
    }

    public function load(){
        parent::getModel('negozio_model.php');
        $model = new NegozioModel();
        if(isset($_POST['aggiungiNegozio'])){
            $tipi = $model->ottieniTipi();
            $this->view->render('gestioneNegozi/aggiungiNegozio.php', false, array('tipi' => $tipi));
        }else if(isset($_POST['rimuoviNegozio'])){
            $negozi = $model->mostraNegozi();
            $this->view->render('gestioneNegozi/rimuoviNegozio.php',  false, array('negozi' => $negozi));
        }else if(isset($_POST['modificaNegozio'])){
            $this->view->render('gestioneNegozi/modificaNegozio.php');
        }else if(isset($_POST['mostraNegozi'])){
            $negozi = $model->mostraNegozi();
            $this->view->render('gestioneNegozi/mostraNegozi.php',  false, array('negozi' => $negozi));
        }
    }

    public function aggiungiNegozio(){
        parent::getModel("negozio_model.php");
        $model = new NegozioModel();
        $nome = $_POST['nome'];
        $indirizzo = $_POST['indirizzo'];
        $tipo = $_POST['tipo'];
        $model->aggiungiNegozio($nome, $indirizzo, $tipo);
        $this->locate('negozio');
    }

    public function mostraNegozi(){
        parent::getModel("negozio_model.php");
        $model = new NegozioModel();
        if($result = $model->mostraNegozi()){
            $this->view->render("gestioneNegozi/mostraNegozi", false, array('negozi' => $result));
        }
    }

    public function eliminaNegozio(){
        parent::getModel("negozio_model.php");
        $model = new NegozioModel();
        $id = $_POST['negozio'];
        echo $id;
        $model->rimuoviNegozio($id);
        $this->locate('negozio');
    }

}
?>