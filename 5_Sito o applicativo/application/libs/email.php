<?php
	/**
	 * classe per il controllo della email
	 */
	class Email
	{
		private $fullEmail;
		private $domain;
		public function __construct($fullEmail)
		{
			$this->fullEmail = $fullEmail; 
		}

		/**
         * Trova il dominio dell'email
         */
		public function getDomain(){
			$this->domain = substr($this->fullEmail, strpos($this->fullEmail, '@')+1);
			return $this->domain;
		}

		/**
		 * Controlla se l'email dell'utente con id passato come parametro sia uguale a quella passata.
		 * Se torna 1 significa che l'email passata è uguale a quella presente sul database, altrimenti 0
		 * 
		 * @param Int $id -> id dell'utente
		 * @param Boolean $isDatore -> se l'utente è un datore oppure un dipendente 
		 */
		public function isOldEmail($id, $isDatore){
			require 'application/libs/connection.php';
			if($isDatore == true){
				$sql = $conn->prepare("SELECT * FROM datore WHERE id=? AND archiviato=0");
				$sql->bind_param("s", $id);
			}else{
				$sql = $conn->prepare("SELECT * FROM dipendente WHERE id=? AND archiviato=0");
				$sql->bind_param("s", $id);
			}
			$sql->execute();
			$result = $sql->get_result();
			$finEm = $result->fetch_assoc()['email'];
			if($finEm == $this->fullEmail){
				return true;
			}
			return false;
		}

		/**
         * Torna se l'email ha tuttte le caratteristiche valide oppure no
         */
		public function isValid(){
			if($this->checkFilters()){
				if($this->checkEmailsInDB()){
					return true;
				}else{
					throw new Exception("Email già esistente");
				}
			}else{
				throw new Exception("Email non valida");
			}
		}

		/**
         * Torna se l'email ha tutti i caratteri validi
         */
		public function checkFilters(){
			return filter_var($this->fullEmail, FILTER_VALIDATE_EMAIL);
		}

		/**
         * Torna se l'email è già presente nel database oppure no
         */
		public function checkEmailsInDB(){
			require 'application/libs/connection.php';
			$sql1 = $conn->prepare("SELECT * FROM dipendente WHERE email=? AND archiviato=0");
			$sql1->bind_param("s", $this->fullEmail);
			$sql2 = $conn->prepare("SELECT * FROM datore WHERE email=? AND archiviato=0");
			$sql2->bind_param("s", $this->fullEmail);
			$sql3 = $conn->prepare("SELECT * FROM amministratore WHERE email=?");
            $sql3->bind_param("s", $this->fullEmail);
			for($i=1;$i<=3;$i++){
				$currentQuery = 'sql' . $i;
				$$currentQuery->execute();
				$result = $$currentQuery->get_result();
				if($result){
					if ($result->num_rows > 0) {
						return false;
					}
				}
				$$currentQuery->close();
			}
			return true;
		}
	}
?>
