<?php

    class GestioneTipi extends Controller
    {
        /**
		 * Carica la pagina home degli utenti
		 */
        public function index()
        {
            if(isset($_SESSION['role']))
                $this->view->render('gestioneTipi/index.php');
            else
                $this->view->render('login/index.php');
        }

        public function aggiungiTipo(){
            if(isset($_POST['aggiungi'])){
                require 'application/models/tipi_model.php';
                $model = new TipiModel();
                try{
                    $nm = $model->aggiungi();
                    $this->writeLog("Tipo ".$em." aggiunto");
                    $this->view->locate("gestioneDatori/index");
                }catch(Exception $e){
                    $this->writeErrorLog("Errore nell'aggiunta di un datore: ".$e->getMessage());
                    $this->view->error = $e->getMessage();
                }
            }else{
                $this->view->render("gestioneTipi/aggiungi.php");
            }
            
        }
    }
?>