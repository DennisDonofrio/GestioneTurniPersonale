<?php $dati = $data['dati']; ?>
<table style="margin: auto; margin-right:auto; margin-top:3em;" class="table table-gray">
    <tr><th>Nome</th><th>Ore feriali</th><th>Ore festivi</th><th>Ore totali</th></tr>
    <?php for ($i=0; $i < count($dati); $i++) : ?>
        <tr>
            <td>
                <?php echo $dati[$i][0]; ?>
            </td>
            <td>
                <?php echo $dati[$i][1]; ?>
            </td>
            <td>
                <?php echo $dati[$i][2]; ?>
            </td>
            <td>
                <?php echo $dati[$i][3]; ?>
            </td>
        </tr>
    <?php endfor; ?>
</table>