<?php

class TipiModel{
    

    /**
     * Aggiunge un nuovo dipendente con le relative informazioni
     */
    public function aggiungi(){
        require 'application/libs/connection.php';
        if(!empty($_POST['nome']) && !empty($_POST['descrizione'])){
            $nome = AntiCsScript::check($_POST['nome']);
            $descrizione = AntiCsScript::check($_POST['descrizione']);
            $sql = $conn->prepare("INSERT INTO tipo(nome, descrizione) VALUES (?, ?)");
            $sql->bind_param("ss",$nome, $descrizione);
            $result = $sql->execute();
            if($result){
                return true;
            }  
            throw new Exception("Errore durante l'inserimento del nuovo tipo");
        }else{
            throw new Exception("Completare tutti i campi");
        }
    }
}

?>