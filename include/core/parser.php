<?php
require_once  'simple_html_dom.php';
require_once '../config.php';
require_once 'database.php';
require_once '_no_buffer.php';
set_time_limit (0);

class Parser{
	private $db;
	
	public function __construct(){
		$this->db = new db_engine();		
	}
}

main();

function getLastId($tableName){
	global $g_db;
	$result = $g_db->query("SELECT * FROM $tableName ORDER BY id DESC LIMIT 1") or die ("last id ".mysql_error());
	$id = 0;
	if(mysql_num_rows($result) > 0)
	$id = mysql_result($result, 0, 0);
	return ++$id;
}

function getHtmlToParse($pageId){
	global $g_db;
	$g_db->setDBname("phpcrawl");
	$result = $g_db->query("SELECT * FROM phpcrawler_links WHERE `id` = $pageId")
	or die("initHtml ".mysql_error());
	$page = mysql_fetch_array($result);
	//echo $page['content'];
	if ($page['url'])
	echo_nobuffer("On Page: " . $page['url']);
	return str_get_html($page['html']);
}

function parse($html, $pageId){
	global $g_db;
	$g_db->setDBname("parser");
	$id = getLastId("forms");
	if ($html){
		echo_nobuffer(" -Finding forms... ");
		foreach ($html->find('form') as $element){
			$cont = 0;
			echo_nobuffer(" -Finding inputs... "."<br>");
			foreach ($element->find('input') as $input){
				$cont++;
				$inId = getLastId("inputs");
				$g_db->query("INSERT INTO inputs (id, type, name, value, formId)
									VALUES ($inId, '{$input->type}', '{$input->name}', '{$input->value}', $id)") 
				or die ("SQL Error [inputs] 1: ".mysql_error());
			}
			$sid = getLastId("inputs");
			foreach ($element->find('select') as $select){
				$cont++;
				$f=0;
				$lastoption = 0;
				$options = "";
				foreach ($select->find('option') as $option){
					$options=$options . "," . $option->value;
					$lastoption++;
				}
				$options = substr($options,1);
				$g_db->query("INSERT INTO selects ( name, options, formId)
									VALUES ( '{$select->name}', '$options' ,$id)") 
				or die ("SQL Error [inputs] 2: ".mysql_error());
				$sid++;
			}
			echo_nobuffer("Finding inputs : Done! <br>");
			$fau = parse_url($element->action);
			if (isset($fau['host']))
			$full_action=$element->action;
			else{
				$pu2 = $g_db->query("SELECT url FROM phpcrawler_links WHERE id = $pageId ")
				or die ("select url ".mysql_error());
				$pu = mysql_fetch_row($pu2);
				if ($pu === false)
				die('salam');
				$pu=$pu[0];
				if ($element->action[0] == '/'){
					$tt=parse_url($pu);
					$full_action =$tt['scheme'] . '://' .$tt['host'] . $element->action;
				}
				else{
					if ($pu[strlen($pu)-1] = '/')
					$full_action = $pu . $element->action;
					else
					$full_action = $pu . '/' . $element->action;
				}
			}
			$g_db->query("INSERT INTO forms (id, pageId, action, method, inputNum, full_action)
								VALUES ($id, $pageId, '{$element->action}', '{$element->method}', $cont, '$full_action')") 
			or die ("SQL Error [forms] 3: ".mysql_error());
			$id++;
		}
	}
}

function stop(){
	$file = file("sp.txt");
	if ($file[0] == '0')
	return false;
	return true;
}
function main(){
	global $_config;
	$file = file("config.txt");
	$lastPd = $file[0];
	$_config['parser']['last_page_parsed'] = $lastPd;
	$pageId = $lastPd + 1;
	$lastId = getLastId("phpcrawler_links");
	$f = fopen("sp.txt","w");
	fwrite($f,0);
	fclose($f);
	for ($i = 0; $i < $lastId && !stop(); $i++){
		parse(getHtmlToParse($pageId), $pageId);
		$file2 = fopen("config.txt","w");
		fwrite($file2,$pageId++);
		fclose($file2);
	}
}
?>