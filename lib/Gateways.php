<?php
class Gateways {
	public $key,$api_key,$api_secret,$api_url,$sandbox,$payment_url;
	
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
		$this->api_url = rtrim(!$this->sandbox ? $result['offsite_url'] : $result['offsite_url'],'/');
		$this->payment_url = false;
	}
	
	function getUrl($request_id=false,$currency=false,$total_amount=false){
		global $CFG;
		
		$request_id = intval($request_id);
		$currency = $CFG->currencies[$currency]['currency'];
		$total_amount = floatval($total_amount);
		$url = false;
		
		if (in_array($this->key,array('neteller','skrill'))) {
			$r = $this->request('orders/'.$request_id,array(
				'merchantRefNum' => $request_id,
				'currencyCode' => $currency,
				'totalAmount' => $total_amount,
				'paymentMethod' => $this->key,
				'callback' => array(
					'format' => 'get',
					'uri' => rtrim($CFG->baseurl,'/').'deposit.php'
				)
			));
			
			if ($r['link']) foreach ($r['link'] as $l) {
				if ($l['rel'] == 'hosted_payment') {
					$url = $l['uri'];
					break;
				}
			}
		}
		
		return $url;
	}
	
	function request($endpoint=false,$params=array(),$post=false,$basic_auth=false) {
		$url = $this->api_url;
		$query = '';
		
		if (!$post)
			$query = '?'.http_build_query($params);
		
		if ($basic_auth)
			$url = (stristr('https')) ? str_ireplace('https://','https://'.$this->api_key.':'.$this->api_secret,$url) : str_ireplace('http://','http://'.$this->api_key.':'.$this->api_secret,$url);
		
		$ch = curl_init($url.'/'.$endpoint.$query);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		
		if ($post)
			curl_setopt($ch,CURLOPT_POSTFIELDS,$params);
		
		$result1 = curl_exec($ch);
		$result = json_decode($result1,true);
		curl_close($ch);
	}
}
