<?php
    class GestioneDatori extends Controller
    {
        /**
         * Carica la pagina index per la gestione dei datori
         */
        public function index()
        {
            if($this->isLogged() == 3){
                $this->view->render('gestioneDatori/index.php');
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Questo metodo serve per mostrare la lista di datori
         */
        public function mostra(){
            if($this->isLogged() == 3){
                require 'application/models/datoreModel.php';
                $model = new DatoreModel();
                $this->view->data = $model->ottieniTuttiDatoriCompleti();
                $this->view->template = array("id", "nome", "cognome", "email", "indirizzo");
                $this->view->render("gestioneDatori/mostra.php");
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Questo metodo viene invocato per modificare un datore di lavoro.
         * Se tutti i controlli vanno a buon fine, richiama il metodo del model per modificare le informazioni del datore
         */
        public function modifica(){
            if($this->isLogged() == 3){
                require 'application/models/datoreModel.php';
                $model = new DatoreModel();
                if(isset($_POST['modifica'])){
                    try{
                        $em = $model->modificaDatore();
                        Log::writeLog("Datore ".$em." modificato");
                        $this->view->render("gestioneDatori/index.php");
                    }catch(Exception $e){
                        Log::writeErrorLog("Errore nella modifica di un datore: ". $e->getMessage());
                        $this->view->error = $e->getMessage();
                        $this->view->data = $model->ottieniTuttiDatori();
                        $this->view->selected = $model->ottieniDatiDatore($_POST['id']);
                        $this->view->render("gestioneDatori/modifica.php");
                    }
                }else if(isset($_POST['datoreButton']) && isset($_POST['id'])){
                    $this->view->data = $model->ottieniTuttiDatori();
                    $this->view->selected = $model->ottieniDatiDatore($_POST['id']);
                    $this->view->render("gestioneDatori/modifica.php");
                }else{
                    $this->view->data = $model->ottieniTuttiDatori();
                    $this->view->selected = $model->ottieniTuttiDatori()[0];
                    $this->view->render("gestioneDatori/modifica.php");
                }
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Questo metodo viene invocato per eliminare un datore di lavoro.
         * Se tutti i controlli vanno a buon fine, richiama il metodo del model per eliminare il datore selezionato
         */
        public function rimuovi(){
            if($this->isLogged() == 3){
                require 'application/models/datoreModel.php';
                $model = new DatoreModel();
                if(isset($_POST['elimina'])){
                    try{
                        $em = $model->eliminaDatore();
                        Log::writeLog("Datore ".$em." rimosso");
                        $this->view->locate("home");
                    }catch(Exception $e){
                        Log::writeErrorLog("Errore nell'eliminazione di un datore: ".$e->getMessage());
                        $this->view->error = $e->getMessage();
                    }
                }
                $this->view->data = $model->ottieniTuttiDatoriEmail();
                $this->view->render("gestioneDatori/rimuovi.php");
            }else{
                $this->view->render('login/index.php');
            }
        }
        
        /**
         * Questo metodo viene invocato per aggiungere un datore di lavoro.
         * Se tutti i controlli vanno a buon fine, richiama il metodo del model per aggiungere un nuovo datore
         */
        public function aggiungi(){
            if($this->isLogged() == 3){
                if(isset($_POST['aggiungi'])){
                    require 'application/models/datoreModel.php';
                    $model = new DatoreModel();
                    try{
                        $em = $model->aggiungiDatore();
                        Log::writeLog("Datore ".$em." aggiunto");
                        $this->view->locate("gestioneDatori/index");
                    }catch(Exception $e){
                        Log::writeErrorLog("Errore nell'aggiunta di un datore: ".$e->getMessage());
                        $this->view->error = $e->getMessage();
                    }
                }
                $this->view->render("gestioneDatori/aggiungi.php");
            }else{
                $this->view->render('login/index.php');
            }
        }
    }
?>