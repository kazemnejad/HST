<?php
require_once 'requestManager.php';
require_once 'simple_html_dom.php';

abstract class CMSDetector{
	
	private static $cachedArray;
	protected $baseURL;
	protected $dirArray;
	
	public function __construct($url){
		self::$cachedArray = array();
		//$this->cachePageContent($url);
		$this->baseURL = $url;
		//return $this->detect($url);
		$this->init();
	}
	
	protected function init(){
		
	}
	
	#TODO complete return values
	public static function detectAll($types, $url){
		foreach ($types as $type){
			$className = $type."Detector";
			$detector = new $className($url);
			hst_log('Joomla: ' . $detector->detect() * 100 . '%');
		}
	} 
	
	
	
	protected abstract function detect();
	
	protected static function getCachedPageContent($url){
		if (isset(self::$cachedArray[$url]))
			return self::$cachedArray[$url];
		$req = new RequestManager();
		
		$response = $req->sendRequest(array(), 'get', $url);
		self::$cachedArray[$url] = $response;
		return $response;
	}
}


//CMSDetector::detectAll(array('Joomla'), 'http://localhost/graffito/');
/*CMSDetector::detectAll(array('Joomla'), 'http://www.joomla.org/');*/
