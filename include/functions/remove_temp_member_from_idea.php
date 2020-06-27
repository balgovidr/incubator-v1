<?php
session_start();
include '../../lib/database.php';
$MemberId = $_SESSION["MemberId"];
$IdeaId=$_POST['IdeaId'];
$TempMemberId=$_POST['TempMemberId'];

if (is_numeric($TempMemberId) && is_numeric($IdeaId)) {
	//If both the temporary member id and the idea id is numeric, then
	$SharedTempMembers = mysqli_query($conn,"SELECT * FROM tbl_ideas WHERE id='".$IdeaId."'");
	$SharedTempMembers = mysqli_fetch_array($SharedTempMembers);

	//Making sure only the owner of the idea can add members to it
	if ($SharedTempMembers['member_id']==$MemberId) {

		$stmt = mysqli_prepare($conn, "UPDATE tbl_ideas SET share_temp_member= REPLACE(share_temp_member, ?, '') WHERE id= ?");
		mysqli_stmt_bind_param($stmt, 'si', $DeleteTerm, $IdeaId);

		$DeleteTerm="#".$TempMemberId."#";


		/* execute prepared statement */
		if (mysqli_stmt_execute($stmt)) {
			echo json_encode(array("statusCode"=>200));
		} 
		else {
			echo json_encode(array("statusCode"=>201));
		}

		/* close statement and connection */
		mysqli_stmt_close($stmt);
	}

	/* close connection */
	mysqli_close($conn);

}

?>