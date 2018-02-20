<!-- Footer
======================================= -->

<div class="footer">



	<div class="arrow_02"></div>

    <h2>!Es hora de hacer buenos negocios!</h2>
	
	<form name="register" action="register.php">
		<div class="input-group input-group-lg start-div">
	        <input type="text" class="form-control" autofocus="none" placeholder="Escribe tu correo electrónico" aria-describedby="basic-addon2">
	        <button type="submit" class="input-group-addon" id="addon-start-div">COMIENZA A GANAR!</button> 
	    </div>
    </form>
    
    <div id="footer-nav" class="footer-nav">
                
                <ul id="">
                    <li><a href="<?= Lang::url('order-book.php') ?>" <?= ($CFG->self == 'order-book.php') ? 'class="active"' : '' ?>><?= Lang::string('order-book') ?></a></li>
                    <? /*if (!User::isLoggedIn()) {*/ ?>
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
                    <? /*} else { */?>
                    
                    <?/* } */?>
                </ul>
    </div>

</div>

<div class="copyright_info">
    <div class="container">
        <div class="">

            <b>BTCTRACECENTER Copyright &copy; 2017 <br>by <a href="http://www.cuncode.com/#home">www.cuncode.com</a></b>

        </div>

    	<div class="one_half last">
     		<!--
            <ul class="footer_social_links">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
            </ul>
            -->    
    	</div>
    
    </div>
</div><!-- end copyright info -->


<a href="#" class="scrollup">Scroll</a><!-- end scroll to top of the page-->
</div>

<!-- ######### JS FILES ######### -->
<script type="text/javascript" src="js/socket.io.js"></script>
<script type="text/javascript" src="js/universal/jquery.js"></script>
<script type="text/javascript" src="js/universal/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="js/chat.js?v=20151202"></script>

<!-- main js -->
<script type="text/javascript" src="js/ops.js?v=20160210"></script>

<? if ($CFG->self == 'index.php' || $CFG->self == 'order-book.php' || $CFG->self == 'btc_to_currency.php') { ?>
<!-- flot -->
<script type="text/javascript" src="js/flot/jquery.flot.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.time.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.crosshairs.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.candle.js"></script>

<script type="text/javascript" src="js/parallax/jquery.particleground.js"></script>
<script>
$('#parallax').particleground({
    dotColor: '#ffffff',
    lineColor: '#ffffff',
    lineWidth: '0.2',
    particleRadius: '2'
});
</script>

<? } ?>

<? if ($CFG->self == 'security.php') { ?>
<!-- authy -->
<script src="https://www.authy.com/form.authy.min.js" type="text/javascript"></script>
<? } ?>

<? if ($CFG->self == 'index.php' || $CFG->self == 'login.php') { ?>
<!-- countdown -->
<script type="text/javascript" src="js/countdown/jquery.countdown.js"></script>
<?= ($CFG->language != 'en' && !empty($CFG->language)) ? '<script type="text/javascript" src="js/countdown/jquery.countdown-'.(($CFG->language == 'zh') ? 'zh-CN' : $CFG->language).'.js"></script>' : '' ?>
<? } ?>

<? if ($CFG->self == 'api-docs.php') { ?>
<script type="text/javascript" src="js/prism.js"></script>
<? } ?>



</script>

</body>
</html>
