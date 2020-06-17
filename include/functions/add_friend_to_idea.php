<?php
include '../../lib/database.php';

$memberid=$_POST['memberid'];
$ideaid=$_POST['ideaid'];

if (is_numeric($memberid) && is_numeric($ideaid)) {
	$sharedfriends = mysqli_query($conn,"SELECT share_friends FROM tbl_ideas WHERE id='".$ideaid."'");

	$sharedfriends = mysqli_fetch_array($sharedfriends);

	$sharedfriends = $sharedfriends['share_friends']."#".$memberid."#";

	$query = "UPDATE tbl_ideas SET share_friends='".$sharedfriends."' WHERE id='".$ideaid."'";

		if (mysqli_query($conn, $query)) {
			echo json_encode(array("statusCode"=>200));
		} 
		else {
			echo json_encode(array("statusCode"=>201));
		}
	mysqli_close($conn);
}
?>