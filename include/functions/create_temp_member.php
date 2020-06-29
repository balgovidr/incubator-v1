<?php
include '../../lib/database.php';
$TempMemberEmail=$_POST["InvitationEmail"];

//Only execute script if entered value is an email
if (filter_var($TempMemberEmail, FILTER_VALIDATE_EMAIL)) {
	
	//Checking if temporary member's email already exists
	$stmt1 = mysqli_prepare($conn, "SELECT id FROM tbl_temp_member WHERE email=?");
	mysqli_stmt_bind_param($stmt1, 's', $TempMemberEmail);
	mysqli_stmt_execute($stmt1);
	mysqli_stmt_bind_result($stmt1, $TempMemberId);


	if (mysqli_stmt_fetch($stmt1)) {
		//If the email exists then output the temporary member's id and close connection
		echo $TempMemberId;
		mysqli_stmt_close($stmt1);
	} else {
		//If the email does not exist create a new entry
		mysqli_stmt_close($stmt1);
		$stmt2 = mysqli_prepare($conn, "INSERT INTO tbl_temp_member (email) VALUES (?)");
		mysqli_stmt_bind_param($stmt2, 's', $TempMemberEmail);
		mysqli_stmt_execute($stmt2);
		mysqli_stmt_close($stmt2);

		//Fetch the new temporary member's id and output
		$TempMemberId = mysqli_insert_id($conn);
		echo $TempMemberId;
	}

	/* close connection */
	mysqli_close($conn);

}

?>
