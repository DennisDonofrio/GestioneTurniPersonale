<?php

class TurnoModel{

    /**
     * Questa funzione serve per insrire un turno nel database
     * Un turno viene inserito solo se è coerente rispetto
     * agli orari di apertura
     */
    public function aggiungiTurno(){
        if(!empty($_POST['inizio']) && !empty($_POST['fine']) && !empty($_POST['giorno'])){
            $tinizio = mktime(substr($_POST['inizio'], 0, 2), substr($_POST['inizio'], 3, 2));
            $tfine = mktime(substr($_POST['fine'], 0, 2), substr($_POST['fine'], 3, 2));
            $inizio = $_POST['inizio'] . ":00";
            $fine = $_POST['fine'] . ":00";
            if($tinizio < $tfine && $this->turnoInRange($inizio, $fine)){
                require 'application/libs/connection.php';

                $sql = $conn->prepare("INSERT INTO orario_turno(inizio, fine, negozio_id, giorno_id) VALUES(?, ?, ?, ?)");
                $inizio = AntiCsScript::check($inizio);
                $fine = AntiCsScript::check($fine);
                $negozio = AntiCsScript::check($_POST['negozio']);
                $giorno = AntiCsScript::check($_POST['giorno']);
                $sql->bind_param("ssii",$inizio, $fine, $negozio, $giorno);
                $result = $sql->execute();
            }else{
                throw new Exception("Inserire orari coerenti con gli orari di apertura");
            }
        }else{
            throw new Exception("Compilare tutti i campi");
        }
    }

    /**
     * Questa funzione serve per eliminare un turno dal database
     */
    public function eliminaTurno(){
        $id = AntiCsScript::check($_POST['turno']);
        $riga = $this->ottieniDatiTurno($id);
        require 'application/libs/connection.php';
        $sql = $conn->prepare("DELETE FROM orario_turno
        WHERE inizio = ? AND fine = ? AND negozio_id = ? AND giorno_id = ?");
        $sql->bind_param("ssii", $riga['inizio'], $riga['fine'], $riga['negozio_id'], $riga['giorno_id']);
        $sql->execute();
        return true;
    }

    /**
     * Questa funzione serve per mostrare tutti i turni di un negozio
     */
    public function mostraTurni(){
        require 'application/libs/connection.php';
        $sql = $conn->prepare("SELECT inizio, fine, nome from orario_turno 
        INNER JOIN giorno on giorno.id = giorno_id
        WHERE negozio_id = ?");
        $sql->bind_param("i", $_SESSION['negozio_id']);
        $sql->execute();
        $result = $sql->get_result();
        $data = array();
        if (!empty($result)) {
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    /**
     * Questa funzione serve per ottenere i giorni
     * che vengono inseriti nella view aggiungi della
     * gestione dei truni
     */
    public function ottieniGiorni(){
        require 'application/libs/connection.php';
        $query = "SELECT id, nome
                    FROM giorno";
        $conn->query($query);
        $result = $conn->query($query);
        $data = array();
        if (!empty($result)) {
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    /**
     * Questa funzione serve per ottenere i turni di un certo negozio
     * aggiungendo un identificatore in più
     */
    public function ottieniTurni(){
        require 'application/libs/connection.php';
        $sql = $conn->prepare("SELECT inizio, fine, n.nome FROM orario_turno
        INNER JOIN negozio n ON n.id = orario_turno.negozio_id
        WHERE negozio_id = ?");
        $negozio = AntiCsScript::check($_SESSION['negozio_id']);
        $sql->bind_param("i", $negozio);
        $sql->execute();
        $result = $sql->get_result();
        $data = array();
        if ($result->num_rows > 0) {
            $i = 0;
            while($row = $result->fetch_assoc()){
                $row = array_merge($row, array('id' => $i));
                $data[] = $row;
                $i++;
            }
        }
        return $data;
    }

    /**
     * Questa funzione serve per verificare che il turno sia coerente
     * con gli orari di apertura e chiusura
     * @param inizioTurno l'orario di inizio del turno
     * @param fineTurno l'orario di fine del turno
     */
    public function turnoInRange($inizioTurno, $fineTurno){
        require 'application/libs/connection.php';
        $sql = $conn->prepare("SELECT o.inizio as inizio, o.fine as fine FROM usa
        INNER JOIN orario o
        ON o.id = usa.orario_id
        WHERE negozio_id = ?");
        $negozio = AntiCsScript::check($_SESSION['negozio_id']);
        $sql->bind_param("i", $negozio);
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $inizio = $this->daOrarioASecondi($row['inizio']);
                $fine = $this->daOrarioASecondi($row['fine']);
                if($inizio <= $this->daOrarioASecondi($inizioTurno) && $fine >= $this->daOrarioASecondi($fineTurno)){
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Questa funzione converte da ora a secondi
     * @param orario l'orario da convertire
     */
    function daOrarioASecondi(string $orario){
        $arr = explode(':', $orario);
        if (count($arr) === 3) {
            return $arr[0] * 3600 + $arr[1] * 60 + $arr[2];
        }
        return $arr[0] * 60 + $arr[1];
    }

    /**
     * Questa funzione serve per ottenere i dati di un turno partendo
     * dal numero della riga
     */
    public function ottieniDatiTurno($riga){
        require 'application/libs/connection.php';
        $sql = $conn->prepare("SELECT * FROM orario_turno
        LIMIT ?, 1");
        $riga = AntiCsScript::check($riga + 1);
        $sql->bind_param("i", $riga);
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }

}

?>
