<?php
session_start();
include '../../lib/database.php';
$groupid=$_POST['groupid'];
$ideaid=$_POST['ideaid'];
$MemberId = $_SESSION["MemberId"];

if (is_numeric($groupid) && is_numeric($ideaid)) {
	$sharedgroups = mysqli_query($conn,"SELECT * FROM tbl_ideas WHERE id='".$ideaid."'");
	$sharedgroups = mysqli_fetch_array($sharedgroups);

	//Making sure only the owner of the idea can add groups to it
	if ($sharedgroups['member_id']==$MemberId) {
		$sharedgroups = $sharedgroups['share_groups']."#".$groupid."#";
		$query = "UPDATE tbl_ideas SET share_groups='".$sharedgroups."' WHERE id='".$ideaid."'";
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