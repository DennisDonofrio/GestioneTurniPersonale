<?php

    class Negozio extends Controller{

        /**
         * Questa funzione controlla che l'utente sia un datore.
         */
        function index(){
            if($this->isLogged() == 2){
                if(isset($_SESSION['role'])){
                    if($_SESSION['role'] == 2){
                        $this->view->render("gestioneNegozi/index.php");
                    }else{
                        $this->view->render("home/index.php");
                    }
                }else{
                    $this->locate("login");
                }
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Questa funzione serve per preparare il model
         * ritorna il model
         */
        public function prepara(){
            if($this->isLogged() == 2){
                parent::getModel('negozio_model.php');
                return new NegozioModel();
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Questa funzione serve per ottenere i tipi da 
         * visualizzare in una select per la pagina aggiungi
         */
        public function aggiungi(){
            if($this->isLogged() == 2){
                $model = $this->prepara();
                $tipi = $model->ottieniTipi();
                $this->view->render('gestioneNegozi/aggiungiNegozio.php', false, array('tipi' => $tipi));
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Questa funzione serve per ottenere i tipi e il negozio da 
         * visualizzare in una select per la pagina modifica
         */
        public function modifica(){
            if($this->isLogged() == 2){
                $model = $this->prepara();
                $negozi = $model->ottieniNegozi();
                $tipi = $model->ottieniTipi();
                $this->view->render('gestioneNegozi/modificaNegozio.php', false, array('negozi' => $negozi, 'tipi' => $tipi));
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Questa funzione serve per ottenere i tipi da 
         * visualizzare in una select per la pagina rimuovi
         */
        public function rimuovi(){
            if($this->isLogged() == 2){
                $model = $this->prepara();
                $negozi = $model->mostraNegozi();
                $this->view->render('gestioneNegozi/rimuoviNegozio.php', false, array('negozi' => $negozi));
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Questa funzione serve per mostrare tutti i negozi di un datore
         */
        public function mostra(){
            if($this->isLogged() == 2){
                $model = $this->prepara();
                $result = $model->mostraNegozi();
                $this->view->render("gestioneNegozi/mostraNegozi.php", false, array('negozi' => $result));
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Questa funzione serve per aggiungere un negozio
         */
        public function aggiungiNegozio(){
            if($this->isLogged() == 2){
                parent::getModel("negozio_model.php");
                $model = new NegozioModel();
                try{
                    $nm = $model->aggiungiNegozio();
                    Log::writeLog("Negozio ".$nm." aggiunto");
                    $this->locate('negozio');
                }catch(Exception $e){
                    $tipi = $model->ottieniTipi();
                    Log::writeErrorLog("Errore nell'aggiunta di un negozio: ".$e->getMessage());
                    $this->view->render('gestioneNegozi/aggiungiNegozio.php', false, array('error' => $e->getMessage(), 'tipi' => $tipi));
                }
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Questa funzione serve per eliminare un negozio
         */
        public function eliminaNegozio(){
            if($this->isLogged() == 2){
                parent::getModel("negozio_model.php");
                $model = new NegozioModel();
                try{
                    $idNeg = $model->rimuoviNegozio();
                    Log::writeLog("Negozio ".$idNeg." rimosso");
                    $this->locate('negozio');
                }catch(Exception $e){
                    $tipi = $model->ottieniTipi();
                    Log::writeErrorLog("Errore durante l'eliminazione di un negozio: ".$e->getMessage());
                    $this->view->render('gestioneNegozi/rimuoviNegozio.php', false, array('error' => $e->getMessage(), 'tipi' => $tipi));
                }
            }else{
                $this->view->render('login/index.php');
            }
        }
        
        /**
         * Questa funzione serve per modificare un negozio
         */
        public function modificaNegozio(){
            if($this->isLogged() == 2){
                parent::getModel("negozio_model.php");
                $model = new NegozioModel();
                try{   
                    $nm = $model->modificaNegozio();
                    Log::writeLog("Negozio ".$nm." modificato");
                    $this->locate('negozio');
                }catch(Exception $e){
                    $tipi = $model->ottieniTipi();
                    $negozi = $model->ottieniNegozi();
                    Log::writeErrorLog("Errore durante la modifica di un negozio: ".$e->getMessage());
                    $this->view->render('gestioneNegozi/modificaNegozio.php', false, array('negozi' => $negozi, 'tipi' => $tipi, 'error' => $e->getMessage()));
                }
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Questa funzone serve per visualizzare la
         * lista di orari disponibili del negozio e
         * per vedere gli orari che il negozio usa
         * attualmente 
         */
        public function impostaOrario(){
            if($this->isLogged() == 2){
                $_SESSION['negozio_id'] = $_POST['negozio'];
                parent::getModel("orario_model.php");
                $model = new OrarioModel();
                $this->view->render("gestioneNegozi/impostaOrario.php", false, array('orari' => json_encode($model->ottieniOrariCompleti()), 'uso' => json_encode($model->ottieniOrariInUso())));
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Questa funzione serve per impostare il negozio
         * di cui si vuole modificare l'orario
         */
        public function impostaNegozio(){
            if($this->isLogged() == 2){
                parent::getModel('negozio_model.php');
                $model = new NegozioModel();
                $this->view->render('gestioneNegozi/negozio.php', false, array('negozi' => $model->ottieniNegozi()));
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Questa funzione serve per salvare gli orari modificati
         */
        public function salvaOrario(){
            if($this->isLogged() == 2){
                parent::getModel('negozio_model.php');
                $model = new NegozioModel();
                $orari = $model->ottieniOrari($_POST);
                $model->salva($_POST);
                $this->locate('negozio');
            }else{
                $this->view->render('login/index.php');
            }
        }
    }
?>