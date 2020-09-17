<?include"../../../Coneccion/conexion.php"?>
<?
	if(Trim($_POST["hf_ok"]) != '')
	{
	
		$sql = "Select MAX(id_moneda) + 1 As Total From con_moneda ;";
		$resultado_query = pg_exec($conexion,$sql);
	
		$li_id     = pg_result($resultado_query, 0, 0);
		$ls_nombre = Trim($_POST["tf_nombre"]);
		$ls_sigla  = Trim($_POST["tf_sigla"]);
			
		$sql_new = "INSERT INTO con_moneda VALUES ($li_id, '$ls_nombre', '$ls_sigla');";
		//Echo("SQL $sql_new ");
		$res_new = pg_exec($conexion,$sql_new);
		
		
		
	?>
	<Script>
	parent.main.location.href="resultado.php"
	</Script>
	<?
	
	}

	pg_close($conexion);
?>

<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../../../css/objeto.css" type="text/css">
<script language="JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function validar()
{
if (document.form1.tf_sigla.value == "" || document.form1.tf_nombre.value == ""  )
 {
 alert("Los Campos Sigla y Nombre No pueden ser nulos");
 }else{
 document.all.form1.hf_ok.value = 1;
 document.all.form1.submit();
 }  
}

//-->
</script>
</head>

<body bgcolor="#FFFFFF" text="#000000">
<form name="form1" method="post" action="">
  <table width="50%" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr> 
      <td class="linea_datos_02"> 
        <div align="center">NOMBRE :</div>
      </td>
      <td class="membrete_datos"> 
        <input type="text" name="tf_nombre" class="text_9_x_300">
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> 
        <div align="center">SIGLA :</div>
      </td>
      <td class="membrete_datos"> 
        <input type="text" name="tf_sigla" class="text_9_x_300">
      </td>
    </tr>
  </table>
  <br>
  <table width="50%" border="0" align="center" cellspacing="0" cellpadding="0">
    <tr>
      <td> 
        <div align="center">
		  <input type="hidden" name="hf_ok">
          <input type="button" name="cb_go" value="Volver" class="cb_none_9_x_70" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="MM_goToURL('parent.frames[\'main\']','resultado.php');return document.MM_returnValue" >
          <input type="button" name="cb_new" value="Grabar &gt;&gt;" class="cb_none_9_x_70" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="validar()">
        </div>
      </td>
    </tr>
  </table>
    </form>
</body>
</html>
