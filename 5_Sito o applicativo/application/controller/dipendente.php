<?php

    class dipendente extends Controller{

        /**
         * Carica la pagina index per la gestione dei dipendeti
         */
        public function index(){
            if($this->isLogged() == 2){
                $this->view->render('gestioneDipendenti/index.php');
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Ottiene tutti i dipendenti con le rispettive informazioni
         */
        public function prepara(){
            
            if($this->isLogged() == 2){
                parent::getModel('dipendente_model.php');
                $model = new DipendenteModel();
                return $model->ottieniDipendenti();
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Carica la pagina per l'aggiunta di un dipendente
         */
        public function aggiungi(){
            if($this->isLogged() == 2){
                $this->view->render('gestioneDipendenti/aggiungiDipendente.php');
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Carica la pagina della lista dei dipendenti
         */
        public function mostra(){
            if($this->isLogged() == 2){
                $this->view->render('gestioneDipendenti/mostraDipendenti.php', false, array('dipendenti' => $this->prepara()));
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Carica la pagina per la modifica dei dipendenti
         */
        public function modifica(){
            if($this->isLogged() == 2){
                $this->view->render('gestioneDipendenti/modificaDipendente.php', false, array('dipendenti' => $this->prepara()));
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Carica la pagina per la rimozione dei dipendenti
         */
        public function rimuovi(){
            if($this->isLogged() == 2){
                $this->view->render('gestioneDipendenti/rimuoviDipendente.php', false, array('dipendenti' => $this->prepara()));
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Questo metodo viene invocato con il bottone dalla pagina di aggiunta dei dipendenti.
         * Prende tutte le informazioni dai campi e in seguito, se i vari controlli vanno a buon fine,
         * aggiunge il nuovo dipendete al database
         */
        public function aggiungiDipendente(){
            
            if($this->isLogged() == 2){
                parent::getModel("dipendente_model.php");
                $model = new DipendenteModel();
                try{
                    $em = $model->aggiungiDipendente();
                    Log::writeLog("Nuovo dipendente ".$em." aggiunto");
                    $this->locate('dipendente');
                }catch(Exception $e){
                    Log::writeErrorLog("Errore nell'aggiunta di un dipendete: ". $e->getMessage());
                    $this->view->render('gestioneDipendenti/aggiungiDipendente.php',  false, array('error' => $e->getMessage()));
                }  
            }else{
                $this->view->render('login/index.php');
            }
        }
        
        /**
         * Questo metodo viene invocato con il bottone dalla pagina di eliminazione dei dipendenti.
         * Prende tutte le informazioni dai campi e in seguito, se i vari controlli vanno a buon fine,
         * aggiunge il nuovo dipendete al database
         */
        public function rimuoviDipendente(){
            if($this->isLogged() == 2){
                parent::getModel("dipendente_model.php");
                $model = new DipendenteModel();
                $id = $_POST['dipendente'];
                try{
                    $model->rimuoviDipendente($id);
                    Log::writeLog("Dipendente ".$id." eliminato ");
                    $this->locate('dipendente');
                }catch(Exception $e){
                    Log::writeErrorLog("Errore nell'eliminazione di un dipendete: ".$e->getMessage());
                    $this->view->render('gestioneDipendenti/rimuoviDipendente.php',  false, array('error' => $e->getMessage()));
                }
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Questo metodo viene invocato con il bottone dalla pagina di modifica dei dipendenti.
         * Prende tutte le nuove informazioni dai campi e in seguito, se i vari controlli vanno a buon fine,
         * modifica il dipendente all'interno del database
         */
        public function modificaDipendente(){
            if($this->isLogged() == 2){
                parent::getModel("dipendente_model.php");
                $model = new DipendenteModel();
                if(isset($_POST['modifica'])){
                    try{
                        $em = $model->modificaDipendente();
                        Log::writeLog("Dipendente ".$em." modificato");
                        $this->locate('dipendente');
                    }catch(Exception $e){
                        Log::writeErrorLog("Errore durante la modifica di un dipendete: ".$e->getMessage());
                        $dipendenti = $model->ottieniDipendenti();
                        $this->view->render('gestioneDipendenti/modificaDipendente.php',  false, array('error' => $e->getMessage(), 'dipendenti' => $dipendenti, 'dipendente' => $model->ottieniDipendente($_POST['dipendente'])));
                    }
                }else if(isset($_POST['riempi'])){
                    $dipendenti = $model->ottieniDipendenti();
                    $this->view->render('gestioneDipendenti/modificaDipendente.php',  false, array('dipendenti' => $dipendenti, 'dipendente' => $model->ottieniDipendente($_POST['dipendente'])));
                }
            }else{
                $this->view->render('login/index.php');
            }
        }

    }

?>