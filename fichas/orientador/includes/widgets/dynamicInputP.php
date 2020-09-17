<?php
	session_start();
	$sessInsTest = &$HTTP_SESSION_VARS['sessInsTest'];
	$vars = $sessInsTest[$HTTP_GET_VARS['id']];
	require_once('../../Connections/'.$vars['conn'].'.php');

	$el = $HTTP_GET_VARS['el'];
	$text = $HTTP_GET_VARS['text'];

	$KT_conn = ${$vars['conn']};
	$sql = "insert into " . $vars['table'] . " (" . $vars['field'] . ") values ('" . $text . "') ";
	$KT_conn->Execute($sql) or die($sql);
	$sql = "select " . $vars['idfield'] . " as id FROM " . $vars['table'] . " where " . $vars['field'] . " = '" . $HTTP_GET_VARS['text'] . "'";
	$rs = $KT_conn->Execute($sql) or die($sql);
?>
<script>
	var el = parent.document.getElementById('<?php echo $el; ?>');
	datasource = eval("parent." + el.NUghURlDXXp);
	datasource[datasource.length] = '<?php echo $rs->Fields('id'); ?>';
	datasource[datasource.length] = '<?php echo $text; ?>';
	parent.di_sortDatasource(datasource);

	el.addButton.disabled = 'true';
	parent.di_syncSelection(el);
	el.focus();
</script>
