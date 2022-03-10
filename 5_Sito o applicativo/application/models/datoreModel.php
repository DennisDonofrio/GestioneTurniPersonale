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

        public function __construct(){

        }

        public function ottieniTuttiDatori(){
            require 'application/libs/connection.php';
            $sql = "SELECT id, nome, cognome FROM datore;";
            $result = $conn->query($sql);
            $out = array();
            while($row = $result->fetch_assoc()){
                $out[] = array($row['nome'] . " " . $row['cognome'], $row['id']);
            }
            return $out;
        }

        public function ottieniTuttiDatoriCompleti(){
            require 'application/libs/connection.php';
            $sql = "SELECT * FROM datore;";
            $result = $conn->query($sql);
            $out = array();
            while($out[] = $result->fetch_assoc()){}
            return $out;
        }

        public function ottieniTuttiDatoriEmail(){
            require 'application/libs/connection.php';
            $sql = "SELECT id, email FROM datore;";
            $result = $conn->query($sql);
            $out = array();
            while($out[] = $result->fetch_assoc()){}
            return $out;
        }

        public function ottieniDatiDatore($id){
            require 'application/libs/connection.php';
            $sql = "SELECT * FROM datore WHERE id = $id;";
            $result = $conn->query($sql);
            $out = array();
            while($out[] = $result->fetch_assoc()){}
            return $out;
        }

        public function estraiDatiPost(){
            if(!empty($_POST['id']) && !empty($_POST['nome']) && !empty($_POST['cognome']) && !empty($_POST['email']) && !empty($_POST['pass1']) && !empty($_POST['pass2']) && !empty($_POST['indirizzo'])){
                $this->id = $this->test_input($_POST['id']);
                $this->nome = $this->test_input($_POST['nome']);
                $this->cognome = $this->test_input($_POST['cognome']);
                $this->email = $this->test_input($_POST['email']);
                $this->pass1 = $this->test_input($_POST['pass1']);
                $this->pass2 = $this->test_input($_POST['pass2']);
                $this->indirizzo = $this->test_input($_POST['indirizzo']);
            }else{
                throw new Exception("Email o password non inseriti");
            }
        }

        public function modificaDatore(){
            require 'application/libs/Connection.php';
			require 'application/libs/Hash.php';
            $this->estraiDatiPost();
            if($this->sonoPasswordUguali() == 0){
				$strongRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/";
				if(preg_match($strongRegex, $this->pass1)){

					$hp = new Hash($this->pass1);
					$hp->doHash($this->email);
					$this->hash_password = $hp->getHashed();

                    $sql = "UPDATE datore set nome='".$this->nome."', cognome='"
                    .$this->cognome."', email='".$this->email."', hash_password='".$this->hash_password."',
                    indirizzo='".$this->indirizzo."' WHERE id='".$this->id."';";
                    $result = $conn->query($sql);
				}else{
					throw new Exception("Complessità password non valida");
				}
			}else{
				throw new Exception("Le due password non corrispondono");
			}
        }

        public function sonoPasswordUguali(){
			return strcmp($this->pass1, $this->pass2);
		}

        public function eliminaDatore(){
            if(isset($_POST['id']) && isset($_POST['email'])){
                if($this->ottieniDatiDatore($_POST['id'])[0]['email'] == $_POST['email']){
                    require 'application/libs/connection.php';
                    $sql = "DELETE FROM datore WHERE id = " . $_POST['id'] . " ;";
                    $result = $conn->query($sql);
                }else{
                    throw new Exception("Le due email non corrispondono");
                }
            }else{
                throw new Exception("Completare tutti i campi");
            }
        }

        public function aggiungiDatore(){
            if(!empty($_POST['nome']) && !empty($_POST['cognome']) && !empty($_POST['email']) && !empty($_POST['pass1']) && !empty($_POST['pass2']) && !empty($_POST['indirizzo'])){
                if($this->sonoPasswordUguali() == 0){
                    require 'application/libs/Hash.php';

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
                    $sql = "INSERT INTO datore(nome, cognome, email, hash_password, indirizzo) values('".$this->nome."', '".$this->cognome."', '".$this->email."', '".$this->hash_password."', '".$this->indirizzo."');";
                    echo $sql;
                    $result = $conn->query($sql);
                }else{
                    throw new Exception("Le due password non corrispondono");
                }
            }else{
                throw new Exception("Completare tutti i campi");
            }
        }

        public function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    }
?>