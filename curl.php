<?php
	error_reporting(E_ALL);
	ini_set("display_errors", "On");
	include "include/config.php";
	include "include/core/database.php";
	require_once('_no_buffer.php');
	require_once('type.php');
	
	$g_db = new db_engine();
	
	
	
	/*$data = array (
			'username' => 'admin',
			'password' => 'asghar' 
	);*/

	
	$headers = array (
			'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv=>15.0) Gecko/20100101 Firefox/15.0.1',
			'Accept: */*',
			'Accept-Language: en-us,en;q=0.5',
			'Accept-Encoding: gzip, deflate',
			'Connection: close',
			'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
			// 'X-Requested-With: XMLHttpRequest',
			'Referer: http://localhost/',
			'Pragma: no-cache',
			'Cache-Control: no-cache',
			'Expect:'
	);
	
	//echo_nobuffer( $data );

	//$result = $g_db->query("SELECT * FROM forms ");
	
	
	
	
	//curl_setopt_array ( $ch, $curlOpts );
	
	
	/*$response = curl_exec ( $ch );
	if ($result === false)
		echo_nobuffer (curl_error ( $ch ));
	echo_nobuffer( 'c');
	
	//echo_nobuffer (( $result ));
	fclose ( $f );*/
	
function main(){
	global $g_db;
	$result = $g_db->query("SELECT * FROM forms ");
	while ($form = mysql_fetch_array($result)){
		$result = $inputQ = $g_db->query("SELECT * FROM inputs WHERE `formId` = '". $form['id'] . "'");
		while ($input = mysql_fetch_array($result))	
			$inputs[] = $input;
		$selectsQuery = $g_db->query("SELECT * FROM selects WHERE `formId` = '".$form['id']. "'");
		while ($select = mysql_fetch_array($selectQuery))
			$selects[] = $select;
			
		//sendDefault();
		sendEmpty($form, $inputs, $selects);
		//sendHacked();
	
	}

}

function sendEmpty($form, $inputs, $seletcts){
	
	$data = array();

	#inset inputs into data as map
	foreach ($inputs as $input)
		$data[$input['name']] = generateByType(getInputType($input['name']), _NORMUSER_);

	#insert selects into data as map
	foreach ($selects as $select){
		$opts = explode(',', $select['options']);
		#if select tag has more than one options we select secound option else we select first options
		$data[$select['name']] = (count($opts) > 1) ? $opts[1] : $opts[0];
	}

	foreach ($data as $name => $value){
		$value = generateByType(getInputType($name));
		sendRequest($data, $form['method'], $form['fullAction']);
	}
	
	
	echo_nobuffer (" <br>".$data."<br>");

	#set CURL options
	curl_setopt_array ( $ch, $curlOpts );
	
}

function sendRequest($data, $formMethod, $formAction){
	#make CURL object
	$ch = curl_init ();
	
	#use flobal headers variable
	global $headers;
	
	#make http query like ?name1=value1&name2=value2...
	$data = "?".http_build_query($data);
	
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
	curl_setopt_array ( $ch, $curlOpts );
	
	$response = curl_exec ( $ch );
	if ($response === false)
		echo_nobuffer (curl_error ( $ch ));
	//echo_nobuffer ($response);
	
	fclose($file);
	return $response;
}

$data = array (
 	'username' => 'admin',
	'password' => 'asghar'
);

//sendRequest($data, "post", 'http://localhost/test.php');
