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
			<input class="input-box" type="text" name="signin-username"
						id="signin-username" placeholder="Username">
			<input class="input-box" type="password"
						name="signin-password" id="signin-password" placeholder="Password">
			<input class="button" type="submit" name="login-btn"
					id="login-btn" value="Login">

		</form>
	</div>

	<script>
function loginValidation() {
	var valid = true;
	$("#signin-username").removeClass("error-field");
	$("#password").removeClass("error-field");
	
	var UserName = $("#signin-username").val();
	var Password = $('#signin-password').val();
    
	$("#signin-username-info").html("").hide();
	$("#email-info").html("").hide();

	if (UserName.trim() == "") {
		$("#signin-username-info").html("required.").css("color", "#ee0000").show();
		$("#signin-username").addClass("error-field");
		valid = false;
	}
	if (Password.trim() == "") {
		$("#signin-password-info").html("required.").css("color", "#ee0000").show();
		$("#signin-password").addClass("error-field");
		valid = false;
	}
	if (valid == false) {
		$('.error-field').first().focus();
		valid = false;
	}
	return valid;	
}
</script>