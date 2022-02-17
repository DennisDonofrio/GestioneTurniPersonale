<div class="d-flex justify-content-center pt-4 pb-4">
	<form action="<?php echo URL ?>login/loginUser" method="POST">
		<table>
			<thead>
				<tr>
					<h1>Login</h1>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<label>Email:</label>
					</td>
					<td>
						<input type="text" name="email" >
					</td>
				</tr>
				<tr>
					<td>
						<label>Password: </label>
					</td>
					<td>
						<input type="password" name="password">
					</td>	
				</tr>
				<tr>
					<td colspan="2" style="text-align:center">
						<input type="submit" class="btn btn-dark btn-lg" value="Accedi">
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
<?php if(isset($this->errorMessage) &&  $this->errorMessage != ""){ ?>
	<h2 id="errorLogin" style="text-align: center" class="alert alert-danger"> <?php echo $this->errorMessage ?></h2>
<?php } ?>