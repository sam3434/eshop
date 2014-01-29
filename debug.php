<?php 
	define('DEBUG', 2);
	
	function debug($msg, $level = 1)
	{
		if (defined('DEBUG') && $level>=DEBUG) {
			echo "<br />[Debug message] $msg";
		}
	}
 ?>