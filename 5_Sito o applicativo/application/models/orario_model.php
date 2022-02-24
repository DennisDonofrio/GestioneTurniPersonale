<?php

class OrarioModel{

    function ottieniOrarioDiNegozio($id){
        require 'application/libs/connection.php';
        $query = "Select negozio SET nome = '$nome', indirizzo = '$indirizzo', tipo_id = $tipo WHERE id = $id";
        $result = $conn->query($query);
        if ($result) {
            return TRUE;
        }
        return FALSE;
    }

    function ottieniDipendentiDiDatore(){
        require 'application/libs/connection.php';
        $query = "SELECT nome, id FROM dipendente WHERE datore_id = " . $_SESSION['id'];
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

    public function ottieniEventiInRange($inizio, $fine){
        require 'application/libs/connection.php';
        $nomeCampi = array("title", "start", "end");
        $query = "SELECT d.nome, o.orario_turno_inizio, o.orario_turno_fine, o.data
        FROM turno_lavoro o 
        INNER JOIN dipendente d
        ON d.id = o.dipendente_id
        WHERE o.negozio_id = " . $_SESSION['negozio_id'] . 
        " AND o.data BETWEEN '" . $inizio . "' AND '" . $fine . "'";
        $result = $conn->query($query);
        $data = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $data[] = array(
                    'title' => $row['nome'],
                    'start' => $row['data'] . "T". $row['orario_turno_inizio'],
                    'end' => $row['data'] . "T" . $row['orario_turno_fine'],
                );
            }
            return $data;
        }
        return false;
    }

}

?>