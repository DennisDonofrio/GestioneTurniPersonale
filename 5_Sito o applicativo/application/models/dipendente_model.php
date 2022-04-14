<?php

class DipendenteModel{
    
    /**
     * Torna tutte le informazioni dei dipendenti di un determinato negozio
     */
    public function ottieniDipendenti(){
        require 'application/libs/connection.php';
        $query = "SELECT di.id, di.nome , di.cognome, di.email, di.indirizzo 
        FROM dipendente di WHERE di.archiviato = 0 AND di.datore_id = " . $_SESSION['id'];
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

    /**
     * Torna le informazioni di un dipendente che ha un determinato id
     * 
     * @param Int $id -> l'id del dipendente da cercare
     */
    public function ottieniDipendente($id){
        require 'application/libs/connection.php';
        $sql = $conn->prepare("SELECT di.id, di.nome , di.cognome, di.email, di.indirizzo FROM dipendente di WHERE di.id = ? AND archiviato = 0");
        $idChecked = AntiCsScript::check($id);
        $sql->bind_param("i", $idChecked);
        $sql->execute();
        $result = $sql->get_result();
        $data = array();
        if ($result->num_rows > 0) {
            while($data[] = $result->fetch_assoc()){}
            return $data;
        }
        return false;
    }

    /**
     * Aggiunge un nuovo dipendente con le relative informazioni
     */
    public function aggiungiDipendente(){
        require 'application/libs/connection.php';
        if(!empty($_POST['nome']) && !empty($_POST['cognome']) && !empty($_POST['email']) 
        && !empty($_POST['password1']) && !empty($_POST['password2']) && !empty($_POST['indirizzo'])){
            require 'application/libs/hash.php';
            require 'application/libs/email.php';
            require 'application/libs/password.php';
            $nome = AntiCsScript::check($_POST['nome']);
            $cognome = AntiCsScript::check($_POST['cognome']);
            $email = AntiCsScript::check($_POST['email']);
            $pass1 = AntiCsScript::check($_POST['password1']);
            $pass2 = AntiCsScript::check($_POST['password2']);
            $indirizzo = AntiCsScript::check($_POST['indirizzo']);
            $emailUser = new Email($email);
            if($emailUser->isValid()){
                if($pass1 == $pass2){
                    $passUser = new Password($pass1);
                    if($passUser->isValid()){
                        $hp = new Hash($pass1);
                        $hp->doHash($email);
                        $hash_password = $hp->getHashed();
                        $sql = $conn->prepare("INSERT INTO dipendente(nome, cognome, indirizzo, email, hash_password, archiviato, datore_id) VALUES (?, ?, ?, ?, ?, 0, ?)");
                        $sql->bind_param("sssssi",$nome, $cognome, $indirizzo, $email, $hash_password, $_SESSION['id']);
                        $result = $sql->execute();
                        return $email;
                    }else{
                        throw new Exception("La password deve contenere almeno:<br>- 8 Caratteri<br>-1 Maiuscola<br>-1 Minuscola<br>-1 Cifra<br>-1 Carattere speciale");
                    }
                }else{
                    throw new Exception("Le due password inserite non corrispondono");
                }
            }
        }else{
            throw new Exception("Completare tutti i campi");
        }
    }

    /**
     * Rimuove un dipendete che ha un determinato id
     * 
     * @param Int $id -> l'id del dipendente da eliminare
     */
    public function rimuoviDipendente($id){
        require 'application/libs/connection.php';
        $sql = $conn->prepare("UPDATE dipendente SET archiviato = 1 WHERE id = ?");
        $sql->bind_param("i", AntiCsScript::check($id));
        $result = $sql->execute();
        if($result){
            return $email;
        }else{
            throw new Exception("Non è stato possibile rimuovere il dipendente");
        }
    }

    /**
     * Modifica un dipendente con le nuove informazioni passate
     */
    public function modificaDipendente(){
        require 'application/libs/connection.php';
        if(!empty($_POST['dipendente']) && !empty($_POST['nome']) && !empty($_POST['cognome']) 
        && !empty($_POST['email']) && !empty($_POST['password1']) 
        && !empty($_POST['password2']) && !empty($_POST['indirizzo'])){
            require 'application/libs/hash.php';
            require 'application/libs/email.php';
            require 'application/libs/password.php';
            $id =AntiCsScript::check($_POST['dipendente']);
            $nome = AntiCsScript::check($_POST['nome']);
            $cognome = AntiCsScript::check($_POST['cognome']);
            $email = AntiCsScript::check($_POST['email']);
            $pass1 = AntiCsScript::check($_POST['password1']);
            $pass2 = AntiCsScript::check($_POST['password2']);
            $indirizzo = AntiCsScript::check($_POST['indirizzo']);
            $emailUser = new Email($this->email);
            if(!$emailUser->isOldEmail($this->id, TRUE)){
                $emailUser->isValid();
            }
            if($pass1 == $pass2){
                $passUser = new Password($pass1);
                if($passUser->isValid()){
                    $hp = new Hash($pass1);
                    $hp->doHash($email);
                    $hash_password = $hp->getHashed();
                    $sql = $conn->prepare("UPDATE dipendente SET nome = ?, cognome = ?, indirizzo = ?, email = ?, hash_password = ?  WHERE archiviato = 0 AND id = ?");
                    $sql->bind_param("sssssi", $nome, $cognome, $indirizzo, $email, $hash_password, $id);
                    $result = $sql->execute();
                    return $email;
                }else{
                    throw new Exception("La password deve contenere almeno:<br>- 8 Caratteri<br>-1 Maiuscola<br>-1 Minuscola<br>-1 Cifra<br>-1 Carattere speciale");
                }
            }else{
                throw new Exception("Le due password non corrispondono");
            }
        }else{
            throw new Exception("Completare tutti i campi");
        }
    }
}

?>