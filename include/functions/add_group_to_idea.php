<?php
session_start();
include '../../lib/database.php';
$groupid=$_POST['groupid'];
$ideaid=$_POST['ideaid'];
$MemberId = $_SESSION["MemberId"];

if (is_numeric($groupid) && is_numeric($ideaid)) {
	$sharedgroups = mysqli_query($conn,"SELECT * FROM tbl_ideas WHERE id='".$ideaid."'");
	$sharedgroups = mysqli_fetch_array($sharedgroups);

	//Making sure only the owner of the idea can add groups to it
	if ($sharedgroups['member_id']==$MemberId) {
		$sharedgroups = $sharedgroups['share_groups']."#".$groupid."#";
		$query = "UPDATE tbl_ideas SET share_groups='".$sharedgroups."' WHERE id='".$ideaid."'";
			if (mysqli_query($conn, $query)) {
				
				//Getting an array of temporary member emails to send invites to
				if (!empty($sharedgroups['temp_member'])) {
					$TempMembers=explode("#",$sharedgroups['temp_member']);

					$TempMemberArray=array($ideaid);

					foreach ($TempMembers as $TempMember) {
						if ($TempMember!=null) {
							//If there are team members then add to array
							$TempMember = mysqli_query($conn,"SELECT * FROM tbl_temp_member WHERE id='".$TempMember."'");
							$TempMember = mysqli_fetch_array($TempMember);
							array_push($TempMemberArray,$TempMember['email']);
						}
					}
					echo json_encode($TempMemberArray);
				}

			} 
			else {
				echo json_encode(array("statusCode"=>201));
			};
	};
	mysqli_close($conn);
}
?>