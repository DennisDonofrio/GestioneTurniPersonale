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
                return $nome;
            }  
            throw new Exception("Errore durante l'inserimento del nuovo tipo");
        }else{
            throw new Exception("Completare tutti i campi");
        }
    }

     /**
     * Questa funzione serve per ottenere tutti i tipi
     */
    public function ottieniTipi(){
        require 'application/libs/connection.php';
        $query = "SELECT id, nome, descrizione FROM tipo";
        $conn->query($query);
        $result = $conn->query($query);
        if(!empty($result)){
            $data = array();
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
}

?>