<form action="<?php echo URL ?>negozio/load" method="POST">
    <table style="margin: auto; margin-right:auto; margin-top:3em;">
        <tr>
            <div>
                <td>
                    <input type="submit" class="btn btn-dark btn-lg" style="height: 5em; width: 10em" name="aggiungiNegozio" value="Aggiungi negozio">
                </td>
                <td>
                    <input type="submit" class="btn btn-dark btn-lg" style="height: 5em; width: 10em" name="rimuoviNegozio" value="Rimuovi negozio">
                </td>
            </div>
        </tr>
            <div>
                <td>
                    <input type="submit" class="btn btn-dark btn-lg" style="height: 5em; width: 10em" name="mostraNegozi" value="Mostra negozi">
                </td>
                <td>
                    <input type="submit" class="btn btn-dark btn-lg" style="height: 5em; width: 10em" name="modificaNegozio" value="Modifica negozio">
                </td>
            </div>
        </tr>
    </table>
</form>