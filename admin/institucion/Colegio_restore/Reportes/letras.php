<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?
$ls_string = "MAURICIO";
//print strlen(trim($ls_string));
for($j=0;$j<strlen(trim($ls_string));$j++)
	{
		echo "<img src='letras/".substr($ls_string,strlen(trim($ls_string)) - ($j+1),1).".gif'>";
		//print substr($ls_string,$j,1);
		echo "<br>";
	}

?>

</body>
</html>
