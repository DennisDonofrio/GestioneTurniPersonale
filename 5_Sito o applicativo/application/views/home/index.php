<?php if($_SESSION['role'] == 1): ?>
   <h1>Benvenuto dipendente [nome]</h1>
       
<?php elseif($_SESSION['role'] == 2): ?>
   <h1>Benvenuto datore [nome]</h1>
   <form action="<?php echo URL ?>home/load" method="POST">
    <table style="margin: auto; margin-right:auto; margin-top:3em;">
        <tr>
            <div>
                <td>
                    <input type="submit" class="btn btn-dark btn-lg" style="height: 5em; width: 10em" name="calendario" value="Calendario">
                </td>
                <td>
                    <input type="submit" class="btn btn-dark btn-lg" style="height: 5em; width: 10em" name="gestisciDipendenti" value="Gesisci dipendenti">
                </td>
            </div>
        </tr>
            <div>
                <td>
                    <input type="submit" class="btn btn-dark btn-lg" style="height: 5em; width: 10em" name="gestisciOrari" value="Gestisci orari">
                </td>
                <td>
                    <input type="submit" class="btn btn-dark btn-lg" style="height: 5em; width: 10em" name="gestisciNegozi" value="Gestisci negozio">
                </td>
            </div>
        </tr>
      </table>
   </form>
<?php elseif($_SESSION['role'] == 3): ?>
   <h1>Benvenuto admin [nome]</h1>
   <form action="<?php echo URL ?>home/load" method="POST">
        <table style="margin: auto; margin-right:auto; margin-top:3em;">
            <tr>
                <div>
                    <td>
                        <input type="submit" class="btn btn-dark btn-lg" style="height: 5em; width: 10em" name="gestioneDatori" value="Gestione Datori">
                    </td>
                </div>
            </tr>
      </table>
   </form>
<?php endif; ?>