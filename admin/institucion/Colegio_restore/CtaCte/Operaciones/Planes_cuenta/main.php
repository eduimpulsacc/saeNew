 
<?
		$li_id_nivel   = Trim($_GET["ai_nivel"]);
		$li_id_usuario = Trim($_GET["ai_usuario"]);
		$li_id_perfil  = Trim($_GET["ai_perfil"]);
		$li_id_colegio_selec  = Trim($_GET["ai_colegio_selec"]);
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<frameset rows="18,100,13" frameborder="NO" border="0" framespacing="0"> 
  <frame name="motor_up" scrolling="NO" noresize src="resultado_up.php?ai_nivel=<?=($li_id_nivel)?>&ai_perfil=<?=($li_id_perfil)?>&ai_usuario=<?=($li_id_usuario)?>&ai_colegio_selec=<?=($li_id_colegio_selec)?>" >
  <frame name="main" src="resultado_down.php">
  <frame name="motor" src="motor.php?ai_nivel=<?=($li_id_nivel)?>&ai_perfil=<?=($li_id_perfil)?>&ai_usuario=<?=($li_id_usuario)?>&ai_colegio_selec=<?=($li_id_colegio_selec)?>">
</frameset>
<noframes> 
<body bgcolor="#FFFFFF" text="#000000">
</body>
</noframes> 
</html>
