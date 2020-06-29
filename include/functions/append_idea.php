<?php
session_start();
include '../../lib/database.php';
$member_id=$_SESSION["MemberId"];

//Getting the default friends and groups to share idea with
$stmt1 = mysqli_query($conn, "SELECT default_share_friends, default_share_groups, default_share_temp_members FROM tbl_member WHERE id='".$member_id."'");
$stmt1=mysqli_fetch_array($stmt1);

$stmt = mysqli_prepare($conn, "INSERT INTO tbl_ideas (member_id, title, share_friends, share_groups, share_temp_members) VALUES (?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, 'issss', $member_id, $title, $stmt1['default_share_friends'], $stmt1['default_share_groups'], $stmt1['default_share_temp_members']);

$title=$_POST['title'];

/* execute prepared statement */
if (mysqli_stmt_execute($stmt)) {
	//Fetch the new idea's id
	$IdeaId = mysqli_insert_id($conn);

	if ($stmt1['default_share_temp_members']!='') {
		$TempMemberArray=array($IdeaId);
		$TempMembers=explode("#",$stmt1['default_share_temp_members']);
		foreach ($TempMembers as $TempMember) {
			if ($TempMember!=null) {
				$TempMember = mysqli_query($conn,"SELECT * FROM tbl_temp_member WHERE id='".$TempMember."'");
				$TempMember = mysqli_fetch_array($TempMember);
				array_push($TempMemberArray,$TempMember['email']);
			};
		};
		echo json_encode($TempMemberArray);
	}
} 
else {
	echo json_encode(array("statusCode"=>201));
}

/* close statement and connection */
mysqli_stmt_close($stmt);

/* close connection */
mysqli_close($conn);

?>
