<?php
	/**
	 * classe per il controllo della password
	 */
	class Password
	{
		private $password;

		public function __construct($password)
		{
			$this->password = $password; 
		}

		/**
         * Questo metodo permette di controllare che una password 
		 * abbia tutte le caratteristiche per essere valida
         */
		public function isValid(){
			$pass = $this->password;
			$uppercase = preg_match('@[A-Z]@', $pass);
			$lowercase = preg_match('@[a-z]@', $pass);
			$number = preg_match('@[0-9]@', $pass);
			$specialChars = preg_match('@[^\w]@', $pass);
			if(!$uppercase || !$lowercase || !$number 
				|| !$specialChars || strlen($pass) < 8) {
					return false;
			}
			return true;
		}
	}
?>

