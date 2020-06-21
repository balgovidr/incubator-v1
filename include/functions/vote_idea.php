<?php
session_start();
include '../../lib/database.php';

$IdeaId=$_POST['IdeaId'];
$MemberId=$_SESSION["MemberId"];
$VoteType=$_POST['VoteType'];

if ($VoteType='public') {
	$VoteType='publ';
} else {
	$VoteType='anon';
}

$stmt = mysqli_query($conn, "SELECT votes FROM tbl_ideas WHERE id='".$IdeaId."'");
$OldVotes = mysqli_fetch_array($stmt)['votes'];

//Find any instance where the member has voted before
if (strpos($OldVotes,'#'.$MemberId.',')!==FALSE) {
	//If the member has voted before then remove his vote (unvote)
	//Find the position of the bit we want to remove
	$StringPosition1=strpos($OldVotes,'#'.$MemberId.',');
	//Find length of the string to replace
	$StringLength = strlen('#'.$MemberId.',publ#');
	//Create the new string by replacing the unwanted stuff
	$NewVotes=substr_replace($OldVotes,'',$StringPosition1,$StringLength);
} else {
	//If there are no matches for the current member then
	$StringAdd='#'.$MemberId.','.$VoteType.'#';
	$NewVotes=$OldVotes.$StringAdd;
};

$stmt2 = mysqli_prepare($conn, "UPDATE tbl_ideas SET votes=? WHERE id=?");
mysqli_stmt_bind_param($stmt2, 'si', $NewVotes, $IdeaId);

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