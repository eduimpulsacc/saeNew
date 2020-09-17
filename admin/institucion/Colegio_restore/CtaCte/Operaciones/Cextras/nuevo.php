<? include"../../../Coneccion/conexion.php"?>
<?
	if($_POST["cb_new"] != '')
	{
		$li_id_colegio = Trim($_POST["ddlb_colegio"]);
		$ls_nombre = Trim($_POST["tf_nombre"]);
		$ls_descr  = Trim($_POST["tf_obs"]);
		$li_tipo   = Trim($_POST["ddlb_tipo"]);
		$li_signo  = Trim($_POST["ddlb_signo"]);
		$li_signo_saldo  = Trim($_POST["ddlb_saldo"]);
		
		
		if($ls_nombre=='')
		{
		$ls_nombre = ' ';
		}
		if($ls_descr=='')
		{
		$ls_descr = ' ';
		}

		$sql= "Select id_extra From con_extra Order by id_extra Desc;";
		$resultado_query = pg_exec($conexion,$sql);
		$total_filas     = pg_numrows($resultado_query);
		
			if($total_filas<=0)
			{
			$li_ultimo = 1;
			}else
			{
			$li_ultimo = pg_result($resultado_query, 0, 0);
			}
			$li_ultimo = $li_ultimo + 1;
			
		$sql_new = "INSERT INTO con_extra VALUES ($li_id_colegio, $li_ultimo, '$ls_nombre', '$ls_descr', '$li_tipo', '$li_signo', '$li_signo_saldo');";
		$res_new = pg_exec($conexion,$sql_new);
		
		// *** BUSCA SI EXISTE EL ID CERO PARA LOS PLANES *** SINO LO GUARDA ****
		
		$sql_del_cero= "Select * From con_extra where rdb = $li_id_colegio and id_extra = 0;";
		$resultado_query_cero = pg_exec($conexion,$sql_del_cero);
		$total_filas_cero     = pg_numrows($resultado_query_cero);
		
						if($total_filas_cero<=0)
						{
						//echo("No existe CERO");
						$sql_new = "INSERT INTO con_extra VALUES ($li_id_colegio, 0, '0', '0', '0', '0');";
						$res_new = pg_exec($conexion,$sql_new);
						}else
						{
						//echo("existe CERO");
						}
						
		// *** BUSCA SI EXISTE EL ID -1 PARA BECA GENERAL *** SINO LO GUARDA ****
		
		$sql_de_beca= "Select * From con_extra where rdb = $li_id_colegio and id_extra = -1;";
		$resultado_query_beca = pg_exec($conexion,$sql_de_beca);
		$total_filas_beca     = pg_numrows($resultado_query_beca);
		
						if($total_filas_beca<=0)
						{
						//echo("No existe CERO");
						$sql_new = "INSERT INTO con_extra VALUES ($li_id_colegio, -1, 'Beca General', 'Beca General para todos los Colegios', '%', '-');";
						$res_new = pg_exec($conexion,$sql_new);
						}else
						{
						//echo("existe CERO");
						}
						
		?>
		<Script>
		parent.main.location.href="resultado.php?ai_mostrar=1&ai_criterio=1&ai_colegio=<?=($li_id_colegio)?>";
		</Script>
		<?
	}
?>
<?
	$li_id_colegio = Trim($_GET["ai_colegio"]);
	$li_id_nivel   = Trim($_GET["ai_nivel"]);
	$li_id_perfil  = Trim($_GET["ai_perfil"]);

	IF($li_id_perfil == 0) //Administrador
	{
	
	$sql= "SELECT DISTINCT B.RDB, B.NOMBRE_INSTIT FROM INSTITUCION B ORDER BY B.NOMBRE_INSTIT ;";
	
	}ELSE //Si el Perfil es Distinto de Administrador
	{
	
			IF($li_id_nivel == 1 or $li_id_nivel == 2 or $li_id_nivel == 3) //Sistema Gcolegio colegio
			{
		
			$sql= "SELECT DISTINCT B.RDB, B.NOMBRE_INSTIT FROM ACCEDE A, INSTITUCION B WHERE A.ID_PERFIL = $li_id_perfil AND A.RDB = B.RDB ORDER BY B.NOMBRE_INSTIT ;";
		
			}
	}
	$resultado_query_col = pg_exec($conexion,$sql);
	$total_filas_col     = pg_numrows($resultado_query_col);
		
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
//-->
</script>
</head>

<body bgcolor="#FFFFFF" text="#000000">
<form name="form1" method="post" action="">
  <table width="50%" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr> 
      <td class="linea_datos_02"> <div align="center">NOMBRE :</div></td>
      <td class="membrete_datos"> <input type="text" name="tf_nombre" class="text_9_x_300"> 
        <input type="hidden" name="ddlb_colegio" value="<?=($li_id_colegio)?>"> 
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> <div align="center">DESCRIPCION :</div></td>
      <td class="membrete_datos"> <input type="text" name="tf_obs" class="text_9_x_300"> 
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> <div align="center">TIPO :</div></td>
      <td class="membrete_datos"> <select name="ddlb_tipo" class="ddlb_9_x_100">
          <option value="$">Valor</option>
          <option value="%">Porcentaje</option>
        </select> </td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> <div align="center">SIGNO :</div></td>
      <td class="membrete_datos"> <select name="ddlb_signo" class="text_9_x_100">
          <option value="+">Agrega</option>
          <option value="-">Descuenta</option>
        </select> </td>
    </tr>
    <tr>
      <td class="linea_datos_02"><div align="center">aplica al saldo</div></td>
      <td class="membrete_datos">
	  <select name="ddlb_saldo" class="text_9_x_100">
          <option value="S" >SI</option>
          <option value="N" >NO</option>
        </select></td>
    </tr>
  </table>
  <br>
  <table width="50%" border="0" align="center" cellspacing="0" cellpadding="0">
    <tr>
      <td> 
        <div align="center">
          <input type="button" name="cb_go" value="Volver" class="cb_none_9_x_70" onClick="MM_goToURL('parent.frames[\'main\']','resultado.php?ai_mostrar=1&ai_criterio=1&ai_colegio='+<?=($li_id_colegio)?>);return document.MM_returnValue" >
          <input type="submit" name="cb_new" value="Grabar &gt;&gt;" class="cb_none_9_x_70">
        </div>
      </td>
    </tr>
  </table>
    </form>
</body>
</html>
