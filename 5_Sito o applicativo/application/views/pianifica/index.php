<h1 style="text-align: center;">Pianifica orario automaticamente</h1>
<form action="<?php echo URL; ?>pianifica/pianificaOrario" method="POST">
    <?php if(!empty($data['negozi'])) : ?>  
    <table style="margin: auto; margin-right:auto; margin-top:3em;">
        <tr>
            <td>
                Seleziona il negozio di cui si vuole pianificare l'orario
            </td>
            <td>
                <select name="negozio">
                    <?php foreach($data['negozi'] as $negozio): ?>
                        <option value="<?php echo $negozio['id']; ?>"><?php echo $negozio['nome']; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Inserisci la data da cui cominciare a pianificare
            </td>
            <td>
                <input type="date" name="inizio">
            </td>
        </tr>
        <tr>
            <td>
                Inserisci la data in cui termina la programmazione
            </td>
            <td>
                <input type="date" name="fine">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;padding-top: 50px;">
                <input type="submit" class="btn btn-dark btn-lg" value="Pianifica">
            </td>
        </tr>
    </table>
    <?php else : ?>
        <br>
        <h3 style="text-align: center;">Nessun negozio disponibile</h3>
    <?php endif; ?>
</form>

<?php if(isset($data['errore'])) : ?>
	<h2 id="errorLogin" style="text-align: center" class="alert alert-danger"> <?php echo $data['errore'] ?></h2>
<?php endif; ?>