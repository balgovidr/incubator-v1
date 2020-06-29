<?php
session_start();
include '../../lib/database.php';

$FriendId=$_POST['memberid'];
$ideaid=$_POST['ideaid'];
$MemberId = $_SESSION["MemberId"];

if (is_numeric($FriendId) && is_numeric($ideaid)) {
	$sharedfriends = mysqli_query($conn,"SELECT * FROM tbl_ideas WHERE id='".$ideaid."'");
	$sharedfriends = mysqli_fetch_array($sharedfriends);

	//Making sure only the owner of the idea can add friends to it
	if ($sharedfriends['member_id']==$MemberId) {
		$sharedfriends = $sharedfriends['share_friends']."#".$FriendId."#";

		$query = "UPDATE tbl_ideas SET share_friends='".$sharedfriends."' WHERE id='".$ideaid."'";

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