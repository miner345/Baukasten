<form>
	<table>
		<tbody>
			<tr><td><label>Username: </label></td><td><input type="text" name="name" placeholder="username" /></td></tr>
			<tr><td><label>Password: </label></td><td><input type="password" name="password" placeholder="password" /></td></tr>
			<input type="hidden" name="pogress" value="pogress" />
			<tr><td><input type="button" name="login" name="login"/></td><td><input type="reset" name="reset" name="Reset"/></td></tr>
		</tbody>
	</table>
</form>
<?php 
	if(isset($_POST['login']) && isset($_POST['pogress'])) {
		$UserClass->login($_POST['name'], $_POST['password'], $_POST['pogress']);		
	} else {
		echo "Fehler beim login";	
	}
?>