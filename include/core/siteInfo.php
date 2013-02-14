<?php

require_once '../config.php';
require_once 'database.php';
require_once 'utilFunctions.php';
require_once 'requestManager.php';
require_once 'simple_html_dom.php';

define('_WHOISSERVER_', "http://www.whois.com/whois/");

class SiteInfo{
	private $url;
	
	public function __construct($url) {
		$this->url = $url;
	}
		
	public function getWhois(){
		#extract main domain
		$url = parse_url($this->url);	
		$action = _WHOISSERVER_ . $url['host'];
		hst_log('whois: -> ' . $action. '<br>');
		$html = file_get_html($action);
		$whois = $html->find('div[id=registryData]');
		return $whois[0];
	}
	
	public function getIp(){
		$url = parse_url($this->url);
		return gethostbyname($url['host']);
	}
	
};

/*$req = new SiteInfo("http://narenji.ir");
echo_nobuffer($req->getIp());*/