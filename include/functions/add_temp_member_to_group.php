<?php
session_start();
include '../../lib/database.php';
$TempMemberId=$_POST['TempMemberId'];
$GroupId=$_POST['GroupId'];
$MemberId = $_SESSION["MemberId"];

if (is_numeric($GroupId) && is_numeric($TempMemberId)) {
	$members = mysqli_query($conn,"SELECT * FROM tbl_group WHERE id='".$GroupId."'");
	$members = mysqli_fetch_array($members);
	
	//Making sure only the group owner can add members
	if ($members['member_id']==$MemberId) {
		$members = $members['temp_member']."#".$TempMemberId."#";
		$query = "UPDATE tbl_group SET temp_member='".$members."' WHERE id='".$GroupId."'";
			if (mysqli_query($conn, $query)) {
				echo json_encode(array("statusCode"=>200));
			} 
			else {
				echo json_encode(array("statusCode"=>201));
			};
	};
	mysqli_close($conn);
}
?>