<?php

class DipendenteModel{
    
    public function ottieniDipendenti(){
        require 'application/libs/connection.php';
        $query = "select di.id, di.nome , di.cognome, di.email, di.indirizzo 
        from dipendente di where di.datore_id = " . $_SESSION['id'];
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

    public function ottieniDipendente($id){
        require 'application/libs/connection.php';
        $query = "select di.id, di.nome , di.cognome, di.email, di.indirizzo 
        from dipendente di where di.id = " . $id;
        $result = $conn->query($query);
        $data = array();
        if ($result->num_rows > 0) {
            while($data[] = $result->fetch_assoc()){}
            return $data;
        }
        return false;
    }

    public function aggiungiDipendente($nome, $cognome, $email, $indirizzo, $pass){
        require 'application/libs/connection.php';
        require 'application/libs/hash.php';
        if(!empty($nome) && !empty($cognome) && !empty($email) && !empty($indirizzo) && !empty($pass)){
            $hp = new Hash($pass);
			$hp->doHash($email);
			$hash_password = $hp->getHashed();
            echo $email . " " . $pass . " " . $hash_password;
            $query = "INSERT INTO dipendente(nome, cognome, indirizzo, email, hash_password, archiviato, datore_id) VALUES ('$nome', '$cognome', '$indirizzo', '$email', '$hash_password', 0, " . $_SESSION['id'] . ")";
            /*$result = $conn->query($query);
            if ($result) {
                return TRUE;
            }*/
        }
        return FALSE;
    }

    public function rimuoviDipendente($id){
        require 'application/libs/connection.php';
        $query = "DELETE FROM dipendente WHERE id = " . $id;
        echo $query;
        $conn->query($query);
        return true;
    }

    public function modificaDipendente($id, $nome, $cognome, $indirizzo, $email, $pass){
        require 'application/libs/connection.php';
        require 'application/libs/hash.php';
        if(!empty($id) && !empty($nome) && !empty($indirizzo) && !empty($cognome) && !empty($email) && !empty($pass)){
            $hp = new Hash($pass);
			$hp->doHash($email);
			$hash_password = $hp->getHashed();
            $query = "UPDATE dipendente SET nome = '$nome', indirizzo = '$indirizzo', cognome = '$cognome', email = '$email', hash_password = '$hash_password'  WHERE id = $id";
            $result = $conn->query($query);
            if ($result) {
                return TRUE;
            }
        }
        return FALSE;
    }

}

?>