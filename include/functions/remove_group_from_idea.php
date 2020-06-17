<?php
include '../../lib/database.php';

$stmt = mysqli_prepare($conn, "UPDATE tbl_ideas SET share_groups= REPLACE(share_groups, ?, '') WHERE id= ?");
mysqli_stmt_bind_param($stmt, 'si', $deleteterm, $ideaid);

$groupid=$_POST['groupid'];
$deleteterm="#".$groupid."#";
$ideaid=$_POST['ideaid'];

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