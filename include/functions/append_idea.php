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

	if (!empty($stmt1['default_share_temp_members'])) {
		//If there are default temporary members to share the idea with
		$TempMemberArray=array($IdeaId);
		//Getting the list of temporary members ids
		$TempMembers=explode("#",$stmt1['default_share_temp_members']);
		foreach ($TempMembers as $TempMember) {
			if ($TempMember!=null) {
				//If the Temp Member id is not null
				$TempMember = mysqli_query($conn,"SELECT * FROM tbl_temp_member WHERE id='".$TempMember."'");
				$TempMember = mysqli_fetch_array($TempMember);
				//Adds their email to the array
				array_push($TempMemberArray,$TempMember['email']);
			};
		};
	}

	if (!empty($stmt1['default_share_groups'])) {
		//If there are groups
		$Groups=explode("#",$stmt1['default_share_groups']);
		foreach ($Groups as $Group) {
			if ($Group!=null) {
				//If the $Group has a value
				$TempMembers = mysqli_query($conn,"SELECT temp_member FROM tbl_group WHERE id='".$Group."'");
				$TempMembers = mysqli_fetch_array($TempMembers);
				if (!empty($TempMembers['temp_member'])) {
					$TempMembers=explode("#",$TempMembers['temp_member']);
					//If there are temporary members in the group
					if (!isset($TempMemberArray)) {
						//If there isn't already an array
						$TempMemberArray=array($IdeaId);
					};
					foreach ($TempMembers as $TempMember) {
						if ($TempMember!=null) {
							//If there are team members then add to array
							$TempMember = mysqli_query($conn,"SELECT * FROM tbl_temp_member WHERE id='".$TempMember."'");
							$TempMember = mysqli_fetch_array($TempMember);
							array_push($TempMemberArray,$TempMember['email']);
						}
					}
				}
			}
		}
	};

	if (isset($TempMemberArray)) {
		//If there is an array then show it
		$TempMemberArray = array_unique($TempMemberArray);
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
