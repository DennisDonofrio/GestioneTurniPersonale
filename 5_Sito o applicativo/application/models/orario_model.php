<?php

class OrarioModel{

    /*
    select n.nome as 'negozio', g.nome as 'giorno', o.inizio as 'dalle', o.fine as 'alle' from usa
    inner join negozio n on n.id = usa.negozio_id
    inner join giorno g on g.id = usa.giorno_id
    inner join orario o on o.id = usa.orario_id;

    
    }*/

    function ottieniDipendentiDiDatore(){
        require 'application/libs/connection.php';
        $query = $conn->prepare("SELECT nome, id FROM dipendente WHERE datore_id = ?");
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

    public function cominciaTransazione($conn){
        $conn->begin_transaction();
    }

    public function commit($conn){
        $conn->commit();
    }

    public function rollback($conn){
        $conn->rollback();
    }

    public function salva($range, $eventi){
        require 'application/libs/connection.php';
        mysqli_autocommit($conn, false);
        $this->cominciaTransazione($conn);
        $this->rimuoviEventiInRange($conn, $range);
        if($this->inserisciEventi($conn, $range, $eventi)){
            $this->commit($conn);
            return "committed";
        }else{
            $this->rollback($conn);
            return "rollback";
        }
        mysqli_autocommit($conn, true);
        $conn->close();
    }

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
                }
            }
            return true;
        }catch(Exception $e){
            return false;
        }
    }

    public function formattaData($data){
        return substr($data, 0, strpos($data, 'T'));
    }

    public function formattaOrario($data){
        $raw = substr($data, strpos($data, 'T') + 1);
        return substr($raw, 0, strlen($raw) - 5);
    }

    public function trovaId($titolo){
        if(strpos($titolo, ')') >= 2){
            return substr($titolo, 1, strpos($titolo, ')') - 1);
        }else{
            throw new Exception("Id non valido");
        }
    }

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
                    $result = $conn->query($query);
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

    public function ottieniOrariInUso(){
        require 'application/libs/connection.php';
        $query = "SELECT g.nome, o.inizio, o.fine
                    FROM usa u
                    INNER JOIN giorno g on g.id = u.giorno_id
                    INNER JOIN orario o on o.id = u.orario_id
                    WHERE u.negozio_id = " . $_SESSION['negozio_id'];
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