<?php
include '../../lib/database.php';
$memberid=$_POST['memberid'];
$groupid=$_POST['groupid'];
$members = mysqli_query($conn,"SELECT members FROM tbl_group WHERE id='".$groupid."'");
$members = mysqli_fetch_array($members);
$members = $members['members']."#".$memberid."#";
$query = "UPDATE tbl_group SET members='".$members."' WHERE id='".$groupid."'";
	if (mysqli_query($conn, $query)) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}
	mysqli_close($conn);

?>