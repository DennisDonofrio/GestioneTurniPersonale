<?php

    class GestioneTipi extends Controller
    {
        /**
		 * Carica la pagina home degli utenti
		 */
        public function index()
        {
            if($this->isLogged() == 3){
                $this->view->render('gestioneTipi/index.php');
            }else{
                $this->view->render('login/index.php');
            } 
        }

        /**
		 * Aggiunge un nuovo tipo se i requisiti sono giusti
		 */
        public function aggiungiTipo(){
            if($this->isLogged() == 3){
                if(isset($_POST['aggiungi'])){
                    require 'application/models/tipi_model.php';
                    $model = new TipiModel();
                    try{
                        $nm = $model->aggiungi();
                        Log::writeLog("Tipo ".$nm." aggiunto");
                        $this->view->locate("gestioneTipi/index");
                    }catch(Exception $e){
                        Log::writeErrorLog("Errore nell'aggiunta di un tipo: ".$e->getMessage());
                        $this->view->render("gestioneTipi/aggiungi.php",  false, array('error' => $e->getMessage()));
                    }
                }else{
                    $this->view->render("gestioneTipi/aggiungi.php");
                }
            }else{
                $this->view->render('login/index.php');
            }       
        }

        /**
		 * Mostra tutti i tipi di negozi
		 */
        public function mostra(){
            if($this->isLogged() == 3){
                require 'application/models/tipi_model.php';
                $model = new TipiModel();
                $dati = $model->ottieniTipi();
                $this->view->render("gestioneTipi/mostra.php", false, array('tipi' => $dati));
            }else{
                $this->view->render('login/index.php');
            }
        }
    }
?>