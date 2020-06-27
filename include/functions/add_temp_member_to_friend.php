<?php
session_start();
include '../../lib/database.php';
$TempMemberEmail=$_POST["TempMemberEmail"];
$MemberId = $_SESSION["MemberId"];

//Only execute script if entered value is an email
if (filter_var($TempMemberEmail, FILTER_VALIDATE_EMAIL)) {
	
	//Checking if temporary member's email already exists
	$stmt1 = mysqli_prepare($conn, "SELECT id, friend FROM tbl_temp_member WHERE email=?");
	mysqli_stmt_bind_param($stmt1, 's', $TempMemberEmail);
	mysqli_stmt_execute($stmt1);
	mysqli_stmt_bind_result($stmt1, $TempMemberId, $TempMemberFriend);
	mysqli_stmt_fetch($stmt1);
	mysqli_stmt_close($stmt1);

	//Get the temp member's existing friend list and add current member on
	$TempMemberFriend = $TempMemberFriend."#".$MemberId."#";

	$stmt2 = mysqli_prepare($conn, "UPDATE tbl_temp_member SET friend=? WHERE email=?");
	mysqli_stmt_bind_param($stmt2, 'ss', $TempMemberFriend, $TempMemberEmail);
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_close($stmt2);

	/* close connection */
	mysqli_close($conn);

}

?>
