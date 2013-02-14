/* <?php
// 	error_reporting(E_ALL);
// 	ini_set("display_errors", "On");
// 	include "include/config.php";
// 	include "include/core/database.php";
// 	require_once('_no_buffer.php');
	
// 	$g_db = new db_engine();
	
// 	$f = fopen ( 'out.txt', 'w+' );
	
// 	/*$data = array (
// 			'username' => 'admin',
// 			'password' => 'asghar' 
// 	);*/
	
// 	$headers = array (
// 			'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv=>15.0) Gecko/20100101 Firefox/15.0.1',
// 			'Accept: */*',
// 			'Accept-Language: en-us,en;q=0.5',
// 			'Accept-Encoding: gzip, deflate',
// 			'Connection: close',
// 			'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
// 			// 'X-Requested-With: XMLHttpRequest',
// 			'Referer: http://localhost/',
// 			'Pragma: no-cache',
// 			'Cache-Control: no-cache',
// 			'Expect:'
// 	);
	
// 	//echo_nobuffer( $data );

// 	//$result = $g_db->query("SELECT * FROM forms ");
	
	
	
	
// 	//curl_setopt_array ( $ch, $curlOpts );
	
// 	echo_nobuffer( 'b' );
	
// 	$response = curl_exec ( $ch );
// 	if ($result === false)
// 		echo_nobuffer (curl_error ( $ch ));
// 	echo_nobuffer( 'c');
	
// 	echo_nobuffer (( $result ));
// 	fclose ( $f );
// function main(){
// 	$result = $g_db->query("SELECT * FROM forms ");
// 	while ($form = mysql_fetch_array($result)){
// 		$result = $inputQ = $g_db->query("SELECT * FROM inputs WHERE `formId` = '". $form['id'] . "'");
// 		while ($input = mysql_fetch_array($result)){
// 			$inputs[] = $input;
// 		$selectsQuery = $g_db->query("SELECT * FROM selects WHERE `formId` = '".$form['id']. "'");
// 		while ($select = mysql_fetch_array($selectQuery))
// 			$selects[] = $select;
			
// 		sendDefault();
// 		sendEmpty();
// 		sendHacked();
	
// 	}

// }
	
// function manage($form), $type){
// 		#GET forms
// 		if ($form['method'] == "get"){
// 			$inputQ = $g_db->query("SELECT * FROM inputs WHERE `formId` = '". $form['id'] . "'");
// 			$isFirst = true;
// 			#get inputs from database and make a request
// 			while ($input = mysql_fetch_array($inputQ)){
// 				if ($isFirst){
// 					$isFirst = false;
// 				} else {
// 					$reqURL .= "&";
// 				}
// 				$reqURL .= $input['name'];
// 				$reqURL .= "=";
// 				switch $type{
// 					case 0:
// 						$reqURL .= $input['value'];
// 						break;
// 					case 1:
// 						$reqURL .= "";
// 						break;
// 					case 2:
						
// 			}
// 			$selectsQuery = $g_db->query("SELECT * FROM selects WHERE `formId` = '".$form['id']. "'");
// 			$isFirst = true;
// 			#get selects from database and add it to request
// 			while ($select = mysql_fetch_array($selectsQuery)){
// 				$opts = explode(',', $select['options']);
// 				$i =0;
// 				while ($opts){
// 					if ($isFirst)
// 						$isFirst = false;
// 					else
// 						$reqURL .= "&";
// 					$reqURL .= $select['name'];
// 					$reqURL .= $opt[$i++];
// 				}
// 			}
// 			#CURL options
// 			$curlOpts = array (
// 				CURLOPT_URL => $form['action'] . "?" . $reqURL , // $form['action'],
// 				CURLOPT_RETURNTRANSFER => 1,
// 				CURLOPT_FOLLOWLOCATION => 1,
// 				CURLOPT_FRESH_CONNECT => true,
// 				CURLOPT_VERBOSE => 1,
// 				CURLOPT_TIMEOUT => 15,
// 				CURLOPT_ENCODING => 'gzip',
// 				CURLOPT_STDERR => $f,
// 				CURLOPT_HTTPHEADER => $headers,
// 				// CURLOPT_HEADERFUNCTION => 'readHeader',
// 				CURLOPT_COOKIEFILE => "cookie.coo",
// 				CURLOPT_COOKIEJAR => "cookie.coo" 
// 			);
			
// 			echo_nobuffer (" <br>".$reqURL."<br>");
// 		#POST forms
// 		} else if ($form['method'] == 'post'){
			
