<?


$li_institucion = $_GET["ai_institucion"];


?>


<html>


<head>


<title>Untitled Document</title>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


</head>





<frameset rows="50,*,65" cols="*" framespacing="0" frameborder="no" border="0" bordercolor="#CCCCCC">

  <frame src="botonesweb.htm" name="result" id="result">


  <frame src="Rpt05.php" name="result" id="result">


  <frame src="motor.php?ai_institucion=<?=($li_institucion)?>" name="motor" scrolling="NO" noresize id="motor">


</frameset>


<noframes><body>





</body></noframes>


</html>


