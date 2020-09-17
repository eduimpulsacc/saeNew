<?
$li_institucion = $_GET["ai_institucion"];
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<frameset rows="50,*,60" cols="*" framespacing="0" frameborder="no" border="0" bordercolor="#999999">
  <frame src="botonesweb.htm" name="result" id="result">
  <frame src="Rpt10.php" name="result" id="result">
  <frame src="motor.php?ai_institucion=<?=($li_institucion)?>" name="motor" scrolling="NO" noresize id="motor">
</frameset>
<noframes><body>

</body></noframes>
</html>
