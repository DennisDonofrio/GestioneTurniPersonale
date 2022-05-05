<h1 style="text-align: center; padding:25px;">Mostra tipi</h1>
<?php if($data['tipi'] != false){ ?>
    <table class="table table-gray">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Descrizione</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['tipi'] as $tipo){ ?>
                <tr>
                    <?php foreach($tipo as $campo){ ?>
                        <td><?php echo $campo ?></td>
                    <?php }?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php }else{ ?>
    <h3>Nessun tipo disponibile</h3>
<?php } ?>