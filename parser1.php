<?php
	include 'simple_html_dom.php';
	include 'include/config.php';
	include 'include/core/database.php';
	
	$g_db = new db_engine;
	
	main();
	
	function getLastId($tableName){
		global $g_db;
		$result = $g_db->query("SELECT * FROM $tableName ORDER BY id DESC LIMIT 1");
		$id = 0;
		if(mysql_num_rows($result) > 0)
			$id = mysql_result($result, 0, 0);
		return ++$id;
	}
	
	function getHtmlToParse($pageId){
		global $g_db;
		$g_db->setDBname("phpcrawl");
		$result = $g_db->query("SELECT * FROM phpcrawler_links WHERE `id` = $pageId")
			or die(mysql_error());
		$page = mysql_fetch_array($result);
		return str_get_html($page['content']);
	}
	
	function parse($html, $pageId){
		global $g_db;
		$g_db->setDBname("parser");
		$id = getLastId("forms");
		foreach ($html->find('form') as $element){
			$cont = 0;
			foreach ($element->find('input') as $input){
				$cont++;
				$inId = getLastId("inputs");
				$g_db->query("INSERT INTO inputs (id, type, name, value, formId) VALUES ($inId, $input->type, $input->name, $input->value, $id");
			}
			$g_db->query("INSERT INTO forms (id, pageId, action, method, inputNum) VALUES ($id, $pageId, $element->action, $element->method, $cont");
			$id++;
		}
	}
	
	
	function main(){
		global $_config;
		$file = file("config.txt");
		$lastPd = $file[0];
		$_config['parser']['last_page_parsed'] = $lastPd;
		$pageId = $lastPd + 1;
		$lastId = getLastId("phpcrawler_links");
		for ($i = 0; $i < $lastId; $i++){
			parse(getHtmlToParse($pageId), $pageId);
			$pageId++;
		}
	}
?>