// 			$inputQ = $g_db->query("SELECT * FROM inputs WHERE `formId` = '". $form['id']."'");
// 			while ($input = mysql_fetch_array($inputQ)){
// 				$data[$input['name']] = $input['value'];
// 			}
// 			//task
// 			$selectsQuery = $g_db->query("SELECT * FROM selects WHERE `formId` = '" . $form['id'] . "'");
// 			$isFirst = true;
// 			#get selects from database and add it to request
// 			while ($select = mysql_fetch_array($selectsQuery)){
// 				$opts = explode(',', $select['options']);
// 				$optionFlag = true;
// 				while ($opts){
// 					if ($isFirst)
// 						$isFirst = false;
// 					else
// 						$reqURL .= "&";
// 					$reqURL .= $select['name'];
// 					$reqURL .= $opt[$i++];
// 				}
// 			}
// 			$data = http_build_query ( $data );
			
// 			$curlOpts = array (
// 				CURLOPT_URL => $form['action'] , // $form['action'],
// 				CURLOPT_RETURNTRANSFER => 1,
// 				CURLOPT_FOLLOWLOCATION => 1,
// 				CURLOPT_FRESH_CONNECT => true,
// 				CURLOPT_VERBOSE => 1,
// 				CURLOPT_TIMEOUT => 15,
// 				CURLOPT_ENCODING => 'gzip',
// 				CURLOPT_STDERR => $f,
// 				CURLOPT_POSTFIELDS => $data,
// 				CURLOPT_HTTPHEADER => $headers,
// 				// CURLOPT_HEADERFUNCTION => 'readHeader',
// 				CURLOPT_COOKIEFILE => "cookie.coo",
// 				CURLOPT_COOKIEJAR => "cookie.coo" 
// 			);
			
// 			echo_nobuffer (" <br>".$data."<br>");
		
// 		}
// 	}
// }

// function sendDefault($form, $inputs, $seletcts){
// 	$ch = curl_init ();
	
// 	if ($form['method'] == "get"){
// 		$reqURL = "";
// 		$isFirst = true;
// 		#get inputs from database and make a request
// 		for ($i = 0; $i < count($inputs); $i++){
// 			if ($isFirst)
// 				$isFirst = false;
// 			else 
// 				$reqURL .= "&";
// 			$reqURL .= $inputs[i]['name'];
// 			$reqURL .= "=";
// 			if ($inputs[i]['value'] == "")
// 				$reqURL .= "generated_by_hst";
// 			else
// 				$reqURL .= $inputs[i]['value'];
// 		}
// 		$isFirst = true;
// 		#get selects from database and add it to request
// 		for ($i = 0; $i < count($selects); $i++){
// 			$opts = explode(',', $selects[i]['options']);
// 			/*$i =0;
// 			while ($opts){*/
// 			if ($isFirst)
// 				$isFirst = false;
// 			else
// 				$reqURL .= "&";/*
// 				$reqURL .= $select['name'];
// 				$reqURL .= $opt[$i++];
// 			}*/
// 			$reqURL .= $selects[i]['name'];
// 			$reqURL .= "=";
// 			$reqURL .= $opts[0];
// 		}
// 		#CURL options
// 		$curlOpts = array (
// 			CURLOPT_URL => $form['action'] . "?" . $reqURL , // $form['action'],
// 			CURLOPT_RETURNTRANSFER => 1,
// 			CURLOPT_FOLLOWLOCATION => 1,
// 			CURLOPT_FRESH_CONNECT => true,
// 			CURLOPT_VERBOSE => 1,
// 			CURLOPT_TIMEOUT => 15,
// 			CURLOPT_ENCODING => 'gzip',
// 			CURLOPT_STDERR => $f,
// 			CURLOPT_HTTPHEADER => $headers,
// 			// CURLOPT_HEADERFUNCTION => 'readHeader',
// 			CURLOPT_COOKIEFILE => "cookie.coo",
// 			CURLOPT_COOKIEJAR => "cookie.coo" 
// 		);
		
// 		echo_nobuffer (" <br>".$reqURL."<br>");
// 	#POST forms
// 	} else if ($form['method'] == 'post'){
// 		$data = array();
		
// 		for ($i = 0; $i < count($inputs); $i++){
// 			if ($inputs[i]['value'] == "")
// 				$data[$inputs[i]['name'] = "generated_by_hst";
// 			else
// 				$data[$inputs[i]['name']] = $inputs[i]['value'];
// 		}
		
// 		$isFirst = true;
		
// 		#get selects from database and add it to request
// 		for ($i = 0; $i < count($selects); $i++){
// 			$opts = explode(',', $selects[i]['options']);
// 			$data[$selects[i]['name']] = $opts[1];
// 		}
		
// 		$data = http_build_query ( $data );
		
