<?include"../../../Coneccion/conexion.php"?>

<?

	if($_POST["cb_new"] != '')

	{

		$li_colegio = Trim($_POST["ddlb_colegio"]);

		$ls_nombre  = Trim($_POST["tf_nombre"]);

		

		$sql= "Select id_categoria From con_categoria Order by id_categoria Desc;";

		$resultado_query = pg_exec($conexion,$sql);

		$total_filas     = pg_numrows($resultado_query);

		

			if($total_filas<=0)

			{

			$li_ultimo = 0;

			}else

			{

			$li_ultimo = pg_result($resultado_query, 0, 0);

			}

			$li_ultimo = $li_ultimo + 1;

		

			

		$sql_new = "INSERT INTO con_categoria VALUES ($li_colegio, $li_ultimo, '$ls_nombre');";

		$res_new = pg_exec($conexion,$sql_new);

	

	?>

	<Script>

	parent.main.location.href="resultado.php?ai_mostrar=1&ai_colegio=<?=($li_colegio)?>"

	</Script>

	<?

	}



?>

<?

	$li_id_colegio = Trim($_GET["ai_colegio"]);

	$li_id_nivel  = Trim($_GET["ai_nivel"]);

	$li_id_perfil = Trim($_GET["ai_perfil"]);



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

if (document.form1.tf_nombre.value == "")

 {

 alert("Nombre No pueden se nulo");

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

		<input type="hidden" name="ddlb_colegio" value="<?=($li_id_colegio)?>">

      </td>

    </tr>

  </table>  

  <br>

  <table width="50%" border="0" align="center" cellspacing="0" cellpadding="0">

    <tr>

      <td> 

        <div align="center">

          <input type="button" name="cb_go" value="Volver" class="cb_none_9_x_70" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="MM_goToURL('parent.frames[\'main\']','resultado.php?ai_mostrar=1&ai_colegio=<?=($li_id_colegio)?>');return document.MM_returnValue" >

          <input type="submit" name="cb_new" value="Grabar &gt;&gt;" class="cb_none_9_x_70" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff'>

        </div>

      </td>

    </tr>

  </table>

    </form>

</body>

</html>

