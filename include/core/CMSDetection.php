<?php
require_once 'requestManager.php';
abstract class CMSDetector{
	private $cachedArray;
	
	public function __construct(){
		$this->cachedArray = array();
	}
	
	protected abstract function detect($url);
	
	private function getPageContent($url){
		if (isset($this->cachedArray[$url]))
			return $this->cachedArray[$url];
		$req = new RequestManager();
		
		$response = $req->sendRequest(array(), 'get', $url);
		$this->cachedArray[$url] = $response;
		return $response;
	}
};

class JoomlaDetector extends CMSDetector{
	
	protected function detect($url){
		
	}
	
	private function checkMeta(){
		
	}
	
	private 
};