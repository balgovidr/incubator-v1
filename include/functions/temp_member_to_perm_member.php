<?php
session_start();
include '../../lib/database.php';

$Member1Id=$_POST['Member1Id'];
$Member2Id = $_POST["Member2Id"];
//Only the Members Temp status is being changed, not the friend's

if (is_numeric($Member1Id) && is_numeric($Member2Id)) {
	//Checking that the member's email has actually been confirmed and finding the temp member id of the member
	$member=mysqli_query($conn, "SELECT temp_member_id, email_confirm FROM tbl_member WHERE id='".$Member2Id."'");
	$member=mysqli_fetch_array($member);
	if (!is_null($member['temp_member_id']) && $member['email_confirm']=='Confirmed') {
		//Only if member has a temporary id and if email has been confirmed
		$MemberTempId = $member['temp_member_id'];

		//Shift temp member to perm member from friend's tbl_group
		$groups=mysqli_query($conn, "SELECT * FROM tbl_group WHERE member_id='".$Member1Id."' AND temp_member LIKE '%#".$MemberTempId."#%'");
		$groups=mysqli_fetch_array($groups);

		foreach ($groups as $group) {
			//Add the permanent id of the member to the list of members of the group
			//Get current member list
			$CurrentList=$group['members'];
			$NewList=$CurrentList."#".$Member2Id."#";

			//Update the member list
			mysqli_query($conn, "UPDATE tbl_group SET members='".$NewList."' WHERE id='".$group['id']."'");

			//Delete the temp member from list
			$ReplaceTerm = "#".$MemberTempId."#";
			mysqli_query($conn, "UPDATE tbl_group SET temp_member= REPLACE(temp_member, '".$ReplaceTerm."' , '') WHERE id= '".$group['id']."'");
		}

		//Shift temp member to perm member from friend's tbl_ideas
		$ideas=mysqli_query($conn, "SELECT * FROM tbl_ideas WHERE member_id='".$Member1Id."' AND share_temp_members LIKE '%#".$MemberTempId."#%'");
		$ideas=mysqli_fetch_array($ideas);

		foreach ($ideas as $idea) {
			//Add the permanent id of the member to the list of members of the idea
			//Get current member list
			$CurrentList=$idea['share_friends'];
			$NewList=$CurrentList."#".$Member2Id."#";

			//Update the member list
			mysqli_query($conn, "UPDATE tbl_ideas SET share_friends='".$NewList."' WHERE id='".$idea['id']."'");

			//Delete the temp member from list
			$ReplaceTerm = "#".$MemberTempId."#";
			mysqli_query($conn, "UPDATE tbl_ideas SET share_temp_members= REPLACE(share_temp_members, '".$ReplaceTerm."' , '') WHERE id= '".$idea['id']."'");
		}
	}

	//Checking that the member's email has actually been confirmed and finding the temp member id of the member
	$member=mysqli_query($conn, "SELECT temp_member_id, email_confirm FROM tbl_member WHERE id='".$Member1Id."'");
	$member=mysqli_fetch_array($member);
	if (!is_null($member['temp_member_id']) && $member['email_confirm']=='Confirmed') {
		//Only if member has a temporary id and if email has been confirmed
		$MemberTempId = $member['temp_member_id'];

		//Shift temp member to perm member from friend's tbl_group
		$groups=mysqli_query($conn, "SELECT * FROM tbl_group WHERE member_id='".$Member2Id."' AND temp_member LIKE '%#".$MemberTempId."#%'");
		$groups=mysqli_fetch_array($groups);

		foreach ($groups as $group) {
			//Add the permanent id of the member to the list of members of the group
			//Get current member list
			$CurrentList=$group['members'];
			$NewList=$CurrentList."#".$Member1Id."#";

			//Update the member list
			mysqli_query($conn, "UPDATE tbl_group SET members='".$NewList."' WHERE id='".$group['id']."'");

			//Delete the temp member from list
			$ReplaceTerm = "#".$MemberTempId."#";
			mysqli_query($conn, "UPDATE tbl_group SET temp_member= REPLACE(temp_member, '".$ReplaceTerm."' , '') WHERE id= '".$group['id']."'");
		}

		//Shift temp member to perm member from friend's tbl_ideas
		$ideas=mysqli_query($conn, "SELECT * FROM tbl_ideas WHERE member_id='".$Member2Id."' AND share_temp_members LIKE '%#".$MemberTempId."#%'");
		$ideas=mysqli_fetch_array($ideas);

		foreach ($ideas as $idea) {
			//Add the permanent id of the member to the list of members of the idea
			//Get current member list
			$CurrentList=$idea['share_friends'];
			$NewList=$CurrentList."#".$Member1Id."#";

			//Update the member list
			mysqli_query($conn, "UPDATE tbl_ideas SET share_friends='".$NewList."' WHERE id='".$idea['id']."'");

			//Delete the temp member from list
			$ReplaceTerm = "#".$MemberTempId."#";
			mysqli_query($conn, "UPDATE tbl_ideas SET share_temp_members= REPLACE(share_temp_members, '".$ReplaceTerm."' , '') WHERE id= '".$idea['id']."'");
		}
	}
	mysqli_close($conn);
}
?>