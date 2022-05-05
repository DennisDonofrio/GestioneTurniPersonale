<div class="d-flex justify-content-center pt-4 pb-4">
	<form action="<?php echo URL ?>negozio/eliminaNegozio" method="POST">
		<table>
			<thead>
				<tr>
					<td colspan="2"><h1>Rimuovi negozio</h1></td>
				</tr>
			</thead>
			<tbody>
			<?php if(!empty($data['negozi'])) : ?>
                <tr>
					<td style="text-align: right;">
						<label>Negozio:</label>
					</td>
					<td>
                        <select name="negozio">
                            <?php foreach($data['negozi'] as $negozio): ?>
                                <option value="<?php echo $negozio["id"]; ?>"><?php echo $negozio["nome"]; ?></option>
                            <?php endforeach; ?>
                        </select>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center">
					<br>
						<input type="submit" class="btn btn-dark" value="Rimuovi">
					</td>
				</tr>
			<?php else : ?>
				<tr><td><h3>Nessun negozio disponibile</h3></td></tr>
			<?php endif; ?>
			</tbody>
		</table>
	</form>
</div>