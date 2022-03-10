<form action="<?php echo URL ?>gestioneDatori/action" method="POST">
    <table style="margin: auto; margin-right:auto; margin-top:3em;">
        <tr>
            <div>
                <td>
                    <input type="submit" class="btn btn-dark btn-lg" style="height: 5em; width: 15em" name="aggiungi" value="Aggiungi datore">
                </td>
                <td>
                    <input type="submit" class="btn btn-dark btn-lg" style="height: 5em; width: 15em" name="modifica" value="Modifica datore">
                </td>
            </div>
        </tr>
            <div>
                <td>
                    <input type="submit" class="btn btn-dark btn-lg" style="height: 5em; width: 15em" name="rimuovi" value="Rimuovi datore">
                </td>
                <td>
                    <input type="submit" class="btn btn-dark btn-lg" style="height: 5em; width: 15em" name="mostra" value="Mostra datore">
                </td>
            </div>
        </tr>
    </table>
</form>