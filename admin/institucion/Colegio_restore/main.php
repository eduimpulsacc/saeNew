 
<? include"Coneccion/conexion.php"?>
<?
		$li_id_usuario = $_USUARIO;
		$ls_nombre	   = $_NOMBREUSUARIO;
		$li_colegio	   = $_INSTIT;
		$li_id_perfil  = $_PERFIL;		

?>
<html>
<head>
<title>Sistema Ctas-Ctes Colegios</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<frameset rows="40,*" framespacing="0" frameborder="NO" border="0" bordercolor="#CCCCCC"> 
  <frame src="main_banner.php?as_nombre=<?=($ls_nombre)?>&ai_usuario=<?=($li_id_usuario)?>" name="Banner" scrolling="NO" noresize id="Banner">
  <frameset rows="*" cols="125,*" framespacing="0" frameborder="no" border="0" bordercolor="#CCCCCC"> 
    <frame src="main_menu.php?ai_usuario=<?=($li_id_usuario )?>&as_nombre=<?=($ls_nombre)?>&ai_colegio=<?=($li_colegio)?>&ai_perfil=<?=($li_id_perfil)?>" name="Menu" scrolling="NO" noresize id="Menu">
    <frame src="main_bienvenida.php?as_nombre=<?=($ls_nombre)?>" name="Cuerpo" id="Cuerpo">
  </frameset>
</frameset>
<noframes> 
<body>
</body>
</noframes> 
</html>
