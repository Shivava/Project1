<?php
// initialiseerd sessie
session_start();

// checkt of je ingelogged bent, zo ja word je naar index.php gestuurd
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('location: login.php');
    exit;
}
?>

<html>
    <head>
        <title>Welcome htmlentities(<?php $_SESSION['username'] ?>)!</title>
    </head>
    <body>
        <div class="topnav">
            <a class="active" href="welcome_user.php">Home</a>
            <a href="new_user.php">Add user</a>
            <a href="view_edit_delete.php">Edit and/or Delete users</a>
            <a href="logout.php">Logout</a>
        </div>
        <?php echo "Welcome " . htmlentities( $_SESSION['username']) ."!" ?>
        test
    </body>
</html>
