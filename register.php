<!-- Furkan ucar OITAOO8B -->
<?php

include 'database.php';

  // maak een array met alle name attributes
  $fields = [
    	"uname",
      "fname",
      "lname",
      "pwd",
      "email"
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
    $firstname = $_POST['fname'];
    $middlename = $_POST['mname'];
    $lastname = $_POST['lname'];
    $password =$_POST['pwd'];
    $email = $_POST['email'];

    $db = new database('localhost', 'root', '', 'project1', 'utf8');
    $db->insert($username, $firstname, $middlename, $lastname, $password, $email);
  }

  header("location:login.php");

 ?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Registratie scherm</title>
  </head>

  <body>
  	<form method="post" action='register.php' method='post' accept-charset='UTF-8'>
      <fieldset >
        <legend>Registratie</legend>
        <input type="text" name="uname" placeholder="Gebruikersnaam" required/>
        <input type="text" name="fname" placeholder="Voornaam" required/>
      	<input type="text" name="mname" placeholder="Middelnaam" />
      	<input type="text" name="lname" placeholder="Achternaam" required/><br/>
        <input type="email" name="email" placeholder="E-mail" required/>
        <input type="password" name="pwd" placeholder="Wachtwoord" required/>
        <input type="password" name="repeatpwd" placeholder="Herhaal wachtwoord" required/>
        <input type="submit" value"Sign up!"/>
      </fieldset>
      <a href="login.php">Ik heb al een account. Login!</a>
    </form>
  </body>
</html>
