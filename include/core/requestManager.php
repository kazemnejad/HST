<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

require_once  '../config.php';
require_once 'utilFunctions.php';
require_once 'database.php';
require_once 'no_buffer.php';
require_once 'type.php';

class RequestManager{
	private $db;
	private $headers;
	private $file;
	private $ch;

	public function __construct(){
		#make header default value
		$this->headers = array (
			'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv=>15.0) Gecko/20100101 Firefox/15.0.1',
			'Accept: */*',
			'Accept-Language: en-us,en;q=0.5',
			'Accept-Encoding: gzip, deflate',
			'Connection: close',
			'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
			//'X-Requested-With: XMLHttpRequest',
			'Referer: http://localhost/',
			'Pragma: no-cache',
			'Cache-Control: no-cache',
			'Expect:'
			);

		#init CURL log
		$this->file = fopen("out.txt","w+");

		#init database engine
		$this->db = new db_engine;

		#make CURL object
		$this->ch = curl_init ();
	}

	public function __destruct(){
		fclose($this->file);
	}

	public function run() {
		//global $_config;
		$result = $this->db->query("SELECT * FROM forms ");
		while ($form = mysql_fetch_array($result)){
			$result = $this->db->query("SELECT * FROM inputs WHERE `formId` = '". $form['id'] . "'");
			while ($input = mysql_fetch_array($result)){
				$inputs[] = $input;	
				//if (getConfig('main', 'debugMode') == 1) echo_nobuffer('INPUT: ' . $input['name'] . '->' .$input['value'] .'<br>');	
			}
			
			$selectQuery = $this->db->query("SELECT * FROM selects WHERE `formId` = '".$form['id']. "'");
			$selects = array();
			while ($select = mysql_fetch_array($selectQuery)){
				$selects[] = $select;
				//if (getConfig('main', 'debugMode') == 1) echo_nobuffer('SELECT: ' . $select['name'].'<br>');
			}
			
			//sendDefault();
			$this->makeRequest($form, $inputs, $selects);
		}
	}

	private function makeRequest($form, $inputs, $selects){
		$data = array();
		
		hst_log('inputs_count ' . count($inputs) .'<br>');
		
		#inset inputs into data as map
		foreach ($inputs as $input){
			$data[$input['name']] = generateByType(getInputType($input['name']), _NORMUSER_);
			hst_log('INP_NAME: ' . $input['name'] . ' -> INP_GT: ' . getInputType($input['name'], _NORMUSER_) . '<br>');
		}

		#insert selects into data as map
		foreach ($selects as $select){
			$opts = explode(',', $select['options']);
			#if select tag has more than one options we select secound option else we select first options
			$data[$select['name']] = (count($opts) > 1) ? $opts[1] : $opts[0];
			hst_log('SELECT_NAME: ' . $select['name'] . ' -> SELECT_OPTION: ' . $data[$select['name']] . '<br>');
		}

		foreach ($data as $name => $value){
			$value = generateByType(getInputType($name), _HACKED_);
			$respnse = mysql_real_escape_string($this->sendRequest($data, $form['method'], $form['full_action']));
			$request = http_build_query($data);
			$this->db->query('INSERT INTO `results` (`formId`, `request`, `response`) VALUES ('. $form['id'] . ',' . $request . ',' . $respnse .')' );
		}

		#set CURL options
		curl_setopt_array ( $ch, $curlOpts );
	}

	public function sendRequest($data, $formMethod, $formAction){
		#use flobal headers variable
		global $headers;

		#make http query like ?name1=value1&name2=value2...
		$data = "?".http_build_query($data);
		hst_log('DATA: ' . $data. '<br>');

		#init file to save curl logs
		$file = fopen ( 'out.txt', 'w+' );

		#make CURL option into map
		$curlOpts = array (
		CURLOPT_URL => $formAction . (($formMethod == 'get') ? $data : '') ,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_FOLLOWLOCATION => 1,
		CURLOPT_FRESH_CONNECT => true,
		CURLOPT_VERBOSE => 1,
		CURLOPT_TIMEOUT => 15,
		CURLOPT_ENCODING => 'gzip',
		CURLOPT_STDERR => $file,
		CURLOPT_HTTPHEADER => $headers,
		// CURLOPT_HEADERFUNCTION => 'readHeader',
		CURLOPT_COOKIEFILE => "cookie.coo",
		CURLOPT_COOKIEJAR => "cookie.coo"
		);

		if ($formMethod== 'post')
			$curlOpts[CURLOPT_POSTFIELDS] = $data;
		#set CURL options
		curl_setopt_array ( $this->ch, $curlOpts );

		$response = curl_exec ( $this->ch );
		if ($response === false)
			echo_nobuffer (curl_error ( $this->ch ));

		fclose($file);
		return $response;
	}

};

/*$rq = new RequestManager();
$rq->run();*/
