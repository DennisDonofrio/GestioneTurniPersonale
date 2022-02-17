<div class="d-flex justify-content-center pt-4 pb-4">
	<form action="<?php echo URL ?>negozio/modificaNegozio" method="POST">
		<table>
			<thead>
				<tr>
                    <h1>Modifica negozio</h1>
				</tr>
			</thead>
			<tbody>
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
                    <td>
                        <br>
                    </td>
                </tr>
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
						<label>Indirizzo:</label>
					</td>
					<td>
                        <input type="text" name="indirizzo" autocomplete="off">
					</td>
				</tr>
                <tr>
					<td>
						<label>Tipo:</label>
					</td>
					<td>
                        <select name="tipo">
                            <?php foreach($data['tipi'] as $tipo): ?>
                                <option value="<?php echo $tipo["id"]; ?>"><?php echo $tipo["nome"]; ?></option>
                            <?php endforeach; ?>
                        </select>
					</td>
				</tr>
                <tr>
					<td colspan="2" style="text-align:center">
					<br>
						<input type="submit" class="btn btn-dark" value="Modifica">
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
<?php if(isset($data['error'])){ ?>
	<h2 id="errorModifyComponent" style="text-align: center" class="alert alert-danger"> <?php echo $data['error'] ?></h2>
<?php } ?>