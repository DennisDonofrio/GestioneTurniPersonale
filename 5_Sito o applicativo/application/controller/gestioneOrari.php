<?php
    class GestioneOrari extends Controller
    {
        public function index()
        {
            $this->view->render('gestioneOrari/index.php');
        }

        public function action(){

            if(isset($_POST['aggiungi'])){
                $this->view->render("gestioneOrari/aggiungi.php");
            }else if(isset($_POST['modifica'])){
                $this->view->render("gestioneOrari/modifica.php");
            }else if(isset($_POST['rimuovi'])){
                $this->view->render("GestioneOrari/rimuovi.php");
            }else if(isset($_POST['mostra'])){
                $this->view->render("gestioneOrari/mostra.php");
            }
        }
/*
        public function modifica(){
            if(isset($_POST['modifica'])){
                require 'application/models/datoreModel.php';
                $model = new DatoreModel();
                try{
                    $model->modificaDatore();
                   
                }catch(Exception $e){
                    $this->view->error = $e->getMessage();
                }
                $this->view->data = $model->ottieniTuttiDatori();
                $this->view->selected = $model->ottieniDatiDatore($_POST['id']);
                $this->view->render("gestioneDatori/modifica.php");
            }else if(isset($_POST['datoreButton']) && isset($_POST['id'])){
                require 'application/models/datoreModel.php';
                $model = new DatoreModel();
                $this->view->data = $model->ottieniTuttiDatori();
                $this->view->selected = $model->ottieniDatiDatore($_POST['id']);
                $this->view->render("gestioneDatori/modifica.php");
            }
        }

        public function rimuovi(){
            if(isset($_POST['elimina'])){
                require 'application/models/datoreModel.php';
                $model = new DatoreModel();
                try{
                    $model->eliminaDatore();
                }catch(Exception $e){
                    $this->view->error = $e->getMessage();
                }
                $this->view->data = $model->ottieniTuttiDatoriEmail();
                $this->view->render("gestioneDatori/rimuovi.php");
            }
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
                $this->view->render("gestioneDatori/aggiungi.php");
            }
        }*/
    }
?>