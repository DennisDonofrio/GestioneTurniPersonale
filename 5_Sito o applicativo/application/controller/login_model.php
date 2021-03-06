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

		function getHashedPass(){
			require 'application/libs/hash.php';
			$hashUser = new Hash($this->password);
			$hashUser->doHash($this->email);
			$this->hashedPassword = $hashUser->getHashed();
		}

		function doLogin(){
			require 'application/libs/connection.php';
            $this->getHashedPass();
			$sql1 = $conn->prepare("SELECT * FROM dipendente WHERE email=? AND hash_password=? AND archiviato=0");
			$sql1->bind_param("ss", $this->email, $this->hashedPassword);
			$sql2 = $conn->prepare("SELECT * FROM datore WHERE email=? AND hash_password=? AND archiviato=0");
			$sql2->bind_param("ss", $this->email, $this->hashedPassword);
			$sql3 = $conn->prepare("SELECT * FROM amministratore WHERE email=? AND hash_password=?");
            $sql3->bind_param("ss", $this->email, $this->hashedPassword);
			//$sql1 = "SELECT * FROM dipendente WHERE email='$this->email' AND hash_password='$this->hashedPassword' AND archiviato=0";
			//$sql2 = "SELECT * FROM datore WHERE email='$this->email' AND hash_password='$this->hashedPassword' AND archiviato=0";
			//$sql3 = "SELECT * FROM amministratore WHERE email='$this->email' AND hash_password='$this->hashedPassword'";
			for($i=1;$i<=3;$i++){
				$currentQuery = 'sql' . $i;
				$$currentQuery->execute();
				$result = $$currentQuery->get_result();
				if($result){
					if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						$_SESSION['id'] = $row['id'];
						$_SESSION['role'] = $i;
						return true;
					}
				}
				$$currentQuery->close();
			}
			session_destroy();
			return false;
		}

		public static function ottieniNome(){
			if(isset($_SESSION['id']) && isset($_SESSION['role'])){
				require 'application/libs/connection.php';
				switch ($_SESSION['role']) {
					case 1:
						$sql = $conn->prepare("SELECT nome FROM dipendente WHERE id=? AND archiviato=0");
						break;
					case 2:
						$sql = $conn->prepare("SELECT nome FROM datore WHERE id=? AND archiviato=0");
						break;
					case 3:
						$sql = $conn->prepare("SELECT nome FROM amministratore WHERE id=? AND in_uso=1");
						break;
				}
				$sql->bind_param("i", $_SESSION['id']);
				$sql->execute();
				//var_dump($sql->get_result()->fetch_assoc());
				$out = $sql->get_result()->fetch_assoc()['nome'];
			}else{
				$out = "[nome]";
			}
			return $out;
		}
	}
?>
