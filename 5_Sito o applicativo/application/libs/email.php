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
         * Torna se l'email ha tuttte le caratteristiche valide oppure no
         */
		public function isValid(){
			return filter_var($this->fullEmail, FILTER_VALIDATE_EMAIL);
		}
	}
?>
