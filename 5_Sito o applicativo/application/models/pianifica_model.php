<?php

class PianificaModel{

    /**
     * Questa funzione serve per pianificare l'orario di un negozio
     * sapendo il periodo
     * @param negozio il negozio di cui si vuole pianificare l'orario
     * @param inizio l'inizio del periodo di pianificazione
     * @param fine la fine del periodo di pianificazione
     */

    public function pianifica($negozio, $inizio, $fine){
        require 'application/libs/connection.php';
        try{
            $this->cominciaTransazione($conn);
            $dipendenti = $this->ottieniDipendenti();
            if(!empty($dipendenti) && count($dipendenti) >= 2){
                $this->inserisciDipendenti($negozio, $dipendenti, $inizio, $fine, $conn);
                $this->commit($conn);
                return true;
            }else{
                return "Non ci sono abbastanza dipendenti";
            }
        }catch(Exception $e){
            $this->rollback($conn);
            return $e->getMessage(); 
        }
    }

    /**
     * Questa funzione serve per ottenere l'orario di un negozio un certo giorno
     * @param id l'id del negozio
     * @param giorno il giorno di cui si vuole sapere l'orario
     */
    public function ottieniOrariDiNegozio($id, $giorno){
        require 'application/libs/connection.php';
        $query = $conn->prepare("SELECT inizio, fine, giorno_id FROM orario_turno WHERE negozio_id = ? AND giorno_id = ?");
        $id =  AntiCsScript::check($id);
        $query->bind_param("ii", $id, $giorno);
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
     * Questa funzione serve per ottenere tutti i dipendenti di un datore
     */
    public function ottieniDipendenti(){
        require 'application/libs/connection.php';
        $query = $conn->prepare("SELECT id FROM dipendente WHERE datore_id = ? AND archiviato = 0");
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
     * Questa funzione serve per pianificare i turni, controlla gli orari di
     * ogni giorno e inserisce i dipendenti se sono liberi
     * @throws Exception se non c'è nessun dipendente libero per un certo orario
     * @param negozio il negozio di cui si vuole pianificare l'orario
     * @param dipendenti i dipendenti del datore
     * @param inizio l'inizio del periodo di pianificazione
     * @param fine la fine del periodo di pianificazione
     * @param conn la connessione con il database
     */
    public function inserisciDipendenti($negozio, $dipendenti, $inizio, $fine, $conn){
        $data = $inizio;
        
        $counterDipendenti = 0;
        while(strtotime($data) <= strtotime($fine)){
            
            $giorno = $this->daDataAGiorno($data);
            $orari = $this->ottieniOrariDiNegozio($negozio, $giorno);
            if($orari){
                foreach($orari as $orario){
                    $done = false;
                    while(!$done){
                        for($i=0;$i<2;$i++){
                            $dipendente = $dipendenti[$counterDipendenti];
                            $orariLavoroDipendente = $this->ottieniOrariLavoroDipendente($dipendente['id'], $data);
                            if(!$orariLavoroDipendente){
                                $this->inserisciDipendente($dipendente['id'], $orario, $data, $negozio, $conn);
                                $done = true; 
                            }else{
                                foreach($orariLavoroDipendente as $orarioLavoro){
                                    if($this->dipendenteLibero($orario['inizio'], $orario['fine'], $orarioLavoro['turno_inizio'], $orarioLavoro['turno_fine'])){
                                        $this->inserisciDipendente($dipendente['id'], $orario, $data, $negozio, $conn);
                                        $done = true;
                                        break;
                                    }
                                }
                                if($counterDipendenti == count($dipendenti) - 1){
                                    throw new Exception("Tutti i dipendenti sono occupati durante l'orario " . $orario['inizio'] . "-" . $orario['fine'] . "!");
                                }
                            }
                            $counterDipendenti = ($counterDipendenti + 1) % count($dipendenti);
                        }
                    }
                }
            }
            $data = date('Y-m-d', strtotime($data. ' + 1 days'));
        }
        
    }

    /**
     * Questa funzione inserisce il turno di lavoro nel database
     * @param id l'id del dipendente
     * @param orario l'orario di inizio e fine del turno
     * @param data la data del turno di lavoro
     * @param negozio l'id del negozio
     * @param conn la connessione con il database
     */
    public function inserisciDipendente($id, $orario, $data, $negozio, $conn){
        $query = $conn->prepare("INSERT INTO turno_lavoro VALUES(?, ?, ?, ?, ?)");
        $query->bind_param("iisss", $id, $negozio, $orario['inizio'], $orario['fine'], $data);
        $query->execute();
        return $query->get_result();
    }

    /**
     * Questa funzione trasforma una data in un giorno
     * es: 22.10.2022 -> 6 (Sabato)
     * @param data la data da convertire
     */
    public function daDataAGiorno($data){
        $dayofweek = date('w', strtotime($data));
        return $dayofweek;
    }

    /**
     * Questa funzione serve per ottenere i turni di lavoro di un certo dipendente
     * in una certa data
     * @param dipendente l'id del dipendente
     * @param data la data in cui cercare
     */
    public function ottieniOrariLavoroDipendente($dipendente, $data){
        require 'application/libs/connection.php';
        $query = $conn->prepare("SELECT data, orario_turno_inizio as turno_inizio, orario_turno_fine as turno_fine FROM turno_lavoro WHERE dipendente_id = ? AND data = ?");
        $query->bind_param("is", $dipendente, $data);
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
     * Questa funzione determina se un dipendente è libero in un certo orario
     * @param inizio l'inizio del turno di lavoro
     * @param fine la fine del truno di lavoro
     * @param turno_inizio l'inizio del turno di lavoro da confrontare
     * @param turno_fine la fine del turno di lavoro da confrontare
     */
    public function dipendenteLibero($inizio, $fine, $turno_inizio, $turno_fine){
        $inizio = $this->daOrarioASecondi($inizio);
        $fine = $this->daOrarioASecondi($fine);
        $turno_inizio = $this->daOrarioASecondi($turno_inizio);
        $turno_fine = $this->daOrarioASecondi($turno_fine);
        return $turno_inizio >= $fine || $turno_fine <= $inizio; 
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

}

?>