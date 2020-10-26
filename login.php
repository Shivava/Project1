<!-- Furkan ucar OITAOO8B -->
<?php

include 'database.php';
include 'helperfunctions.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && !empty($_POST['submit'])){
  // maak een array met alle name attributes
  $fields = [
    	"username",
      "pass"
  ];

$obj = new HelperFunctions();
$no_error = $obj->has_provided_input_for_required_fields($fields);

  // in case of field values, proceed, execute insert
if($no_error){
  $username = $_POST['username'];
  $pass = $_POST['pass'];

  $db = new database('localhost', 'root', '', 'project1', 'utf8');
  $db->authenticate_user($username, $pass);
}
}

 ?>


<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>login pagina</title>
	</head>
	<body>
		<form id='login' action='login.php' method='post' accept-charset='UTF-8'>
			<fieldset >
				<legend>Login</legend>
				<input type="text" name="username" placeholder="Username" required/>
				<input type="password" name="pass" placeholder="Password" required/>
				<input type='submit' name="submit" value='submit' />
			</fieldset>
		  	<p>
		  		Not a member? <a href="register.php">register</a>
		  	</p>
		  	<p>
		  		Reset Password? <a href="reset.php">Reset</a>
		  	</p>
		</form>
	</body>
</html>
