<?php
include '../../lib/database.php';
$member_id=$_POST['member_id'];
$friend_id=$_POST['friend_id'];
$query = "INSERT INTO tbl_friends(member1, member2, status) VALUES ('".$member_id."','".$friend_id."','request')";
	if (mysqli_query($conn, $query)) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}
	mysqli_close($conn);

?>