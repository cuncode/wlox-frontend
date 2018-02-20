<?php

include '../lib/common.php';

$page_title = Lang::string('home-login');
$user1 = (!empty($_REQUEST['login']['user'])) ? preg_replace("/[^0-9a-zA-Z@\.\!#\$%\&\*+_\~\?\-]/", "",$_REQUEST['login']['user']) : false;
$pass1 = (!empty($_REQUEST['login']['pass'])) ? preg_replace($CFG->pass_regex, "",$_REQUEST['login']['pass']) : false;

if (!empty($_REQUEST['submitted'])) {
	if (empty($user1)) {
		Errors::add(Lang::string('login-user-empty-error'));
	}

	if (empty($pass1)) {
		Errors::add(Lang::string('login-password-empty-error'));
	}
	
	if (!empty($_REQUEST['submitted']) && (empty($_SESSION["register_uniq"]) || $_SESSION["register_uniq"] != $_REQUEST['uniq']))
		Errors::add('Page expired.');
	
	if (!empty(User::$attempts) && User::$attempts > 3 && !empty($CFG->google_recaptch_api_key) && !empty($CFG->google_recaptch_api_secret)) {
		$captcha = new Form('captcha');
		$captcha->reCaptchaCheck(1);
		if (!empty($captcha->errors) && is_array($captcha->errors)) {
			Errors::add($captcha->errors['recaptcha']);
		}
	}
	
	if (!is_array(Errors::$errors)) {
		$login = User::logIn($user1,$pass1);
		if ($login && empty($login['error'])) {
			if (!empty($login['message']) && $login['message'] == 'awaiting-token') {
			    $_SESSION["register_uniq"] = md5(uniqid(mt_rand(),true));
				Link::redirect('verify-token.php');
			}
			elseif (!empty($login['message']) && $login['message'] == 'logged-in' && $login['no_logins'] == 'Y') {
			    $_SESSION["register_uniq"] = md5(uniqid(mt_rand(),true));
				Link::redirect('first_login.php');
			}
			elseif (!empty($login['message']) && $login['message'] == 'logged-in') {
			    $_SESSION["register_uniq"] = md5(uniqid(mt_rand(),true));
				Link::redirect('account.php');
			}
		}
		elseif (!$login || !empty($login['error'])) {
			Errors::add(Lang::string('login-invalid-login-error'));
		}
	}
}

if (!empty($_REQUEST['message']) && $_REQUEST['message'] == 'registered')
	Messages::add(Lang::string('register-success'));

$_SESSION["register_uniq"] = md5(uniqid(mt_rand(),true));
include 'includes/head.php';
?>
<div class="page_title" style="display:none;">
	<div class="container">
		<div class="title"><h1><?= Lang::string('home-login') ?></h1></div>
        <div class="pagenation">&nbsp;<a href="index.php"><?= Lang::string('home') ?></a> <i>/</i> <a href="login.php"><?= Lang::string('home-login') ?></a></div>
	</div>
</div>
<div class="fresh_projects login_bg">
	<div class="clearfix mar_top8"></div>
	
<!-- <?= Lang::string('home-login') ?> -->
	<h2>LOGIN</h2>
	<div class="container">
    	
    	<? 
    	if (count(Errors::$errors) > 0) {
			echo '
		<div class="error" id="div4">
			<div class="message-box-wrap">
				'.((User::$timeout > 0) ? str_replace('[timeout]','<span class="time_until"></span><input type="hidden" class="time_until_seconds" value="'.(time() + User::$timeout).'" />',Lang::string('login-timeout')) : Errors::$errors[0]).'
			</div>
		</div>';
		}
		
		if (count(Messages::$messages) > 0) {
			echo '
		<div class="messages" id="div4">
			<div class="message-box-wrap">
				'.Messages::$messages[0].'
			</div>
		</div>';
		}
    	?>
    	<form method="POST" action="login.php" name="login">
	    	<div class="loginform">
	    		<div class="loginform_inputs">
		    		<div class="input_contain">
		    			<i class="fa fa-user" style="border: 1px; background-color: #1743d7; border-radius: .5em 0 0 .5em; width: 10%; text-align:center;padding: 10px; height: 40px;"></i>
		    			<input type="text" class="login" name="login[user]" placeholder="Username" value="<?= $user1 ?>">
		    		</div>
		    		<div class="separate"></div>
		    		<div class="input_contain last">
		    			<i class="fa fa-lock" style="border:1px; background-color: #1743d7; border-radius: .5em 0 0 .5em; width: 10%; text-align:center;padding: 10px; height: 40px;"></i>
		    			<input type="password" class="login" name="login[pass]" placeholder="Password" value="<?= $pass1 ?>">
		    		</div>
	    		</div>
	    		<? if (!empty(User::$attempts) && User::$attempts > 2 && !empty($CFG->google_recaptch_api_key) && !empty($CFG->google_recaptch_api_secret)) { ?>
		    	<div style="margin-bottom:10px;">
		    		<div class="g-recaptcha" data-sitekey="<?= $CFG->google_recaptch_api_key ?>"></div>
		    	</div>
		    	<? } ?>
	    		<input type="hidden" name="submitted" value="1" />
	    		<input type="hidden" name="uniq" value="<?= $_SESSION["register_uniq"] ?>" />
	    		<input type="submit" name="submit" value="<?= Lang::string('home-login') ?>" class="but_user" />
	    		<a href="forgot.php" style="margin-top: 20px; color: #000;"><?= Lang::string('forgot-ask') ?></a>
	    	</div>
    	</form>
    	<a class="forgot" href="register.php?"><?= Lang::string('login-dont-have') ?></a>
    </div>
    <div class="clearfix mar_top8"></div>
</div>
<? include 'includes/foot.php'; ?>