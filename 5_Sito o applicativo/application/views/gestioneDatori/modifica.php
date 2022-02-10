<h2>Modifica datore</h2>

<form method="POST" action="<?php echo URL; ?>gestionedatori/modifica">
    <table>
        <tr>
            <td>Datore</td>
            <td>
                <select name="id">
                    <?php for($i = 0; $i < count($this->data); $i++) : ?>
                        <option value="<?php echo $this->data[$i][1]; ?>" <?php echo (isset($this->selected[0]['id']) && $this->selected[0]['id'] == $this->data[$i][1] ? "SELECTED" : ""); ?> ><?php echo $this->data[$i][0]; ?></option>
                    <?php endfor; ?>
                </select>
                <input type="submit" name="datoreButton" value="Riempi campi"></td>
        </tr>
        <tr>
            <td>Nome</td>
            <td><input type="text" name="nome" value="<?php echo (isset($this->selected[0]['nome']) ? $this->selected[0]['nome'] : ""); ?>"></td>
        </tr>
        <tr>
            <td>Cognome</td>
            <td><input type="text" name="cognome" value="<?php echo (isset($this->selected[0]['cognome']) ? $this->selected[0]['cognome'] : ""); ?>"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="email" name="email" value="<?php echo (isset($this->selected[0]['email']) ? $this->selected[0]['email'] : ""); ?>"></td>
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
            <td><input type="text" name="indirizzo" value="<?php echo (isset($this->selected[0]['indirizzo']) ? $this->selected[0]['indirizzo'] : ""); ?>"></td>
        </tr>
        <tr>
            <td><input type="submit" name="modifica" value="Modifica"></td>
        </tr>
    </table>
    <?php echo (isset($this->error) ? $this->error : "" ); ?>
</form>