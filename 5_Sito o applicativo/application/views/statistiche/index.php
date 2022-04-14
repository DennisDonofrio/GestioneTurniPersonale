<form method="POST" action="<?php echo URL; ?>statistiche/stampa">
    <table style="margin: auto; margin-right:auto; margin-top:3em;">
        <tr>
            <th colspan="2"><h1>Statistiche</h1></th>
        </tr>
        <tr>
            <td>Data inizio</td>
            <td>Data fine</td>
        </tr>
        <tr>
            <td><input type="date" name="inizio"></td>
            <td><input type="date" name="fine"></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;"><input type="submit" name="calcola" value="Calcola" class="btn btn-dark btn-lg" style="margin: auto; margin-right:auto;"></td>
        </tr>
    </table>
</form>