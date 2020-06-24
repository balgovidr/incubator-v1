<?php
session_start();
include '../../lib/database.php';
$member_id=$_SESSION["MemberId"];

//Getting the default friends and groups to share idea with
$stmt1 = mysqli_query($conn, "SELECT default_share_friends, default_share_groups FROM tbl_member WHERE id='".$member_id."'");
$stmt1=mysqli_fetch_array($stmt1);

$stmt = mysqli_prepare($conn, "INSERT INTO tbl_ideas (member_id, title, share_friends, share_groups) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, 'isss', $member_id, $title, $stmt1['default_share_friends'], $stmt1['default_share_groups']);

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
