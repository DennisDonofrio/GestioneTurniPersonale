<?php

    class dipendente extends Controller{

        /**
         * Carica la pagina index per la gestione dei dipendeti
         */
        public function index(){
            $this->view->render('gestioneDipendenti/index.php');
        }

        /**
         * Ottiene tutti i dipendenti con le rispettive informazioni
         */
        public function prepara(){
            parent::getModel('dipendente_model.php');
            $model = new DipendenteModel();
            return $model->ottieniDipendenti();
        }

        /**
         * Carica la pagina per l'aggiunta di un dipendente
         */
        public function aggiungi(){
            $this->view->render('gestioneDipendenti/aggiungiDipendente.php');
        }

        /**
         * Carica la pagina della lista dei dipendenti
         */
        public function mostra(){
            $this->view->render('gestioneDipendenti/mostraDipendenti.php', false, array('dipendenti' => $this->prepara()));
        }

        /**
         * Carica la pagina per la modifica dei dipendenti
         */
        public function modifica(){
            $this->view->render('gestioneDipendenti/modificaDipendente.php', false, array('dipendenti' => $this->prepara()));
        }

        /**
         * Carica la pagina per la rimozione dei dipendenti
         */
        public function rimuovi(){
            $this->view->render('gestioneDipendenti/rimuoviDipendente.php', false, array('dipendenti' => $this->prepara()));
        }

        /**
         * Questo metodo viene invocato con il bottone dalla pagina di aggiunta dei dipendenti.
         * Prende tutte le informazioni dai campi e in seguito, se i vari controlli vanno a buon fine,
         * aggiunge il nuovo dipendete al database
         */
        public function aggiungiDipendente(){
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
        }
        
        /**
         * Questo metodo viene invocato con il bottone dalla pagina di eliminazione dei dipendenti.
         * Prende tutte le informazioni dai campi e in seguito, se i vari controlli vanno a buon fine,
         * aggiunge il nuovo dipendete al database
         */
        public function rimuoviDipendente(){
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
        }

        /**
         * Questo metodo viene invocato con il bottone dalla pagina di modifica dei dipendenti.
         * Prende tutte le nuove informazioni dai campi e in seguito, se i vari controlli vanno a buon fine,
         * modifica il dipendente all'interno del database
         */
        public function modificaDipendente(){
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
                    $this->view->render('gestioneDipendenti/modificaDipendente.php',  false, array('error' => $e->getMessage()));
                }
            }else if(isset($_POST['riempi'])){
                $dipendenti = $model->ottieniDipendenti();
                $this->view->render('gestioneDipendenti/modificaDipendente.php',  false, array('dipendenti' => $dipendenti, 'dipendente' => $model->ottieniDipendente($_POST['dipendente'])));
            }
            
        }

    }

?>