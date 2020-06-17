<?php
include '../../lib/database.php';

$stmt = mysqli_prepare($conn, "UPDATE tbl_group SET members= REPLACE(members, ?, '') WHERE id= ?");
mysqli_stmt_bind_param($stmt, 'si', $deleteterm, $groupid);

$groupid=$_POST['groupid'];
$memberid=$_POST['memberid'];
$deleteterm="#".$memberid."#";

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