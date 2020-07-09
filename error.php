<?php
session_start();
include_once('lib/database.php');
if (empty($_SESSION["username"])) {
    header("Location:".BASE_URL);
}
$username = $_SESSION["username"];
$MemberId = $_SESSION["MemberId"];

//Getting member details
$member = mysqli_query($conn,"SELECT * FROM tbl_member where username='".$username."'");
$member = mysqli_fetch_array($member);

//Creating the error message
$status = $_SERVER['REDIRECT_STATUS'];
$codes = array(
       403 => array('403 Forbidden', 'The server has refused to fulfill your request.'),
       404 => array('404 Not Found', 'The document/file requested was not found on this server.'),
       405 => array('405 Method Not Allowed', 'The method specified in the Request-Line is not allowed for the specified resource.'),
       408 => array('408 Request Timeout', 'Your browser failed to send a request in the time allowed by the server.'),
       500 => array('500 Internal Server Error', 'The request was unsuccessful due to an unexpected condition encountered by the server.'),
       502 => array('502 Bad Gateway', 'The server received an invalid response from the upstream server while trying to fulfill the request.'),
       504 => array('504 Gateway Timeout', 'The upstream server failed to send a request in the time allowed by the server.'),
);

$title = $codes[$status][0];
$message = $codes[$status][1];
if ($title == false || strlen($status) != 3) {
       $message = 'An unknown error...';
       $title = '40 Something';
       $status = 202;
}
?>
<HTML>
<HEAD>
<TITLE>Incubator - <?php echo $title ?></TITLE>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<!-- Favicon -->
<link rel="shortcut icon" href="<?php echo BASE_URL ?>/images/favicon.png" />

<link href="<?php echo BASE_URL ?>/assets/css/style.css" type="text/css"
	rel="stylesheet" />
<!--Required for the montserrat font -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"/>
</HEAD>
<BODY>
	<div class="container container-error">
        <!-- Fetches the header and displays it -->
        <?php include('assets/elements/header.php') ?>

        <div class="content">
            <!-- Shows the menu element -->
            <?php include('assets/elements/menu.php') ?>
            <div class="content-rows content-error">
                <div class="error-img error-col">
                    <i class="fas fa-skull-crossbones"></i>
                </div>
                <div class="error-col">
                    <h1>
                        <?php echo $title ?>
                    </h1>
                    <h2>
                        <?php echo $message ?>
                    </h2>
                    <div class="error-text">
                        Head to the 
                        <a href="<?php echo BASE_URL ?>">
                            homepage to signup or login
                        </a>
                        , or 
                        <a href="<?php echo BASE_URL ?>/home.php">
                            check out your ideas
                        </a>
                        .
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/js/all.js"></script>

</BODY>
</HTML>