<h2>Elimina datore</h2>

<form method="POST" action="<?php echo URL; ?>gestionedatori/rimuovi">
    <table>
        <tr>
            <td>Email</td>
            <td>
                <select name="id">
                    <?php for($i = 0; $i < count($this->data) - 1; $i++) : ?>
                        <option value="<?php echo $this->data[$i]['id']; ?>"><?php echo $this->data[$i]['email']; ?></option>
                    <?php endfor; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Conferma email</td>
            <td>
                <input type="email" name="email">
            </td>
        </tr>
    </table>
    <input type="submit" name="elimina" value="Elimina datore"><br>
    <?php echo (isset($this->error) ? $this->error : "" ); ?>
</form>