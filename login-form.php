<?php
use Phppot\Member;
if (! empty($_POST["login-btn"])) {
    require_once './Model/Member.php';
    $member = new Member();
    $loginResult = $member->loginMember();
}
?>
	<div class="log-in-container">
		<form name="login" action="" method="post"
			onsubmit="return loginValidation()">
		<?php if(!empty($loginResult)){?>
		<div class="error-msg"><?php echo $loginResult;?></div>
		<?php }?>
			<input class="input-box" type="text" name="username"
						id="username" placeholder="Username">
			<input class="input-box" type="password"
						name="signup-password" id="signup-password" placeholder="Password">
			<input class="button" type="submit" name="login-btn"
					id="login-btn" value="Login">

		</form>
	</div>

	<script>
function loginValidation() {
	var valid = true;
	$("#username").removeClass("error-field");
	$("#password").removeClass("error-field");
	
	var UserName = $("#username").val();
	var Password = $('#signup-password').val();
    
	$("#username-info").html("").hide();
	$("#email-info").html("").hide();

	if (UserName.trim() == "") {
		$("#username-info").html("required.").css("color", "#ee0000").show();
		$("#username").addClass("error-field");
		valid = false;
	}
	if (Password.trim() == "") {
		$("#signup-password-info").html("required.").css("color", "#ee0000").show();
		$("#signup-password").addClass("error-field");
		valid = false;
	}
	if (valid == false) {
		$('.error-field').first().focus();
		valid = false;
	}
	return valid;	
}
</script>