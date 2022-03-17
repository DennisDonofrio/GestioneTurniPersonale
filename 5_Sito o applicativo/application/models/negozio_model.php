<?php

class NegozioModel{

    

    public function aggiungiNegozio($nome, $indirizzo, $tipo){
        require 'application/libs/connection.php';
        if(!empty($nome) && !empty($indirizzo) && !empty($tipo)){
            $sql = $conn->prepare("INSERT INTO negozio(nome, indirizzo, archiviato, tipo_id, datore_id) VALUES (?, ?, FALSE, ?, ?)");
            $nome = AntiCsScript::check($nome);
            $indirizzo = AntiCsScript::check($indirizzo);
            $sql->bind_param("ssii", $nome, $indirizzo, AntiCsScript::check($tipo), AntiCsScript::check($_SESSION['id']));
            $result = $sql->execute();
            if ($result) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function ottieniTipi(){
        require 'application/libs/connection.php';
        $query = "SELECT nome, id FROM tipo WHERE archiviato = 0";
        $conn->query($query);
        $result = $conn->query($query);
        $data = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function ottieniNegozi(){
        require 'application/libs/connection.php';
        $query = "SELECT nome, id FROM negozio WHERE archiviato = 0";
        $result = $conn->query($query);
        $data = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function mostraNegozi(){
        require 'application/libs/connection.php';
        $query = "SELECT n.id, n.nome, n.indirizzo, t.nome AS 'tipo' FROM negozio n INNER JOIN tipo t ON t.id = n.tipo_id WHERE n.archiviato = 0 AND n.datore_id = " . $_SESSION['id'];
        $result = $conn->query($query);
        $data = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function rimuoviNegozio($id){
        require 'application/libs/connection.php';
        $sql = $conn->prepare("UPDATE negozio SET archiviato=1 WHERE id =?");
        $sql->bind_param("i", AntiCsScript::check($id));
        $result = $sql->execute();
        return true;
    }

    public function modificaNegozio($id, $nome, $indirizzo, $tipo){
        require 'application/libs/connection.php';
        if(!empty($id) && !empty($nome) && !empty($indirizzo) && !empty($tipo)){
            $query = "UPDATE negozio SET nome = '$nome', indirizzo = '$indirizzo', tipo_id = $tipo WHERE id = $id";
            $result = $conn->query($query);
            $nome = AntiCsScript::check($nome);
            $indirizzo = AntiCsScript::check($indirizzo);
            $sql = $conn->prepare("UPDATE negozio SET nome = ?, indirizzo = ?, tipo_id = ? WHERE id = ?");
            $sql->bind_param("ssii", $nome, $indirizzo, AntiCsScript::check($tipo), AntiCsScript::check($id));
            if ($sql->execute()) {
                return TRUE;
            }
        }
        return FALSE;
    }
}
?>