<?php
	function dependentDropdown($v) {
		global $KT_dddSW, $KT_relPath, $KT_dd;
		require_once('browser.php');
		$br = new Browser;
		$sw = true;
		if ($br->Name != 'unknown') {
			if ($br->Name == 'opera') {
				if ($br->Version < 7) {
					$sw = false;
				}
			}
		} else {
			$sw = false;
		}
		if ($sw) {
		if (!isset($KT_dddSW)) {
			$KT_dddSW = true;
		}
		$ret = "";

		if ($KT_dddSW) {
			$ret .= "<script language=\"JavaScript\" src=\"".$KT_relPath."includes/widgets/dependentDropdown.js\"></script>\n";
			$KT_dddSW = false;
		}

		$KT_dd ++;
		$ret .= '<select id="'.$v['name'].'" ';
		while (list($key,$value) = each($v)) {
			switch ($key) {
				case 'type':
				case 'subtype':
				case 'pkey':
				case 'fkey':
				case 'display':
				case 'recordset':
				case 'boundto':
				case 'id':
				case 'selected':
				case 'kdefault':
					break;
				default:
					$ret .= " " . $key . '="' . $value . '"';
			}
		}
		$ret .= '></select>';
		
		$ret .= '
	<script>
		dddefaults_'.$v['name'].' = new Array();
		ddfks_'.$v['name'].' = new Array();
		ddnames_'.$v['name'].' = new Array();
		dddefval_'.$v['name'].' = "'.@$v['selected'].'";
		';
		$tok = $v['kdefault'];
		for($i=0;$i<sizeof($tok);$i+=2) {
			$ret .= 'dddefaults_'.$v['name'].'["'.$tok[$i].'"]="'.$tok[$i+1].'";
			';
		}

		global ${$v['recordset']};
		$rs = &${$v['recordset']};
		$rs->MoveFirst();
		while (!$rs->EOF) {
			$ret .= 'ddfks_'.$v['name'].'["'.$rs->Fields($v['pkey']).'"]="'.$rs->Fields($v['fkey']).'";
		';

			$value = $rs->Fields($v['display']);
			$value = str_replace("\\", "\\\\", $value);
			$value = str_replace("\"", "\\\"", $value);

			$ret .= 'ddnames_'.$v['name'].'["'.$rs->Fields($v['pkey']).'"]="'.$value.'";
		';
			$rs->MoveNext();
		}
		$ret .= '
		initMenu("'.$v['name'].'", "'.$v['boundto'].'");
	</script>';
		} else {
			$ret = '<select';
			while (list($key,$value) = each($v)) {
				switch ($key) {
					case 'type':
					case 'subtype':
					case 'pkey':
					case 'fkey':
					case 'display':
					case 'recordset':
					case 'boundto':
					case 'selected':
					case 'kdefault':
						break;
					default:
						$ret .= " " . $key . '="' . $value . '"';
				}
			}
			$ret .= '>\n';
			global ${$v['recordset']};
			$rs = &${$v['recordset']};

			$tok = $v['kdefault'];
			for($i=0;$i<sizeof($tok);$i+=2) {
				$ret .= '<OPTION VALUE="'.$tok[$i].'"';
				if ($v['selected'] == $tok[$i]) {
					$ret .= ' SELECTED';
				}
				$ret .= '>' . $tok[$i+1] . "</OPTION>\n";
			}
			$rs->MoveFirst();
			while (!$rs->EOF) {
				$value = $rs->Fields($v['display']);
				$value = str_replace("\\", "\\\\", $value);
				$value = str_replace("\"", "\\\"", $value);
				$ret .= '<option value="' . $rs->Fields($v['pkey']) . '"';
				if ($v['selected'] == $rs->Fields($v['pkey'])) {
					$ret .= ' SELECTED';
				}
				$ret .= '>' . $value . "</option>\n";
				$rs->MoveNext();
			}
			$ret .= '</select>';
		}
		return $ret;
	}
?>
