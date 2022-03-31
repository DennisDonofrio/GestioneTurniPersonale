<?php
	/**
	 * classe adatta per controllare che non ci siano script injectati in campi di testo
	 */
	class AntiCsScript
	{
         /**
         * Questo metodo permette di controllare se una stringa contenga 
         * parti di script che potrebbero essere eseguite involontariamente
         * 
         * @param String $text -> la stringa da controllare
         */
		public static function checkAntiScript($text){
			if(strpos($text, 'script')){
                $text = str_replace("script", "", $text);
            }
            return $text;
		}

        /**
         * Questo metodo permette di rimuovere spazi vuoti, gli slash, 
         * e caratteri speciali da una stringa
         * 
         * @param String $data -> la stringa da controllare
         */
        public static function check($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return AntiCsScript::checkAntiScript($data);
        }
	}
?>
