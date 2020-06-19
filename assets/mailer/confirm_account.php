<?php
  require 'assets/mailer/mailer.php';
  use \Mailjet\Resources;
  $mj = new \Mailjet\Client('914536ef8d44485eacf98b35131687f1','b8894f215d107f30dea834367074f034',true,['version' => 'v3.1']);
  $body = [
    'Messages' => [
      [
        'From' => [
          'Email' => "info@".MAIL_URL,
          'Name' => MAIL_URL
        ],
        'To' => [
          [
            'Email' => $MemberEmail,
            'Name' => $MemberFirstName." ".$MemberLastName
          ]
        ],
        'Subject' => "Confirm your email",
        'TextPart' => "Confirmation email", 
        'HTMLPart' => "<h3>Hi ".$MemberFirstName.", welcome to <a style='text-decoration:none;color:href='".BASE_URL."'>".MAIL_URL."</a>!</h3><br />May the delivery force be with you!",
        'CustomID' => "AppGettingStartedTest"
      ]
    ]
  ];
  $response = $mj->post(Resources::$Email, ['body' => $body]);
  $response->success() && var_dump($response->getData());
?>
