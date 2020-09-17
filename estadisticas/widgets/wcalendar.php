<?php
	function wcalendar($v) {
		global $KT_calendarSW, $KT_relPath, $KT_cid;
		require_once(MX_WID_DIR . '/browser.php');
		$br = new Browser;

		$sw = true;
		if ($br->Name != 'unknown') {
			if ($br->Name == 'opera') {
				if ($br->Version < 7) {
					$sw = false;
				}
			} elseif ($br->Name == 'msie') {
				if ($br->Platform == 'mac') {
					$sw = false;
				}
			} elseif ($br->Name == 'konqueror') {
				$sw = false;
			}
		} else {
			$sw = false;
		}

		if ($sw) {

			if (!isset($KT_cid)) {
				$KT_cid = 0;
			}
			if (!isset($KT_calendarSW)) {
				$KT_calendarSW = true;
			}
			$ret = "";

			if ($KT_calendarSW) {
				$ret .= "<script language=\"JavaScript\" src=\"".$KT_relPath."../../includes/widgets/calendar.js\"></script>\n";
				//$ret .= "<script language=\"JavaScript\" src=\"".$KT_relPath."includes/widgets/wcalendar.js\"></script>\n";
				$ret .= "<script language=\"JavaScript\" src=\"".$KT_relPath."../../includes/widgets/calendar-setup.js\"></script>\n";
				$KT_calendarSW = false;
			}

			$ret .= '<input type="text"';
			$Id = "";
			$format = "";
			$label = "...";
			$lang = "en";
			$skin = "system";
			$mondayFirst = "false";
			$singleClick = "true";
			while (list($key,$value) = each($v)) {
				switch ($key) {
					case "type":
					case "subtype":
						break;
					case "skin":
						$skin = $value;
						break;
					case "language":
						$lang = $value;
						break;
					case "label":
						$label = $value;
						break;
					case "format":
						$format = $value;
						break;
					case "mondayfirst":
						$mondayFirst = $value;
						break;
					case "singleclick":
						$singleClick = $value;
						break;
					case "id":
						$Id = $value;
					default:
						$ret .= " " . $key . '="' . $value . '"';
				}
			}
			if($Id === "") {
				$Id = 'wcal_'.$KT_cid;
				$KT_cid++;
				$ret .= ' id="' . $Id . '"';
			}
		$ret .= '>'."\n";
			#add language
			$ret .= '<script language="JavaScript" src="'.$KT_relPath.'../../includes/widgets/lang/calendar-'.$lang.'.js"></script>'."\n";
			#add style
			$ret .= '<link rel="stylesheet" type="text/css" media="all" href="'.$KT_relPath.'../../includes/widgets/calendar-'.$skin.'.css" title="'.$skin.'"/>'."\n";
			#add button
			$ret .= '<input type="button" id="'.$Id.'_btn" class="botadd" value=" '.stripslashes($label).' ">';
			$ret .= '
                <script type="text/javascript">
                    Calendar.setup({
                        inputField     :    "'.$Id.'",      // id of the input field
                        ifFormat       :    "'.$format.'",  // format of the input field (even if hidden, this format will be honored)
                        button         :    "'.$Id.'_btn",  // trigger button (well, IMG in our case)
                        align          :    "Bl",           // alignment (defaults to "Bl")
                        singleClick    :    '.$singleClick.',
						mondayFirst	   :    '.$mondayFirst.'
                    });
                </script>';
			return $ret;
		} else {
			$ret = '<input type="text"';
			while (list($key,$value) = each($v)) {
				switch ($key) {
					case "type":
					case "readonly":
					case "subtype":
					case "skin":
					case "language":
					case "label":
					case "format":
					case "mondayfirst":
						break;
					default:
						$ret .= " " . $key . '="' . $value . '"';
				}
			}
			$ret .= ">\n";
			return $ret;
		}
	}
?>
