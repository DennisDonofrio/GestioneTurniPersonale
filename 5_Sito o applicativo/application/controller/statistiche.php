<?php

class Statistiche extends Controller{

    /**
     * Questa funzione viene richiamata per aprire la pagina
     * base delle statistiche.
     */
    public function index(){
        if($this->isLogged() == 2){
            $this->view->render('statistiche/index.php');
        }else{
            $this->view->render('login/index.php');
        }
    }

    /**
     * Questa funzione elabora i dati ricevuti dal post.
     * Questi dati sono le date di inizio e fine del range.
     * Vengono prese tutte le ore in programma del suddetto range
     * e vengono raggruppate per dipendente e giorno (feriale o festivo).
     * Vengono direttamente passati alla view gli output.
     */
    public function stampa(){
        if($this->isLogged() == 2){
            if(!empty($_POST['inizio']) && !empty($_POST['fine'])){
                parent::getModel('orario_model.php');
                $model = new OrarioModel();
                //$id = $_SESSION['id'];
                $inizio = AntiCsScript::check($_POST['inizio']) . "T00.00.00";
                $fine = AntiCsScript::check($_POST['fine']) . "T00.00.00";

                $dipendenti = $model->ottieniDipendentiDiDatore();
                $dipOre = array();
                for($i = 0; $i < count($dipendenti); $i++){
                    $data = $model->ottieniEventiInRangeDipendente($inizio, $fine, $dipendenti[$i]['id']);
                    $giorni = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0);
                    if($data != null){
                        $ore = 0;
                        for($j = 0; $j < count($data); $j++){
                            $a = $this->estraiTempo($data[$j]['start'], $data[$j]['end']);
                            $day = date('w', strtotime($a[1]));
                            ($day == 0 ? $day = 7 : $day = $day);
                            $giorni[$day] += intval($a[0]);
                        }
                        
                    }else{
                        echo $dipendenti[$i]['id'] . " non e accessibile";
                    }
                    $dipOre[] = array_merge(array('(' . $dipendenti[$i]['id'] . ') ' . $dipendenti[$i]['nome']), $giorni);
                }

                $fin = $this->settimanaInFerialiFestivi($dipOre);
                $this->view->render('statistiche/statistiche.php', false, array('dati' => $fin));
            }else{
                $this->view->error = "Completare tutti i campi";
                $this->index();
            }
        }else{
            $this->view->render('login/index.php');
        }
    }

    /**
     * Questa funzione riceve come parametro due date
     * e calcola la distanza in ore tra le due.
     * @param start contiene la data di inizio.
     * @param end contiene la data di fine.
     * @return array contine alla posizione 0 la differenza in ore
     * e alla posizione 1 contiene la data $start.
     */
    public function estraiTempo($start, $end){
        //2022-12-12T00.00.0000+02:00
        if($this->isLogged() == 2){
            $dateStart = date_create(str_replace("T", " ", $start));
            $dateEnd = date_create(str_replace("T", " ", $end));
            $diff = date_diff($dateEnd, $dateStart);
            $array = array();
            $array[] = $diff->format('%h');
            $array[] = $dateStart->format('Y-m-d');
            return $array;
        }else{
            $this->view->render('login/index.php');
        }
    }

    /**
     * Questa funzione riceve come parametro una matrice contenente
     * il numero di ore che deve fare un dipendente per ogni giorno
     * di una settimana.
     * @param dipOre contiene la matrice con le ore ed i dipendenti.
     * @return out contiene la matrice con i dipendenti e le ore programmate
     * per loro. Le ore sono raggruppate per giorni feriali e festivi.
     */
    public function settimanaInFerialiFestivi($dipOre){
        if($this->isLogged() == 2){
            $out = array();
            for ($i=0; $i < count($dipOre); $i++) {
                $ferialiFestivi = array(0 => '', 1 => 0, 2 => 0, 3 => 0);
                $ferialiFestivi[0] = $dipOre[$i][0];
                for ($j=1; $j < 6; $j++) {
                    $ferialiFestivi[1] += $dipOre[$i][$j];
                }
                for ($j=6; $j < 8; $j++) {
                    $ferialiFestivi[2] += $dipOre[$i][$j];
                }
                $ferialiFestivi[3] = $ferialiFestivi[1] + $ferialiFestivi[2];
                $out[] = $ferialiFestivi;
            }
            return $out;
        }else{
            $this->view->render('login/index.php');
        }
    }
}