<h1 style="text-align: center; padding:25px;">Orari</h1>
<?php if($data['orario'] != false){ ?>
    <table class="table table-gray">
        <thead>
            <tr>
                <th>Inizio</th>
                <th>Fine</th>
            </tr>
        </thead>
        <tbody>
            <?php for($i = 0; $i < count($data['orario']) - 1; $i++) : ?>
                <tr>
                    <td><?php echo substr($data['orario'][$i]['inizio'], 0, 5); ?></td>
                    <td><?php echo substr($data['orario'][$i]['fine'], 0, 5); ?></td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
<?php }else{ ?>
    <h3>Nessun orario disponibile</h3>
<?php } ?>