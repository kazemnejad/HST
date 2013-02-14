<?php
require_once '../config.php';
require_once 'no_buffer.php';

function hst_log($string){
	if (getConfig('main', 'debugMode') == 1) echo_nobuffer($string); 
}
