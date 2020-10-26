<?php
include 'database.php';

//initilisserd de sessie
session_start();
//kijkt of er een account ingelogd is, zo niet dan word ie redirected naar login.php
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('location: login.php');
    exit;
}


?>

<html>
    <head>
        <title>Welcome!</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="topnav">
            <a class="active" href="welcome_user.php">Home</a>
            <a href="new_user.php">Add user</a>
            <a href="view_edit_delete.php">View, Edit and/or Delete users</a>
            <a href="logout.php">Logout</a>
        </div>

        <?php
            //maakt verbinding met DB
            $db = new database('localhost', 'root', '', 'project1', 'utf8');
            $results = $db->show_profile_details_user(NULL);

            // fixed array. alle indexes hebben de zelfde nummer kolommnen
            $columns = array_keys($results[0]);

            //checkt resultaten
            echo "<table>";
                echo "<tr>";
                    foreach($columns as $column){
                        echo "
                            <th>
                                <strong>$column</strong>
                            </th>
                        ";
                    }
                echo "<th>Edit</th>";
                echo "<th>Delete</th>";
                echo "</tr>";

                foreach($results as $rows => $row){

                    echo "<tr>";
                    foreach($row as $row_data){

                        echo "<td>$row_data</td>";

                    }
                    echo "<td>Edit</td>";
                    echo "<td>Delete</td>";
                    echo "</tr>";
                }

            echo "</table>";
        ?>
    </body>
</html>
