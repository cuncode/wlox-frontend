<?php
include '../lib/common.php';

if (User::$info['locked'] == 'Y' || User::$info['deactivated'] == 'Y')
	Link::redirect('settings.php');
elseif (User::$awaiting_token)
	Link::redirect('verify-token.php');
elseif (!User::isLoggedIn())
	Link::redirect('login.php');

$page1 = (!empty($_REQUEST['page'])) ? preg_replace("/[^0-9]/", "",$_REQUEST['page']) : false;
$currencies = Settings::sessionCurrency();
API::add('BankAccounts','get');
API::add('BitcoinAddresses','get',array(false,$currencies['c_currency'],false,1,1));
API::add('Requests','get',array(1));
API::add('Requests','get',array(false,$page1,15));
API::add('Content','getRecord',array('deposit-bank-instructions'));
API::add('Content','getRecord',array('deposit-no-bank'));
$query = API::send();

$bank_accounts = $query['BankAccounts']['get']['results'][0];
$bitcoin_addresses = $query['BitcoinAddresses']['get']['results'][0];
$key = (is_array($bank_accounts)) ? key($bank_accounts) : false;
$bank_account = $bank_accounts[$key];
$total = $query['Requests']['get']['results'][0];
$requests = $query['Requests']['get']['results'][1];
$bank_instructions = ($bank_account) ? $query['Content']['getRecord']['results'][0] : $query['Content']['getRecord']['results'][1];
$bank_account_currency = $CFG->currencies[$bank_account['currency']];
$pagination = $pagination = Content::pagination('deposit.php',$page1,$total,15,5,false);
$method = !empty($_REQUEST['method']) ? preg_replace("/[^a-zA-Z0-9\-\.\_]/", "",$_REQUEST['method']) : false;
$deposit_amount1 = 0;
$step = (!empty($_REQUEST['step'])) ? $_REQUEST['step'] : 'INIT';

$page_title = Lang::string('deposit');

if ($method) {
	API::add('Gateways','get',array($method));
	$query = API::send();
	$gateway = $query['Gateways']['get']['results'][0];
	$method = (!$gateway) ? false : $method;
	$deposit_amount1 = (!empty($_REQUEST['deposit_amount'])) ? String::currencyInput($_REQUEST['deposit_amount']) : 0;
	$deposit_currency1 = (!empty($_REQUEST['deposit_currency'])) ? intval($_REQUEST['deposit_currency']) : false;
	
	if ($gateway && $step == 'REDIRECT') {
		$g = new Gateways($method);
		$g->getUrl();
		$g->redirect();
		
		if ($url)
			Link::redirect($url);
	}
}

if (strtolower(parse_url($_SERVER['HTTP_REFERER'],PHP_URL_HOST)) != parse_url($CFG->baseurl,PHP_URL_HOST)) {
	$g = new Gateways($_SESSION['gateway_method']);
	$g->receivePaymentInfo();
}

