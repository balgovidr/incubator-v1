<?php 
use Phppot\Member;
include_once 'lib/database.php';

session_start();
?>
<HTML>
<HEAD>
<TITLE>Incubator</TITLE>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<!--<link href="./assets/css/phppot-style.css" type="text/css"
	rel="stylesheet" />-->
<!--<link href="./assets/css/user-registration.css" type="text/css"
	rel="stylesheet" />-->
	<script type="text/javascript" src="<?php echo BASE_URL ?>/assets/js/all.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>/vendor/jquery/jquery-3.3.1.js"></script>
<link href="./assets/css/style.css" type="text/css"
	rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"/>

</HEAD>
<BODY>
	<div class="container home">
		<div class="content flex-column" style="background-image: url(<?php echo BASE_URL ?>/images/home/turned-on-pendant-lamp-132340.jpg)">
			<div class="header fixed-size">
				<a href="<?php echo BASE_URL ?>/home.php" class="title">Incubator</a>
				<div class="login-form right">
						<?php require_once "login-form.php";?>
				</div>
			</div>
			<div class="content-cover adjust-size flex-row vertical-center">
				<div class="text left" id="content1-text1">
					Your idea sharing portal.
				</div>
				<div class="signup-form right">
					<?php require_once "user-registration-form.php";?>
				</div>
			</div>
		</div>
		<div class="content" style="background-image:url(<?php echo BASE_URL ?>/images/home/background-blur-clean-clear-531880.jpg)">
			<div class="content-cover">
				<div>
					<img src="<?php echo BASE_URL ?>/images/home/brain.svg" class="icon-image"/>
				</div>
				<div class="text uppercase right">
					<div id="content2-text1">
						Create.
					</div>
					<div id="content2-text2">
						Collaborate.
					</div>
					<div id="content2-text3">
						Innovate.
					</div>
				</div>
			</div>
		</div>
		<div class="content" style="background-image:url(<?php echo BASE_URL ?>/images/home/crowd-ground-hands-legs-450059.jpg)">
			<div class="content-cover">
				<div class="text left">
					<div id="content3-text1">
						Add friends.
					</div>
					<div id="content3-text2">
						Create groups.
					</div>
				</div>
			</div>
		</div>
		<div class="content" style="background-image:url(<?php echo BASE_URL ?>/images/home/ballpen-blank-desk-journal-606541.jpg)">
		<div class="content-cover">	
				<div class="text right">
					<div id="content4-text1">
						Journal ideas.
					</div>
				</div>
			</div>
		</div>
		<div class="content" style="background-image:url(<?php echo BASE_URL ?>/images/home/people-coffee-meeting-team-7096.jpg)">
			<div class="content-cover">
				<div class="text left">
					<div id="content5-text1">
						Develop them
					</div>
					<div id="content5-text2">
						collaboratively.
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="<?php echo BASE_URL ?>/assets/js/all.js" type="text/javascript"></script>
	<script>
	if ( window.history.replaceState ) {
	window.history.replaceState( null, null, window.location.href );
	}
	</script>
	<a href="https://www.freepik.com/free-photos-vectors/icon" style="display:none">Icon vector created by rawpixel.com - www.freepik.com</a>
</BODY>
</HTML>