<div class="d-flex justify-content-center pt-4 pb-4">
<form method="POST" action="<?php echo URL; ?>gestioneOrari/aggiungi">
    <table>
        <thead>
            <tr>
                <h1>Aggiungi orario</h1>
            </tr>
        </thead>
        <tbody>
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
<h2 style="text-align: center"<?php echo (isset($this->error) ? 'class="alert alert-danger">' . $this->error: ">" ); ?></h2>