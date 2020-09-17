<?php
	session_start();
	if (!defined('MX_WID_DIR')) define('MX_WID_DIR',dirname(__FILE__));
	function showWidget($v) {
		global $KT_relPath;
		$funct = $v['subtype'];
		@include_once($v['subtype'] . ".php");
		if (!function_exists($funct)) {
			@include_once($KT_relPath . "includes/widgets/" . $v['subtype'] . ".php");
		}
		if (function_exists($funct)) {
			return $funct($v);
		} else {
			return 'Unknown widget type: ' . $v['subtype'];
		}
	}
	ob_start();
?>
