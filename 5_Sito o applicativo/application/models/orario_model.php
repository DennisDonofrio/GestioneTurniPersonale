<?php
    class OrarioModel{
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
            while($data[] = $result->fetch_assoc()){}
            return $data;
        }

        public function rimuoviEventiInRange($start, $end){
            require 'application/libs/connection.php';
            $query = "";
            $result = $conn->query($query);
            if($result){
                return true;
            }
            return false;
        }
    }
?>