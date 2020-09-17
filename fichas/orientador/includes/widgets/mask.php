<?php
	function mask($v) {
		global $KT_maskSW, $KT_relPath;
		if (isset($v['value'])) {
			$v['value']=stripslashes($v['value']);
		} else {
			$v['value']='';
		}

		require_once(MX_WID_DIR . '/browser.php');
		$br = new Browser;
		if ($br->Name == 'msie' || $br->Name == 'gecko' || $br->Name == 'safari') {

		if (!isset($KT_maskSW)) {
			$KT_maskSW = true;
		}
		$ret = "";

		if ($KT_maskSW) {
			$ret .= "<script language=\"JavaScript\" src=\"".$KT_relPath."includes/widgets/mask.js\"></script>\n";
			$KT_maskSW = false;
		}

			$ret .= '<input autocomplete="off" type="text" onkeypress="return editMaskPre(this, \''.$v['mask'].'\', event)" onkeyup="return editMask(this, \''.$v['mask'].'\', event);" onblur="return editMask(this, \''.$v['mask'].'\', event);"';
		} else {
			$ret = '<input type="text"';
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
