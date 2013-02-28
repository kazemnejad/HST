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
		return $this->parseWhois($whois[0]->innerText());
	}
	
	public function getIp(){
		$url = parse_url($this->url);
		return gethostbyname($url['host']);
	}
	
	public function parseWhois($whois){
		//hst_log("whois: " . htmlentities($whois));
		$result = str_replace("<br><br>", "<br>", $whois);
		$temp  = "";
		while ($temp != $result){
			$temp = $result;
			$result = str_replace("<br><br>", "<br>", $result);
			
			#hst_log("RESULT: " . htmlentities($result));
			#hst_log("whois: " . htmlentities($whois));
		}
		
		$tempArray = explode("<br>",$result);
		
		
		
		$whoisArray = array();
		//hst_log($tempArray[0][0]);
		
		foreach ($tempArray as $key => $value) {
			if (empty($value) || $value[0] == '%'){ 
				//hst_log($tempArray[$i][0]);
				unset($tempArray[$key]);
				continue;
			}
						
			$line = explode(":	", $value);
			
			$whoisArray[$line[0]] = $line[1];
			hst_log("key: " . $line[0]);
			/*for ($j = 1; $j < count($line); $j++)
				$whoisArray[$line[0]] .= $line[$j];*/
			hst_log("value: " . $whoisArray[$line[0]]);	
		}
		return $whoisArray;
	}
	
};



/*$req = new SiteInfo("http://linuxreview.ir/");
//echo_nobuffer(htmlentities($req->parseWhois("<br><br><br><br>adsfadsfad<br>")));
$req->getWhois();*/