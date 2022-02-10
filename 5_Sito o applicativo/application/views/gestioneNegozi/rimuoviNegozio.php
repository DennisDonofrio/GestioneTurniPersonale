<div class="d-flex justify-content-center pt-4 pb-4">
	<form action="<?php echo URL ?>negozio/eliminaNegozio" method="POST">
		<table>
			<thead>
                <tr>
					<td>
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
			</tbody>
		</table>
	</form>
</div>