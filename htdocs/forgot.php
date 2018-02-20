<?php

include '../lib/common.php';

$page_title = Lang::string('login-forgot');
$email1 = (!empty($_REQUEST['forgot']['email'])) ? preg_replace("/[^0-9a-zA-Z@\.\!#\$%\&\*+_\~\?\-]/", "",$_REQUEST['forgot']['email']) : false;
$captcha_error = false;

if (!empty($_REQUEST['forgot']) && $email1 && $_SESSION["forgot_uniq"] == $_REQUEST['uniq']) {
	/*if (empty($CFG->google_recaptch_api_key) || empty($CFG->google_recaptch_api_secret)) {
		include_once 'securimage/securimage.php';
		$securimage = new Securimage();
		$captcha_error = (empty($_REQUEST['forgot']['captcha']) || !$securimage->check($_REQUEST['forgot']['captcha']));
	}
	else {*/
		$captcha = new Form('captcha');
		$captcha->reCaptchaCheck(1);
		if (!empty($captcha->errors) && is_array($captcha->errors)) {
			$captcha_error = true;
			Errors::add($captcha->errors['recaptcha']);
		}
	//}
	
	if (!$captcha_error) {
		API::add('User','resetUser',array($email1));
		$query = API::send();

		Messages::$messages = array();
		Messages::add(Lang::string('login-password-sent-message'));
	}
	else {
		Errors::add(Lang::string('login-capcha-error'));
	}
}

$_SESSION["forgot_uniq"] = md5(uniqid(mt_rand(),true));
include 'includes/head.php';
?>
<div class="page_title">
	<div class="container">
		<div class="title"><h1><?= Lang::string('login-forgot') ?></h1></div>
        <div class="pagenation">&nbsp;<a href="index.php"><?= Lang::string('home') ?></a> <i>/</i> <a href="forgot.php"><?= Lang::string('login-forgot') ?></a></div>
	</div>
</div>
<div class="fresh_projects login_bg">
	<div class="clearfix mar_top8"></div>
	<div class="container">
    	<h2><?= Lang::string('login-forgot') ?></h2>
    	<? 
    	if (count(Errors::$errors) > 0) {
			echo '
		<div class="error" id="div4">
			<div class="message-box-wrap">
				<button id="colosebut4" class="close-but">close</button>
				'.Errors::$errors[0].'
			</div>
		</div>';
		}
		
		if (count(Messages::$messages) > 0) {
			Lang::string(Messages::$messages[0]);
			echo '
		<div class="messages" id="div4">
			<div class="message-box-wrap">
				'.Messages::$messages[0].'
			</div>
		</div>';
		}
    	?>
    	<form method="POST" action="forgot.php" name="forgot">
	    	<div class="loginform">
	    		<span><?= Lang::string('forgot-explain') ?></span>
	    		<div class="loginform_inputs">
		    		<div class="input_contain">
		    			<i class="fa fa-user"></i>
		    			<input type="text" class="login" name="forgot[email]" value="<?= $email1 ?>" />
		    		</div>
	    		</div>
		    	<div style="margin-bottom:10px;">
		    		<div class="g-recaptcha" data-sitekey="6LfofToUAAAAAM_YAubk0r6Y4w40QujjAHdXr6iC"></div>
		    	</div>
		    	<input type="hidden" name="uniq" value="<?= $_SESSION["forgot_uniq"] ?>" />
	    		<input type="submit" name="submit" value="<?= Lang::string('login-forgot-send-new') ?>" class="but_user" />
	    	</div>
    	</form>
    	<a class="forgot" href="login.php"><?= Lang::string('login-remembered') ?></a>
    </div>
    <div class="clearfix mar_top8"></div>
</div>
<? include 'includes/foot.php'; ?>