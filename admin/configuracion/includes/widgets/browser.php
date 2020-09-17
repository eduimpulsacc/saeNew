<?php
	// browser detection class
	class browser {
		var $Name = "unknown";
		var $Version = "unknown";
		var $Platform = "unknown";
		function browser() {
			global $HTTP_SERVER_VARS;
			$HTTP_USER_AGENT = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
			if (eregi("opera",$HTTP_USER_AGENT)) {
				$this->Name = 'opera';
				preg_match("/opera\s+([0-9]+)/i", $HTTP_USER_AGENT, $tmp);
				$this->Version = $tmp[1];
			} elseif (eregi("msie",$HTTP_USER_AGENT)) {
				$this->Name = 'msie';
				preg_match("/msie\s+([0-9\.]+)/i", $HTTP_USER_AGENT, $tmp);
				$this->Version = $tmp[1];
			} elseif (eregi("safari",$HTTP_USER_AGENT)) {
				$this->Name = 'safari';
			} elseif (eregi("gecko",$HTTP_USER_AGENT)) {
				$this->Name = 'gecko';
			} elseif (eregi("konqueror",$HTTP_USER_AGENT)) {
				$this->Name = 'konqueror';
			}

			if (eregi("windows", $HTTP_USER_AGENT)) {
				$this->Platform = 'windows';
			} elseif (eregi("linux", $HTTP_USER_AGENT)) {
				$this->Platform = 'linux';
			} elseif (eregi("mac", $HTTP_USER_AGENT)) {
				$this->Platform = 'mac';
			} elseif (eregi("unix", $HTTP_USER_AGENT)) {
				$this->Platform = 'unix';
			}
		}
	}
