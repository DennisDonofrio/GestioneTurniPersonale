<h1 style="text-align: center; padding:25px;">Rimuovi dipendente</h1>
<?php if($data['dipendenti'] != false): ?>
<div class="d-flex justify-content-center pt-4 pb-4">
	<form action="<?php echo URL ?>dipendente/rimuoviDipendente" method="POST">
		<table>
			<tbody>
                <tr>
					<td>
						<label>Dipendente:</label>
					</td>
					<td>
                        <select name="dipendente">
                            <?php foreach($data['dipendenti'] as $dipendente): ?>
                                <option value="<?php echo $dipendente["id"]; ?>"><?php echo $dipendente["nome"] . " " . $dipendente['cognome']; ?></option>
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
<?php else: ?>
    <h3 style="text-align: center; padding:25px;">Nessun dipendente disponibile</h3>
<?php endif ?>