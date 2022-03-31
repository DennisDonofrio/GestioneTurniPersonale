<?php

    class Home extends Controller
    {
        public function index()
        {
            if(isset($_SESSION['role']))
                $this->view->render('home/index.php');
            else
                $this->view->render('login/index.php');
        }

        /*public function load(){
            if(isset($_POST['calendario'])){
                //$this->view->render('gestioneNegozi/aggiungiNegozio.php');
            }else if(isset($_POST['gestisciDipendenti'])){
                $this->locate('dipendente');
            }else if(isset($_POST['gestisciNegozi'])){
                $this->locate('negozio');
            }else if(isset($_POST['gestisciOrari'])){
                $this->view->render('gestioneOrari/index.php');
            }else if(isset($_POST['gestioneDatori'])){
                $this->locate('gestioneDatori');
            }
        }*/
    }
?>