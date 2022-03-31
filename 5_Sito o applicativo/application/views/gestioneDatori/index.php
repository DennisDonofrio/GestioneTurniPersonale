<form action="<?php echo URL ?>gestioneDatori/action" method="POST">
    <table style="margin: auto; margin-right:auto; margin-top:3em;">
        <tr>
            <div>
                <td>
                    <input type="button" class="btn btn-dark btn-lg" style="height: 5em; width: 12em" onclick="window.location.href='<?php echo URL; ?>gestioneDatori/aggiungi'" value="Aggiungi datore">
                </td>
                <td>
                    <input type="button" class="btn btn-dark btn-lg" style="height: 5em; width: 12em" onclick="window.location.href='<?php echo URL; ?>gestioneDatori/modifica'" value="Modifica datore">
                </td>
            </div>
        </tr>
            <div>
                <td>
                    <input type="button" class="btn btn-dark btn-lg" style="height: 5em; width: 12em" onclick="window.location.href='<?php echo URL; ?>gestioneDatori/rimuovi'" value="Rimuovi datore">
                </td>
                <td>
                    <input type="button" class="btn btn-dark btn-lg" style="height: 5em; width: 12em" onclick="window.location.href='<?php echo URL; ?>gestioneDatori/mostra'" value="Mostra datore">
                </td>
            </div>
        </tr>
    </table>
</form>