<h1 style="text-align: center; padding:25px;">Mostra dipendenti</h1>
<?php if($data['dipendenti'] != false): ?>
    <table class="table table-gray">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Email</th>
                <th>indirizzo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['dipendenti'] as $dipendente): ?>
                <tr>
                    <?php foreach($dipendente as $campo): ?>
                        <td><?php echo $campo ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <h3 style="text-align: center; padding:25px;">Nessun dipendente disponibile</h3>
<?php endif ?>