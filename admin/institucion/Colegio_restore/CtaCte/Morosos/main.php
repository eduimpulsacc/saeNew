 
<?
	$li_id_nivel  = Trim($_GET["ai_nivel"]);
	$li_id_perfil = Trim($_GET["ai_perfil"]);
	$li_id_usuario = Trim($_GET["ai_usuario"]);

	$li_colegio_selec  = Trim($_GET["ai_colegio_selec"]);	
?>
<html>
<head>
<title>Modulos USUARIO en PHP</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<frameset rows="*,45" frameborder="no" border="0" framespacing="0" bordercolor="#000000"> 
  <frame name="main" src="resultado.php">
  <frame name="motor" scrolling="NO" noresize src="motor.php?ai_nivel=<?=($li_id_nivel)?>&ai_perfil=<?=($li_id_perfil)?>&ai_usuario=<?=($li_id_usuario)?>&ai_colegio_selec=<?=($li_colegio_selec)?>">
</frameset>
<noframes> 
<body bgcolor="#FFFFFF" text="#000000">
</body>
</noframes> 
</html>
