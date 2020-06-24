<?php
session_start();
include '../../lib/database.php';

$IdeaId=$_POST['IdeaId'];
$MemberId=$_SESSION["MemberId"];

if (!is_numeric($IdeaId)) {
	$IdeaId='Error';
}

$stmt = mysqli_query($conn, "SELECT member_id, share_friends, share_groups FROM tbl_ideas WHERE id='".$IdeaId."'");
$stmt = mysqli_fetch_array($stmt);

//Making sure that the user can only add friends or groups from his own ideas (his own friends and groups)
if ($stmt['member_id']==$MemberId) {
	
	$stmt2 = mysqli_prepare($conn, "UPDATE tbl_member SET default_share_friends=?, default_share_groups=? WHERE id=?");
	mysqli_stmt_bind_param($stmt2, 'ssi', $stmt['share_friends'], $stmt['share_groups'], $MemberId);

	/* execute prepared statement */
	if (mysqli_stmt_execute($stmt2)) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}

	/* close statement and connection */
	mysqli_stmt_close($stmt2);

	/* close connection */
	mysqli_close($conn);

}
?>