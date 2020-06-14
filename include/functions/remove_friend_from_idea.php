<?php
include '../../lib/database.php';
$friendid=$_POST['friendid'];
$ideaid=$_POST['ideaid'];
$deleteterm = "#".$friendid."#";
$query = "UPDATE tbl_ideas SET share_friends= REPLACE(share_friends,'".$deleteterm."','') WHERE id='".$ideaid."'";
	if (mysqli_query($conn, $query)) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}
	mysqli_close($conn);

?>