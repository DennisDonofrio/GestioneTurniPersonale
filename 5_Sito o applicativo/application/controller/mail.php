<?php


class Mail extends Controller{

    public function invia(){
        parent::getModel('email_model.php');
        $model = new EmailModel();
        $model->inviaEmailANegozio();
        echo "Email inviate";
    }

    public function visualizza(){
        $this->view->render('email/index.php', true);
    }

}
