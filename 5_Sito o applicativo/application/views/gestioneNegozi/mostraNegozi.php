<h1 style="text-align: center;">Mostra negozi</h1>
<table class="table table-gray">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Indirizzo</th>
            <th>Tipo</t>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data['negozi'] as $negozio){ ?>
            <tr>
                <?php foreach($negozio as $campo){ ?>
                    <td><?php echo $campo ?></td>
                <?php }?>
            </tr>
        <?php }?>
    </tbody>

</table>