// 		$curlOpts = array (
// 			CURLOPT_URL => $form['action'] , // $form['action'],
// 			CURLOPT_RETURNTRANSFER => 1,
// 			CURLOPT_FOLLOWLOCATION => 1,
// 			CURLOPT_FRESH_CONNECT => true,
// 			CURLOPT_VERBOSE => 1,
// 			CURLOPT_TIMEOUT => 15,
// 			CURLOPT_ENCODING => 'gzip',
// 			CURLOPT_STDERR => $f,
// 			CURLOPT_POSTFIELDS => $data,
// 			CURLOPT_HTTPHEADER => $headers,
// 			// CURLOPT_HEADERFUNCTION => 'readHeader',
// 			CURLOPT_COOKIEFILE => "cookie.coo",
// 			CURLOPT_COOKIEJAR => "cookie.coo" 
// 		);
		
// 		echo_nobuffer (" <br>".$data."<br>");
	
// 	}
// 	#set CURL options
// 	curl_setopt_array ( $ch, $curlOpts );
// 	#send request and get response
// 	$response = curl_exec ( $ch );
	
// 	if ($result === false)
// 		echo_nobuffer (curl_error ( $ch ));
// 	#output the respone
// 	echo_nobuffer ( $result );
// }

// function sendEmpty($form){
// 	$ch = curl_init ();
	
// 	if ($form['method'] == "get"){
	
// 		/*$reqURL = "";
		
// 		$isFirst = true;
		
// 		#get inputs from database and make a request
// 		for ($i = 0; $i < count($inputs); $i++){
// 			if ($isFirst)
// 				$isFirst = false;
// 			else 
// 				$reqURL .= "&";
// 			$reqURL .= $inputs[i]['name'];
// 			$reqURL .= "=";
// 		}
		
// 		$isFirst = true;
		
// 		#get selects from database and add it to request
// 		for ($i = 0; $i < count($selects); $i++){
// 			$opts = explode(',', $selects[i]['options']);
// 			/*$i =0;
// 			while ($opts){
// 			if ($isFirst)
// 				$isFirst = false;
// 			else
// 				$reqURL .= "&";
// 				$reqURL .= $select['name'];
// 				$reqURL .= $opt[$i++];
// 			}
// 			$reqURL .= $selects[i]['name'];
// 			$reqURL .= "=";
// 		}
		
// 		#CURL options
// 		$curlOpts = array (
// 			CURLOPT_URL => $form['action'] . "?" . $reqURL , // $form['action'],
// 			CURLOPT_RETURNTRANSFER => 1,
// 			CURLOPT_FOLLOWLOCATION => 1,
// 			CURLOPT_FRESH_CONNECT => true,
// 			CURLOPT_VERBOSE => 1,
// 			CURLOPT_TIMEOUT => 15,
// 			CURLOPT_ENCODING => 'gzip',
// 			CURLOPT_STDERR => $f,
// 			CURLOPT_HTTPHEADER => $headers,
// 			// CURLOPT_HEADERFUNCTION => 'readHeader',
// 			CURLOPT_COOKIEFILE => "cookie.coo",
// 			CURLOPT_COOKIEJAR => "cookie.coo" 
// 		);
		
// 		echo_nobuffer (" <br>Request URL: ".$reqURL."<br>");*/
// 	#POST forms
// 	} else if ($form['method'] == 'post'){
// 		$data = array();
		
// 		for ($i = 0; $i < count($inputs); $i++)
// 			$data[$inputs[i]['name'] = "";
		
// 		$isFirst = true;
		
// 		#get selects from database and add it to request
// 		for ($i = 0; $i < count($selects); $i++){
// 			$opts = explode(',', $selects[i]['options']);
// 			$data[$selects[i]['name']] = "";
// 		}
		
// 		$data = http_build_query ( $data );
		
// 		$curlOpts = array (
// 			CURLOPT_URL => $form['action'] , // $form['action'],
// 			CURLOPT_RETURNTRANSFER => 1,
// 			CURLOPT_FOLLOWLOCATION => 1,
// 			CURLOPT_FRESH_CONNECT => true,
// 			CURLOPT_VERBOSE => 1,
// 			CURLOPT_TIMEOUT => 15,
// 			CURLOPT_ENCODING => 'gzip',
// 			CURLOPT_STDERR => $f,
// 			CURLOPT_POSTFIELDS => $data,
// 			CURLOPT_HTTPHEADER => $headers,
// 			// CURLOPT_HEADERFUNCTION => 'readHeader',
// 			CURLOPT_COOKIEFILE => "cookie.coo",
// 			CURLOPT_COOKIEJAR => "cookie.coo" 
// 		);
		
// 		echo_nobuffer (" <br>".$data."<br>");
	
// 	}
// 	#set CURL options
// 	curl_setopt_array ( $ch, $curlOpts );
	
// 	#send request and get response
// 	$response = curl_exec ( $ch );
// 	if ($response === false)
// 		echo_nobuffer (curl_error ( $ch ));
// 	#output the respone
// 	echo_nobuffer ( $response );
// }

// function sendHacked(){
// 	$hackedWordResult = $g_db->query("SELECT * FROM modForms");
// 	while ($hackValue = mysql_fetch_array($hackedWordResult)){
	
// 	}
// }
//  */