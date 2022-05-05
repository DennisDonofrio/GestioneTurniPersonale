<h1 style="text-align: center; padding:25px;">Turni</h1>
<?php if($data['turni'] != false){ ?>
    <table class="table table-gray">
        <thead>
            <tr>
                <th>Inizio</th>
                <th>Fine</th>
                <th>Giorno</th>
            </tr>
        </thead>
        <tbody>
            <?php for($i = 0; $i < count($data['turni']); $i++) : ?>
                <tr>
                    <td><?php echo substr($data['turni'][$i]['inizio'], 0, 5); ?></td>
                    <td><?php echo substr($data['turni'][$i]['fine'], 0, 5); ?></td>
                    <td><?php echo $data['turni'][$i]['nome']; ?></td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
<?php }else{ ?>
    <h3 style="text-align: center; padding:25px;">Nessun turno disponibile</h3>
<?php } ?>