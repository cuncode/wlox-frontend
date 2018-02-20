<? $_SESSION["logout_uniq"] = md5(uniqid(mt_rand(),true));?>
<!doctype html>
<!--[if IE 7 ]>    <html lang="<?= $CFG->language ?>" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="<?= $CFG->language ?>" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="<?= $CFG->language ?>" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="<?= $CFG->language ?>" class="no-js"> <!--<![endif]-->

<head>
	<title><?= $page_title ?></title>
	<base href="<?= $CFG->baseurl ?>" />
	
	<meta charset="utf-8">
	<meta name="keywords" content="" />

	<meta name="description" content="<?= (!empty($meta_desc) ? $meta_desc : false) ?>" />
	<meta name="publisher" content="BTC Trade Center is the best online platform. Safe to buy, sell, transfer and store digital currency, developed by Cuncode" />

    
    <!-- Favicon --> 
	<link rel="shortcut icon" href="images/favicon.ico">
    
    <!-- this styles only adds some repairs on idevices  -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    <!-- Google fonts - witch you want to use - (rest you can just remove) -->
    <link rel='stylesheet' href='//fonts.googleapis.com/css?family=Open+Sans:400,800,700italic,700,600italic,600,400italic,300italic,300|Roboto:100,300,400,500,700&amp;subset=latin,latin-ext' type='text/css' />
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
    
    <!-- ######### CSS STYLES ######### -->
    <link rel="stylesheet" href="css/animate.css" type="text/css" />
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <link rel="stylesheet" href="css/style2.css" type="text/css" />
	
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css" type="text/css" />
    
    <!-- responsive devices styles -->
	<link rel="stylesheet" media="screen" href="css/responsive-leyouts.css?v=20160205" type="text/css" />

    <link rel="stylesheet" href="css/parallax/style.css" type="text/css" />
    
<!-- just remove the below comments witch color skin you want to use -->
    <!--<link rel="stylesheet" href="css/colors/lightblue.css" />-->
    <!--<link rel="stylesheet" href="css/colors/lightgreen.css" />-->
    <!--<link rel="stylesheet" href="css/colors/blue.css" />-->
    <!--<link rel="stylesheet" href="css/colors/green.css" />-->
    <!--<link rel="stylesheet" href="css/colors/red.css" />-->
    <link rel="stylesheet" href="css/colors/cyan.css" />
    <!--<link rel="stylesheet" href="css/colors/purple.css" />-->
    <!--<link rel="stylesheet" href="css/colors/pink.css" />-->
    <!--<link rel="stylesheet" href="css/colors/brown.css" />-->
    
    
    <? if ($CFG->self == 'security.php') { ?>
    <!-- authy -->
    <link href="https://www.authy.com/form.authy.min.css" media="screen" rel="stylesheet" type="text/css">
    <? } ?>
    
    <? if ($CFG->self == 'contact.php') { ?>
	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<? } ?>
	
	<? if ($CFG->self == 'api-docs.php') { ?>
	<link rel="stylesheet" media="screen" href="css/prism.css" type="text/css" />
	<? } ?>
	
	<? if ($CFG->self == 'contact.php' || $CFG->self == 'login.php' || $CFG->self == 'register.php' || $CFG->self == 'forgot.php') { ?>
	<script src='https://www.google.com/recaptcha/api.js<?= ((!empty($CFG->language) && $CFG->language != 'en') ? '?hl='.($CFG->language == 'zh' ? 'zh-CN' : $CFG->language) : '') ?>'></script>
	<? } ?>
	
	<?= Lang::url($CFG->self,1); ?>
</head>

