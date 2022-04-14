<?php

    class Calendario extends Controller{

        /**
         * Questa funzione fa in modo che l'utente venga
         * trasportato nella pagina per selezionare
         * il negozio di cui si vuole visualizzare
         * l'orario
         */
        public function index(){
            parent::getModel('negozio_model.php');
            $model = new NegozioModel();
            $this->view->render('calendario/negozio.php', false, array('negozi' => $model->ottieniNegozi()));
        }

        /**
         * Questa funzione imposta la variabile di sessione
         * negozio_id in modo che contenga l'id del negozio
         * di cui si vuole vedere l'orario e sposta l'utente 
         * nella pagina del calendario
         */
        public function impostaNegozio(){
            $_SESSION['negozio_id'] = $_POST['negozio'];
            parent::getModel('orario_model.php');
            $model = new OrarioModel();
            $this->view->render("calendario/index.php", false, array('dipendenti' => $model->ottieniDipendentiDiDatore()));
        }

        /**
         * Questa funzione serve per ottenere tutti gli
         * eventi in in certo range.
         * Questo range viene specificato nell'url
         * tramite le variabili start e end
         */
        public function ottieniEventi(){
            parent::getModel('orario_model.php');
            $inizio = $_GET['start'];
            $fine = $_GET['end'];
            $model = new OrarioModel();
            $json = json_encode($model->ottieniEventiInRange($inizio, $fine));
            return $json;
        }

        /**
         * Questa funzione salva gli eventi che cambiano 
         * nel calendario all'interno del database
         */
        public function salva(){
            $data = json_decode($_POST['data'], true);
            
            $range = json_decode($data['range'], true);
            $events = json_decode($data['events'], true);
            parent::getModel('orario_model.php');
            $model = new OrarioModel();
            echo json_encode(array("status" => $model->salva($range, $events)));
        }

    }

?>