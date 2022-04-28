<?php


class Mail extends Controller{

    /**
     * Questo metodo invoca il metodo del model per inviare l'email ad un dipendente
     */
    public function invia(){
        parent::getModel('email_model.php');
        $model = new EmailModel();
        $model->inviaEmailANegozio();
    }

    /**
     * Mostra l'email che vine inviata
     */
    public function visualizza(){
        $this->view->render('email/index.php', true);
    }

}
