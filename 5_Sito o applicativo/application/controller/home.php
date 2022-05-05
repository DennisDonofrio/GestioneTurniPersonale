<?php

    class Home extends Controller
    {
        /**
		 * Carica la pagina home degli utenti
		 */
        public function index()
        {
            if(isset($_SESSION['role'])){
                if($_SESSION['role'] == 1){
                    parent::getModel('negozio_model.php');
                    $model = new NegozioModel();
                    $this->view->render('home/negozio.php', false, array('negozi' => $model->ottieniNegoziDipendente($_SESSION['id'])));
                }else{
                    $this->view->render('home/index.php');
                }
            }else{
                $this->view->render('login/index.php');
            }
        }

        public function negozio(){
            $this->view->render('home/negozio.php');
        }

        public function dipendente(){
            $_SESSION['negozio_id'] = $_POST['negozio'];
            $this->view->render('home/homeDipendente.php');
        }
    }
?>