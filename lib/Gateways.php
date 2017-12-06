<?php
use baibaratsky\WebMoney\WebMoney;
use baibaratsky\WebMoney\Signer;
use baibaratsky\WebMoney\Request\Requester\CurlRequester;
use baibaratsky\WebMoney\Api\X\X2;

class Gateways {
	public $key,$api_key,$api_secret,$api_username,$api_url,$sandbox,$payment_url,$request_id,$amount,$currency;
	
	function __construct($key) {
		$key = preg_replace("/[^0-9a-zA-Z\.\-\_]/", "",$key);
		
		if (!$key)
			return false;
		
		API::add('Gateways','get',array('deposit-no-bank'));
		$query = API::send();
		$result = $query['Gateways']['get']['results'][0];
		
		if (!$result)
			return false;
		
		$this->key = $key;
		$this->sandbox = ($result['sandbox_mode'] == 'Y');
		$this->api_key = $result['api_key'];
		$this->api_secret = $result['api_secret'];
		$this->api_username = $result['api_username'];
		$this->api_url = rtrim(!$this->sandbox ? $result['offsite_url'] : $result['offsite_url'],'/');
		$this->payment_url = false;
		$this->request_id = false;
		$this->amount = false;
	}
	
	function startRequest($currency,$amount,$link=false) {
		API::add('Requests','insertGatewayRequest',array($this->key,$CFG->currencies[$currency]['id'],$amount,$link));
		$query = API::send();
		return $query['Requests']['insertGatewayRequest']['results'][0];
	}
	
	function updateRequest($request_id,$status,$link=false) {
		API::add('Requests','updateGatewayRequest',array($request_id,$status,$link));
		$query = API::send();
		return $query['Requests']['updateGatewayRequest']['results'][0];
	}
	
	function getUrl($currency=false,$total_amount=false){
		global $CFG;
		
		$currency_abbr = $CFG->currencies[$currency]['currency'];
		$total_amount = floatval($total_amount);
		$request_id = $this->startRequest($currency,$amount,$link);
		
		$this->request_id = $request_id;
		$this->amount = $total_amount;
		
		$url = false;
		$url_self = false;
		
		if ($this->key == 'neteller') {
			$r = $this->request('orders/'.$request_id,array(
				'merchantRefNum' => $request_id,
				'currencyCode' => $currency_abbr,
				'totalAmount' => $total_amount * 100,
				'paymentMethod' => $this->key
			),true,true);
			
			if ($r['link']) foreach ($r['link'] as $l) {
				if ($l['rel'] == 'hosted_payment')
					$url = $l['uri'];
				else if ($l['rel'] == 'self') {
					$url_self = $l['uri'];
					$_SESSION['gateway_uri'] = $l['uri'];
					$_SESSION['gateway_method'] = $this->key;
				}
			}
			
			if ($url) {
				$this->payment_url = $url;
				$this->updateRequest($request_id,'pending',$url_self);
			}
		}
		else if ($this->key == 'skrill') {
			$r = $this->request(false,array(
				'pay_to_email' => $CFG->api_username,
				'amount' => $total_amount,
				'currency' => $currency_abbr,
				'language' => strtoupper($CFG->language),
				'prepare_only' => '1'
			));
			
			if ($r) {
				$_SESSION['gateway_uri'] = $r;
				$url = $r;
				$this->currency = $currency_abbr;
				$this->updateRequest($request_id,'pending',$url);
			}
		}
		else if ($this->key == 'webmoney') {
			$this->payment_url = $this->api_url;
			return $this->payment_url;
		}
		
		return $url;
	}
	
