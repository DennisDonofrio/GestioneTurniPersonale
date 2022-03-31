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
     * @param String $nome -> il nome del dipendente
     * @param String $cognome -> il cognome del dipendente
     * @param String $email -> l'email del dipendente
     * @param String $indirizzo -> l'indirizzo del dipendente
     * @param String $pass -> la password del dipendente
     */
    public function aggiungiDipendente($nome, $cognome, $email, $indirizzo, $pass){
        require 'application/libs/connection.php';
        require 'application/libs/hash.php';
        if(!empty($nome) && !empty($cognome) && !empty($email) && !empty($indirizzo) && !empty($pass)){
            $hp = new Hash($pass);
			$hp->doHash($email);
			$hash_password = $hp->getHashed();
            $sql = $conn->prepare("INSERT INTO dipendente(nome, cognome, indirizzo, email, hash_password, archiviato, datore_id) VALUES (?, ?, ?, ?, ?, 0, ?)");
            $nome = AntiCsScript::check($nome);
            $cognome = AntiCsScript::check($cognome);
            $indirizzo = AntiCsScript::check($indirizzo);
            $email = AntiCsScript::check($email);
            $hash_password = AntiCsScript::check($hash_password);
            $sql->bind_param("sssssi",$nome, $cognome, $indirizzo, $email, $hash_password, $_SESSION['id']);
            if($sql->execute()){
                return true;
            }
        }
        return FALSE;
    }

    /**
     * Rimuove un dipendete che ha un determinato id
     * @param Int $id -> l'id del dipendente da eliminare
     */
    public function rimuoviDipendente($id){
        require 'application/libs/connection.php';
        $sql = $conn->prepare("UPDATE dipendente SET archiviato = 1 WHERE id = ?");
        $sql->bind_param("i", AntiCsScript::check($id));
        $result = $sql->execute();
        return $result;
    }

    /**
     * Modifica un dipendente con le nuove informazioni passate
     * @param Int $id -> id del dipendente
     * @param String $nome -> il nome del dipendente
     * @param String $cognome -> il cognome del dipendente
     * @param String $indirizzo -> l'indirizzo del dipendente
     * @param String $email -> l'email del dipendente
     * @param String $pass -> la password del dipendente
     */
    public function modificaDipendente($id, $nome, $cognome, $indirizzo, $email, $pass){
        require 'application/libs/connection.php';
        require 'application/libs/hash.php';
        if(!empty($id) && !empty($nome) && !empty($indirizzo) && !empty($cognome) && !empty($email) && !empty($pass)){
            $hp = new Hash($pass);
			$hp->doHash($email);
			$hash_password = $hp->getHashed();
            $sql = $conn->prepare("UPDATE dipendente SET nome = ?, cognome = ?, indirizzo = ?, email = ?, hash_password = ?  WHERE archiviato = 0 AND id = ?");
            $nome = AntiCsScript::check($nome);
            $cognome = AntiCsScript::check($cognome);
            $indirizzo = AntiCsScript::check($indirizzo);
            $email = AntiCsScript::check($email);
            $hash_password = AntiCsScript::check($hash_password);
            $sql->bind_param("sssssi", $nome, $cognome, $indirizzo, $email, $hash_password, AntiCsScript::check($id));
            $result = $sql->execute();
            return $result;
        }
        return FALSE;
    }

}

?>