<body onload="top_window()">
<div class="trans02" id="menuM">
    <nav class="navIcons">
        <a href="<?= Lang::url('index.php') ?>" <?= ($CFG->self == 'index.php' || !$CFG->self) ? 'class="overlayClick animated"' : '' ?>><?= Lang::string('home') ?></a>
        <a href="<?= Lang::url('order-book.php') ?>" class="overlayClick animated" <?= ($CFG->self == 'order-book.php') ? : '' ?>><?= Lang::string('order-book') ?></a>
        <? if (!User::isLoggedIn()) { ?>
            
            <a href="<?= Lang::url('our-security.php') ?>" class="overlayClick animated" <?= ($CFG->self == 'our-security.php') ?  : '' ?>><?= Lang::string('our-security') ?></a>
            <a href="<?= Lang::url('buy-and-sell-bitcoin.php') ?>" class="overlayClick animated" <?= ($CFG->self == 'buy-and-sell-bitcoin.php') ?  : '' ?>><?= Lang::string('how-to-register') ?> <!-- i class="fa fa-angle-down"></i --></a>
            
            <a href="<?= Lang::url('fee-schedule.php') ?>" class="overlayClick animated" <?= ($CFG->self == 'fee-schedule.php') ? : '' ?>><?= Lang::string('fee-schedule') ?></a>
            <a href="<?= Lang::url('contact.php') ?>" class="overlayClick animated"><?= Lang::string('contact') ?></a>
            <a href="login.php" class="overlayClick animated" ><?= Lang::string('home-login') ?></a>
            <a href="register.php" class="overlayClick animated" ><?= Lang::string('home-register') ?></a>

            <? } else { ?>

            <a href="account.php" class="overlayClick animated" <?= ($CFG->self == 'account.php' || $CFG->self == 'open-orders.php' || $CFG->self == 'transactions.php' || $CFG->self == 'security.php' || $CFG->self == 'settings.php' || $CFG->self == 'bank-accounts.php' || $CFG->self == 'bitcoin-addresses.php' || $CFG->self == 'history.php' || $CFG->self == 'api-access.php') ?  : '' ?>><?= Lang::string('account') ?></a>
            <a href="buy-sell.php" class="overlayClick animated" <?= ($CFG->self == 'buy-sell.php') ?  : '' ?>><?= Lang::string('buy-sell') ?></a>
            <a href="deposit.php" class="overlayClick animated" <?= ($CFG->self == 'deposit.php') ?  : '' ?>><?= Lang::string('deposit') ?></a>
            <a href="withdraw.php" class="overlayClick animated" <?= ($CFG->self == 'withdraw.php') ?  : '' ?>><?= Lang::string('withdraw') ?></a>

            <? } ?>
        </nav>
</div>
<input type="hidden" id="javascript_date_format" value="<?= Lang::string('javascript-date-format') ?>" />
<input type="hidden" id="javascript_mon_0" value="<?= Lang::string('jan') ?>" />
<input type="hidden" id="javascript_mon_1" value="<?= Lang::string('feb') ?>" />
<input type="hidden" id="javascript_mon_2" value="<?= Lang::string('mar') ?>" />
<input type="hidden" id="javascript_mon_3" value="<?= Lang::string('apr') ?>" />
<input type="hidden" id="javascript_mon_4" value="<?= Lang::string('may') ?>" />
<input type="hidden" id="javascript_mon_5" value="<?= Lang::string('jun') ?>" />
<input type="hidden" id="javascript_mon_6" value="<?= Lang::string('jul') ?>" />
<input type="hidden" id="javascript_mon_7" value="<?= Lang::string('aug') ?>" />
<input type="hidden" id="javascript_mon_8" value="<?= Lang::string('sep') ?>" />
<input type="hidden" id="javascript_mon_9" value="<?= Lang::string('oct') ?>" />
<input type="hidden" id="javascript_mon_10" value="<?= Lang::string('nov') ?>" />
<input type="hidden" id="javascript_mon_11" value="<?= Lang::string('dec') ?>" />
<input type="hidden" id="gmt_offset" value="<?= $CFG->timezone_offset ?>" />
<input type="hidden" id="is_logged_in" value="<?= User::isLoggedIn() ?>" />
<input type="hidden" id="cfg_orders_edit" value="<?= Lang::string('orders-edit') ?>" />
<input type="hidden" id="cfg_orders_delete" value="<?= Lang::string('orders-delete') ?>" />
<input type="hidden" id="cfg_user_id" value="<?= (User::isLoggedIn()) ? User::$info['user'] : '0' ?>" />
<input type="hidden" id="buy_errors_no_compatible" value="<?= Lang::string('buy-errors-no-compatible') ?>" />
<input type="hidden" id="orders_converted_from" value="<?= Lang::string('orders-converted-from') ?>" />
<input type="hidden" id="your_order" value="<?= Lang::string('home-your-order') ?>" />
<input type="hidden" id="order-cancel-all-conf" value="<?= Lang::string('order-cancel-all-conf') ?>" />
<input type="hidden" id="this_currency_id" value="<?= (!empty($currency_info)) ? $currency_info['id'] : 0 ?>" />
<input type="hidden" id="chat_handle" value="<?= (User::isLoggedIn()) ? User::$info['chat_handle'] : 'not-logged-in' ?>" />
<input type="hidden" id="chat_baseurl" value="<?= ($CFG->chat_baseurl) ? $CFG->chat_baseurl : $CFG->baseurl ?>" />
<input type="hidden" id="cfg_thousands_separator" value="<?= (!empty($CFG->thousands_separator)) ? $CFG->thousands_separator : ',' ?>" />
<input type="hidden" id="cfg_decimal_separator" value="<?= (!empty($CFG->decimal_separator)) ? $CFG->decimal_separator : '.' ?>" />
<input type="hidden" id="cfg_time_24h" value="<?= (!empty($CFG->time_24h)) ? $CFG->time_24h : 'N' ?>" />
<?= Lang::url(false,false,1); ?>
<?= Lang::jsCurrencies(false,false,1); ?>

