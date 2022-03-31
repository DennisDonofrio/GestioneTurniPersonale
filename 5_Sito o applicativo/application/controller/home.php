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
    }
?>