	function redirect() {
		global $CFG;
		
		if ($this->key == 'neteller') {
			Link::redirect($url);
		}
		else if ($this->key == 'skrill') {
			echo '
			<form id=pay name=pay method="POST" action="'.$this->payment_url.'">
				<input type="hidden" name="session_ID" value="'.$_SESSION['gateway_uri'].'">
			    <input type="hidden" name="pay_to_email" value="'.$CFG->api_username.'">
				<input type="hidden" name="status_url" value="'.$CFG->baseurl.'deposit.php?status=pending">
				<input type="hidden" name="return_url" value="'.$CFG->baseurl.'deposit.php?status=completed">
 				<input type="hidden" name="cancel_url" value="'.$CFG->baseurl.'deposit.php?status=cancelled">
				 <input type="hidden" name="language" value="'.strtoupper($CFG->language).'">
				 <input type="hidden" name="amount" value="'.$this->amount.'">
				 <input type="hidden" name="currency" value="GBP">
				 <input type="hidden" name="detail1_description" value="Description:">
				 <input type="hidden" name="detail1_text" value="'.$CFG->exchange_name.' #'.$this->request_id.'">
			</form>
			<script type="text/JavaScript" language="JavaScript">
				document.myform.submit();
			</script>';
			exit;
		}
		else if ($this->key == 'webmoney') {
			echo '
			<form id=pay name=pay method="POST" action="'.$this->payment_url.'">
			    <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="'.$this->amount.'">
			    <input type="hidden" name="LMI_PAYMENT_DESC" value="'.$CFG->exchange_name.' #'.$this->request_id.'">
			    <input type="hidden" name="LMI_PAYMENT_NO" value="'.$this->request_id.'">
			    <input type="hidden" name="LMI_PAYEE_PURSE" value="'.$CFG->api_key.'">
			    <input type="hidden" name="LMI_SIM_MODE" value="'.$this->sandbox.'">
			    <input type="hidden" name="LMI_RESULT_URL" value="'.$CFG->baseurl.'deposit.php?status=pending">
			    <input type="hidden" name="LMI_SUCCESS_URL" value="'.$CFG->baseurl.'deposit.php?status=completed">
			    <input type="hidden" name="LMI_SUCCESS_METHOD" value="1">
			    <input type="hidden" name="LMI_FAIL_URL" value="'.$CFG->baseurl.'deposit.php?status=cancelled">
			    <input type="hidden" name="LMI_FAIL_METHOD" value="1">
			</form>
			<script type="text/JavaScript" language="JavaScript">
				document.myform.submit();
			</script>';
			exit;
		}
	}
	
	function receivePaymentInfo() {
		global $CFG;
		
		API::add('Requests','getGatewayActive');
		$query = API::send();
		$result = $query['Requests']['getGatewayActive']['results'][0];
		if (!$result)
			return false;
		
		$status = 'pending';
		$amount = false;
		
		if ($result['gateway'] == 'neteller') {
			$r = $this->request('orders/'.$result['id'],false,false,false,$result['link']);
			if ($r) {
				if ($r['transaction']['status'] == 'success')
					$status = 'completed';
				else if ($r['transaction']['status'] != 'pending' && $r['transaction']['status'] != 'held')
					$status = 'cancelled';
					
				$amount = $r['totalAmount'] / 100;
			}
		}
		else if ($result['gateway'] == 'skrill') {
			if ($_REQUEST['status'] == 2)
				$status = 'comleted';
			else if ($_REQUEST['status'] == 0)
				$status = 'pending';
			else if ($_REQUEST['status'] < 0)
				$status = 'cancelled';
			
			$amount = floatval($_REQUEST['mb_amount']);
		}
		else if ($result['gateway'] == 'webmoney') {
			$status = preg_replace("/[^a-z]/", "",$_REQUEST['status']);
			$amount = floatval($_REQUEST['LMI_PAYMENT_AMOUNT']);
		}
		
		self::updateRequest($result['id'],$status,false,$amount);
		return $status;
	}
	
	function withdraw($currency,$amount,$purse) {
		global $CFG;
		
		if ($this->key == 'webmoney') {
			$webMoney = new WebMoney(new CurlRequester);
			$request_id = $this->startRequest($currency,$amount);
	
			$request = new X2\Request;
			$request->setSignerWmid($CFG->api_username); // YOUR WMID
			$request->setTransactionExternalId(1);
			$request->setPayerPurse($CFG->api_key); // 'YOUR PURSE'
			$request->setPayeePurse($purse);
			$request->setAmount($amount);
			$request->setDescription($CFG->exchange_name.' #'.$request_id);
			
			$request->sign(new Signer($CFG->api_username,'../lib/wmcert',$CFG->api_secret));
			
			if ($request->validate()) {
			    $response = $webMoney->request($request);
			
			    if ($response->getReturnCode() === 0) {
			        echo 'Successful payment, transaction id: ' . $response->getTransactionId();
			    } else {
			        echo 'Payment error: ' . $response->getReturnDescription();
			    }
			} else {
			    echo 'Request errors: ' . PHP_EOL;
			    foreach ($request->getErrors() as $error) {
			        echo ' - ' . $error . PHP_EOL;
			    }
			}
		}
	}
	
	function request($endpoint=false,$params=array(),$post=false,$basic_auth=false,$url=false) {
		$url = $this->api_url;
		$query = '';
		
		if (!$post)
			$query = '?'.http_build_query($params);
		
		if ($basic_auth)
			$url = (stristr('https')) ? str_ireplace('https://','https://'.$this->api_key.':'.$this->api_secret,$url) : str_ireplace('http://','http://'.$this->api_key.':'.$this->api_secret,$url);
		
		if ($url)
			$url = rtrim($url,'/');
		
		$ch = curl_init($url.'/'.$endpoint.$query);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		
		if ($post)
			curl_setopt($ch,CURLOPT_POSTFIELDS,$params);
		
		$result1 = curl_exec($ch);
		$result = json_decode($result1,true);
		curl_close($ch);
	}
}
