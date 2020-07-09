<?php 
use Phppot\Member;
include_once 'lib/database.php';

session_start();

if( strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false ) {
	// webp is supported!
	$imgext='webp';
} else {
	$imgext = 'jpg';
}
?>
<!DOCTYPE html>
<HTML lang="en" xml:lang="en">
<HEAD>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-171498731-1"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-171498731-1');
	</script>

<TITLE>Incubator - Idea sharing and collaboration portal</TITLE>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="description" content="Jot your ideas down, share ideas with your friends and groups, collaborate and develop the ideas further!">
<meta name="keywords" content="Idea, Journal, Jot, Share, Portal, Collaborate, Develop, Friends, Groups">

<!--To display the website to social media -->
<meta name="twitter:card" content="summary"/>
<meta property="twitter:title" content="Incubator - Idea sharing and collaboration portal" />
<meta property="twitter:image" content="<?php echo BASE_URL ?>/images/logo.png" />
<meta property="twitter:description" content="Jot your ideas down, share ideas with your friends and groups, collaborate and develop the ideas further!" />

<!--To display the website on Twitter -->
<meta property="og:title" content="Incubator - Idea sharing and collaboration portal" />
<meta property="og:url" content="https://www.incubator.gq/" />
<meta property="og:image" content="<?php echo BASE_URL ?>/images/logo.png" />
<meta property="og:description" content="Jot your ideas down, share ideas with your friends and groups, collaborate and develop the ideas further!" />

<!-- Favicon -->
<link rel="shortcut icon" href="<?php echo BASE_URL ?>/images/favicon.png" />

<!-- Canonical redirection -->
<link rel="canonical" href="https://www.incubator.gq">

<link href="./assets/css/style.css" type="text/css" rel="stylesheet" />

</HEAD>
<BODY>
	<div class="container home">
		<div class="content content-a flex-column" style="background-image: url(<?php echo BASE_URL ?>/images/home/turned-on-pendant-lamp-132340.<?php echo $imgext ?>)">
			<div class="header fixed-size">
				<H1 href="<?php echo BASE_URL ?>/home.php" class="title">Incubator</H1>
				<div class="login-form right">
						<?php require_once "login-form.php";?>
				</div>
			</div>
			<div class="content-cover adjust-size flex-row vertical-center">
				<div class="subtitle left color-white" id="content1-text1">
					Your idea sharing portal.
				</div>
				<div class="signup-form right">
					<?php require_once "user-registration-form.php";?>
				</div>
			</div>
		</div>
		<div class="content content-b">
			<img alt="Your ideas on Incubator" src="<?php echo BASE_URL ?>/images/home/slide-1.png" class="desc-image"/>
			<div class="right">
				<div class="subtitle">
					Jot down your ideas
				</div>
				<br/>
				<div class="text">
					Write down all of your quirky ideas, from the craziest to the most concrete.
				</div>
			</div>
		</div>
		<div class="content content-a" style="background-image:url(<?php echo BASE_URL ?>/images/home/ballpen-blank-desk-journal-606541.<?php echo $imgext ?>)">
		<div class="content-cover">	
				<div class="text color-white">
					<div class="subtitle">
					“I have lots of ideas. How do I pick the right one?
					<br/>
					<br/>
					Execute on as many as possible. The right idea will pick you.”
					</div>
					<br/>
					<div class="text">
					- James Altucher, The Choose Yourself Guide To Wealth
					</div>
				</div>
			</div>
		</div>
		<div class="content content-c">
			<div class="left">
				<div class="subtitle">
					Add friends
				</div>
				<div class="text">
					Invite and add friends, or create groups to share your ideas with. Assemble your dream team on Incubator!
				</div>
			</div>
			<img alt="Your ideas on Incubator" src="<?php echo BASE_URL ?>/images/home/slide-2.png" class="desc-image right"/>
		</div>
		<div class="content content-c">
			<img alt="Your ideas on Incubator" src="<?php echo BASE_URL ?>/images/home/slide-3.png" class="desc-image"/>
			<div class="right">
				<div class="subtitle">
					Collaborate
				</div>
				<div class="text">
					Work on ideas together, develop them and bring your ideas to life.
				</div>
			</div>
		</div>
		<div class="content content-a" style="background-image:url(<?php echo BASE_URL ?>/images/home/people-coffee-meeting-team-7096.<?php echo $imgext ?>)">
			<div class="content-cover color-white">
				<div class="subtitle">
					“Ideas are cheap. It’s the execution that is all important.”
				</div>
				<div class="text">
					— George R.R. Martin
				</div>
			</div>
		</div>
		<div class="content content-c">
			<div class="left">
				<div class="subtitle">
					Share
				</div>
				<div class="text">
					Check out ideas shared with you by your friends
				</div>
			</div>
			<img alt="Your ideas on Incubator" src="<?php echo BASE_URL ?>/images/home/slide-4.png" class="desc-image right"/>
		</div>
		<div class="content content-c">
			<img alt="Your ideas on Incubator" src="<?php echo BASE_URL ?>/images/home/slide-5.png" class="desc-image"/>
			<div class="right">
				<div class="subtitle">
					Upvote ideas
				</div>
				<div class="text">
					Show your love for innovative ideas you see. Use this to figure out your most popular ideas.
				</div>
			</div>
		</div>
		<!--<div class="content" style="background-image:url(<?php echo BASE_URL ?>/images/home/background-blur-clean-clear-531880.<?php echo $imgext ?>)">
			<div class="content-cover">
				<div>
					<img alt="A developing brain" src="<?php echo BASE_URL ?>/images/home/brain.svg" class="icon-image"/>
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
		<div class="content" 
			style="background-image:url(<?php echo BASE_URL ?>/images/home/crowd-ground-hands-legs-450059.<?php echo $imgext ?>)">
			<div class="content-cover">
				<div class="text left">
					<div id="content3-text1">
						Add friends.
					</div>
					<div>
						Incubator enables you to create groups with your friends in an inspiring setting to bring your ideas to life.
						Incubator enables _____ collaboration.

						Incubator enables you to share ideas with friends so that you can work on them together, develop them.

						Create focused groups
					</div>
					<div id="content3-text2">
						Create groups.
					</div>
				</div>
			</div>
		</div>
		-->
	</div>
	<script>
	if ( window.history.replaceState ) {
	window.history.replaceState( null, null, window.location.href );
	}
	</script>
	<a href="https://www.freepik.com/free-photos-vectors/icon" style="display:none">Icon vector created by rawpixel.com - www.freepik.com</a>

	<script type="text/javascript" src="<?php echo BASE_URL ?>/assets/js/all.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"/>
</BODY>
</HTML>