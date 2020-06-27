<?php
session_start();
include '../../lib/database.php';
$MemberId = $_SESSION["MemberId"];
$GroupId=$_POST['GroupId'];
$TempMemberId=$_POST['TempMemberId'];

if (is_numeric($TempMemberId) && is_numeric($GroupId)) {

	//If both the temporary member id and the idea id is numeric, then
	$stmt1 = mysqli_query($conn,"SELECT * FROM tbl_group WHERE id='".$GroupId."'");
	$stmt1 = mysqli_fetch_array($stmt1);

	//Making sure only the owner of the idea can add members to it
	if ($stmt1['member_id']==$MemberId) {

		$stmt = mysqli_prepare($conn, "UPDATE tbl_group SET temp_member= REPLACE(temp_member, ?, '') WHERE id= ?");
		mysqli_stmt_bind_param($stmt, 'si', $DeleteTerm, $GroupId);

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