<?
$li_institucion = $_GET["ai_institucion"];
//$li_institucion = $_INSTIT;

//echo "inst : $li_institucion";
?>
<html>
<head>
<title>Reportes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript">
//window.resizeTo(800,600);
</script>
</head>

<frameset rows="80,*" framespacing="1" frameborder="yes" border="1" bordercolor="#999999">
  <frame src="Main_banner.php" name="top" scrolling="NO" noresize id="top" >
  <frameset rows="*" cols="98,*" framespacing="1" frameborder="yes" border="1" bordercolor="#999999">
    <frame src="main_motor.php?ai_institucion=<?=($li_institucion)?>" name="menu" scrolling="NO" noresize id="menu">
    <frame src="main_bienvenida.php" name="cuerpo" id="cuerpo">
  </frameset>
</frameset>
<noframes><body>


</body></noframes>
</html>
