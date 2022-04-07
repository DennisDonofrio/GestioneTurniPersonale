<?php

    class Calendario extends Controller{

        public function index(){
            parent::getModel('negozio_model.php');
            $model = new NegozioModel();
            $this->view->render('calendario/negozio.php', false, array('negozi' => $model->ottieniNegozi()));
        }

        public function impostaNegozio(){
            $_SESSION['negozio_id'] = $_POST['negozio'];
            parent::getModel('orario_model.php');
            $model = new OrarioModel();
            $this->view->render("calendario/index.php", false, array('dipendenti' => $model->ottieniDipendentiDiDatore()));
            $inizio = new DateTime('2000-01-01');
            $fine = new DateTime('2030-01-01');
        }

        public function ottieniEventi(){
            parent::getModel('orario_model.php');
            $inizio = $_GET['start'];
            $fine = $_GET['end'];
            $model = new OrarioModel();
            $json = json_encode($model->ottieniEventiInRange($inizio, $fine));
            echo $json;
            return $json;
        }

        public function ottieniEventiDipendente($id){
            parent::getModel('orario_model.php');
            $inizio = $_GET['start'];
            $fine = $_GET['end'];
            $model = new OrarioModel();
            $json = json_encode($model->ottieniEventiInRangeDipendente($inizio, $fine, $id));
            echo $json;
            return $json;
        }

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