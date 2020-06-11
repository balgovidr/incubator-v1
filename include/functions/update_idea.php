<?php
include '../../lib/database.php';
$id=$_POST['id'];
$description=$_POST['description'];
$query = "UPDATE tbl_ideas SET description='".$description."' WHERE id='".$id."'";
	if (mysqli_query($conn, $query)) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}
	mysqli_close($conn);

?>