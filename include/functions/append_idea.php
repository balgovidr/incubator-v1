<?php
include '../../lib/database.php';
$member_id=$_POST['member_id'];
$title=$_POST['title'];
$query = "INSERT INTO tbl_ideas(member_id, title) VALUES ('".$member_id."','".$title."')";
	if (mysqli_query($conn, $query)) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}
	mysqli_close($conn);

?>