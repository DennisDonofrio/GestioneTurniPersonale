<form method="POST" action="<?php echo URL; ?>gestioneOrari/action">
    <table style="margin: auto; margin-right:auto; margin-top:3em;">
        <tr>
            <div>
                <td>
                <input type="submit" class="btn btn-dark btn-lg" style="height: 5em; width: 10em" name="aggiungi" value="Aggiungi orario">
                </td>
                <td>
                <input type="submit" class="btn btn-dark btn-lg" style="height: 5em; width: 10em" name="modifica" value="Modifica orario">
                </td>
            </div>
        </tr>
            <div>
                <td>
                    <input type="submit" class="btn btn-dark btn-lg" style="height: 5em; width: 10em" name="rimuovi" value="Rimuovi orario">
                </td>
                <td>
                    <input type="submit" class="btn btn-dark btn-lg" style="height: 5em; width: 10em" name="mostra" value="Mostra orario">
                </td>
            </div>
        </tr>
      </table>
   </form>