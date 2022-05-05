<?php
    class GestioneTurni extends Controller
    {

        /**
         * Questa funzione serve per aggiungere dei nuovi orari
         * dei turni di lavoro
         */
        public function aggiungi(){
            parent::getModel("turno_model.php");
            parent::getModel("negozio_model.php");
            $model = new TurnoModel();
            $model2 = new NegozioModel();
            if(isset($_POST['aggiungi'])){
                try{
                    $model->aggiungiTurno();
                    Log::writeLog("Aggiunta di un nuovo turno");
                }catch(Exception $e){
                    $this->view->error = $e->getMessage();
                    Log::writeErrorLog($e->getMessage());
                }
            }
            $this->view->render("gestioneTurni/aggiungi.php", false, array("giorni" => $model->ottieniGiorni(), "negozi" => $model2->ottieniNegozi()));
        }

        /**
         * Questa funzione serve per eliminare un orario dal database
         */
        public function elimina(){
            if(isset($_POST['negozio'])){
                $_SESSION['negozio_id'] = AntiCsScript::check($_POST['negozio']);
            }
            parent::getModel("turno_model.php");
            $model = new TurnoModel();
            if(isset($_POST['elimina'])){
                try{
                    if($model->eliminaTurno()){
                        Log::writeLog("Eliminazione di un turno");
                        $this->view->render("home/index.php");
                    }else{
                        Log::writeErrorLog("Errore nell'eliminazione di un turno");
                        $this->view->render("gestioneTurni/elimina.php", false, array("turni" => $model->ottieniTurni(), "error" => "Non è possibile cancellare un turno in utilizzo"));
                    }
                }catch(Exception $e){
                    $this->view->error = $e->getMessage();
                    Log::writeLog($e->getMessage());
                }
            }else{
                $this->view->render("gestioneTurni/elimina.php", false, array("turni" => $model->ottieniTurni()));
            }
        }

        /**
         * Questa funzione serve per mostrare tutti
         * i turni di lavoro che vengono usati da
         * un certo negozio
         */
        public function mostra(){
            parent::getModel("turno_model.php");
            $model = new TurnoModel();
            $this->view->render("gestioneTurni/mostra.php", false, array('turni' => $model->mostraTurni()));
        }

        /**
         * Questa funzione serve per impostare il negozio del
         * quale si vuole eliminare un turno
         */
        public function scegliNegozio(){
            parent::getModel("negozio_model.php");
            $model = new NegozioModel();
            $this->view->render("gestioneTurni/negozio.php", false, array('negozi' => $model->mostraNegozi()));
        }
    }
?>