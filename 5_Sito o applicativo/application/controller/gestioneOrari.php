<?php
    class GestioneOrari extends Controller
    {
        public function index()
        {
            if($this->isLogged() == 2){
                $this->view->render('gestioneOrari/index.php');
            }else{
                $this->view->render('login/index.php');
            }
        }

        public function action(){
            if($this->isLogged() == 2){
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
            }else{
                $this->view->render('login/index.php');
            }
        }

        public function aggiungi(){
            if($this->isLogged() == 2){
                if(isset($_POST['aggiungi'])){
                    require 'application/models/orario_model.php';
                    $model = new OrarioModel();
                    try{
                        $model->aggiungiOrario();
                        Log::writeLog("Nuovo orario aggiunto");
                        //$this->view->locate("gestioneOrari/index");
                    }catch(Exception $e){
                        $this->view->error = $e->getMessage();
                        Log::writeErrorLog("Errore durante l'aggiunta di un orario: ". $e->getMessage());
                    }
                }
                $this->view->render("gestioneOrari/aggiungi.php");
            }else{
                $this->view->render('login/index.php');
            }
        }

        public function modifica(){
            if($this->isLogged() == 2){
                require 'application/models/orario_model.php';
                $model = new OrarioModel();
                if(isset($_POST['modifica'])){
                    try{
                        $idOrario = $model->modificaOrario();
                        Log::writeLog("L'orario ".$idOrario." è stato modificato");
                    }catch(Exception $e){
                        $this->view->error = $e->getMessage();
                        Log::writeErrorLog("Errore durante la modifica di un orario: ". $e->getMessage());
                    }
                }
                $this->view->render("gestioneOrari/modifica.php", false, array('orario' => $model->ottieniOrariCompleti()));
            }else{
                $this->view->render('login/index.php');
            }
        }

        public function mostra(){
            if($this->isLogged() == 2){
                require 'application/models/orario_model.php';
                $model = new OrarioModel();
                $this->view->render("gestioneOrari/mostra.php", false, array('orario' => $model->ottieniOrariCompleti()));
            }else{
                $this->view->render('login/index.php');
            }
        }
    }
?>