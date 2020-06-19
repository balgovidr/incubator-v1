<?php
use Phppot\Member;
if (! empty($_POST["signup-btn"])) {
    require_once './Model/Member.php';
    $member = new Member();
    $registrationResponse = $member->registerMember();
}
?>
<HTML>
<HEAD>
<TITLE>Registration</TITLE>
<!--<link href="./assets/css/user-registration.css" type="text/css"
	rel="stylesheet" />-->
<script src="./vendor/jquery/jquery-3.3.1.js" type="text/javascript"></script>
</HEAD>
<BODY>
	<form name="sign-up" action="" method="post" class="sign-up-container"
		onsubmit="return signupValidation()">
		<div class="signup-heading">Changed</div>
	<?php 
	if(!empty($registrationResponse["status"]))
	{
	?>
		<?php 
		if($registrationResponse["status"] == "error")
		{
		?>
		<div class="server-response error-msg"><?php echo $registrationResponse["message"]; ?></div>
		<?php 
		} 
		else if($registrationResponse["status"] == "success")
		{
		?>
		<div class="server-response success-msg"><?php echo $registrationResponse["message"]; ?></div>
		<?php 
		}
		?>
	<?php 
	}
	?>
	<div class="error-msg" id="error-msg"></div>
				<input class="input-box" type="text" name="firstname"
					id="firstname" placeholder="First name">
				<input class="input-box" type="text" name="lastname"
					id="lastname" placeholder="Last name">
				<input class="input-box" type="text" name="username"
					id="username" placeholder="Username">
				<input class="input-box" type="email" name="email" id="email" placeholder="Email">
				<input class="input-box" type="password"
					name="signup-password" id="signup-password" placeholder="Password">
				<input class="input-box" type="password"
					name="confirm-password" id="confirm-password" placeholder="Confirm password">
			<input class="sign-up-btn button" type="submit" name="signup-btn"
				id="signup-btn" value="SIGN UP">
	</form>
	<script>
function signupValidation() {
	var valid = true;
	
    $("#firstname").removeClass("error-field");
    $("#lastname").removeClass("error-field");
	$("#username").removeClass("error-field");
	$("#email").removeClass("error-field");
	$("#password").removeClass("error-field");
	$("#confirm-password").removeClass("error-field");
	
    var FirstName = $("#firstname").val();
    var LastName = $("#lastname").val();
	var UserName = $("#username").val();
	var email = $("#email").val();
	var Password = $('#signup-password').val();
    var ConfirmPassword = $('#confirm-password').val();
	var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
	
    $("#firstname-info").html("").hide();
    $("#lastname-info").html("").hide();
	$("#username-info").html("").hide();
	$("#email-info").html("").hide();

	if (FirstName.trim() == "") {
		$("#firstname-info").html("required.").css("color", "#ee0000").show();
		$("#firstname").addClass("error-field");
		valid = false;
	}
    if (LastName.trim() == "") {
		$("#lastname-info").html("required.").css("color", "#ee0000").show();
		$("#lastname").addClass("error-field");
		valid = false;
	}
    if (UserName.trim() == "") {
		$("#username-info").html("required.").css("color", "#ee0000").show();
		$("#username").addClass("error-field");
		valid = false;
	}
	if (email == "") {
		$("#email-info").html("required").css("color", "#ee0000").show();
		$("#email").addClass("error-field");
		valid = false;
	} else if (email.trim() == "") {
		$("#email-info").html("Invalid email address.").css("color", "#ee0000").show();
		$("#email").addClass("error-field");
		valid = false;
	} else if (!emailRegex.test(email)) {
		$("#email-info").html("Invalid email address.").css("color", "#ee0000")
				.show();
		$("#email").addClass("error-field");
		valid = false;
	}
	if (Password.trim() == "") {
		$("#signup-password-info").html("required.").css("color", "#ee0000").show();
		$("#signup-password").addClass("error-field");
		valid = false;
	}
	if (ConfirmPassword.trim() == "") {
		$("#confirm-password-info").html("required.").css("color", "#ee0000").show();
		$("#confirm-password").addClass("error-field");
		valid = false;
	}
	if(Password != ConfirmPassword){
        $("#error-msg").html("Both passwords must be same.").show();
        valid=false;
    }
	if (valid == false) {
		$('.error-field').first().focus();
		valid = false;
	}
	return valid;	
}
</script>
</BODY>
</HTML>