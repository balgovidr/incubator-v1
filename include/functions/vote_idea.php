<?php
include '../../lib/database.php';

$IdeaId=$_POST['IdeaId'];
$MemberId=$_POST['MemberId'];
$VoteType=$_POST['VoteType'];

$stmt = mysqli_prepare($conn, "SELECT votes FROM tbl_ideas WHERE id=?");
mysqli_stmt_bind_param($stmt, 'i', $IdeaId);

//Defining results from the query
mysqli_stmt_bind_result($stmt, $OldEncodedVotes);

//Fetch values from query
mysqli_stmt_fetch($stmt);

/* close statement and connection */
mysqli_stmt_close($stmt);

if ($OldEncodedVotes='') {
	$NewDecodedVotes=array(array("MI"=>$MemberId,"VT"=>$VoteType));
} else {
$OldDecodedVotes=json_decode($OldEncodedVotes);
$NewDecodedVotes=array_push($OldDecodedVotes,array("MI"=>$MemberId,"VT"=>$VoteType));
};
$NewEncodedVotes=json_encode($NewDecodedVotes);

$stmt2 = mysqli_prepare($conn, "UPDATE tbl_ideas SET votes=? WHERE id=?");
mysqli_stmt_bind_param($stmt2, 'si', $NewEncodedVotes, $IdeaId);

/* execute prepared statement */
if (mysqli_stmt_execute($stmt2)) {
	echo json_encode(array("statusCode"=>200));
} 
else {
	echo json_encode(array("statusCode"=>201));
}

/* close statement and connection */
mysqli_stmt_close($stmt2);

/* close connection */
mysqli_close($conn);

?>