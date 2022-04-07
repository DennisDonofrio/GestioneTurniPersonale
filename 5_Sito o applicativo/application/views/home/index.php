<?php if($_SESSION['role'] == 1): ?>
   <h1>Benvenuto dipendente [nome]</h1>
       
   <table style="margin: auto; margin-right:auto; margin-top:3em;">
        <tr>
            <div>
                <td>
                    <input type="button" class="btn btn-dark btn-lg" style="height: 5em; width: 10em" onclick="window.location.href='<?php echo URL; ?>home/negozio'" value="Scegli negozio">
                </td>
            </div>
        </tr>
    </table>

<?php elseif($_SESSION['role'] == 2): ?>
   <h1>Benvenuto datore [nome]</h1>
   <table style="margin: auto; margin-right:auto; margin-top:3em;">
        <tr>
            <div>
                <td>
                    <input type="button" class="btn btn-dark btn-lg" style="height: 5em; width: 10em" onclick="window.location.href='<?php echo URL; ?>calendario'" value="Calendario">
                </td>
                <td>
                    <input type="button" class="btn btn-dark btn-lg" style="height: 5em; width: 10em" onclick="window.location.href='<?php echo URL; ?>dipendente'" value="Gesisci dipendenti">
                </td>
            </div>
        </tr>
            <div>
                <td>
                    <input type="button" class="btn btn-dark btn-lg" style="height: 5em; width: 10em" onclick="window.location.href='<?php echo URL; ?>gestioneOrari'" value="Gestisci orari">
                </td>
                <td>
                    <input type="button" class="btn btn-dark btn-lg" style="height: 5em; width: 10em" onclick="window.location.href='<?php echo URL; ?>negozio'" value="Gestisci negozio">
                </td>
            </div>
        </tr>
      </table>
<?php elseif($_SESSION['role'] == 3): ?>
   <h1>Benvenuto admin [nome]</h1>
    <table style="margin: auto; margin-right:auto; margin-top:3em;">
        <tr>
            <div>
                <td>
                    <input type="button" class="btn btn-dark btn-lg" style="height: 5em; width: 10em" onclick="window.location.href='<?php echo URL; ?>gestioneDatori'" value="Gestione Datori">
                </td>
            </div>
        </tr>
    </table>
<?php endif; ?>