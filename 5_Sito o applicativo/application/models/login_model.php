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
			$this->email = $email;
			$this->password = $password; 
		}

		function getHashedPass(){
			require 'application/libs/hash.php';
			$hashUser = new Hash($this->password);
			$hashUser->doHash($this->email);
			$this->hashedPassword = $hashUser->getHashed();
		}

		function doLogin(){
			require 'application/libs/connection.php';
            $this->getHashedPass();
            $sql1 = "SELECT * FROM dipendente WHERE email='$this->email' AND hash_password='$this->hashedPassword' AND archiviato=0";
			$sql2 = "SELECT * FROM datore WHERE email='$this->email' AND hash_password='$this->hashedPassword' AND archiviato=0";
			$sql3 = "SELECT * FROM amministratore WHERE email='$this->email' AND hash_password='$this->hashedPassword'";
			for($i=1;$i<=3;$i++){
				$currentQuery = 'sql' . $i;
				$result = $conn->query($$currentQuery);
				if($result){
					if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						$_SESSION['id'] = $row['id'];
						$_SESSION['role'] = $i;
						return true;
					}
				}
			}
			session_destroy();
			return false;
		}
	}
?>
