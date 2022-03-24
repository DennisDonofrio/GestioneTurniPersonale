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
            $sql = "SELECT * FROM datore WHERE archiviato=0;";
            $result = $conn->query($sql);
            $out = array();
            while($out[] = $result->fetch_assoc()){}
            return $out;
        }

        public function ottieniTuttiDatoriEmail(){
            require 'application/libs/connection.php';
            $sql = "SELECT id, email FROM datore WHERE archiviato=0;";
            $result = $conn->query($sql);
            $out = array();
            while($out[] = $result->fetch_assoc()){}
            return $out;
        }

        public function ottieniDatiDatore($id){
            require 'application/libs/connection.php';
            $idChecked = AntiCsScript::check($id);
            $sql = "SELECT * FROM datore WHERE id = $idChecked AND archiviato=0;";
            $result = $conn->query($sql);
            $out = array();
            while($out[] = $result->fetch_assoc()){}
            return $out;
        }

        public function estraiDatiPost(){
            if(!empty($_POST['id']) && !empty($_POST['nome']) && !empty($_POST['cognome']) 
            && !empty($_POST['email']) && !empty($_POST['pass1']) 
            && !empty($_POST['pass2']) && !empty($_POST['indirizzo'])){
                $this->id = AntiCsScript::check($_POST['id']);
                $this->nome = AntiCsScript::check($_POST['nome']);
                $this->cognome = AntiCsScript::check($_POST['cognome']);
                $this->email = AntiCsScript::check($_POST['email']);
                $this->pass1 = AntiCsScript::check($_POST['pass1']);
                $this->pass2 = AntiCsScript::check($_POST['pass2']);
                $this->indirizzo = AntiCsScript::check($_POST['indirizzo']);
            }else{
                throw new Exception("Completare tutti i campi");
            }
        }

        public function modificaDatore(){
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
                        $sql = $conn->prepare("UPDATE datore set nome=?, cognome=?, email=?, hash_password=?, indirizzo=? WHERE id=?");
			            $sql->bind_param("sssssi", $this->nome, $this->cognome, $this->email, $this->hash_password, $this->indirizzo, $this->id);
                        $result = $sql->execute();
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

        public function sonoPasswordUguali(){
			return strcmp($this->pass1, $this->pass2);
		}

        public function eliminaDatore(){
            if(!empty($_POST['id']) && !empty($_POST['email'])){
                if(!empty($this->ottieniDatiDatore($_POST['id'])[0]['email'])
                    && $this->ottieniDatiDatore($_POST['id'])[0]['email'] == $_POST['email']){
                    require 'application/libs/connection.php';
                    $sql = $conn->prepare("UPDATE datore set archiviato=1 WHERE id =?");
                    $id = AntiCsScript::check($_POST['id']);
			        $sql->bind_param("i", $id);
                    $result = $sql->execute();
                }else{
                    throw new Exception("Le due email non corrispondono");
                }
            }else{
                throw new Exception("Completare tutti i campi");
            }
        }

        public function aggiungiDatore(){
            if(!empty($_POST['nome']) && !empty($_POST['cognome']) 
            && !empty($_POST['email']) && !empty($_POST['pass1']) 
            && !empty($_POST['pass2']) && !empty($_POST['indirizzo'])){
                require 'application/libs/Hash.php';
                require 'application/libs/email.php';
                require 'application/libs/password.php';

                $emailUser = new Email($_POST['email']);
                if($emailUser->isValid()){
                    if($_POST['pass1'] == $_POST['pass2']){
                        $passUser = new Password(AntiCsScript::check($_POST['pass1']));
                        if($passUser->isValid()){
                            $this->nome = AntiCsScript::check($_POST['nome']);
                            $this->cognome = AntiCsScript::check($_POST['cognome']);
                            $this->email = AntiCsScript::check($_POST['email']);
                            $this->pass1 = AntiCsScript::check($_POST['pass1']);
                            $this->pass2 = AntiCsScript::check($_POST['pass2']);
                            $this->indirizzo = AntiCsScript::check($_POST['indirizzo']);
                            $hp = new Hash($this->pass1);
                            $hp->doHash($this->email);
                            $this->hash_password = $hp->getHashed();
                            require 'application/libs/connection.php';
                            $sql = $conn->prepare("INSERT INTO datore(nome, cognome, email, hash_password, indirizzo, archiviato) values(?, ?, ?, ?, ?, 0)");
                            $sql->bind_param("sssss", $this->nome, $this->cognome, $this->email, $this->hash_password, $this->indirizzo);
                            $result = $sql->execute();
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
    }
?>