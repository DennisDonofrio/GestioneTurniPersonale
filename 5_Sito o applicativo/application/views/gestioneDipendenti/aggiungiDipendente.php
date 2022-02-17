<div class="d-flex justify-content-center pt-4 pb-4">
	<form action="<?php echo URL ?>dipendente/aggiungiDipendente" method="POST">
		<table>
			<thead>
				<tr>
                    <h1>Aggiungi dipendente</h1>
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
						<label>Cognome:</label>
					</td>
					<td>
						<input type="text" name="cognome" autocomplete="off">
					</td>
				</tr>
                <tr>
					<td>
						<label>Email:</label>
					</td>
					<td>
						<input type="mail" name="email" autocomplete="off">
					</td>
				<tr>
					<td>
						<label>Indirizzo:</label>
					</td>
					<td>
						<input type="text" name="indirizzo" autocomplete="off">
					</td>
				</tr>
                <tr>
					<td>
						<label>Password:</label>
					</td>
					<td>
						<input type="password" name="password1" autocomplete="off">
					</td>
				</tr>
                <tr>
					<td>
						<label>Ripeti la password:</label>
					</td>
					<td>
						<input type="password" name="password2" autocomplete="off">
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center">
					<br>
						<input type="submit" class="btn btn-dark" value="Aggiungi">
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
<?php if(isset($data['error'])){ ?>
	<h2 id="errorModifyComponent" style="text-align: center" class="alert alert-danger"> <?php echo $data['error'] ?></h2>
<?php } ?>