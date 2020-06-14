<?php
include '../../lib/database.php';
$groupid=$_POST['groupid'];
$ideaid=$_POST['ideaid'];
$deleteterm = "#".$groupid."#";
$query = "UPDATE tbl_ideas SET share_groups= REPLACE(share_groups,'".$deleteterm."','') WHERE id='".$ideaid."'";
	if (mysqli_query($conn, $query)) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}
	mysqli_close($conn);

?>