<?php
	/**
	 * classe adatta agli hash delle password
	 */
	class Hash
	{
		private $plainText;
		private $hashedText;
		public function __construct($plainText)
		{
			$this->plainText = $plainText; 
		}

		/**
         * Viene effettuato l'hash in sha256 della password combinata ad una salt
         * 
         * @param String $salt -> testo da utilizzare come salt
         */
		public function doHash($salt){
			$this->hashedText = hash('sha256', $salt . hash('sha256', $this->plainText));
		}

		/**
         * Torna la stringa in sha256
         */
		public function getHashed(){
			return $this->hashedText;
		}
	}
?>
