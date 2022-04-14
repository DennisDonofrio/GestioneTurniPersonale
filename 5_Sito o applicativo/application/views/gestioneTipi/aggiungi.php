<div class="d-flex justify-content-center pt-4 pb-4">
	<form action="<?php echo URL ?>gestioneTipi/aggiungiTipo" method="POST">
		<table>
			<thead>
				<tr>
                    <h1>Aggiungi tipo</h1>
				</tr>
			</thead>
			<tbody>
                <tr>
					<td>
						<label>Nome:</label>
					</td>
					<td>
						<input type="text" name="nome" autocomplete="off">
					</td>
				</tr>
                <tr>
					<td>
						<label>Descrizione:</label>
					</td>
					<td>
						<input type="text" name="descrizione" autocomplete="off">
					</td>
				</tr>
                <tr>
					<td colspan="2" style="text-align:center">
					<br>
						<input type="submit" class="btn btn-dark" name="aggiungi" value="Aggiungi">
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
<?php if(isset($data['error'])){ ?>
	<h2 id="errorModifyComponent" style="text-align: center" class="alert alert-danger"> <?php echo $data['error'] ?></h2>
<?php } ?>