<div class="d-flex justify-content-center pt-4 pb-4">
	<form action="<?php echo URL ?>gestioneDatori/rimuovi" method="POST">
		<table>
			<tbody>
            <tr><h2>Elimina datore</h2></tr>
            <tr>
                <td>Email</td>
                <td>
                    <select name="id">
                        <?php for($i = 0; $i < count($this->data) - 1; $i++) : ?>
                            <option value="<?php echo $this->data[$i]['id']; ?>"><?php echo $this->data[$i]['email']; ?></option>
                        <?php endfor; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Conferma email</td>
                <td>
                    <input type="email" name="email">
                </td>
            </tr>
				<tr>
					<td colspan="2" style="text-align:center">
					<br>
						<input type="submit" class="btn btn-dark" name="elimina" value="Elimina datore">
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
<?php if(isset($this->error)){ ?>
	<h2 id="errorModifyComponent" style="text-align: center" class="alert alert-danger"> <?php echo $this->error ?></h2>
<?php } ?>