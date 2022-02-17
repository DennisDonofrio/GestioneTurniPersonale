<form action="<?php echo URL ?>dipendente/load" method="POST">
    <table style="margin: auto; margin-right:auto; margin-top:3em;">
        <tr>
            <div>
                <td>
                    <input type="submit" class="btn btn-dark btn-lg" style="height: 5em; width: 15em" name="aggiungiDipendente" value="Aggiungi dipendente">
                </td>
                <td>
                    <input type="submit" class="btn btn-dark btn-lg" style="height: 5em; width: 15em" name="rimuoviDipendente" value="Rimuovi dipendente">
                </td>
            </div>
        </tr>
            <div>
                <td>
                    <input type="submit" class="btn btn-dark btn-lg" style="height: 5em; width: 15em" name="mostraDipendenti" value="Mostra dipendenti">
                </td>
                <td>
                    <input type="submit" class="btn btn-dark btn-lg" style="height: 5em; width: 15em" name="modificaDipendente" value="Modifica dipendente">
                </td>
            </div>
        </tr>
    </table>
</form>