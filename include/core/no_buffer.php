<?php
error_reporting(E_ALL);
	ini_set("display_errors", "On");

function echo_nobuffer($s) {
	echo $s;
	flush();
}

ob_end_flush();
echo str_repeat(' ', 1024);
flush();
