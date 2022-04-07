<?php
	/**
	 * classe adatta per controllare che non ci siano script injectati in campi di testo
	 */
	class AntiCsScript
	{
		static function checkAntiScript($text){
			if(strpos($text, 'script')){
                $text = str_replace("script", "", $text);
            }
            /*if(str_contains($text, '<')){
                $text = str_replace("<", "", $text);
            }
            if(str_contains($text, '>')){
                $text = str_replace(">", "", $text);
            }*/
            return $text;
		}

        static public function check($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return AntiCsScript::checkAntiScript($data);
        }
	}
?>
