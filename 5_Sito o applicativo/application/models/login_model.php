<?php
	/**
	 * classe per il login
	 */
	class LoginClass
	{
		private $email;
		private $password;
        private $hashedPassword;

		function __construct($email, $password)
		{
			$this->email = AntiCsScript::check($email);
			$this->password = AntiCsScript::check($password); 
		}

		/**
		 * Calcola l'hash della password in sha256
		 */
		function getHashedPass(){
			require 'application/libs/hash.php';
			$hashUser = new Hash($this->password);
			$hashUser->doHash($this->email);
			$this->hashedPassword = $hashUser->getHashed();
		}

		/**
		 * Viene controllato se le credenziali d'accesso sono valide,
		 * in caso di si, salva anche di che tipo è l'utente
		 */
		function doLogin(){
			require 'application/libs/connection.php';
            $this->getHashedPass();
			$sql1 = $conn->prepare("SELECT * FROM dipendente WHERE email=? AND hash_password=? AND archiviato=0");
			$sql1->bind_param("ss", $this->email, $this->hashedPassword);
			$sql2 = $conn->prepare("SELECT * FROM datore WHERE email=? AND hash_password=? AND archiviato=0");
			$sql2->bind_param("ss", $this->email, $this->hashedPassword);
			$sql3 = $conn->prepare("SELECT * FROM amministratore WHERE email=? AND hash_password=?");
            $sql3->bind_param("ss", $this->email, $this->hashedPassword);
			for($i=1;$i<=3;$i++){
				$currentQuery = 'sql' . $i;
				$$currentQuery->execute();
				$result = $$currentQuery->get_result();
				if($result){
					if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						$_SESSION['id'] = $row['id'];
						$_SESSION['role'] = $i;
						$_SESSION['roleType'] = $this->getRole($i);
						return true;
					}
				}
				$$currentQuery->close();
			}
			session_destroy();
			return false;
		}

		function getRole($r){
			if($r == 1){
				return "dipendente";
			}else if($r == 2){
				return "datore";
			}else if($r == 3){
				return "amministratore";
			}
		} 
	}
?>
