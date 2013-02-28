<?php
require_once '../config.php';
require_once 'no_buffer.php';

function hst_log($string){
	if (getConfig('main', 'debugMode') == 1) echo_nobuffer($string . "<br>\n"); 
}

function hst_error($string, $component = NULL){
	
	hst_log('<font color="red"><b>'. (is_null($component)? "" : ($component . ' ')) . 'ERROR: ' . $string . '</b></font>');
}
