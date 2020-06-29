<?php
  session_start();
  include '../../lib/database.php';
  require '../../assets/mailer/mailer.php';
  use \Mailjet\Resources;

  $MemberId = $_SESSION["MemberId"];
  $InvitationEmail=$_POST["InvitationEmail"];

  if (filter_var($InvitationEmail, FILTER_VALIDATE_EMAIL)) {

    $stmt = mysqli_prepare($conn, "SELECT firstname, lastname FROM tbl_member WHERE id= ?");
    mysqli_stmt_bind_param($stmt, 's', $MemberId);

    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $MemberFirstName, $MemberLastName);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

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
                'Email' => $InvitationEmail,
                'Name' => ""
              ]
            ],
            'Subject' => $MemberFirstName." just shared an idea with you",
            'TextPart' => "Confirmation email", 
            'HTMLPart' => 
            "<h3>
              Hi, ".$MemberFirstName." ".$MemberLastName." just shared an idea with you on 
                <a style='text-decoration:none;color:#455a64;' href='".BASE_URL."'>
                  ".MAIL_URL."
                </a>
              !
              </h3>
              <br />
              Incubator is an idea sharing platform, to create ideas, collaborate with friends and develop them!
              <br /><br />
              Please click on the link below to sign up to <a style='text-decoration:none;color:#455a64;' href='".BASE_URL."'>".MAIL_URL."</a> and check out the idea that ".$MemberFirstName." shared with you
              <br /><br />
              <a style='text-transform:uppercase;color:#455a64;text-decoration:none;font-size:40px;font-weight:bold;' href='".BASE_URL."'>
                ".MAIL_URL."
              </a>",
            'CustomID' => "AppGettingStartedTest"
          ]
        ]
      ];
      $response = $mj->post(Resources::$Email, ['body' => $body]);
      $response->success() && var_dump($response->getData());

    if (mysqli_close($conn)) {
      echo json_encode(array("statusCode"=>200));
    } 
    else {
      echo json_encode(array("statusCode"=>201));
    }
  }
?>
