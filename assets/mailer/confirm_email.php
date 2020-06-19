<?php
  include '../../lib/database.php';
  require 'mailer.php';
  use \Mailjet\Resources;

  $stmt = mysqli_prepare($conn, "SELECT email, firstname, lastname, email_confirm FROM tbl_member WHERE username= ?");
  mysqli_stmt_bind_param($stmt, 's', $MemberUsername);
  
  $MemberUsername=$_POST['MemberUsername'];

  mysqli_stmt_execute($stmt);

  mysqli_stmt_bind_result($stmt, $MemberEmail, $MemberFirstName, $MemberLastName, $MemberEmailConfirm);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt);

  if ($MemberEmailConfirm!='Confirmed') {
    $stmt2 = mysqli_prepare($conn, "UPDATE tbl_member SET email_confirm= ? WHERE username= ?");
    mysqli_stmt_bind_param($stmt2, 'ss', $Key, $MemberUsername);

    $Key=uniqid();
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_close($stmt2);

    $mj = new \Mailjet\Client('914536ef8d44485eacf98b35131687f1','b8894f215d107f30dea834367074f034',true,['version' => 'v3.1']);
    $body = [
      'Messages' => [
        [
          'From' => [
            'Email' => "info@incubator.gq",
            'Name' => "Incubator"
          ],
          'To' => [
            [
              'Email' => $MemberEmail,
              'Name' => $MemberFirstName." ".$MemberLastName
            ]
          ],
          'Subject' => "Confirm your email",
          'TextPart' => "Confirmation email", 
          'HTMLPart' => "<h3>Hi ".$MemberFirstName.", welcome to <a style='text-decoration:none;color:#455a64;' href='".BASE_URL."'>".MAIL_URL."</a>!</h3><br />Please click on the link below to verify your email address.<br /><a href='".BASE_URL."/include/user-functions/confirm_email.php?username=".$MemberUsername."&key=".$Key."'>".BASE_URL."/include/user-functions/confirm_email.php?username=".$MemberUsername."&key=".$Key."</a>",
          'CustomID' => "AppGettingStartedTest"
        ]
      ]
    ];
    $response = $mj->post(Resources::$Email, ['body' => $body]);
    $response->success() && var_dump($response->getData());
  };

  if (mysqli_close($conn)) {
    echo json_encode(array("statusCode"=>200));
  } 
  else {
    echo json_encode(array("statusCode"=>201));
  }
?>
