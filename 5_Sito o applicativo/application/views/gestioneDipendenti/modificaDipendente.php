<div class="d-flex justify-content-center pt-4 pb-4">
	<form action="<?php echo URL ?>dipendente/modificaDipendente" method="POST">
		<table>
			<thead>
				<tr>
                    <h1>Modifica dipendente</h1>
				</tr>
			</thead>
			<tbody>
                <tr>
					<td>
						<label>Dipendente:</label>
					</td>
					<td>
                        <select name="dipendente">
                            <?php foreach($data['dipendenti'] as $dipendente): ?>
                                <option value="<?php echo $dipendente["id"]; ?>" <?php echo (isset($data['dipendente'][0]['id']) && $data['dipendente'][0]['id'] == $dipendente["id"] ? "SELECTED" : ""); ?>><?php echo $dipendente["nome"] . " " . $dipendente['cognome']; ?></option>
                            <?php endforeach; ?>
                        </select>
					</td>
				</tr>
                <tr>
                    <td>
                        <br>
                    </td>
                </tr>
				<tr>
					<td colspan="2" style="text-align:center">
						<input type="submit" class="btn btn-dark" name="riempi" value="Riempi colonne">
					</td>
                </tr>
				<tr>
                    <td>
                        <br>
                    </td>
                </tr>
				<tr>
					<td>
						<label>Nome:</label>
					</td>
					<td>
						<input type="text" name="nome" autocomplete="off" value="<?php echo (isset($data['dipendente'][0]['nome']) ? $data['dipendente'][0]['nome'] : ""); ?>">
					</td>
				</tr>
                <tr>
					<td>
						<label>Cognome:</label>
					</td>
					<td>
                        <input type="text" name="cognome" autocomplete="off" value="<?php echo (isset($data['dipendente'][0]['cognome']) ? $data['dipendente'][0]['cognome'] : ""); ?>">
					</td>
				</tr>
                <tr>
					<td>
						<label>Email:</label>
					</td>
					<td>
                        <input type="email" name="email" autocomplete="off"  value="<?php echo (isset($data['dipendente'][0]['email']) ? $data['dipendente'][0]['email'] : ""); ?>">
					</td>
				</tr>
                <tr>
					<td>
						<label>Indirizzo:</label>
					</td>
					<td>
                        <input type="text" name="indirizzo" autocomplete="off"  value="<?php echo (isset($data['dipendente'][0]['indirizzo']) ? $data['dipendente'][0]['indirizzo'] : ""); ?>">
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
						<label>Conferma password:</label>
					</td>
					<td>
                        <input type="password" name="password2" autocomplete="off">
					</td>
                </tr>
                <tr>
					<td colspan="2" style="text-align:center">
					<br>
						<input type="submit" class="btn btn-dark" value="Modifica" name="modifica">
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
<?php if(isset($data['error'])){ ?>
	<h2 id="errorModifyComponent" style="text-align: center" class="alert alert-danger"> <?php echo $data['error'] ?></h2>
<?php } ?>