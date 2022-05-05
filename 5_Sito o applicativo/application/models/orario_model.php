<?php

class OrarioModel{

    /*
    select n.nome as 'negozio', g.nome as 'giorno', o.inizio as 'dalle', o.fine as 'alle' from usa
    inner join negozio n on n.id = usa.negozio_id
    inner join giorno g on g.id = usa.giorno_id
    inner join orario o on o.id = usa.orario_id;

    
    }*/

    /**
     * Questa funzionr serve per ottenere i dipendenti
     * di un datore
     */
    function ottieniDipendentiDiDatore(){
        require 'application/libs/connection.php';
        $query = $conn->prepare("SELECT nome, id FROM dipendente WHERE datore_id = ? AND archiviato = 0");
        $query->bind_param("i", $_SESSION['id']);
        $query->execute();
        $result = $query->get_result();
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
     * Questa funzione serve per ottenere gli eventi (turni di lavoro)
     * in un certo range
     * @param inizio la data da cui cominciare a cercare
     * @param fine la diata in cui la ricerca finisce
     */
    public function ottieniEventiInRange($inizio, $fine){
        require 'application/libs/connection.php';
        $query = $conn->prepare("SELECT d.id, d.nome, o.orario_turno_inizio, o.orario_turno_fine, o.data
        FROM turno_lavoro o 
        INNER JOIN dipendente d
        ON d.id = o.dipendente_id
        WHERE o.negozio_id = ? AND o.data BETWEEN ? AND ?");
        $inizio = $this->formattaData($inizio);
        $fine = $this->formattaData($fine);
        $query->bind_param("iss", $_SESSION['negozio_id'], $inizio, $fine);
        $query->execute();
        $result = $query->get_result();
        $data = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $data[] = array(
                    'title' => "(" . $row['id'] . ")" . " " . $row['nome'],
                    'start' => $row['data'] . "T". $row['orario_turno_inizio'],
                    'end' => $row['data'] . "T" . $row['orario_turno_fine'],
                );
            }
            return $data;
        }
        return false;
    }

