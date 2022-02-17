<?php
    class GestioneDatori extends Controller
    {
        public function index()
        {
            $this->view->render('gestioneDatori/index');
        }

        public function action(){
            require 'application/models/datoreModel.php';
            $model = new DatoreModel();

            if(isset($_POST['aggiungi'])){
                $this->view->render("gestioneDatori/aggiungi");
            }else if(isset($_POST['modifica'])){
                $this->view->data = $model->ottieniTuttiDatori();
                $this->view->selected = $model->ottieniTuttiDatori()[0];
                $this->view->render("gestioneDatori/modifica");
            }else if(isset($_POST['rimuovi'])){
                $this->view->data = $model->ottieniTuttiDatoriEmail();
                $this->view->render("gestioneDatori/rimuovi");
            }else if(isset($_POST['mostra'])){
                $this->view->data = $model->ottieniTuttiDatoriCompleti();
                $this->view->template = array("id", "nome", "cognome", "email", "indirizzo", "archiviato");
                $this->view->render("gestioneDatori/mostra");
            }
        }

        public function modifica(){
            if(isset($_POST['modifica'])){
                require 'application/models/datoreModel.php';
                $model = new DatoreModel();
                try{
                    $model->modificaDatore();
                   
                }catch(Exception $e){
                    $this->view->error = $e->getMessage();
                }
                $this->view->data = $model->ottieniTuttiDatori();
                $this->view->selected = $model->ottieniDatiDatore($_POST['id']);
                $this->view->render("gestioneDatori/modifica");
            }else if(isset($_POST['datoreButton']) && isset($_POST['id'])){
                require 'application/models/datoreModel.php';
                $model = new DatoreModel();
                $this->view->data = $model->ottieniTuttiDatori();
                $this->view->selected = $model->ottieniDatiDatore($_POST['id']);
                $this->view->render("gestioneDatori/modifica");
            }
        }

        public function rimuovi(){
            if(isset($_POST['elimina'])){
                require 'application/models/datoreModel.php';
                $model = new DatoreModel();
                try{
                    $model->eliminaDatore();
                }catch(Exception $e){
                    $this->view->error = $e->getMessage();
                }
                $this->view->data = $model->ottieniTuttiDatoriEmail();
                $this->view->render("gestioneDatori/rimuovi");
            }
        }

        public function aggiungi(){
            if(isset($_POST['aggiungi'])){
                require 'application/models/datoreModel.php';
                $model = new DatoreModel();
                try{
                    $model->aggiungiDatore();
                    $this->view->locate("gestioneDatori/index");
                }catch(Exception $e){
                    $this->view->error = $e->getMessage();
                }
                $this->view->render("gestioneDatori/aggiungi");
            }
        }
    }
?>