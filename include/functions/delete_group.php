<?php
include '../../lib/database.php';
$id=$_POST['id'];

if (is_numeric($id)) {
$query = "DELETE FROM tbl_group WHERE id='".$id."'";
	if (mysqli_query($conn, $query)) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}
	mysqli_close($conn);
}
?>