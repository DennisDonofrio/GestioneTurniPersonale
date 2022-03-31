<?php

class EmailModel{

    public function inviaEmailANegozio(){
        require 'application/libs/connection.php';
        $query = $conn->prepare("SELECT d.email, d.nome from dipendente d inner join turno_lavoro t on t.dipendente_id = d.id where t.negozio_id = ? group by d.id");
        $query->bind_param("i", $_SESSION['negozio_id']);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                try{
                    $this->invia($row['email'], $row['nome']);
                }catch(Exception $e){
                    echo $e->getMessage();
                }
            }
        }
    }

    public function invia($destinatario, $nome) {
        if (filter_var($destinatario, FILTER_VALIDATE_EMAIL)) {
            $oggetto = "Aggiornamento orario di lavoro";
            
            $messaggio =  file_get_contents(__DIR__ . "../views/email/index.php");
            $messaggio = str_replace("Salve!", "Salve $nome!", $messaggio);
            
            $header = "From:gioele.zanetti@samtrevano.ch\r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";
            
            $retval = mail($destinatario,$oggetto,$messaggio,$header);
            
            if( !$retval ) {
                throw new Exception("Email con destinatario $destinatario non inviata" . PHP_EOL);
            }
        }else{
            throw new Exception("Email $destinatario non valida" . PHP_EOL);
        }
    }

}

?>