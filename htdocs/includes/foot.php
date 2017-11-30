<!-- Footer
======================================= -->

<div class="footer">



	<div class="arrow_02"></div>

    <h2><?= Lang::string('hora-negocios') ?></h2>

	<form name="register" action="register.php">
		<input type="hidden" name="start" value="1" />
		<div class="input-group input-group-lg start-div">
	        <input type="text" name="email" class="form-control" placeholder="<?= Lang::string('escribe-correo') ?>" aria-describedby="basic-addon2">
	        <span class="input-group-addon" id="addon-start-div">
	        	<?= Lang::string('comienza-ganar') ?>
	        	<input type="submit" name="submit" /> 
	        </span>
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

            <b>BTCTRACECENTER Copyright &copy; 2017 <br>by <a href="http://www.cuncode.com/#home">cuncode</a></b>

        </div>

    	<div class="">
     		<ul class="footer_social_links" style="margin-top: 5px;">
                <li style="background-color: rgb(254,81,13);"><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li style="background-color: rgb(254,81,13);"><a href="#"><i class="fa fa-linkedin"></i></a></li>
            </ul>    
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
<script type="text/javascript" src="js/ops.js?v=2"></script>

<? if ($CFG->self == 'index.php' || $CFG->self == 'order-book.php' || $CFG->self == 'btc_to_currency.php') { ?>
<!-- flot -->
<script type="text/javascript" src="js/flot/jquery.flot.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.time.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.crosshairs.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.candle.js"></script>

<script type="text/javascript" src="js/parallax/jquery.particleground.js"></script>
<script type="text/javascript" src="js/particules/js/particles.js"></script>
<script type="text/javascript" src="js/particules/js/app.js"></script>
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
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
        <script>
            var showPush = jQuery.noConflict();
            showPush('#showPush').on('click',function(){
                if (showPush('#showPush').hasClass('tcon-transform')) {
                    showPush('section').removeClass('scala8').addClass('scala1');
                    setTimeout(function() {
                            showPush('section').removeClass('scala8').removeClass('scala1');
                    }, 0)                        
                    showPush('.navIcons a').removeClass('fadeIn').addClass('fadeOut');
                    showPush('.redes').removeClass('block').fadeOut("fast");
                    showPush('#showPush').removeClass('tcon-transform');
                    setTimeout(function() {
                            showPush('.logo').fadeIn('fast');
                            showPush('#menuM').removeClass('navOpen');
                            showPush('.navIcons').removeClass('block');
                            showPush('.navIcons a').removeClass('fadeOut');
                    }, 0);
                    showPush('.navIcons').removeClass('fadeIn');
                }
                else {
                    showPush('.logo').fadeOut('fast');  
                    showPush('#menuM').addClass('navOpen');
                    setTimeout(function() {
                        showPush('section').removeClass('scala1').addClass('scala8');
                    }, 0);                    
                    showPush('#showPush').addClass('tcon-transform');
                    setTimeout(function() {
                            showPush('.navIcons').addClass('block');
                            showPush('.navIcons a').addClass('fadeIn');
                            showPush('.redes').addClass('block').fadeIn("fast");
                    }, 0);
                }
            });
            showPush('.overlayClick').on('click',function(){
                showPush('section').removeClass('scala8').addClass('scala1');
                setTimeout(function() {
                    showPush('section').removeClass('scala8').removeClass('scala1');
                }, 0);                
                showPush('.navIcons a').removeClass('fadeIn').addClass('fadeOut');
                showPush('.redes').removeClass('block').fadeOut("fast");
                showPush('#showPush').removeClass('tcon-transform');
                setTimeout(function() {
                        showPush('.logo').fadeIn('fast');
                        showPush('#menuM').removeClass('navOpen');
                        showPush('.navIcons').removeClass('block');
                        showPush('.navIcons a').removeClass('fadeOut');
                        showPush('section').removeClass('scala8').removeClass('scala1');
                }, 0);
                showPush('.navIcons').removeClass('fadeIn');
            });         
        </script>
</body>
</html>
