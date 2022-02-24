<?php


class Home extends Controller
{

    public function index()
    {
        if(isset($_SESSION['role']))
            $this->view->render('Home/index.php');
        else
            $this->view->render('Login/index.php');
    }

    public function load(){
        if(isset($_POST['calendario'])){
            parent::getModel('negozio_model.php');
            $model = new NegozioModel();
            $this->view->render('calendario/negozio.php', false, array('negozi' => $model->ottieniNegozi()));
        }else if(isset($_POST['gestisciDipendenti'])){
            $this->locate('dipendente');
        }else if(isset($_POST['gestisciNegozi'])){
            $this->locate('negozio');
        }else if(isset($_POST['gestisciOrari'])){
            $this->view->render('gestioneOrari/index.php');
        }else if(isset($_POST['gestioneDatori'])){
            $this->locate('gestioneDatori');
        }
  }
}