<script type="text/javascript">
    /*focus sol*/
    function top_window(){
        window.scrollTo(0,0);
    }
</script>

<div class="site_wrapper">
   
<!-- HEADER -->
<header id="header">

	<!-- Top header bar -->
	<div id="topHeader" style="display:none;">
    
	 <div class="wrapper">
         
        <div class="top_contact_info">
        
        <div class="container">
        <!--
            <ul class="tci_list_left">
                <li><a href="help.php"><?= Lang::string('help') ?></a></li>
                <li>|</li>
                
            </ul>end top contact info -->
        
            
            
        </div>
        
    </div> 
            
 	</div>
    
	</div>
	
    
	<div id="trueHeader">
    
	<div class="wrapper">
    
     <div class="container-header">
    
		<!-- Logo -->
		<div class="logo_container"><a href="index.php" id="logo"></a></div>
		
        <!-- Menu -->
        <div class="three_fourth last">
           
           <nav id="access" class="access" role="navigation">
           
            <div id="menu" class="menu">
                
                <ul id="tiny">
                    <li><a href="<?= Lang::url('index.php') ?>" <?= ($CFG->self == 'index.php' || !$CFG->self) ? 'class="active"' : '' ?>><?= Lang::string('home') ?></a></li>
                    <li><a href="<?= Lang::url('order-book.php') ?>" <?= ($CFG->self == 'order-book.php') ? 'class="active"' : '' ?>><?= Lang::string('order-book') ?></a></li>
                    <? if (!User::isLoggedIn()) { ?>
                    <!-- li><a href="what-are-bitcoins.php" <?= ($CFG->self == 'what-are-bitcoins.php' || $CFG->self == 'how-bitcoin-works.php' || $CFG->self == 'trading-bitcoins.php') ? 'class="active"' : '' ?>><?= Lang::string('what-are-bitcoins') ?> <i class="fa fa-angle-down"></i></a>
                        <ul>
                        	<li><a href="how-bitcoin-works.php"><?= Lang::string('how-bitcoin-works') ?></a></li>
                            <li><a href="trading-bitcoins.php"><?= Lang::string('trading-bitcoins') ?></a></li>
                        </ul>
                    </li -->
                    <li><a href="<?= Lang::url('our-security.php') ?>" <?= ($CFG->self == 'our-security.php') ? 'class="active"' : '' ?>><?= Lang::string('our-security') ?></a></li>
                    <li><a href="<?= Lang::url('buy-and-sell-bitcoin.php') ?>" <?= ($CFG->self == 'buy-and-sell-bitcoin.php') ? 'class="active"' : '' ?>><?= Lang::string('how-to-register') ?> <!-- i class="fa fa-angle-down"></i --></a>
                    	<!-- ul>
                        	<li><a href="securing-account.php"><?= Lang::string('securing-account') ?></a></li>
                        	<li><a href="reset_2fa.php"><?= Lang::string('reset-2fa') ?></a></li>
                        	<li><a href="funding-account.php"><?= Lang::string('funding-account') ?></a></li>
                        	<li><a href="withdrawing-account.php"><?= Lang::string('withdrawing-account') ?></a></li>
                        </ul -->
                    </li>
                    <li><a href="<?= Lang::url('fee-schedule.php') ?>" <?= ($CFG->self == 'fee-schedule.php') ? 'class="active"' : '' ?>><?= Lang::string('fee-schedule') ?></a></li>
                    <!--li><a href="<?= Lang::url('about.php') ?>" <?= ($CFG->self == 'about.php') ? 'class="active"' : '' ?>><?= Lang::string('about') ?> <!-- i class="fa fa-angle-down"></i --></a-->
                    	<!-- >ul>
                        	<li><a href="our-security.php"><?= Lang::string('our-security') ?></a></li>
                        	<li><a href="fee-schedule.php"><?= Lang::string('fee-schedule') ?></a></li->
                        	<li><a href="press-releases.php"><?= Lang::string('news') ?></a></li>
                        </ul -->
                    </li>
                    <li><a href="<?= Lang::url('contact.php') ?>"><?= Lang::string('contact') ?></a></li>
                    <li style="display:none;"><a href="login.php"><?= Lang::string('home-login') ?></a></li>
	                <li style="display:none;"><a href="register.php"><?= Lang::string('home-register') ?></a></li>
                    <? } else { ?>
                    <li><a href="account.php" <?= ($CFG->self == 'account.php' || $CFG->self == 'open-orders.php' || $CFG->self == 'transactions.php' || $CFG->self == 'security.php' || $CFG->self == 'settings.php' || $CFG->self == 'bank-accounts.php' || $CFG->self == 'bitcoin-addresses.php' || $CFG->self == 'history.php' || $CFG->self == 'api-access.php') ? 'class="active"' : '' ?>><?= Lang::string('account') ?> <i class="fa fa-angle-down"></i></a>
                        <ul>
                        	<li><a href="open-orders.php"><?= Lang::string('open-orders') ?></a></li>
                            <li><a href="transactions.php"><?= Lang::string('transactions') ?></a></li>
                            <li><a href="security.php"><?= Lang::string('security') ?></a></li>
                            <li><a href="settings.php"><?= Lang::string('settings') ?></a></li>
                            <li><a href="bank-accounts.php"><?= Lang::string('bank-accounts') ?></a></li>
							<li><a href="bitcoin-addresses.php"><?= Lang::string('bitcoin-addresses') ?></a></li>
							<li><a href="history.php"><?= Lang::string('history') ?></a></li>
							<li><a href="api-access.php"><?= Lang::string('api-access') ?></a></li>
                            <li><a href="logout.php?log_out=1"><?= Lang::string('log-out') ?></a></li>
                        </ul>
                    </li>
                    <li><a href="buy-sell.php" <?= ($CFG->self == 'buy-sell.php') ? 'class="active"' : '' ?>><?= Lang::string('buy-sell') ?></a></li>
                    <li><a href="deposit.php" <?= ($CFG->self == 'deposit.php') ? 'class="active"' : '' ?>><?= Lang::string('deposit') ?></a></li>
                    <li><a href="withdraw.php" <?= ($CFG->self == 'withdraw.php') ? 'class="active"' : '' ?>><?= Lang::string('withdraw') ?></a></li>
                    <!-- <li style="display:none;"><a href="help.php"><?= Lang::string('help') ?></a></li> -->
	                <li style="display:none;"><a href="contact.php"><?= Lang::string('contact') ?></a></li>
	                <li style="display:none;"><a href="logout.php?log_out=1"><?= Lang::string('log-out') ?></a></li>
	                <? } ?>
                </ul>
                <ul class="tci_list">
                    <li class="empty margin-left">
                        <label for="language_selector" style="display: none;"><img src="images/<?= $CFG->language ?>.png" /></label>
                        <select id="language_selector" class="lang">
                            <option value="en" <?= ($CFG->language == 'en') ? 'selected="selected"' : '' ?>>ENG.</option>
                            <!--option value="pt" <?= ($CFG->language == 'pt') ? 'selected="selected"' : '' ?>>Português</option-->
                            <option value="es" <?= ($CFG->language == 'es') ? 'selected="selected"' : '' ?>>ESP.</option>
                            <!--option value="ru" <?= ($CFG->language == 'ru') ? 'selected="selected"' : '' ?>>Pусский</option-->
                            <!--option value="zh" <?= ($CFG->language == 'zh') ? 'selected="selected"' : '' ?>>中文</option-->
                        </select>
                    </li>
                        <img src="../htdocs/images/idioma.png" alt="">
                    <? if (!User::isLoggedIn()) { ?>
                    <a href="login.php" style="margin-right: 10px;"><img src="../htdocs/images/login.png" width="30" height="30" alt=""><!-- <i class="fa fa-key"></i> <?= Lang::string('home-login') ?> --></a>
                    <a href="<?= Lang::url('register.php') ?>"><img src="../htdocs/images/registro.png" width="30" height="30" alt=""><!-- <i class="fa fa-user"></i> <?= Lang::string('home-register') ?>--></a>
                    <? } else { ?>
                    <li>
                        <!-- <a href="account.php"><i class="fa fa-user" style="margin-top: 5px;"></i> <?= User::$info['email'] ?></a>  -->
                        <a href="logout.php?log_out=1&uniq=<?= $_SESSION["logout_uniq"] ?>"><i class="fa fa-unlock"></i> <?= Lang::string('log-out') ?></a>
                    </li>
                    <? } ?>
                    <!-- <i class="glyphicon glyphicon-menu-down" style="position: absolute;right: 10px; display: block; color: #006eaf; font-size: 1em;"></i> -->
                </ul>
            </div>
            
        </nav><!-- end nav menu -->
      <div class="navButtom" id="navButtom">
            <button id="showPush" type="button" class="tcon tcon-menu--xcross trans02" aria-label="toggle menu">
                <span class="tcon-menu__lines" aria-hidden="true"></span>
                <span class="tcon-visuallyhidden"></span>
            </button>       
        </div>
        </div>
        
        
		</div>
		
	</div>
    
	</div>

    
</header><!-- end header -->