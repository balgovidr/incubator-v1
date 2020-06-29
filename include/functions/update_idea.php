<?php
session_start();
include '../../lib/database.php';
$MemberId = $_SESSION["MemberId"];

$query1=mysqli_prepare($conn, "SELECT member_id, share_friends, share_groups FROM tbl_ideas WHERE id=?");
mysqli_stmt_bind_param($query1, 'i', $id);

$id=$_POST['id'];

mysqli_stmt_execute($query1);

mysqli_stmt_bind_result($query1, $query1MemberId, $query1ShareFriendsEncoded, $query1ShareGroupsEncoded);
mysqli_stmt_fetch($query1);
mysqli_stmt_close($query1);

$query1ShareFriendsDecoded=explode("#",$query1ShareFriendsEncoded);
$query1ShareGroupsDecoded=explode("#",$query1ShareGroupsEncoded);

if ($query1MemberId==$MemberId || in_array($MemberId,$query1ShareFriendsDecoded) || in_array($MemberId,$query1ShareGroupsDecoded)) {

	$stmt = mysqli_prepare($conn, "UPDATE tbl_ideas SET description=? WHERE id=?");
	mysqli_stmt_bind_param($stmt, 'si', $description, $id);

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
};
/* close connection */
mysqli_close($conn);

?>