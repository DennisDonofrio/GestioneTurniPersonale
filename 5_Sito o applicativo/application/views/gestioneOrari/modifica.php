<div class="d-flex justify-content-center pt-4 pb-4">
<form method="POST" action="<?php echo URL; ?>gestioneOrari/modifica">
    <table>
        <thead>
            <tr>
                <h1>Modifica orario</h1>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Orario</td>
                <td>
                    <select name="orario">
                        <?php for($i = 0; $i < count($data['orario']) - 1; $i++) : ?>
                            <option value="<?php echo $data['orario'][$i]['id']; ?>"><?php echo substr($data['orario'][$i]['inizio'], 0, 5) . " - " . substr($data['orario'][$i]['fine'], 0, 5); ?></option>
                        <?php endfor; ?>
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
                    <input type="submit" class="btn btn-dark" name="modifica" value="Modifica orario">
                </td>
            </tr>
        </tbody>
    </table>
</form>
</div>
<h2 style="text-align: center"<?php echo (isset($this->error) ? 'class="alert alert-danger">' . $this->error: ">" ); ?></h2>