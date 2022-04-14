<?php

class Statistiche extends Controller{

    public function index(){
        $this->view->render('statistiche/index.php');
    }

    public function stampa(){
        if(isset($_POST['inizio']) && isset($_POST['fine'])){
            parent::getModel('orario_model.php');
            $model = new OrarioModel();
            $id = $_SESSION['id'];
            $inizio = AntiCsScript::check($_POST['inizio']) . "T00.00.00";
            $fine = AntiCsScript::check($_POST['fine']) . "T00.00.00";

            $dipendenti = $model->ottieniDipendentiDiDatore();
            for($i = 0; $i < count($dipendenti); $i++){
                $data = $model->ottieniEventiInRangeDipendente($inizio, $fine, $dipendenti[$i]['id']);
                $array = array();
                if($data != null){
                    for($j = 0; $j < count($data); $j++){
                        //$array[$data[$i]['title']] += $this->estraiTempo($data[$i]['start'], $data[$i]['end']);
                        $this->estraiTempo($data[$j]['start'], $data[$j]['end']);
                    }
                }
                echo "<br>";
                //var_dump($data);
            }
        }else{

        }
        
        //$this->view->render('statistiche/index.php', false, array('negozi' => $model->ottieniNegoziDipendente($_SESSION['id'])));
    }

    public function estraiTempo($start, $end){
        //2022-12-12T00.00.0000+02:00
        $dataStart = explode("T", $start)[0];
        $oraStart = explode("T", $start)[1];
        $dataStart = explode("-", $dataStart)[2];
        $dataEnd = explode("T", $start)[0];
        $oraEnd = explode("T", $start)[1];
        $dataEnd = explode("-", $dataEnd)[2];
        $dateStart = date_create(str_replace("T", " ", $start));
        $dateEnd = date_create(str_replace("T", " ", $end));
        $diff = date_diff($dateEnd, $dateStart);
        //return 1;
    }
}