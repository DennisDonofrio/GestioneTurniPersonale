<?php

    class Negozio extends Controller{

        /**
         * Questa funzione controlla che l'utente sia un datore.
         */
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

        /**
         * Questa funzione serve per preparare il model
         * ritorna il model
         */
        public function prepara(){
            parent::getModel('negozio_model.php');
            return new NegozioModel();
        }

        /**
         * Questa funzione serve per ottenere i tipi da 
         * visualizzare in una select per la pagina aggiungi
         */
        public function aggiungi(){
            $model = $this->prepara();
            $tipi = $model->ottieniTipi();
            $this->view->render('gestioneNegozi/aggiungiNegozio.php', false, array('tipi' => $tipi));
        }

        /**
         * Questa funzione serve per ottenere i tipi e il negozio da 
         * visualizzare in una select per la pagina modifica
         */
        public function modifica(){
            $model = $this->prepara();
            $negozi = $model->ottieniNegozi();
            $tipi = $model->ottieniTipi();
            $this->view->render('gestioneNegozi/modificaNegozio.php', false, array('negozi' => $negozi, 'tipi' => $tipi));
        }

        /**
         * Questa funzione serve per ottenere i tipi da 
         * visualizzare in una select per la pagina rimuovi
         */
        public function rimuovi(){
            $model = $this->prepara();
            $negozi = $model->mostraNegozi();
            $this->view->render('gestioneNegozi/rimuoviNegozio.php', false, array('negozi' => $negozi));
        }

        /**
         * Questa funzione serve per mostrare tutti i negozi di un datore
         */
        public function mostra(){
            $model = $this->prepara();
            $result = $model->mostraNegozi();
            $this->view->render("gestioneNegozi/mostraNegozi.php", false, array('negozi' => $result));
        }

        /**
         * Questa funzione serve per aggiungere un negozio
         */
        public function aggiungiNegozio(){
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
        }

        /**
         * Questa funzione serve per eliminare un negozio
         */
        public function eliminaNegozio(){
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
            
        }
        
        /**
         * Questa funzione serve per modificare un negozio
         */
        public function modificaNegozio(){
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
        }

        /**
         * Questa funzone serve per visualizzare la
         * lista di orari disponibili del negozio e
         * per vedere gli orari che il negozio usa
         * attualmente 
         */
        public function impostaOrario(){
            $_SESSION['negozio_id'] = $_POST['negozio'];
            parent::getModel("orario_model.php");
            $model = new OrarioModel();
            $this->view->render("gestioneNegozi/impostaOrario.php", false, array('orari' => json_encode($model->ottieniOrariCompleti()), 'uso' => json_encode($model->ottieniOrariInUso())));
        }

        /**
         * Questa funzione serve per impostare il negozio
         * di cui si vuole modificare l'orario
         */
        public function impostaNegozio(){
            parent::getModel('negozio_model.php');
            $model = new NegozioModel();
            $this->view->render('gestioneNegozi/negozio.php', false, array('negozi' => $model->ottieniNegozi()));
        }

        /**
         * Questa funzione serve per salvare gli orari modificati
         */
        public function salvaOrario(){
            parent::getModel('negozio_model.php');
            $model = new NegozioModel();
            $orari = $model->ottieniOrari($_POST);
            $model->salva($_POST);
            $this->locate('negozio');
            //var_dump($orari);
            //$this->view->render('gestioneNegozi/negozio.php', false, array('negozi' => $model->ottieniNegozi()));
        }
        

    }
?>