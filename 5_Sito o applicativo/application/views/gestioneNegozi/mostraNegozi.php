<h1 style="text-align: center; padding:25px;">Mostra negozi</h1>
<?php if($data['negozi'] != false){ ?>
    <table class="table table-gray">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Indirizzo</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['negozi'] as $negozio){ ?>
                <tr>
                    <?php foreach($negozio as $campo){ ?>
                        <td><?php echo $campo ?></td>
                    <?php }?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php }else{ ?>
    <h3>Nessun negozio disponibile</h3>
<?php } ?>