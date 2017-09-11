<?php
include_once("db_connect.php");
if(isset($_GET["sort_order"])) {
	$checklist_id_ary = explode(",",$_GET["sort_order"]);
	for($i=0;$i<count($checklist_id_ary);$i++) {		
		$sql = "UPDATE checklist SET display_order='" . $i . "' WHERE checklist_id=". $checklist_id_ary[$i];
		mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
	}
}
?>