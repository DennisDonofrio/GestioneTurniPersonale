<?php


class Home extends Controller
{

    public function index()
    {
      $this->view->render('Home/index.php');
    }

    public function load(){
      if(isset($_POST['calendario'])){
          //$this->view->render('gestioneNegozi/aggiungiNegozio.php');
      }else if(isset($_POST['gestisciDipendenti'])){
          //$this->view->render('gestioneNegozi/rimuoviNegozio.php');
      }else if(isset($_POST['gestisciNegozi'])){
          $this->locate('negozio');
      }else if(isset($_POST['gestisciOrari'])){
          //$this->view->render('gestioneNegozi/mostraNegozi.php');
      }
  }
}
