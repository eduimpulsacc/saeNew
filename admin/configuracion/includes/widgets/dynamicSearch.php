<?php
	function dynamicSearch($v) {
		global $KT_dynamicInputSW, $KT_relPath;
		require_once(MX_WID_DIR . '/browser.php');
		$br = new Browser;

		$ret = "";
		if (($br->Name == 'msie' && $br->Platform=='windows') || $br->Name == 'gecko') {
			if (!isset($KT_dynamicInputSW)) {
				$KT_dynamicInputSW = true;
			}

			$rsName = $v['datasource'];
			if (!isset($v['id'])) {
				$v['id'] = $v['name'];
			}
			$v['id'] = preg_replace("/[\[\]]/", "_", $v['id']);
			
			$wgName = $v['name'];
			$wgId = $v['id'];
			
			$v['style'] = isset($v['style'])?$v['style']:"width:150px";
			global $$rsName;
			$$rsName->MoveFirst();
			$sqlTable =  $$rsName->sql;
			preg_match("/\sfrom\s*([^\s]+)?\s*/i", $sqlTable, $sqlTable);
			$sqlTable = $sqlTable[1];

			if (!isset($v['norec']) || (int)$v['norec'] == "0") {
				$v['norec'] = 100000;
			}

		$ret .= "<script>
		var ${wgId}_restrict = 'No';
		var ${wgId}_norec = '".$v['norec']."';
		var ${wgId}_style = '".$v['style']."';
		var ${wgId}_edittype = 'S';
		var ${wgId}_el = new Array(\"\"";
		if (!isset($v['value'])) {
			$v['value'] = '';
		}
		$dvvalue = stripslashes($v['value']);
		while (!$$rsName->EOF) {
			$value = $$rsName->Fields($v['field']);
			$value = str_replace("\\", "\\\\", $value);
			$value = str_replace("\"", "\\\"", $value);
			$value = str_replace("<!--", "<! --", $value);
			$ret .= ",\"\", \"" . $value . "\"";
			$$rsName->MoveNext();
		}
		$ret .= ");
	</script>\n";
			if ($KT_dynamicInputSW) {
				$ret .= "<script language=\"JavaScript\" src=\"".$KT_relPath."includes/widgets/dynamicInput.js\"></script>\n";
				$KT_dynamicInputSW = false;
			}
			$ret .= '<input type="text" name="'.$wgId.'_edit" id="'.$wgId.'_edit"
				onblur="di_onBlur(this, event);" 
				onKeyDown="return di_inputKeyDown(this, event);"
				onKeyPress="return di_inputKeyPress(this, event);"
				onKeyUp="autoComplete(this, event);"
				autocomplete="off"
				style="'.$v['style'].'"
				value="'.$dvvalue.'"
			';
			while (list($key,$value) = each($v)) {
				switch ($key) {
					case "type":
					case "subtype":
					case "datasource":
					case "norec":
					case "field":
					case "value":
					case "style":
					case "kdefault":
					case "connection":
					case "name":
					case "id":
						break;
					default:
						$ret .= " " . $key . '="' . $value . '"';
				}
			}
			$ret .= '>';
			$ret .= '<input type="button" class="mxw_v" name="'.$wgId.'_v" id="'.$wgId.'_v" tabIndex="-1" value="';
			if ($br->Name == 'msie') {
				$ret .= '6" style="font-family: webdings; ';
			} else {
				$ret .= 'v" style="';
			}
			$ret .= '"
					style="position:relative; left:-1px; top: -1px; height: 21px; width: 18px"
					onFocus="di_vFocused(\''.$wgId.'\')"
					onClick="return di_buttonPressed(\''.$wgId.'\')">';

			$ret .= '<input type="button" id="'.$wgId.'_add" value="fake" disabled="true" style="display:none">';
			$ret .= '<input name="'.$wgName.'" id="'.$wgId.'" type="hidden" value="'.$dvvalue.'">';
			return $ret;
		} else {
			$wgName = $v['name'];
			if (!isset($v['id'])) {
				$v['id'] = $v['name'];
			}
			$v['id'] = preg_replace("/[\[\]]/", "_", $v['id']);
			$wgId = $v['id'];
			if (isset($v['value'])) {
				$dvvalue = stripslashes($v['value']);
			} else {
				$dvvalue = '';
			}

			$ret .= '<input type="text" value="'.$dvvalue.'"';
			while (list($key,$value) = each($v)) {
				switch ($key) {
					case "type":
					case "subtype":
					case "datasource":
					case "norec":
					case "field":
					case "style":
					case "kdefault":
					case "connection":
					case "autocomplete":
					case "value":
						break;
					default:
						$ret .= " " . $key . '="' . $value . '"';
				}
			}
			$ret .= '>';
			return $ret;
		}
	}
?>


