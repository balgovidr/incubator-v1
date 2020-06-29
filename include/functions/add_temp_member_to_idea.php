<?php
session_start();
include '../../lib/database.php';

$TempMemberId=$_POST['TempMemberId'];
$IdeaId=$_POST['IdeaId'];
$MemberId = $_SESSION["MemberId"];

if (is_numeric($TempMemberId) && is_numeric($IdeaId)) {
	$SharedTempMembers = mysqli_query($conn,"SELECT * FROM tbl_ideas WHERE id='".$IdeaId."'");
	$SharedTempMembers = mysqli_fetch_array($SharedTempMembers);

	//Making sure only the owner of the idea can add friends to it
	if ($SharedTempMembers['member_id']==$MemberId) {
		$SharedTempMembers = $SharedTempMembers['share_temp_member']."#".$TempMemberId."#";

		$query = "UPDATE tbl_ideas SET share_temp_member='".$SharedTempMembers."' WHERE id='".$IdeaId."'";

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