<? echo $_URLBASE; 

 
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
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<frameset rows="*,83" frameborder="NO" border="0" framespacing="0">
  <frame src="<?php echo trim($_URLBASE)?>" name="centralFrame"> 
  <frame src="../../menu/adm/abajo_institucion.htm" name="bottomFrame" scrolling="NO" noresize>
<frame src="UntitledFrame-13"></frameset>
<noframes><body>

</body></noframes>



</html>
