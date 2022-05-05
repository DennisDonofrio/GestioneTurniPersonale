<h1 style="text-align: center; padding:25px;">Seleziona un negozio</h1>
<?php if(!empty($data['negozi'])) : ?>
<form method="post" action="<?php echo URL; ?>negozio/impostaOrario">
    <div style="text-align: center; padding:25px;">
    <select name="negozio">
        <?php foreach($data['negozi'] as $negozio): ?>
            <option value="<?php echo $negozio['id']; ?>">
                <?php echo $negozio['nome']; ?> 
            </option>
        <?php endforeach; ?>
    </select>
    <br>
    <br>
    <input type="submit" class="btn btn-dark" value="Seleziona">
    </div>
</form>
<?php else : ?>
    <h3 style="text-align: center; padding:25px;">Nessun negozio disponibile</h3>
<?php endif; ?>