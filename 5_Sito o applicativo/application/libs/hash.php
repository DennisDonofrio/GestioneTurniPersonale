<?php
	/**
	 * classe adatta agli hash delle password
	 */
	class Hash
	{
		private $plainText;
		private $hashedText;
		function __construct($plainText)
		{
			$this->plainText = $plainText; 
		}

		function doHash($salt){
			$this->hashedText = hash('sha256', $salt . hash('sha256', $this->plainText));
		}

		function getHashed(){
			return $this->hashedText;
		}
	}
?>
