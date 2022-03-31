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
            $nome = $_POST['nome'];
            $cognome = $_POST['cognome'];
            $email = $_POST['email'];
            $password = $_POST['password1'];
            $password2 = $_POST['password2'];
            $indirizzo = $_POST['indirizzo'];
            if($password == $password2){
                if($model->aggiungiDipendente($nome, $cognome, $email, $indirizzo, $password)){
                    $this->writeLog("Nuovo dipendente ".$email." aggiunto");
                    $this->locate('dipendente');
                }else{
                    $this->writeErrorLog("Errore nell'aggiunta di un dipendete: Non è stato possibile aggiungere il dipendente");
                    $this->view->render('gestioneDipendenti/aggiungiDipendente.php',  false, array('error' => "Non è stato possibile aggiungere il dipendente"));
                }
            }else{
                $this->writeErrorLog("Errore nell'aggiunta di un dipendete: Le due password inserite non corrispondono");
                $this->view->render('gestioneDipendenti/aggiungiDipendente.php',  false, array('error' => "Le due password inserite non corrispondono"));
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
            if($model->rimuoviDipendente($id)){
                $this->writeLog("Dipendente ".$id." eliminato ");
                $this->locate('dipendente');
            }else{
                $this->writeErrorLog("Errore nell'eliminazione di un dipendete: Non è stato possibile rimuovere il dipendente");
                $this->view->render('gestioneDipendenti/rimuoviDipendente.php',  false, array('error' => "Non è stato possibile rimuovere il dipendente"));
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
            $id = $_POST['dipendente'];
            $nome = $_POST['nome'];
            $cognome = $_POST['cognome'];
            $indirizzo = $_POST['indirizzo'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password2 = $_POST['password2'];
            if(isset($_POST['modifica'])){
                if($password == $password2){
                    if($model->modificaDipendente($id, $nome, $cognome, $indirizzo, $email, $password)){
                        $this->writeLog("Dipendente ".$email." modificato ");
                        $this->locate('dipendente');
                    }else{
                        $this->writeErrorLog("Errore nell'eliminazione di un dipendete: Non è stato possibile modificare il dipendente");
                        $dipendenti = $model->ottieniDipendenti();
                        $this->view->render('gestioneDipendenti/modificaDipendente.php',  false, array('error' => "Non è stato possibile modificare il dipendente", 'dipendenti' => $dipendenti));
                    }
                }else{
                    $this->writeErrorLog("Le due password inserite non corrispondono");
                    $dipendenti = $model->ottieniDipendenti();
                    $this->view->render('gestioneDipendenti/modificaDipendente.php',  false, array('error' => "Le password inserite non corrispondono", 'dipendenti' => $dipendenti));
                }
            }else if(isset($_POST['riempi'])){
                $dipendenti = $model->ottieniDipendenti();
                $this->view->render('gestioneDipendenti/modificaDipendente.php',  false, array('dipendenti' => $dipendenti, 'dipendente' => $model->ottieniDipendente($id)));
            }
            
        }

    }

?>