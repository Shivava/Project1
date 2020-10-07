<!-- Furkan ucar OITAOO8B -->
<?php

include 'database.php';

  // maak een array met alle name attributes
  $fields = [
    	"uname",
      "pwd"
  ];

  // ariabele met default boolean false value
  $error = false;

  // loop all name attributes of input fields
  foreach ($fields as $fieldname) {
      // check whether field has been set. If not, make sure error is true
      if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])){
        // echo "Field $fieldname has not been set or empty";
        $error = true;
      }
  }

  // in case of field values, proceed, execute insert
  if(!$error){
    $username = $_POST['uname'];
    $password =$_POST['pwd'];


    $db = new database('localhost', 'root', '', 'project1', 'utf8');
    $db->authenticate_user($username, $password);
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
				<input type="text" name="uname" placeholder="Username" required/>
				<input type="password" name="pword" placeholder="Password" required/>
				<input type='submit' name='Submit' value='Submit' />
			</fieldset>
		  	<p>
		  		Not a member? <a href="register.php">Sign Up</a>
		  	</p>
		  	<p>
		  		Reset Password? <a href="reset.php">Reset</a>
		  	</p>
		</form>
	</body>
</html>
