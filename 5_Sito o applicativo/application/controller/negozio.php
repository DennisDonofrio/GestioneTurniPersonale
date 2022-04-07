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
            $nome = $_POST['nome'];
            $indirizzo = $_POST['indirizzo'];
            $tipo = $_POST['tipo'];
            if($model->aggiungiNegozio($nome, $indirizzo, $tipo)){
                $this->locate('negozio');
            }else{
                $tipi = $model->ottieniTipi();
                $this->view->render('gestioneNegozi/aggiungiNegozio.php',  false, array('error' => "Non è stato possibile inserire il negozio", 'tipi' => $tipi));
            }
        }

        /**
         * Questa funzione serve per eliminare un negozio
         */
        public function eliminaNegozio(){
            parent::getModel("negozio_model.php");
            $model = new NegozioModel();
            $id = $_POST['negozio'];
            echo $id;
            $model->rimuoviNegozio($id);
            $this->locate('negozio');
        }
        
        /**
         * Questa funzione serve per modificare un negozio
         */
        public function modificaNegozio(){
            parent::getModel("negozio_model.php");
            $model = new NegozioModel();
            $nome = $_POST['nome'];
            $indirizzo = $_POST['indirizzo'];
            $tipo = $_POST['tipo'];
            $idNegozio = $_POST['negozio'];
            if($model->modificaNegozio($idNegozio, $nome, $indirizzo, $tipo)){
                $this->locate('negozio');
            }else{
                $tipi = $model->ottieniTipi();
                $negozi = $model->ottieniNegozi();
                $this->view->render('gestioneNegozi/modificaNegozio.php', false, array('negozi' => $negozi, 'tipi' => $tipi, 'error' => "Non è stato possibile modificare il negozio"));
            }
        }

    }
?>