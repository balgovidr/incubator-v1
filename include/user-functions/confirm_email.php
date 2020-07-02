<?php
  include '../../lib/database.php';
  $MemberUsername=$_GET["username"];
  $Key=$_GET["key"];

  $stmt = mysqli_prepare($conn, "SELECT id, email, email_confirm FROM tbl_member WHERE username= ?");
  mysqli_stmt_bind_param($stmt, 's', $MemberUsername);

  mysqli_stmt_execute($stmt);

  mysqli_stmt_bind_result($stmt, $MemberId, $MemberEmail, $MemberEmailConfirm);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt);

?>
<HTML>
<HEAD>
<TITLE>Confirm email - Incubator</TITLE>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<link href="<?php echo BASE_URL ?>/assets/css/style.css" type="text/css"
	rel="stylesheet" />
<!--Required for the montserrat font -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"/>
<script type="text/javascript" src="<?php echo BASE_URL ?>/assets/js/all.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL ?>/vendor/jquery/jquery-3.3.1.js"></script>
</HEAD>
<BODY>
  <div style="display:none">
      <div id="member-id">
          <?php echo $member['id'] ?>
      </div>
  </div>
	<div class="container" style="max-height:100vh;overflow:hidden">
    <?php include '../../assets/elements/header.php' ?>
    <div class="content">
      <div style="display:inline-block;text-align:center;width:100%">
      <br/>
      <br/>
      <br/>
      <br/>
        <?php
          if ($MemberEmailConfirm==$Key) {
            $stmt2 = mysqli_prepare($conn, "UPDATE tbl_member SET email_confirm= 'Confirmed' WHERE username= ?");
            mysqli_stmt_bind_param($stmt2, 's', $MemberUsername);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_close($stmt2);
            ?>
            
            Your email has been confirmed!
            <br/>
            Click&nbsp;<a href="<?php echo BASE_URL ?>" style="display:inline">here</a>&nbsp;to login.

            <?php
            //Transferring the person from a temporary user to permanent
            $stmt3 = mysqli_prepare($conn, "SELECT id FROM tbl_temp_member WHERE email= ?");
            mysqli_stmt_bind_param($stmt3, 's', $MemberEmail);
            if (mysqli_stmt_execute($stmt3)) {
              //Only executes if there is a temporary email the same as the member's
              mysqli_stmt_bind_result($stmt3, $TempMemberId);
              mysqli_stmt_fetch($stmt3);
              ?>

              <br/>
              Start adding friends to see the ideas they've already shared with you!

              <?php
              //Adds this temporary member id to the user's permanent membership details
              $stmt4 = mysqli_prepare($conn, "UPDATE tbl_member SET temp_member_id= ? WHERE username= ?");
              mysqli_stmt_bind_param($stmt4, 'is', $TempMemberId, $MemberUsername);
              mysqli_stmt_execute($stmt4);
              mysqli_stmt_close($stmt4);

              //Deleting this entry from the tbl_temp_member row
              $stmt3 = mysqli_prepare($conn, "DELETE FROM tbl_temp_member WHERE email = ?");
              mysqli_stmt_bind_param($stmt3, 's', $MemberEmail);
              mysqli_stmt_execute($stmt3);
              
              //For each existing friend, updates each others temporary member id with their permanent id in their ideas and groups
              //This only works for members that already have confirmed their emails and wont happen for ones that haven't confirmed
              $stmt5 = mysqli_query($conn, "SELECT member1, member2, status FROM tbl_friends WHERE member1='".$MemberId."' AND status='friend' OR member2='".$MemberId."' AND status='friend''");
              $stmt5 = mysqli_fetch_array($stmt5);
              foreach ($stmt5 as $row) {
                echo "<script type='text/javascript'>TempMemberToPermMember(".$row['member1'].",".$row['member2'].");</script>";
              }
            }
          } else {
            ?>
            Your link doesn&#39;t seem correct.
            <br/>
            Click&nbsp;<a class="link" style="display:inline" onclick="ConfirmEmail('<?php echo $MemberUsername ?>')">here</a>&nbsp;to get a new link.
            <?php
          };

          mysqli_stmt_close($stmt3);
          mysqli_close($conn);
        ?>
        </div>
    </div>
  </div>

</BODY>
</HTML>