<?php

class dipendente extends Controller{

    public function index(){
        $this->view->render('gestioneDipendenti/index.php');
    }

    public function load(){
        parent::getModel('dipendente_model.php');
        $model = new DipendenteModel();
        if(isset($_POST['aggiungiDipendente'])){
            $this->view->render('gestioneDipendenti/aggiungiDipendente.php');
        }else if(isset($_POST['mostraDipendenti'])){
            $dipendenti = $model->ottieniDipendenti();
            $this->view->render('gestioneDipendenti/mostraDipendenti.php', false, array('dipendenti' => $dipendenti));
        }else if(isset($_POST['modificaDipendente'])){
            $dipendenti = $model->ottieniDipendenti();
            $this->view->render('gestioneDipendenti/modificaDipendente.php', false, array('dipendenti' => $dipendenti));
        }else if(isset($_POST['rimuoviDipendente'])){
            $dipendenti = $model->ottieniDipendenti();
            $this->view->render('gestioneDipendenti/rimuoviDipendente.php', false, array('dipendenti' => $dipendenti));
        }
    }

    public function aggiungiDipendente(){
        parent::getModel("dipendente_model.php");
        $model = new DipendenteModel();
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $email = $_POST['email'];
        $password = $_POST['password1'];
        $password2 = $_POST['password2'];
        $indirizzo = $_POST['indirizzo'];
        if($password == $password2){
            if($model->aggiungiDipendente($nome, $cognome, $email, $indirizzo, $password)){
                $this->locate('dipendente');
            }else{
                $this->view->render('gestioneDipendenti/aggiungiDipendente.php',  false, array('error' => "Non è stato possibile aggiungere il dipendente"));
            }
        }else{
            $this->view->render('gestioneDipendenti/aggiungiDipendente.php',  false, array('error' => "Le password inserite non corrispondono"));
        }
    }

    public function rimuoviDipendente(){
        parent::getModel("dipendente_model.php");
        $model = new DipendenteModel();
        $id = $_POST['dipendente'];
        if($model->rimuoviDipendente($id)){
            $this->locate('dipendente');
        }else{
            $this->view->render('gestioneDipendenti/aggiungiDipendente.php',  false, array('error' => "Non è stato possibile rimuovere il dipendente"));
        }
    }

    public function modificaDipendente(){
        parent::getModel("dipendente_model.php");
        $model = new DipendenteModel();
        $id = $_POST['dipendente'];
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $indirizzo = $_POST['indirizzo'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        if(isset($_POST['modifica'])){
            if($password == $password2){
                if($model->modificaDipendente($id, $nome, $cognome, $indirizzo, $email, $password)){
                    $this->locate('dipendente');
                }else{
                    $dipendenti = $model->ottieniDipendenti();
                    $this->view->render('gestioneDipendenti/modificaDipendente.php',  false, array('error' => "Non è stato possibile modificare il dipendente", 'dipendenti' => $dipendenti));
                }
            }else{
                $dipendenti = $model->ottieniDipendenti();
                $this->view->render('gestioneDipendenti/modificaDipendente.php',  false, array('error' => "Le password inserite non corrispondono", 'dipendenti' => $dipendenti));
            }
        }else if(isset($_POST['riempi'])){
            $dipendenti = $model->ottieniDipendenti();
            $this->view->render('gestioneDipendenti/modificaDipendente.php',  false, array('dipendenti' => $dipendenti, 'dipendente' => $model->ottieniDipendente($id)));
        }
        
    }

}

?>