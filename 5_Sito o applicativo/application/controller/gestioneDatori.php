<?php
    class GestioneDatori extends Controller
    {
        public function index()
        {
            $this->view->render('gestioneDatori/index.php');
        }

        public function mostra(){
            require 'application/models/datoreModel.php';
            $model = new DatoreModel();
            $this->view->data = $model->ottieniTuttiDatoriCompleti();
            $this->view->template = array("id", "nome", "cognome", "email", "indirizzo");
            $this->view->render("gestioneDatori/mostra.php");
        }

        public function mostra(){
            require 'application/models/datoreModel.php';
            $model = new DatoreModel();
            $this->view->data = $model->ottieniTuttiDatoriCompleti();
            $this->view->template = array("id", "nome", "cognome", "email", "indirizzo");
            $this->view->render("gestioneDatori/mostra.php");
        }

        public function modifica(){
            require 'application/models/datoreModel.php';
            $model = new DatoreModel();
            if(isset($_POST['modifica'])){
                try{
                    $model->modificaDatore();
                }catch(Exception $e){
                    $this->view->error = $e->getMessage();
                }
                $this->view->data = $model->ottieniTuttiDatori();
                $this->view->selected = $model->ottieniDatiDatore($_POST['id']);
                $this->view->render("gestioneDatori/index.php");
            }else if(isset($_POST['datoreButton']) && isset($_POST['id'])){
                require 'application/models/datoreModel.php';
                $model = new DatoreModel();
                $this->view->data = $model->ottieniTuttiDatori();
                $this->view->selected = $model->ottieniDatiDatore($_POST['id']);
                $this->view->render("gestioneDatori/modifica.php");
            }else{
                $this->view->data = $model->ottieniTuttiDatori();
                $this->view->selected = $model->ottieniTuttiDatori()[0];
                $this->view->render("gestioneDatori/modifica.php");
            }
        }

        public function rimuovi(){
            require 'application/models/datoreModel.php';
            $model = new DatoreModel();
            if(isset($_POST['elimina'])){
                try{
                    $model->eliminaDatore();
                    $this->view->locate("home");
                }catch(Exception $e){
                    $this->view->error = $e->getMessage();
                }
            }
            $this->view->data = $model->ottieniTuttiDatoriEmail();
            $this->view->render("gestioneDatori/rimuovi.php");
        }

        public function aggiungi(){
            if(isset($_POST['aggiungi'])){
                require 'application/models/datoreModel.php';
                $model = new DatoreModel();
                try{
                    $model->aggiungiDatore();
                    $this->view->locate("gestioneDatori/index");
                }catch(Exception $e){
                    $this->view->error = $e->getMessage();
                }
            }
            $this->view->render("gestioneDatori/aggiungi.php");
        }
    }
?>