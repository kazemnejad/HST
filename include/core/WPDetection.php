<?php

require_once 'requestManager.php';
require_once 'simple_html_dom.php';
require_once 'CMSDetection.php';
require_once 'utilFunctions.php';

class WordPressDetection extends CMSDetector{

	protected function init(){
		$this->dirArray = array('wp-admin', 'wp-content', 'wp-includes');
	}

	protected function detect(){
		$percent = array();
		
		$percent['meta'] = array($this->checkMeta(), 4);
		hst_log('META: '.$percent['meta'][0]);
		
		$percent['dir'] = array($this->checkDir(), 3);
		hst_log('DIR: '.$percent['dir'][0]);
		
		$sum = 0;
		$weights = 0;
		foreach ($percent as $value) {
			$sum += $value[0]* $value[1];
			$weights += $value[1];
		}
		return $sum/$weights;	
	}

	
	private function checkMeta(){
		/*$html = new simple_html_dom();
		
		$html->load(self::getCachedPageContent($this->baseURL));

		foreach ($html->find('meta[name=generator]') as $element){
			$pos = stripos($element->content, 'joomla');
			if ($pos !== false)
			return 1;
		}*/
		return 0;
	}

	private function checkURL(){

	}

	private function checkDir(){
		$score = 0;
		foreach ($this->dirArray as $dir){
			$req = new RequestManager();
			$headers = $req->getHeaders($this->baseURL . '/' . $dir . '/');
				
			$code = $headers['http_code'];
			hst_log($dir.': '.$code[1]);
			switch($code[1]) {
				case 200:
					$score += 1;
					break;
				case 403:
					$score += 0.9;
					break;
			}
		}

		return ($score / count($this->dirArray));
	}
}
