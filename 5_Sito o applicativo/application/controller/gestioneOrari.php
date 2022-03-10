<?php
    class GestioneOrari extends Controller
    {
        public function index()
        {
            $this->view->render('gestioneOrari/index.php');
        }

        public function action(){

            if(isset($_POST['aggiungi'])){
                //require 'application/models/negozio_model.php';
                //$model = new NegozioModel();
                //$this->view->render("gestioneOrari/aggiungi.php", false, array('negozio' => $model->ottieniNegozi()));
                $this->view->render("gestioneOrari/aggiungi.php");
            }else if(isset($_POST['modifica'])){
                require 'application/models/orario_model.php';
                $model = new OrarioModel();
                $this->view->render("gestioneOrari/modifica.php", false, array('orario' => $model->ottieniOrariCompleti()));
                //$this->view->render("gestioneOrari/modifica.php");
            }else if(isset($_POST['rimuovi'])){
                $this->view->render("GestioneOrari/rimuovi.php");
            }else if(isset($_POST['mostra'])){
                require 'application/models/orario_model.php';
                $model = new OrarioModel();
                $this->view->render("gestioneOrari/mostra.php", false, array('orario' => $model->ottieniOrariCompleti()));
            }else{
                $this->index();
            }
        }

        public function aggiungi(){
            if(isset($_POST['aggiungi'])){
                require 'application/models/orario_model.php';
                $model = new OrarioModel();
                try{
                    $model->aggiungiOrario();
                    //$this->view->locate("gestioneOrari/index");
                }catch(Exception $e){
                    $this->view->error = $e->getMessage();
                }
                $this->view->render("gestioneOrari/aggiungi.php");
            }
        }

        public function modifica(){
            if(isset($_POST['modifica'])){
                require 'application/models/orario_model.php';
                $model = new OrarioModel();
                try{
                    $model->modificaOrario();
                }catch(Exception $e){
                    $this->view->error = $e->getMessage();
                }
                $model = new OrarioModel();
                $this->view->render("gestioneOrari/modifica.php", false, array('orario' => $model->ottieniOrariCompleti()));
            }
        }
/*
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
*/
    }
?>