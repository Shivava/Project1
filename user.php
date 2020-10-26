<!--Gemaakt door furkan ucar OITAOO8B -->
<?php
include 'database.php';

//initialiseer de sessie
session_start();

//kijkt of er een account ingelogd is, zo niet dan word ie redirected naar login.php
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('location: login.php');
    exit;
}
?>

<html>
    <head>
        <title>Personal data</title>
         <!-- include css file -->
         <link rel="stylesheet" href="style.css">
    </head>

    <body>
      <!-- de lay out -->
        <div class="topnav">
            <a class="active" href="welcome_user.php">Home</a>
            <a href="user.php">Show profile details</a>
            <a href="logout.php">Logout</a>
        </div>

        <?php
        echo "<table>";
        // maakt connectie met db
        $db = new database('localhost', 'root', '', 'project1', 'utf8');
        // laat user gegevens zien in een table
        $result_set = $db->show_profile_details_user($_SESSION['username'])[0];

        $columns = array_keys($result_set);
        $row_data = array_values($result_set);

        echo "<table>";
        echo "<tr>";
            foreach($columns as $column){
                echo "<th><strong> $column </strong></th>";
            }
        echo "</tr>";
        echo "<tr>";
            foreach($row_data as $value){
                echo "<td> $value </td>";
            }
        echo "</tr>";
        echo "</table>"
        ?>
    </body>
</html>
