<?php
	/**
	 * classe per il controllo della email
	 */
	class Email
	{
		private $fullEmail;
		private $domain;
		function __construct($fullEmail)
		{
			$this->fullEmail = $fullEmail; 
		}

		function getDomain(){
			$this->domain = substr($this->fullEmail, strpos($this->fullEmail, '@')+1);
			return $this->domain;
		}

		function isValid(){
			return filter_var($this->fullEmail, FILTER_VALIDATE_EMAIL);
		}
	}
?>
