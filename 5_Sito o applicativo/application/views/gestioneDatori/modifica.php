<div class="d-flex justify-content-center pt-4 pb-4">
	<form action="<?php echo URL ?>gestionedatori/modifica" method="POST">
		<table>
			<thead>
				<tr>
                    <h1>Modifica datore</h1>
				</tr>
				<tr>
                    <td>Datore</td>
                    <td>
                        <select name="id">
                            <?php for($i = 0; $i < count($this->data); $i++) : ?>
                                <option value="<?php echo $this->data[$i][1]; ?>" <?php echo (isset($this->selected[0]['id']) && $this->selected[0]['id'] == $this->
                                data[$i][1] ? "SELECTED" : ""); ?> ><?php echo $this->data[$i][0]; ?></option>
                            <?php endfor; ?>
                        </select>
                        <input type="submit" class="btn btn-dark" value="Riempi campi" name="datoreButton">
                    </td>
				</tr>
			</thead>
			<tbody>
                <tr>
					<td>
						<label>Nome:</label>
					</td>
					<td>
                        <input type="text" name="nome" value="<?php echo (isset($this->selected[0]['nome']) ? $this->selected[0]['nome'] : ""); ?>">
					</td>
				</tr>
                <tr>
					<td>
						<label>Cognome:</label>
					</td>
					<td>
                        <input type="text" name="cognome" value="<?php echo (isset($this->selected[0]['cognome']) ? $this->selected[0]['cognome'] : ""); ?>">
					</td>
				</tr>
                <tr>
					<td>
						<label>Email:</label>
					</td>
					<td>
                        <input type="email" name="email" value="<?php echo (isset($this->selected[0]['email']) ? $this->selected[0]['email'] : ""); ?>">
					</td>
				</tr>
                <tr>
					<td>
						<label>Indirizzo:</label>
					</td>
					<td>
                        <input type="text" name="indirizzo" value="<?php echo (isset($this->selected[0]['indirizzo']) ? $this->selected[0]['indirizzo'] : ""); ?>">
					</td>
                </tr>
                <tr>
					<td>
						<label>Password:</label>
					</td>
					<td>
                        <input type="password" name="pass1">
					</td>
                </tr>
                <tr>
					<td>
						<label>Conferma password:</label>
					</td>
					<td>
                        <input type="password" name="pass2">
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
<?php if(isset($this->error)){ ?>
	<h2 id="errorModifyComponent" style="text-align: center" class="alert alert-danger"> <?php echo $this->error ?></h2>
<?php } ?>