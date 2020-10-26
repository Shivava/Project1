
<?php
// haalt database.php
'require database.php';

$id = $_REQUEST['id'];

$sql = "DELETE FROM "
require('db.php');

$id=$_REQUEST['id'];
$query = "DELETE FROM new_record WHERE id=$id";
$result = mysqli_query($con,$query) or die ( mysqli_error());
header("Location: view.php");
?>
