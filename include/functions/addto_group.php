<?php
session_start();
include '../../lib/database.php';
$FriendId=$_POST['memberid'];
$groupid=$_POST['groupid'];
$MemberId = $_SESSION["MemberId"];

if (is_numeric($groupid) && is_numeric($FriendId)) {
	$members = mysqli_query($conn,"SELECT * FROM tbl_group WHERE id='".$groupid."'");
	$members = mysqli_fetch_array($members);
	
	//Making sure only the group owner can add members
	if ($members['member_id']==$MemberId) {
		$members = $members['members']."#".$FriendId."#";
		$query = "UPDATE tbl_group SET members='".$members."' WHERE id='".$groupid."'";
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