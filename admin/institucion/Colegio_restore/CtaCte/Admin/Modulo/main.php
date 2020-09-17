<?include"../../../Coneccion/conexion.php"?>

<?
	if($_POST["cb_save"] != '')
{
	
	$li_total_j = $_POST["hf_total_j"];
	$li_total_j = $li_total_j - 1;
	$li_total_x = $_POST["hf_total_x"];
	//echo "<BR> Total j : ($li_total_j) -- Total x : ($li_total_x) <BR>";

	For ($j=0; $j < $li_total_j; $j++)
		{
		$li_id_modulo = $_POST["hf_id_modulo_".$j];

		$sql_save = "DELETE FROM con_perfil_modulo WHERE id_modulo = $li_id_modulo ;";
		//echo " ELIMINANDO EN MODULO_PERFIL : ($sql_save) <BR>";
		$res_save = pg_exec($conexion,$sql_save);
		
		For ($x=0; $x < $li_total_x; $x++)
			{
				
			$li_id_modulo = $_POST["hf_id_modulo_".$j];
			$li_id_perfil = $_POST["hf_id_perfil_".$j._.$x];
			$li_valor	  = $_POST["tf_valor_".$j._.$x];
				If($li_valor == '')
				{
				$li_valor = 0;
				}
			
				If($li_valor > 0)
				{
				$sql_save = "INSERT INTO con_perfil_modulo VALUES($li_id_modulo, $li_id_perfil, $li_valor);";
				//echo " GRABANDO EN MODULO_PERFIL : ($sql_save) <BR><BR>";
				$res_save = pg_exec($conexion,$sql_save);
				}
		
			}
		
		}
}
?>

<?
	$sql= "Select * From con_nivel Order by id_nivel;";
	$resultado_query_nivel= pg_exec($conexion,$sql);
	$total_filas_nivel    = pg_numrows($resultado_query_nivel);
	
	$sql= "Select * From con_modulo Order by nombre;";
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);

	// Query para Obtener los Perfiles
	
	$sql= "Select * From perfil Order by id_perfil;";
	$resultado_query_perfil= pg_exec($conexion,$sql);
	$total_filas_perfil= pg_numrows($resultado_query_perfil);

	
	$ls_sql_perfil = "";
	For ($x=0; $x < $total_filas_perfil; $x++)
	{
		$ls_sql_perfil = $ls_sql_perfil . ",SUM(CASE WHEN TRIM(B.id_perfil) = '".TRIM(pg_result($resultado_query_perfil, $x, 0))."' then 1 else 0 end),SUM(CASE WHEN TRIM(B.id_perfil) = '".TRIM(pg_result($resultado_query_perfil, $x, 0))."' then B.id_nivel else 0 end) As Valor  ";
			
	}
	
	$ls_sql = $ls_sql . "SELECT A.ID_MODULO, A.NOMBRE  ";
	$ls_sql = $ls_sql . $ls_sql_perfil;
	$ls_sql = $ls_sql . "FROM con_modulo A,  ";
	$ls_sql = $ls_sql . "con_perfil_modulo B ";
	$ls_sql = $ls_sql . "WHERE A.id_modulo = B.id_modulo ";
	$ls_sql = $ls_sql . "GROUP BY A.id_modulo, A.nombre  ";
	$ls_sql = $ls_sql . "ORDER BY 2";
	
	//echo("SQL : $ls_sql <BR>");
	$resultado_query_seleccion= pg_exec($conexion,$ls_sql);
	$total_filas_seleccion = pg_numrows($resultado_query_seleccion);
	pg_close($conexion);
	//echo $ls_sql;

?>


<html>
<head>
<title>MODULOS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../../../css/objeto.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<form name="form1" method="post" action="">
  <table width="80%" border="0" align="center" cellspacing="0" cellpadding="0">
    <tr> 
      <td class="linea_datos_02"> 
        <div align="center"><font size="2"><b>A CONTINUACION SE INGRESARAN LOS 
          ACCESOS PARA LOS MODULOS, SEGUN SU PERFIL.</b></font></div>
      </td>
    </tr>
  </table>
  <table width="80%" border="1" align="center" cellspacing="0" cellpadding="0">
    <tr> 
      <td class="linea_datos_05" colspan="<?=($total_filas_perfil + 1)?>">RESULTADOS 
        : <?echo $total_filas?> MODULOS Y <?echo $total_filas_perfil?> PERFILES</td>
    </tr>
    <tr> 
      <td class="linea_datos_02" width="33%"> <div align="left">NOMBRE MODULO</div></td>
      <?
	For ($x=0; $x < $total_filas_perfil; $x++)
	{
	?>
      <td valign="bottom" class="linea_datos_02"> <div align="center"> 
          <?
		  $ls_nombre_perfil= Trim(pg_result($resultado_query_perfil, $x, 1));
		  ?>
          <?
			For($i=0; $i<strlen($ls_nombre_perfil); $i++)
			{
			?>
          <b> 
          <?=substr($ls_nombre_perfil,$i,1)?>
          <br>
          </b> 
          <?
			} 
			?>
        </div></td>
      <?
	}
	?>
    </tr>
    <?
	For ($j=0; $j < $total_filas_seleccion; $j++)
	{
	?>
    <tr> 
      <td class="membrete_datos" width="33%"> <div align="left">&nbsp; <?print pg_result($resultado_query_seleccion, $j, 1);?> 
        </div></td>
      <?
	$li_salto = 2;
	$li_salto_col = 3;
	For ($x=0; $x < $total_filas_perfil; $x++)
	{
	?>
      <td class="membrete_datos" > <div align="center"> 
          <?
		  $li_chek = pg_result($resultado_query_seleccion, $j, $li_salto_col);
		  ?>
          <input type="hidden" name="hf_id_modulo_<?=($j)?>" value="<?=pg_result($resultado_query_seleccion, $j, 0);?>">
          <?If($li_chek == 1)
		  {
		  ?>
          <input type="checkbox" name="tf_valor_<?=($j)?>_<?=($x)?>" value="1" checked>
          <?
		  }Else{
		  ?>
          <input type="checkbox" name="tf_valor_<?=($j)?>_<?=($x)?>" value="1">
          <?
		  }
		  ?>
          <input type="hidden" name="hf_id_perfil_<?=($j)?>_<?=($x)?>" value="<?=pg_result($resultado_query_perfil, $x, 0);?>">
        </div></td>
      <?
	$li_salto_col = $li_salto_col + 2;
	$li_salto = $li_salto + 2;
	}
	?>
    </tr>
    <?
	}
	pg_freeresult($resultado_query_seleccion);
	?>
  </table>
  <br>
  <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td> 
        <div align="center">
          <input type="submit" name="cb_save" value="Grabar Ingreso &gt;&gt;" class="cb_submit_9_x_150" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff'>
        </div>
      </td>
    </tr>
  </table>
  <input type="hidden" name="hf_total_j" value="<?=($total_filas)?>">
  <input type="hidden" name="hf_total_x" value="<?=($total_filas_perfil)?>">
  <br>
  <br>
</form>
</body>
</html>
<Script>
function Limpiar(valor)
{
valor.value = ''
}

function Numero()
{
var key = window.event.keyCode;
if (key < 40 || key > 57)
{
window.event.keyCode=0;
}
}
</Script>
