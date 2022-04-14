<?php

class PianificaModel{

    public function pianifica($negozio, $inizio, $fine){
        $dipendenti = $this->ottieniDipendenti();
        if(count($dipendenti) >= 2){
            $this->inserisciDipendenti($negozio, $dipendenti, $inizio, $fine);
        }

        //prendi gli orari del dipendente in un certo giorno
        //guarda se il dipendente lavora
        //
    }

    public function ottieniOrariDiNegozio($id, $data){
        require 'application/libs/connection.php';
        $query = $conn->prepare("SELECT inizio, fine, giorno_id FROM usa INNER JOIN orario ON orario.id = usa.orario_id WHERE negozio_id = ? AND giorno_id = ? AND in_uso = 1");
        $id =  AntiCsScript::check($id);
        $data = $data + 1;
        $query->bind_param("ii", $id, $data);
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

    public function ottieniDipendenti(){
        require 'application/libs/connection.php';
        $query = $conn->prepare("SELECT id FROM dipendente WHERE datore_id = ?");
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

    public function inserisciDipendenti($negozio, $dipendenti, $inizio, $fine){
        $data = $inizio;
        while(strtotime($data) <= strtotime($fine)){
            
            $giorno = $this->daDataAGiorno($data);
            echo $data . "<br>";
            $orari = $this->ottieniOrariDiNegozio($negozio, $giorno);
            var_dump($orari);
            echo "<br>";
            if($orari){
                foreach($orari as $orario){
                    foreach($dipendenti as $dipendente){
                        $orariLavoroDipendente = $this->ottieniOrariLavoroDipendente($dipendente, $data);
                        var_dump($orariLavoroDipendente);
                        echo "<br>";
                        if($orariLavoroDipendente){
                            foreach($orariLavoroDipendente as $orarioLavoro){
                                if($this->dipendenteLibero($orario['inizio'], $orario['fine'], $orarioLavoro['turno_inizio'], $orarioLavoro['turno_fine'])){

                                }
                            }
                        }
                    }
                }
            }
            $data = date('Y-m-d', strtotime($data. ' + 1 days'));
        }
        
    }

    public function daDataAGiorno($data){
        $dayofweek = date('w', strtotime($data));
        return $dayofweek;
    }

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

    public function dipendenteLibero($inizio, $fine, $turno_inizio, $turno_fine){
        echo $inizio . " " . $fine . " " . $turno_inizio . " " . $turno_fine . "<br>";
    }

}

?>