<?

$li_institucion = $_GET["ai_institucion"];

$li_agno_actual = date(Y);

$li_cant_agno = $li_agno_actual - 2000;



?>

<html>

<head>

<title>Motor</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script language="JavaScript" type="text/JavaScript">

<!--

function MM_goToURL() { //v3.0

  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;

  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");

}

//-->

</script>

<link href="../css/objeto.css" rel="stylesheet" type="text/css">

</head>



<body leftmargin="0" topmargin="4" marginwidth="0" marginheight="0">

<table width="53%" border="1" align="center" cellpadding="1" cellspacing="0">
  <tr> 

    <td width="25%" rowspan="2" valign="top"> <div align="center"> 

        <input name="cb_ok2" type="button" class="cb_submit_9_x_125" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' id="cb_ok2" onClick="MM_goToURL('parent.frames[\'result\']','genera_archivo.php?as_institucion=<?=($li_institucion)?>&ai_ano='+ddlb_ano.options[ddlb_ano.selectedIndex].value);return document.MM_returnValue" value="GENERAR ARCHIVO PLANO">

        <input name="cb_ok" type="button" class="cb_submit_9_x_125" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' id="cb_ok" onClick="MM_goToURL('parent.frames[\'result\']','Rpt08.php?as_institucion=<?=($li_institucion)?>&ai_ano='+ddlb_ano.options[ddlb_ano.selectedIndex].value);return document.MM_returnValue" value="DESPLEGAR DATOS">

      </div></td>

    <td width="75%" class="titulosMotores">Busqueda Avanzada</td>

  </tr>

  <tr> 

    <td> <select name="ddlb_ano" class="ddlb_9_x">

        <?

	For ($j=0; $j <= $li_cant_agno; $j++)

	{

		echo "<option value='200$j'";

		$li_agno_paso = "200".$j;

		if($li_agno_paso ==date(Y))

		{

			print "Selected";

		} 

		echo ">200$j</option> ";	

	}

	?>

      </select> <input name="cb_ok" type="button" class="cb_submit_9_x_75" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' id="cb_ok" onClick="MM_goToURL('parent.frames[\'result\']','Rpt08.php?as_institucion=<?=($li_institucion)?>&ai_ano='+ddlb_ano.options[ddlb_ano.selectedIndex].value);return document.MM_returnValue" value="Buscar">	

    </td>

  </tr>

</table>

</body>

</html>

