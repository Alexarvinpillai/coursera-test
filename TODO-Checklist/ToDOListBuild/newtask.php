<?php
include_once("db_connect.php");
if(isset($_POST['submit'])){
	$newtask = $_POST['#new-task'];
	$insertQuery = "INSERT INTO checklist(thingstodo) VALUES ('$newtask')";
	mysqli_query($conn, $insertQuery) or die("database error:". mysqli_error($conn));
}
?>