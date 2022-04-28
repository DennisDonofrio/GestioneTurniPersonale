<?php

    class Calendario extends Controller{

        /**
         * Questa funzione fa in modo che l'utente venga
         * trasportato nella pagina per selezionare
         * il negozio di cui si vuole visualizzare
         * l'orario
         */
        public function index(){
            if($this->isLogged() == 2){
                parent::getModel('negozio_model.php');
                $model = new NegozioModel();
                $this->view->render('calendario/negozio.php', false, array('negozi' => $model->ottieniNegozi()));
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Questa funzione imposta la variabile di sessione
         * negozio_id in modo che contenga l'id del negozio
         * di cui si vuole vedere l'orario e sposta l'utente 
         * nella pagina del calendario
         */
        public function impostaNegozio(){
            if($this->isLogged() == 2){
                $_SESSION['negozio_id'] = $_POST['negozio'];
                parent::getModel('orario_model.php');
                $model = new OrarioModel();
                $this->view->render("calendario/index.php", false, array('dipendenti' => $model->ottieniDipendentiDiDatore()));
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Questa funzione serve per ottenere tutti gli
         * eventi in in certo range.
         * Questo range viene specificato nell'url
         * tramite le variabili start e end
         */
        public function ottieniEventi(){
            if($this->isLogged() == 1 || $this->isLogged() == 2){
                parent::getModel('orario_model.php');
                $inizio = $_GET['start'];
                $fine = $_GET['end'];
                $model = new OrarioModel();
                $json = json_encode($model->ottieniEventiInRange($inizio, $fine));
                echo $json;
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Questa funzione serve per ottenere tutti gli
         * eventi in un certo range di un dipendente.
         * Questo range ed il dipendente vengono specificati nell'url
         * tramite le variabili start e end
         */
        public function ottieniEventiDipendente($id){
            if($this->isLogged() == 1 || $this->isLogged() == 2){
                parent::getModel('orario_model.php');
                $inizio = $_GET['start'];
                $fine = $_GET['end'];
                $model = new OrarioModel();
                $json = json_encode($model->ottieniEventiInRangeDipendente($inizio, $fine, $id));
                return $json;
            }else{
                $this->view->render('login/index.php');
            }
        }

        /**
         * Questa funzione salva gli eventi che cambiano 
         * nel calendario all'interno del database
         */
        public function salva(){
            if($this->isLogged() == 2){
                $data = json_decode($_POST['data'], true);
                $range = json_decode($data['range'], true);
                $events = json_decode($data['events'], true);
                parent::getModel('orario_model.php');
                $model = new OrarioModel();
            }else{
                $this->view->render('login/index.php');
            }
        }
    }

?>
