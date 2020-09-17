<?php
	function n1dependentDropdown($v) {
		global $KT_n1dddSW, $KT_relPath, $KT_dd;
		if (!isset($KT_n1dddSW)) {
			$KT_n1dddSW = true;
		}
		$ret = "";

		if ($KT_n1dddSW) {
			$ret .= "<script language=\"JavaScript\" src=\"".$KT_relPath."includes/widgets/n1dependentDropdown.js\"></script>\n";
			$KT_n1dddSW = false;
		}

		
		$KT_dd ++;
		$ret .= '<input type="text" readonly="yes" id="'.$v['name'].'" ';
		while (list($key,$value) = each($v)) {
			switch ($key) {
				case "type":
				case "subtype":
				case "triggerrs":
				case "tpkey":
				case "tfkey":
				case "pkey":
				case "display":
				case "recordset":
				case "boundto":
				case "id":
				case "selected":
					break;
				default:
					$ret .= " " . $key . '="' . $value . '"';
			}
		}
		$ret .= '></input>';
		
		$ret .= '
	<script>
		ddfks_'.$v['name'].' = new Array();
		ddnames_'.$v['name'].' = new Array();
		dddefval_'.$v['name'].' = "'.@$v['selected'].'";
		';
		global ${$v['triggerrs']};
		$rs = ${$v['triggerrs']};
		$rs->MoveFirst();
		while (!$rs->EOF) {
			$ret .= 'ddfks_'.$v['name'].'["'.$rs->Fields($v['tpkey']).'"]="'.$rs->Fields($v['tfkey']).'";
			';
				$rs->MoveNext();
		}
		
		global ${$v['recordset']};
		$rs = &${$v['recordset']};
		$rs->MoveFirst();
		while (!$rs->EOF) {
			$value = $rs->Fields($v['display']);
			$value = str_replace("\\", "\\\\", $value);
			$value = str_replace("\"", "\\\"", $value);

			$ret .= 'ddnames_'.$v['name'].'["'.$rs->Fields($v['pkey']).'"]="'.$value.'";
			';
				$rs->MoveNext();
			}
		$ret .= '
		registerN1Menu("'.$v['name'].'", "'.$v['boundto'].'");
	</script>';
		return $ret;
	}
?>
