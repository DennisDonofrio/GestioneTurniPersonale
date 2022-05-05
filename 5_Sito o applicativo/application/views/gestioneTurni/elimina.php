<div class="d-flex justify-content-center pt-4 pb-4">
<form method="POST" action="<?php echo URL; ?>gestioneTurni/elimina">
    <table style="margin: auto; margin-right:auto; margin-top:3em;">
        <thead>
            <tr>
                <h1>Elimina Turno</h1>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Orario</td>
                <td>
                    <select name="turno">
                        <?php for($i = 0; $i < count($data['turni']); $i++) : ?>
                            <option value="<?php echo $data['turni'][$i]['id']; ?>"><?php echo substr($data['turni'][$i]['inizio'], 0, 5) . " - " . substr($data['turni'][$i]['fine'], 0, 5); ?></option>
                        <?php endfor; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center">
                    <br>
                    <input type="submit" class="btn btn-dark" name="elimina" value="Elimina turno">
                </td>
            </tr>
        </tbody>
    </table>
</form>
</div>
<h2 style="text-align: center"<?php echo (isset($data['error']) ? 'class="alert alert-danger">' . $data['error']: ">" ); ?></h2>