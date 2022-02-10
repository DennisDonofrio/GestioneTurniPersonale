<form method="POST" action="<?php echo URL; ?>gestionedatori/aggiungi">
    <table>
        <tr>
            <td>Nome</td>
            <td><input type="text" name="nome"></td>
        </tr>
        <tr>
            <td>Cognome</td>
            <td><input type="text" name="cognome"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="email" name="email"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="pass1"></td>
        </tr>
        <tr>
            <td>Ripetere password</td>
            <td><input type="password" name="pass2"></td>
        </tr>
        <tr>
            <td>Indirizzo</td>
            <td><input type="text" name="indirizzo"></td>
        </tr>
    </table>
    <input type="submit" name="aggiungi" value="Aggiungi datore"><br>
    <?php echo (isset($this->error) ? $this->error : "" ); ?>
</form>