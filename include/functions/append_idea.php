<?php
include '../../lib/database.php';

$stmt = mysqli_prepare($conn, "INSERT INTO tbl_ideas (member_id, title) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt, 'is', $member_id, $title);

$member_id=$_POST['member_id'];
$title=$_POST['title'];

/* execute prepared statement */
if (mysqli_stmt_execute($stmt)) {
	echo json_encode(array("statusCode"=>200));
} 
else {
	echo json_encode(array("statusCode"=>201));
}

/* close statement and connection */
mysqli_stmt_close($stmt);

/* close connection */
mysqli_close($conn);

?>
