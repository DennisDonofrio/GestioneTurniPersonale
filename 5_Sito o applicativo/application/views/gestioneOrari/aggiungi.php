<form method="POST" action="<?php echo URL; ?>gestioneOrari/aggiungi">
    <table>
        <tr>
            <td>Inizio</td>
            <td><input type="time" name="inizio"></td>
        </tr>
        <tr>
            <td>Fine</td>
            <td><input type="time" name="fine"></td>
        </tr>
    </table>
    <input type="submit" name="aggiungi" value="Aggiungi datore"><br>
    <?php echo (isset($this->error) ? $this->error : "" ); ?>
</form>