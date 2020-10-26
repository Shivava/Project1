<!--Gemaakt door furkan ucar OITAOO8B -->
<?php

include 'database.php';
include 'HelperFunctions.php';

if(isset($_POST['submit'])){

  // maak een array met alle name attributes
  $fields = [
      "username",
      "firstname",
      "lastname",
      "pass",
      "cpass",
      "email"
  ];

$obj = new HelperFunctions();
$no_error = $obj->has_provided_input_for_required_fields($fields);

  // in case of field values, proceed, execute insert
  if($no_error){
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $pass =$_POST['pass'];
    $cpass =$_POST['cpass'];
    $email = $_POST['email'];

    $db = new database('localhost', 'root', '', 'project1', 'utf8');
    $db->create_or_update_user($username, $firstname, $middlename, $lastname, $pass, $cpass, $email);
    }
}
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
        <input type="text" name="username" placeholder="Gebruikersnaam" required/>
        <input type="text" name="firstname" placeholder="Voornaam" required/>
          <input type="text" name="middlename" placeholder="Middelnaam" />
          <input type="text" name="lastname" placeholder="Achternaam" required/><br/>
        <input type="email" name="email" placeholder="E-mail" required/>
        <input type="password" name="pass" placeholder="Wachtwoord" required/>
        <input type="password" name="cpass" placeholder="Herhaal wachtwoord" required/>
        <input type="submit" name='submit' value"Sign up!"/>
      </fieldset>
      <a href="login.php">Ik heb al een account. Login!</a>
    </form>
  </body>
</html>
