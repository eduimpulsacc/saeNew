<?
	$li_id_usuario	  = Trim($_GET["ai_usuario"]);
?>
<html>
<head>
<title>Consulta de Caja</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<frameset rows="*,57" frameborder="no" border="0" framespacing="0">
  <frame src="resultado.php?ai_usuario=<?=($li_id_usuario)?>" name="main" id="main">
  <frame src="motor.php?ai_usuario=<?=($li_id_usuario)?>" name="motor" scrolling="NO" noresize>
</frameset>
<noframes><body>

</body></noframes>
</html>