if (empty($_REQUEST['bypass'])) {
	include 'includes/head.php';
?>
<div class="page_title">
	<div class="container">
		<div class="title"><h1><?= $page_title ?></h1></div>
        <div class="pagenation">&nbsp;<a href="index.php"><?= Lang::string('home') ?></a> <i>/</i> <a href="account.php"><?= Lang::string('account') ?></a> <i>/</i> <a href="deposit.php"><?= $page_title ?></a></div>
	</div>
</div>
<div class="container">
	<div class="content_right">
		<div class="row testimonials-4">
			<div class="col-md-6">
				<div class="content">
					<h3 class="section_label">
						<span class="left"><i class="fa fa-btc fa-2x"></i></span>
						<span class="right"><?= Lang::string('deposit-bitcoins') ?></span>
					</h3>
					<div class="clear"></div>
					<div class="buyform">
						<div class="spacer"></div>
						<div class="param">
							<label for="c_currency"><?= Lang::string('deposit-c-currency') ?></label>
							<select id="c_currency" name="currency">
							<?
							if ($CFG->currencies) {
								foreach ($CFG->currencies as $key => $currency) {
									if (is_numeric($key) || $currency['is_crypto'] != 'Y')
										continue;
									
									echo '<option '.(($currency['id'] == $currencies['c_currency']) ? 'selected="selected"' : '').' value="'.$currency['id'].'">'.$currency['currency'].'</option>';
								}
							}	
							?>
							</select>
							<div class="clear"></div>
						</div>
						<div class="param">
							<label for="deposit_address"><?= Lang::string('deposit-send-to-address') ?></label>
							<input type="text" id="deposit_address" name="deposit_address" value="<?= $bitcoin_addresses[0]['address'] ?>" />
							<div class="clear"></div>
						</div>
						<div class="spacer"></div>
						<div class="calc">
							<img class="qrcode" src="includes/qrcode.php?code=<?= $bitcoin_addresses[0]['address'] ?>" />
						</div>
						<div class="spacer"></div>
						<div class="calc">
							<a class="item_label" href="bitcoin-addresses.php"><i class="fa fa-cog"></i> <?= Lang::string('deposit-manage-addresses') ?></a>
							<div class="clear"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="content">
					<h3 class="section_label">
						<span class="left"><i class="fa fa-money fa-2x"></i></span>
						<span class="right"><?= Lang::string('deposit-fiat-instructions') ?></span>
					</h3>
					<div class="clear"></div>
					<div class="buyform">
						<div class="payment-show-payments <?= ($step != 'INIT') ? 'hide' : '' ?>">
							<div class="row">
								<div class="payment-box col-md-6">
									<a href="<?= $CFG->self ?>?method=skrill&step=AMOUNT"><img src="images/skrill-logo.png" /></a>
								</div>
								<div class="payment-box col-md-6">
									<a href="<?= $CFG->self ?>?method=neteller&step=AMOUNT"><img src="images/neteller-logo.png" /></a>
								</div>
							</div>
							<div class="row">
								<div class="payment-box payment-box-cc col-md-6">
									<a href="#"><img src="images/cc.png" /></a>
								</div>
								<div class="payment-box col-md-6">
									<a href="<?= $CFG->self ?>?method=webmoney&step=AMOUNT"><img src="images/webmoney.gif" /></a>
								</div>
							</div>
						</div>
						<div class="payment-show-payments <?= ($step != 'AMOUNT') ? 'hide' : '' ?>">
							<div class="spacer"></div>
							<div class="param">
								<label for="deposit_method"><?= Lang::string('gateway-method-deposit') ?></label>
								<input type="text" id="deposit_method" name="deposit_method" value="<?= $gateway['name'] ?>" readonly="readonly" />
								<input type="hidden" name="method" value="<?= $gateway['key'] ?>" />
								<div class="clear"></div>
							</div>
							<div class="param">
								<label for="deposit_currency"><?= Lang::string('gateway-currency-pay') ?></label>
								<select id="deposit_currency" name="deposit_currency">
								<?
								if ($CFG->currencies) {
									foreach ($CFG->currencies as $key => $currency) {
										if (is_numeric($key) || $currency['is_crypto'] == 'Y')
											continue;
										
										echo '<option '.(($currency['id'] == $currencies['c_currency']) ? 'selected="selected"' : '').' value="'.$currency['id'].'">'.$currency['currency'].'</option>';
									}
								}	
								?>
								</select>
								<div class="clear"></div>
							</div>
							<div class="param">
								<label for="deposit_amount"><?= Lang::string('gateway-amount-pay') ?></label>
								<input type="text" id="deposit_amount" name="deposit_amount" value="<?= String::currencyOutput($deposit_amount1) ?>" />
								<div class="clear"></div>
							</div>
							<div class="spacer"></div>
							<div class="spacer"></div>
							<div class="spacer"></div>
							<input type="submit" name="submit" value="<?= Lang::string('deposit') ?>" class="but_user" />
						</div>
						<div class="hide payment-show-cc">
							<div class="spacer"></div>
							<? if ($bank_accounts) { ?>
							<div class="param">
								<label for="deposit_bank_account"><?= Lang::string('deposit-fiat-account') ?></label>
								<select id="deposit_bank_account" name="deposit_bank_account">
								<?
								$i = 1;
								if ($bank_accounts) {
									foreach ($bank_accounts as $account) {
										echo '<option '.(($i == 1) ? 'selected="selected"' : '').' value="'.$account['id'].'">'.$account['account_number'].' - ('.$account['currency'].')</option>';
										++$i;
									}
								}	
								?>
								</select>
								<div class="clear"></div>
							</div>
							<div class="spacer"></div>
							<div class="calc">
								<div class="text"><?= str_replace('[escrow_name]','<span id="escrow_name">'.$bank_account_currency['account_name'].'</span>',str_replace('[escrow_account]','<span id="escrow_account">'.$bank_account_currency['account_number'].'</span>',str_replace('[client_account]','<span id="client_account">'.$bank_account['account_number'].'</span>',$bank_instructions['content']))) ?></div>
								<div class="mar_top2"></div>
								<a class="item_label" href="bank-accounts.php"><i class="fa fa-cog"></i> <?= Lang::string('deposit-manage-bank-accounts') ?></a>
								<div class="clear"></div>
							</div>
							<? } else { ?>
							<div class="calc">
								<div class="text"><?= $bank_instructions['content'] ?></div>
								<div class="mar_top2"></div>
								<a class="item_label" href="bank-accounts.php"><i class="fa fa-cog"></i> <?= Lang::string('deposit-manage-bank-accounts') ?></a>
								<div class="clear"></div>
							</div>
							<? } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="mar_top3"></div>
		<div class="clear"></div>
		<h3><?= Lang::string('deposit-recent') ?></h3>
		<div id="filters_area">
<? } ?>
        	<div class="table-style">
        		<table class="table-list trades" id="bids_list">
        			<tr>
        				<th>ID</th>
        				<th><?= Lang::string('deposit-date') ?></th>
        				<th><?= Lang::string('deposit-description') ?></th>
        				<th><?= Lang::string('deposit-amount') ?></th>
        				<th><?= Lang::string('deposit-status') ?></th>
        			</tr>
        			<? 
        			if ($requests) {
						foreach ($requests as $request) {
							echo '
					<tr>
						<td>'.$request['id'].'</td>
						<td><input type="hidden" class="localdate" value="'.(strtotime($request['date'])/* + $CFG->timezone_offset*/).'" /></td>
						<td>'.$request['description'].'</td>
						<td>'.(($CFG->currencies[$request['currency']]['is_crypto'] == 'Y') ? String::currency($request['amount'],true).' '.$request['fa_symbol'] : $request['fa_symbol'].String::currency($request['amount'])).'</td>
						<td>'.$request['status'].'</td>
					</tr>';
						}
					}
					else {
						echo '<tr><td colspan="5">'.Lang::string('deposit-no').'</td></tr>';
					}
        			?>
        		</table>
			</div>
			<?= $pagination ?>
<? if (empty($_REQUEST['bypass'])) { ?>
		</div>
		<div class="mar_top5"></div>
	</div>
	<? include 'includes/sidebar_account.php'; ?>
</div>
<? include 'includes/foot.php'; ?>
<? } ?>
