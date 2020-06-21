<?php
  include '../../lib/database.php';
  $MemberUsername=$_GET["username"];
  $Key=$_GET["key"];

  $stmt = mysqli_prepare($conn, "SELECT email_confirm FROM tbl_member WHERE username= ?");
  mysqli_stmt_bind_param($stmt, 's', $MemberUsername);

  mysqli_stmt_execute($stmt);

  mysqli_stmt_bind_result($stmt, $MemberEmailConfirm);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt);

?>
<HTML>
<HEAD>
<TITLE>Confirm email - Incubator</TITLE>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<link href="<?php echo BASE_URL ?>/assets/css/style.css" type="text/css"
	rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"/>
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
            echo 'Your email has been confirmed!<br/>Click&nbsp;<a href="'.BASE_URL.'" style="display:inline">here</a>&nbsp;to login.';
          } else {
            echo 'Your link doesn&#39;t seem correct.<br/>Click&nbsp;<a class="link" style="display:inline" onclick="ConfirmEmail('.$MemberUsername.')">here</a>&nbsp;to get a new link.';
          };

          mysqli_close($conn);
        ?>
        </div>
    </div>
  </div>
  
  <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/js/all.js"></script>
  <script type="text/javascript" src="<?php echo BASE_URL ?>/vendor/jquery/jquery-3.3.1.js"></script>

</BODY>
</HTML>