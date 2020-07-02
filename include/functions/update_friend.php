<?php
session_start();
include '../../lib/database.php';
$member_id=$_SESSION["MemberId"];
$friend_id=$_POST['friend_id'];
?>
<script type="text/javascript" src="<?php echo BASE_URL ?>/assets/js/all.js"></script>
<?php

if (is_numeric($member_id) && is_numeric($friend_id)) {
	$query = "UPDATE tbl_friends SET status='friend' WHERE member1='".$friend_id."' AND member2='".$member_id."'";
	if (mysqli_query($conn, $query)) {
		echo json_encode(array("statusCode"=>200));
		echo "<script type='text/javascript'>TempMemberToPermMember(".$member_id.",".$friend_id.");</script>";
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}

	mysqli_close($conn);
}
?>