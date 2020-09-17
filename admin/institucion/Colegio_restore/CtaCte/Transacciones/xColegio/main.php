 
<?
	$li_colegio_selec  = Trim($_GET["ai_colegio_selec"]);
	$li_id_usuario     = Trim($_GET["ai_usuario"]);
	$li_id_perfil      = Trim($_GET["ai_perfil"]);
?>
<html>
<head>
<title>Modulos USUARIO en PHP</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<frameset rows="*,45" frameborder="NO"> 
  <frame name="main" src="resultado.php?ai_perfil=<?=($li_id_perfil)?>">
  <frame name="motor" scrolling="NO" noresize src="motor.php?ai_perfil=<?=($li_id_perfil)?>&ai_usuario=<?=($li_id_usuario)?>&ai_colegio_selec=<?=($li_colegio_selec)?>">
</frameset>
<noframes> 
<body bgcolor="#FFFFFF" text="#000000">
</body>
</noframes> 
</html>
