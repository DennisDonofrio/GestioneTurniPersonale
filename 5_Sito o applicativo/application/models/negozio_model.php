<?php

class NegozioModel{

    /**
     * Questa funzione serve per aggiungere un negozio
     * @param nome il nome del negozio
     * @param indirizzo l'indirizzo del negozio
     * @param tipo il tipo del negozio 
     */
    public function aggiungiNegozio(){
        require 'application/libs/connection.php';
        if(!empty($_POST['nome']) && !empty($_POST['indirizzo']) && !empty($_POST['tipo'])){
            $sql = $conn->prepare("INSERT INTO negozio(nome, indirizzo, archiviato, tipo_id, datore_id) VALUES (?, ?, FALSE, ?, ?)");
            $nome = AntiCsScript::check($_POST['nome']);
            $indirizzo = AntiCsScript::check($_POST['indirizzo']);
            $tipo = AntiCsScript::check($_POST['tipo']);
            $sql->bind_param("ssii", $nome, $indirizzo, $tipo, AntiCsScript::check($_SESSION['id']));
            $result = $sql->execute();
            if ($result) {
                return $nome;
            }else{
                throw new Exception("Non è stato possibile aggiungere il negozio ".$nome);
            }
        }else{
            throw new Exception("Completare tutti i campi");
        }
    }

    /**
     * Questa funzione serve per ottenere tutti i tipi di un negozio
     */
    public function ottieniTipi(){
        require 'application/libs/connection.php';
        $query = "SELECT nome, id FROM tipo";
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

    /**
     * Questa funzione serve per ottenere tutti i negozi
     * non archiviati
     */
    public function ottieniNegozi(){
        require 'application/libs/connection.php';
        $query = "SELECT nome, id FROM negozio WHERE archiviato = 0 AND datore_id = " . $_SESSION['id'];
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
     * Questa funzione serve per ottenere tutti i negozi
     * di un dipendente
     * @param id id del dipendente
     */
    public function ottieniNegoziDipendente($id){
        require 'application/libs/connection.php';
        $query = "SELECT n.nome, n.id
                FROM negozio n
                INNER JOIN turno_lavoro t
                ON n.id = t.negozio_id
                WHERE n.archiviato = 0 AND t.dipendente_id = $id
                group by negozio_id";
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
     * Questa funzione serve per ottenere tutti i negozi
     * di un certo datore
     */
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

    /**
     * Questa funzione per rimuovere un negozio
     * @param id l'id del negozio
     */
    public function rimuoviNegozio(){
        require 'application/libs/connection.php';
        $sql = $conn->prepare("UPDATE negozio SET archiviato=1 WHERE id =?");
        $id = $_POST['negozio'];
        $sql->bind_param("i", $id);
        $result = $sql->execute();
        if($result){
            return $id;
        }else{
            throw new Exception("Non è stato possibile eliminare il negozio con id ".$id);
        }
    }

    /**
     * Questa funzione serve per modificare un negozio
     * @param id il negozio da modificare
     * @param nome il nuovo nome del negozio
     * @param indirizzo il nuovo indirizzo del negozio
     * @param tipo il nuovo tipo del negozio
     */
    public function modificaNegozio(){
        require 'application/libs/connection.php';
        if(!empty($_POST['nome']) && !empty($_POST['indirizzo']) && !empty($_POST['tipo']) && !empty($_POST['negozio'])){
            $nome = AntiCsScript::check($_POST['nome']);
            $indirizzo = AntiCsScript::check($_POST['indirizzo']);
            $tipo = AntiCsScript::check($_POST['tipo']);
            $id = AntiCsScript::check($_POST['negozio']);
            $sql = $conn->prepare("UPDATE negozio SET nome = ?, indirizzo = ?, tipo_id = ? WHERE id = ?");
            $sql->bind_param("ssii", $nome, $indirizzo, $tipo, $id);
            if ($sql->execute()) {
                return $nome;
            }else{
                throw new Exception("Non è stato possibile modificare il negozio ".$nome);
            }
        }else{
            throw new Exception("Completare tutti i campi");
        }
    }

    /**
     * Questa funzione serve per ottenere gli orari che l'utente
     * vuole usare
     * @param input gli orari impostati dall'utente
     */
    public function ottieniOrari($input){
        $orari = array();
        $counterInput = 0;
        $giorni = array("lunedi", "martedi", "mercoledi", "giovedi", "venerdi", "sabato", "domenica");
        for($i=0;$i<count($giorni);$i++){
            $nome = $giorni[$i] . $counterInput;
            $orari[$giorni[$i]] = array();
            for($j=0;$j<3;$j++){
                if(isset($input[$nome])){
                    $orari[$giorni[$i]][] = $input[$nome];
                    $counterInput++;
                    $nome = $giorni[$i] . $counterInput;
                }else{
                    break;
                }
            }
            $counterInput = 0;
        }
        return $orari;
    }

    /**
     * Questa funzione serve per salvare i nuovi orari
     * nella tabella usa
     * @param conn la connessione con il database
     */
    public function salvaOrari($conn, $orari){
       foreach($orari as $giorno => $orario){
           $giornoId = $this->daGiornoAGiornoId($giorno);
           echo $giornoId."<br>";
           foreach($orario as $orarioId){
                $sql = $conn->prepare("INSERT INTO usa(negozio_id, giorno_id, orario_id, in_uso) VALUES(?, ?, ?, 1)");
                $sql->bind_param("iii", $_SESSION['negozio_id'], $giornoId, $orarioId);
                if(!$sql->execute()){
                    return false;
                }
            }
        }
        Log::writeLog("Orari del negozio ".$_SESSION['negozio_id']. " aggiornati");
        return true;
    }

    /**
     * Questa funzione converte il giorno
     * nel suo id
     * @param giorno il giorno da convertire
     */
    public function daGiornoAGiornoId($giorno){
        switch($giorno){
            case "lunedi":
                return 1;
            case "martedi":
                return 2;
            case "mercoledi":
                return 3;
            case "giovedi":
                return 4;
            case "venerdi":
                return 5;
            case "sabato":
                return 6;
            case "domenica":
                return 7;
        }
    }

    /**
     * Questa funzione comincia una transazione
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
     * Questa funzione imposta gli orari che non sono più in uso
     * come archiviati
     * @param conn la connessione con il database
     */
    public function disattivaOrariNegozio($conn){
        $sql = $conn->prepare("UPDATE usa SET in_uso = 0 WHERE negozio_id = ? AND in_uso = 1");
        if($sql){
            $sql->bind_param("i", $_SESSION['negozio_id']);
            echo "disattivati<br>";
            $sql->execute();
            return true;
        }
    }

    /**
     * Questa funzione salva gli orari che l'utene vuole
     * usare e ritorna uno status
     * @param input gli orari scelti dall'utente
     */
    public function salva($input){
        require 'application/libs/connection.php';
        $orari = $this->ottieniOrari($input);
        mysqli_autocommit($conn, false);
        $this->cominciaTransazione($conn);
        $this->disattivaOrariNegozio($conn);
        $this->commit($conn);
        if($this->salvaOrari($conn, $orari)){
            $this->commit($conn);
            mysqli_autocommit($conn, true);
            $conn->query("call controlloDuplicati()");
            $conn->close();
            return "committed";
        }else{
            $this->rollback($conn);
            mysqli_autocommit($conn, true);
            $conn->close();
            return "rollback";
        }
    }
}
?>