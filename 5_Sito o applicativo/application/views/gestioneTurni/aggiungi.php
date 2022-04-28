<div class="d-flex justify-content-center pt-4 pb-4">
<form method="POST" action="<?php echo URL; ?>gestioneTurni/aggiungi">
    <table>
        <thead>
            <tr>
                <h1>Aggiungi Turno</h1>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Negozio</td>
                <td>
                    <select name="negozio">
                        <?php foreach($data['negozi'] as $negozio): ?>
                            <option value="<?php echo $negozio['id'] ?>"><?php echo $negozio['nome'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Giorno</td>
                <td>
                    <select name="giorno">
                        <?php foreach($data['giorni'] as $giorno): ?>
                            <option value="<?php echo $giorno['id'] ?>"><?php echo $giorno['nome'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Inizio</td>
                <td><input type="time" name="inizio"></td>
            </tr>
            <tr>
                <td>Fine</td>
                <td><input type="time" name="fine"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center">
                <br>
                    <input type="submit" class="btn btn-dark" name="aggiungi" value="Aggiungi orario">
                </td>
            </tr>
        </tbody>
    </table>
</form>
</div>
<h2 style="text-align: center"<?php echo (isset($this->error) ? 'class="alert alert-danger">' . $this->error: ">" ); ?>></h2>