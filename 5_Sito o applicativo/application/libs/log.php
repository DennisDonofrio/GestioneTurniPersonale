<?php
/**
 * classe adatta per scrivere log
 */
class Log
{
    /**
     * Scrive in un file log predefinito il messaggio con la relativa ora e utente. 
     * Serve per tenere traccia di tutte le operazioni andate a buon fine
     * 
     * @param String $msg -> messaggio da inserire nel log
     */
    public static function writeLog($msg){
        if($puntatore = fopen('application/logs/log.log', "a")){
            $user = isset($_SESSION['id']) ? $_SESSION['id'] : "undefined";
            $role = isset($_SESSION['roleType']) ? $_SESSION['roleType'] : "no role";
            $str = date("Y/m/d H:i:s"). " role=" . $role . ", user_id=" . $user . ": " . $msg;
            fwrite($puntatore, $str . PHP_EOL);
        }
    }

    /**
     * Scrive in un file log di errore predefinito il messaggio con la relativa ora e utente. 
     * Serve per tenere traccia di tutti gli errori avvenuti.
     * 
     * @param String $msg -> messaggio da inserire nel log di errore
     */
    public static function writeErrorLog($msg){
        if($puntatore = fopen('application/logs/logError.log', "a")){
            $user = isset($_SESSION['id']) ? $_SESSION['id'] : "undefined";
            $role = isset($_SESSION['roleType']) ? $_SESSION['roleType'] : "no role";
            $str = date("Y/m/d H:i:s") . " role=" . $role .", user_id=" . $user . ": " . $msg;
            fwrite($puntatore, $str . PHP_EOL);
        }
    }
}
?>
