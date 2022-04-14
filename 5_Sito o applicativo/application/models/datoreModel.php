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

        /**
		 * Torna tutti i datori presenti sul database.
		 */
        function ottieniTuttiDatori(){
            require 'application/libs/connection.php';
            $sql = "SELECT id, nome, cognome FROM datore WHERE archiviato = 0;";
            $result = $conn->query($sql);
            $out = array();
            while($row = $result->fetch_assoc()){
                $out[] = array($row['nome'] . " " . $row['cognome'], $row['id']);
            }
            return $out;
        }

        /**
		 * Torna tutti i datori ancora attivi (non archiviati) sul database.
		 */
        function ottieniTuttiDatoriCompleti(){
            require 'application/libs/connection.php';
            $sql = "SELECT * FROM datore WHERE archiviato=0;";
            $result = $conn->query($sql);
            $out = array();
            while($out[] = $result->fetch_assoc()){}
            return $out;
        }

        /**
		 * Torna le email di tutti i datori attivi.
		 */
        function ottieniTuttiDatoriEmail(){
            require 'application/libs/connection.php';
            $sql = "SELECT id, email FROM datore WHERE archiviato=0;";
            $result = $conn->query($sql);
            $out = array();
            while($out[] = $result->fetch_assoc()){}
            return $out;
        }

        /**
		 * Torna tutti i dati di tutti i datori attivi.
		 */
        function ottieniDatiDatore($id){
            require 'application/libs/connection.php';
            $idChecked = AntiCsScript::check($id);
            $sql = "SELECT * FROM datore WHERE id = $idChecked AND archiviato=0;";
            $result = $conn->query($sql);
            $out = array();
            while($out[] = $result->fetch_assoc()){}
            return $out;
        }
        
        /**
		 * Questo metodo serve per modificare i dati di un datore.
         * Vengono effettuati i dovuti controlli per la validità dei dati
		 */
        function modificaDatore(){
            require 'application/libs/Connection.php';
            if(!empty($_POST['id']) && !empty($_POST['nome']) && !empty($_POST['cognome']) 
            && !empty($_POST['email']) && !empty($_POST['pass1']) 
            && !empty($_POST['pass2']) && !empty($_POST['indirizzo'])){
                require 'application/libs/hash.php';
                require 'application/libs/email.php';
                require 'application/libs/password.php';
                $this->id =AntiCsScript::check($_POST['id']);
                $this->nome = AntiCsScript::check($_POST['nome']);
                $this->cognome = AntiCsScript::check($_POST['cognome']);
                $this->email = AntiCsScript::check($_POST['email']);
                $this->pass1 = AntiCsScript::check($_POST['pass1']);
                $this->pass2 = AntiCsScript::check($_POST['pass2']);
                $this->indirizzo = AntiCsScript::check($_POST['indirizzo']);
                $emailUser = new Email($this->email);
                if(!$emailUser->isOldEmail($this->id, TRUE)){
                    $emailUser->isValid();
                }
                if($this->pass1 == $this->pass2){
                    $passUser = new Password($this->pass1);
                    if($passUser->isValid()){
                        $hp = new Hash($this->pass1);
                        $hp->doHash($this->email);
                        $this->hash_password = $hp->getHashed();
                        $sql = $conn->prepare("UPDATE datore set nome=?, cognome=?, email=?, hash_password=?, indirizzo=? WHERE id=?");
                        $sql->bind_param("sssssi", $this->nome, $this->cognome, $this->email, $this->hash_password, $this->indirizzo, $this->id);
                        $result = $sql->execute();
                        return $this->email;
                    }else{
                        throw new Exception("La password deve contenere almeno:<br>- 8 Caratteri<br>-1 Maiuscola<br>-1 Minuscola<br>-1 Cifra<br>-1 Carattere speciale");
                    }
                }else{
                    throw new Exception("Le due password non corrispondono");
                }
            }else{
                throw new Exception("Completare tutti i campi");
            }
            
        }

        /**
		 * Archivia un datore dato il suo id
		 */
        public function eliminaDatore(){
            if(!empty($_POST['id']) && !empty($_POST['email'])){
                $this->email = AntiCsScript::check($_POST['email']);
                if(!empty($this->ottieniDatiDatore($_POST['id'])[0]['email'])
                    && $this->ottieniDatiDatore($_POST['id'])[0]['email'] == $this->email){
                    require 'application/libs/connection.php';
                    $sql = $conn->prepare("UPDATE datore set archiviato=1 WHERE id =?");
                    $id = AntiCsScript::check($_POST['id']);
			        $sql->bind_param("i", $id);
                    $result = $sql->execute();
                    return $this->email;
                }else{
                    throw new Exception("Le due email non corrispondono");
                }
            }else{
                throw new Exception("Completare tutti i campi");
            }
        }

        /**
		 * Aggiunge un nuovo datore utilizando le informazioni dei campi 
		 */
        public function aggiungiDatore(){
            if(!empty($_POST['nome']) && !empty($_POST['cognome']) 
            && !empty($_POST['email']) && !empty($_POST['pass1']) 
            && !empty($_POST['pass2']) && !empty($_POST['indirizzo'])){
                require 'application/libs/hash.php';
                require 'application/libs/email.php';
                require 'application/libs/password.php';
                $this->nome = AntiCsScript::check($_POST['nome']);
                $this->cognome = AntiCsScript::check($_POST['cognome']);
                $this->email = AntiCsScript::check($_POST['email']);
                $this->pass1 = AntiCsScript::check($_POST['pass1']);
                $this->pass2 = AntiCsScript::check($_POST['pass2']);
                $this->indirizzo = AntiCsScript::check($_POST['indirizzo']);
                $emailUser = new Email($this->email);
                if($emailUser->isValid()){
                    if($this->pass1 == $this->pass2){
                        $passUser = new Password($this->pass1);
                        if($passUser->isValid()){
                            $hp = new Hash($this->pass1);
                            $hp->doHash($this->email);
                            $this->hash_password = $hp->getHashed();
                            require 'application/libs/connection.php';
                            $sql = $conn->prepare("INSERT INTO datore(nome, cognome, email, hash_password, indirizzo, archiviato) values(?, ?, ?, ?, ?, 0)");
                            $sql->bind_param("sssss", $this->nome, $this->cognome, $this->email, $this->hash_password, $this->indirizzo);
                            $result = $sql->execute();
                            return $this->email;
                        }else{
                            throw new Exception("La password deve contenere almeno:<br>- 8 Caratteri<br>-1 Maiuscola<br>-1 Minuscola<br>-1 Cifra<br>-1 Carattere speciale");
                        }
                    }else{
                        throw new Exception("Le due password non corrispondono");
                    }
                }
            }else{
                throw new Exception("Completare tutti i campi");
            }
        }
    }
?>