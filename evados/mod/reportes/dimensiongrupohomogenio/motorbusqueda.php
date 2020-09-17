
<?

header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();

require "../class_reporte/class_motor.php";

$ob_motor = new Motor($_IPDB,$_ID_BASE);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>

<script>
function carga_pauta(bloque){
	var parametros ="funcion=pauta&bloque="+bloque;
	//alert(parametros);
	$.ajax({
		url:'mod/reportes/dimensiongrupohomogenio/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#pauta').html(data);
				}
			}
	})
}
function cargar_dimension(pauta,nacional){
	var parametros ='funcion=dimension&nacional='+nacional+'&plantilla='+pauta;
	//alert(parametros);
	$.ajax({
		url:'mod/reportes/dimensiongrupohomogenio/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#dimension').html(data);
				}
			}
	})
}

function cargar_funcion(nacional){
	var parametros ='funcion=funciones&nacional='+nacional;
	//alert(parametros);
	$.ajax({
		url:'mod/reportes/dimensiongrupohomogenio/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#funsion').html(data);
				}
			}
	})
}

function cargar_indicador(subarea,plantilla,area){
	var parametros ='funcion=indicador&plantilla='+plantilla+'&area='+area+'&subarea='+subarea;
	//alert(parametros);
	$.ajax({
		url:'mod/reportes/dimensiongrupohomogenio/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#indicador').html(data);
				}
			}
	})
}

</script>
</head>

<body><br />
<br />
<form name="form" action="mod/reportes/dimensiongrupohomogenio/printDimensionGrupo.php" method="post" target="_blank">
<table width="550" height="43" border="1" cellpadding="0" cellspacing="0" align="center" style="border-collapse:collapse">
	<tr><td>
		<table width="550" height="43" border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
			<td width="500" class="cuadro02" align="center">Buscador Avanzado</td>
		  </tr>
		  <tr>
			<td width="500" align="center">&nbsp;</td>
		  </tr>
		  <tr>
			<td height="27"><table width="550" border="0" cellspacing="0" cellpadding="3">
			  <tr>
				<td width="141" class="textosmediano">Grupo Homogenio          </td>
				<td width="409" colspan="2"><div align="left"><span class="textosmediano">
				  <select name="cmbGRUPO" class="ddlb_x" onchange="carga_pauta(this.value)">
					<option value="0">seleccione</option>
					<? $rs_bloque = $ob_motor->Bloque();
					for($i=0;$i<$rs_bloque;$i++){
						$fila = pg_fetch_array($rs_bloque,$i);?>
						<option value="<?=$fila['id_bloque'];?>"><?=$fila['nombre'];?></option>
					<? } ?>
				  </select>
				</span></div></td>
			  </tr>
			  <tr>
				<td class="textosmediano">Pauta de Evaluaci&oacute;n </td>
				<td colspan="2" class="textosmediano">
				<div id="pauta">
				<table border="0">
					<tr><td>
				  <select name="cmbPAUTA" id="cmbPAUTA" class="ddlb_x">
					<option value="0">seleccione</option>
				  </select>
				  </td></tr></table>
				 </div>				</td>
			  </tr>
			  <tr>
			    <td class="textosmediano">Dimension</td>
			    <td colspan="2" class="textosmediano" >
			      <div id="dimension">
					<table border="0">
						<tr><td>
					  <select name="cmbDIMENSION" id="cmbDIMENSION" class="ddlb_x">
						<option value="0">seleccione</option>
					  </select>
					  </td></tr></table>
				 </div>			    </td>
		      </tr>
			  <tr>
				<td class="textosmediano">Datos</td>
				<td colspan="2"><input name="tipo_dato" type="radio" value="1" />
				  Ponderado 
				  <input name="tipo_dato" type="radio" value="2" />
				  Sin Ponderar </td>
			  </tr>
			  <tr>
				<td colspan="3" class="textosmediano"><div align="right">
				  <input name="cb_ok" class="botonXX" onmouseover="this.style.background='FFFFD7';this.style.color='003b85'" onmouseout="this.style.background='#5c6fa9';this.style.color='ffffff'" type="submit" value="Buscar" />
				</div></td>
				</tr>
			</table></td>
		  </tr>
		</table>
	</td></tr>
</table>
</form>
<br />
<br />

</body>
</html>