    /**
     * Questa funzione serve per ottenere gli eventi (turni di lavoro)
     * in un certo range di un dipendente
     * @param inizio la data da cui cominciare a cercare
     * @param fine la diata in cui la ricerca finisce
     * @param id id del dipendente
     */
    //2022-12-12T00.00.0000+02:00
    public function ottieniEventiInRangeDipendente($inizio, $fine, $id){
        require 'application/libs/connection.php';
        $query = $conn->prepare("SELECT d.id, d.nome, o.orario_turno_inizio, o.orario_turno_fine, o.data
        FROM turno_lavoro o 
        INNER JOIN dipendente d
        ON d.id = o.dipendente_id
        WHERE o.negozio_id = ? AND o.data BETWEEN ? AND ? AND o.dipendente_id = ?");
        $inizio = $this->formattaData($inizio);
        $fine = $this->formattaData($fine);
        $query->bind_param("issi", $_SESSION['negozio_id'], $inizio, $fine, $id);
        $query->execute();
        $result = $query->get_result();
        $data = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $data[] = array(
                    'title' => "(" . $row['id'] . ")" . " " . $row['nome'],
                    'start' => $row['data'] . "T". $row['orario_turno_inizio'],
                    'end' => $row['data'] . "T" . $row['orario_turno_fine'],
                );
            }
            return $data;
        }
        return false;
    }

    /**
     * Questa funzione serve per cominciare una transazione
     * @param conn la connessione con il database
     */
    public function cominciaTransazione($conn){
        $conn->begin_transaction();
    }

    /**
     * Questa funzione fa il commit di una transazione
     * @param conn la connessione con il database
     */
    public function commit($conn){
        $conn->commit();
    }

    /**
     * Questa funzione fa il rollback di una transazione
     * @param conn la connessione con il database
     */
    public function rollback($conn){
        $conn->rollback();
    }

    /**
     * Questa funzione salva i nuovi orari nel database
     * @param range il range di eventi da rimuovere
     * @param eventi i nuovi evennti da inserire
     */
    public function salva($range, $eventi){
        require 'application/libs/connection.php';
        mysqli_autocommit($conn, false);
        $this->cominciaTransazione($conn);
        $this->rimuoviEventiInRange($conn, $range);
        if($this->inserisciEventi($conn, $range, $eventi)){
            $this->commit($conn);
            Log::writeLog("Commit eseguito");
            return "committed";
        }else{
            $this->rollback($conn);
            Log::writeErrorLog("Rollback eseguito: errore nell'aggiunta degli eventi");
            return "rollback";
        }
        mysqli_autocommit($conn, true);
        $conn->close();
    }

    /**
     * Questa funzione serve per rimuovere gli eventi in un certo range
     * @param conn la connessione al database
     * @param range il range in cui rimuovere gli eventi
     */
    public function rimuoviEventiInRange($conn, $range){
        $inizio = $this->formattaData($range['start']);
        $fine = $this->formattaData($range['end']);
        $query = $conn->prepare("DELETE FROM turno_lavoro WHERE data BETWEEN ? AND ?");
        if($query){
            $query->bind_param("ss", $inizio, $fine);
            $query->execute();
            return true;
        }
    }

    /**
     * Questa funzione inserisce gli eventi in un certo range
     * @param conn la connessione al db
     * @param range il range di eventi da inserire
     * @param eventi gli eventi da inserire
     */
    public function inserisciEventi($conn, $range, $eventi){
        try{
            $inizio = $this->formattaData($range['start']);
            $fine = $this->formattaData($range['end']);
            foreach($eventi as $evento){
                if(strtotime($this->formattaData($evento['start'])) >= strtotime($inizio) && 
                strtotime($this->formattaData($evento['start'])) >= strtotime($inizio) && 
                strtotime($this->formattaData($evento['end'])) <= strtotime($fine) && 
                strtotime($this->formattaData($evento['end'])) <= strtotime($fine)){
                    $query = $conn->prepare("INSERT INTO turno_lavoro VALUES (?, ?, ?, ?, ?)");
                    $dipendente = $this->trovaId($evento['title']);
                    $inizioEvento = $this->formattaOrario($evento['start']);
                    $fineEvento =$this->formattaOrario($evento['end']);
                    $data = $this->formattaData($evento['start']);
                    $query->bind_param("iisss", $dipendente, $_SESSION['negozio_id'], $inizioEvento, $fineEvento, $data);
                    if(!$query->execute()){
                        return false;
                    }
                    Log::writeLog("Nuovo evento inserito");
                }
            }
            return true;
        }catch(Exception $e){
            return false;
        }
    }

    /**
     * Questa funzione serve per formattare la data
     * dal formato del calendario
     * @param data la data da cui tirare fuori gli orari
     */
    public function formattaData($data){
        return substr($data, 0, strpos($data, 'T'));
    }

    /**
     * Questa funzione serve per formattare un orario
     * dal formato del calendario
     * @param data la data da cui tirare fuori gli orari
     */
    public function formattaOrario($data){
        $raw = substr($data, strpos($data, 'T') + 1);
        return substr($raw, 0, strlen($raw) - 5);
    }

    /**
     * Questa funzione serve per trovare l'id del dipendente 
     * dal titolo dell'evento
     * @param titolo il titolo da cui ricavare gli id
     */
    public function trovaId($titolo){
        if(strpos($titolo, ')') >= 2){
            return substr($titolo, 1, strpos($titolo, ')') - 1);
        }else{
            throw new Exception("Id non valido");
        }
    }

    /**
     * Questa funzione serve per inserire gli orari di apertura e chiusura nel db  
     */
    public function aggiungiOrario(){
        if(!empty($_POST['inizio']) && !empty($_POST['fine'])){
            $tinizio = mktime(substr($_POST['inizio'], 0, 2), substr($_POST['inizio'], 3, 2));
            $tfine = mktime(substr($_POST['fine'], 0, 2), substr($_POST['fine'], 3, 2));
            $inizio = $_POST['inizio'] . ":00";
            $fine = $_POST['fine'] . ":00";
            if($tinizio < $tfine){
                $data = $this->ottieniOrari($inizio, $fine);
                if($data == false){
                    require 'application/libs/connection.php';
                    $query = "INSERT INTO orario(inizio, fine) VALUES('$inizio', '$fine')";
                    $conn->query($query);
                }else{
                    throw new Exception("Questi orari sono già presenti");
                }
            }else{
                throw new Exception("Inserire orari coerenti");
            }
        }else{
            throw new Exception("Compilare tutti i campi");
        }
    }

    /**
     * Questa funzione serve per modifcare un orario 
     */
    public function modificaOrario(){
        if(!empty($_POST['inizio']) && !empty($_POST['fine'] && !empty($_POST['orario']))){
            $tinizio = mktime(substr($_POST['inizio'], 0, 2), substr($_POST['inizio'], 3, 2));
            $tfine = mktime(substr($_POST['fine'], 0, 2), substr($_POST['fine'], 3, 2));
            $inizio = $_POST['inizio'] . ":00";
            $fine = $_POST['fine'] . ":00";
            if($tinizio < $tfine){
                $data = $this->ottieniOrari($inizio, $fine);
                if($data == false){
                    require 'application/libs/connection.php';
                    $query = "UPDATE orario set inizio = '$inizio', fine = '$fine'
                                WHERE id = ".$_POST['orario'].";";
                    $conn->query($query);
                    $result = $conn->query($query);
                    return $_POST['orario'];
                }else{
                    throw new Exception("Questi orari sono già presenti");
                }
            }else{
                throw new Exception("Inserire orari coerenti");
            }
        }else{
            throw new Exception("Compilare tutti i campi");
        }
    }

    /**
     * Questa funzione serve per ottenere tutti gli orari
     * in un certo range
     * @param inizio l'inizio del range
     * @param fine la fine del range
     */
    public function ottieniOrari($inizio, $fine){
        require 'application/libs/connection.php';
        $query = "SELECT inizio, fine
                    FROM orario
                    WHERE inizio = '$inizio' AND fine = '$fine'";
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
     * Questa funzione serve per ottenere tutti i dati
     * degli orari (id, inizio e fine)
     */
    public function ottieniOrariCompleti(){
        require 'application/libs/connection.php';
        $query = "SELECT id, inizio, fine
                    FROM orario";
        $conn->query($query);
        $result = $conn->query($query);
        $data = array();
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return $data;
    }

    /**
     * Questa funzione server per ottenere gli orari in uso di un negozio
     */
    public function ottieniOrariInUso(){
        require 'application/libs/connection.php';
        $query = "SELECT g.nome, o.inizio, o.fine
                    FROM usa u
                    INNER JOIN giorno g on g.id = u.giorno_id
                    INNER JOIN orario o on o.id = u.orario_id
                    WHERE u.in_uso = 1
                    AND u.negozio_id = " . $_SESSION['negozio_id'];
        $conn->query($query);
        $result = $conn->query($query);
        $data = array();
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return $data;
    }
}

?>