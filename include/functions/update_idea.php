<?php
include '../../lib/database.php';

$stmt = mysqli_prepare($conn, "UPDATE tbl_ideas SET description=? WHERE id=?");
mysqli_stmt_bind_param($stmt, 'si', $description, $id);

$id=$_POST['id'];
$description=$_POST['description'];

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