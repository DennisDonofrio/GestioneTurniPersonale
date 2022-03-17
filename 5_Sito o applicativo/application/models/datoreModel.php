<?php
    class DatoreModel{

        private $id;
        private $nome;
        private $cognome;
        private $email;
        private $pass1;
        private $pass2;
        private $hash_password;
        private $indirizzo;

        function __construct(){

        }

        function ottieniTuttiDatori(){
            require 'application/libs/connection.php';
            $sql = "SELECT id, nome, cognome FROM datore;";
            $result = $conn->query($sql);
            $out = array();
            while($row = $result->fetch_assoc()){
                $out[] = array($row['nome'] . " " . $row['cognome'], $row['id']);
            }
            return $out;
        }

        function ottieniTuttiDatoriCompleti(){
            require 'application/libs/connection.php';
            $sql = "SELECT * FROM datore;";
            $result = $conn->query($sql);
            $out = array();
            while($out[] = $result->fetch_assoc()){}
            return $out;
        }

        function ottieniTuttiDatoriEmail(){
            require 'application/libs/connection.php';
            $sql = "SELECT id, email FROM datore WHERE archiviato=0;";
            $result = $conn->query($sql);
            $out = array();
            while($out[] = $result->fetch_assoc()){}
            return $out;
        }

        function ottieniDatiDatore($id){
            require 'application/libs/connection.php';
            $sql = "SELECT * FROM datore WHERE id = $id AND archiviato=0;";
            $result = $conn->query($sql);
            $out = array();
            while($out[] = $result->fetch_assoc()){}
            return $out;
        }

        function estraiDatiPost(){
            if(!empty($_POST['id']) && !empty($_POST['nome']) && !empty($_POST['cognome']) && !empty($_POST['email']) && !empty($_POST['pass1']) && !empty($_POST['pass2']) && !empty($_POST['indirizzo'])){
                $this->id = $this->test_input($_POST['id']);
                $this->nome = $this->test_input($_POST['nome']);
                $this->cognome = $this->test_input($_POST['cognome']);
                $this->email = $this->test_input($_POST['email']);
                $this->pass1 = $this->test_input($_POST['pass1']);
                $this->pass2 = $this->test_input($_POST['pass2']);
                $this->indirizzo = $this->test_input($_POST['indirizzo']);
            }else{
                throw new Exception("Completare tutti i campi");
            }
        }

        function modificaDatore(){
            require 'application/libs/Connection.php';
            $this->estraiDatiPost();
        
            require 'application/libs/Hash.php';
            require 'application/libs/email.php';
            require 'application/libs/password.php';
            $emailUser = new Email($_POST['email']);
            if($emailUser->isValid()){
                if($_POST['pass1'] == $_POST['pass2']){
                    $passUser = new Password($_POST['pass1']);
                    if($passUser->isValid()){
                        $hp = new Hash($this->pass1);
                        $hp->doHash($this->email);
                        $this->hash_password = $hp->getHashed();
                        echo "ciao";
                        $sql = "UPDATE datore set nome='".$this->nome."', cognome='"
                        .$this->cognome."', email='".$this->email."', hash_password='".$this->hash_password."',
                        indirizzo='".$this->indirizzo."' WHERE id='".$this->id."';";
                        $result = $conn->query($sql);
                    }else{
                        throw new Exception("La password deve contenere almeno:<br>- 8 Caratteri<br>-1 Maiuscola<br>-1 Minuscola<br>-1 Cifra<br>-1 Carattere speciale");
                    }
                }else{
                    throw new Exception("Le due password non corrispondono");
                }
            }else{
                throw new Exception("Email non valida");
            }
        }

        function sonoPasswordUguali(){
			return strcmp($this->pass1, $this->pass2);
		}

        function eliminaDatore(){
            if(isset($_POST['id']) && isset($_POST['email'])){
                if($this->ottieniDatiDatore($_POST['id'])[0]['email'] == $_POST['email']){
                    require 'application/libs/connection.php';
                    $sql = "DELETE FROM datore WHERE id = " . $_POST['id'] . " ;";
                    $sql = "UPDATE datore set archiviato=1 WHERE id = " . $_POST['id'] . " ;";
                    $result = $conn->query($sql);
                }else{
                    throw new Exception("Le due email non corrispondono");
                }
            }else{
                throw new Exception("Completare tutti i campi");
            }
        }

        function aggiungiDatore(){
            if(!empty($_POST['nome']) && !empty($_POST['cognome']) && !empty($_POST['email']) && !empty($_POST['pass1']) && !empty($_POST['pass2']) && !empty($_POST['indirizzo'])){
                require 'application/libs/Hash.php';
                require 'application/libs/email.php';
                require 'application/libs/password.php';

                $emailUser = new Email($_POST['email']);
                if($emailUser->isValid()){
                    if($_POST['pass1'] == $_POST['pass2']){
                        $passUser = new Password($_POST['pass1']);
                        if($passUser->isValid()){
                            $this->nome = $this->test_input($_POST['nome']);
                            $this->cognome = $this->test_input($_POST['cognome']);
                            $this->email = $this->test_input($_POST['email']);
                            $this->pass1 = $this->test_input($_POST['pass1']);
                            $this->pass2 = $this->test_input($_POST['pass2']);
                            $this->indirizzo = $this->test_input($_POST['indirizzo']);

                            $hp = new Hash($this->pass1);
                            $hp->doHash($this->email);
                            $this->hash_password = $hp->getHashed();
                            require 'application/libs/connection.php';
                            $sql = "INSERT INTO datore(nome, cognome, email, hash_password, indirizzo, archiviato) values('".$this->nome."', '".$this->cognome."', '".$this->email."', '".$this->hash_password."', '".$this->indirizzo."', 0);";
                            $result = $conn->query($sql);
                        }else{
                            throw new Exception("La password deve contenere almeno:<br>- 8 Caratteri<br>-1 Maiuscola<br>-1 Minuscola<br>-1 Cifra<br>-1 Carattere speciale");
                        }
                    }else{
                        throw new Exception("Le due password non corrispondono");
                    }
                }else{
                    throw new Exception("Email non valida");
                }
            }else{
                throw new Exception("Completare tutti i campi");
            }
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    }
?>