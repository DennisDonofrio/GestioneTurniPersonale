<h1>Seleziona un negozio</h1>
<form method="post" action="<?php echo URL; ?>calendario/impostaNegozio">
    <select name="negozio">
        <?php foreach($data['negozi'] as $negozio): ?>
            <option value="<?php echo $negozio['id']; ?>">
                <?php echo $negozio['nome']; ?> 
            </option>
        <?php endforeach; ?>
    </select>
    <input type="submit" class="btn btn-dark" value="Seleziona">
</form>