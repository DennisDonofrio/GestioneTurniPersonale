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
            $this->view->render('gestioneNegozi/rimuoviNegozio.php', false, array('negozi' => $negozi));
        }else if(isset($_POST['modificaNegozio'])){
            $negozi = $model->ottieniNegozi();
            $tipi = $model->ottieniTipi();
            $this->view->render('gestioneNegozi/modificaNegozio.php', false, array('negozi' => $negozi, 'tipi' => $tipi));
        }else if(isset($_POST['mostraNegozi'])){
            $this->mostraNegozi();
        }
    }

    public function aggiungiNegozio(){
        parent::getModel("negozio_model.php");
        $model = new NegozioModel();
        $nome = $_POST['nome'];
        $indirizzo = $_POST['indirizzo'];
        $tipo = $_POST['tipo'];
        if($model->aggiungiNegozio($nome, $indirizzo, $tipo)){
            $this->locate('negozio');
        }else{
            $tipi = $model->ottieniTipi();
            $this->view->render('gestioneNegozi/aggiungiNegozio.php',  false, array('error' => "Non è stato possibile inserire il negozio", 'tipi' => $tipi));
        }
    }

    public function mostraNegozi(){
        parent::getModel("negozio_model.php");
        $model = new NegozioModel();
        $result = $model->mostraNegozi();
        $this->view->render("gestioneNegozi/mostraNegozi.php", false, array('negozi' => $result));
    }

    public function eliminaNegozio(){
        parent::getModel("negozio_model.php");
        $model = new NegozioModel();
        $id = $_POST['negozio'];
        echo $id;
        $model->rimuoviNegozio($id);
        $this->locate('negozio');
    }
    
    public function modificaNegozio(){
        parent::getModel("negozio_model.php");
        $model = new NegozioModel();
        $nome = $_POST['nome'];
        $indirizzo = $_POST['indirizzo'];
        $tipo = $_POST['tipo'];
        $idNegozio = $_POST['negozio'];
        if($model->modificaNegozio($idNegozio, $nome, $indirizzo, $tipo)){
            $this->locate('negozio');
        }else{
            $tipi = $model->ottieniTipi();
            $negozi = $model->ottieniNegozi();
            $this->view->render('gestioneNegozi/modificaNegozio.php', false, array('negozi' => $negozi, 'tipi' => $tipi, 'error' => "Non è stato possibile modificare il negozio"));
        }
    }

}
?>