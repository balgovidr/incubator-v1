<?php
session_start();
include '../../lib/database.php';
$id=$_POST['id'];
$MemberId=$_SESSION["MemberId"];

if (is_numeric($id)) {
	$query1 = mysqli_query($conn,"SELECT * FROM tbl_group WHERE id='".$id."'");
	$query1 = mysqli_fetch_array($query1);

	//Ensures only the creator can delete groups
	if ($query1['member_id']==$MemberId) {
		$query = "DELETE FROM tbl_group WHERE id='".$id."'";
		if (mysqli_query($conn, $query)) {
			echo json_encode(array("statusCode"=>200));
		} 
		else {
			echo json_encode(array("statusCode"=>201));
		}
	};
	mysqli_close($conn);
}
?>