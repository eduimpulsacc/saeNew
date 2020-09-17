<?php
	function smartdate($v) {
		global $KT_smartdateSW, $KT_relPath;

		require_once(MX_WID_DIR . '/browser.php');
		$br = new Browser;
		$ret = "";
		if ($br->Name == 'msie' || $br->Name == 'gecko' || $br->Name == 'safari') {
		if (!isset($KT_smartdateSW)) {
			$KT_smartdateSW = true;
		}

		if ($KT_smartdateSW) {
			$ret .= "<script language=\"JavaScript\" src=\"".$KT_relPath."includes/widgets/smartdate.js\"></script>\n";
			$KT_smartdateSW = false;
		}
			$ret .= '<input autocomplete="off" type="text" onblur="editDateBlur(this, \''.$v['mask'].'\')" onkeypress="return editDatePre(this, \''.$v['mask'].'\', event)" onkeyup="return editDate(this, \''.$v['mask'].'\', event);"';
		} else {
			$ret .= '<input type="text"';
		}

		while (list($key,$value) = each($v)) {
			switch ($key) {
				case "type":
				case "subtype":
				case "mask":
					break;
				default:
					$ret .= " " . $key . '="' . $value . '"';
			}
		}
		$ret .= '>';
		
		return $ret;
	}
?>
