<?php 
	session_start();	
	if(!($_CHK_ID==session_id())){//CHEQUEA QUE EL NRO DE LA SESSION ASIGNADO AL LOGONEARSE CORRESPONDE AL ID ACTUAL DE LA SESSION
		echo "ERROR DE ACCESO, SESSION INVALIDA.";
		session_unset();
		session_destroy();
		exit;
	};
?>
<html>
<head>
<title>Colegio Electronico.</title>
<script language="JavaScript" src="tocTab.js"></script>
<script language="JavaScript" src="tocParas.js"></script>
<script language="JavaScript" src="displayToc.js"></script>
</head>
<frameset cols="160,*" border=0 onload="reDisplay('0',true);">
	<frame src="blank.htm" name="toc">
	<frame src="<?php echo trim($_URLBASE)?>" name="content">
</frameset>
