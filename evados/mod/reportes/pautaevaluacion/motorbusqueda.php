<? 
session_start();
require "../../../class/Membrete.class.php";
$ob_membrete = new Membrete($_IPDB,$_DBNAME);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script>
function listarEvaluados(cargo){
	var parametros ="funcion=empleado&cargo="+cargo;
	//alert(parametros);
	$.ajax({
		url:'mod/reportes/pautaevaluacion/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#evaluado').html(data);
				}
			}
	})
}
</script>
</head>

<body><br />
<br />
<form name="form" action="mod/reportes/pautaevaluacion/printPautaEvaluacion.php" method="post" target="_blank">
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
				<td width="141" class="textosmediano">Cargo</td>
				<td width="409" colspan="2"><div align="left"><span class="textosmediano">
				  <select name="cmbCARGO" id="cmbCARGO" onchange="listarEvaluados(this.value)">
		<option value="0">seleccione</option>
		<? 	$sql="SELECT DISTINCT ca.id_cargo,nombre_cargo FROM cargos ca INNER JOIN evados.eva_evaluado eva ON ca.id_cargo=eva.id_cargo ORDER BY nombre_cargo ASC";
			$rs_cargo = @pg_exec($ob_membrete->Conec->conectar(),$sql) or die("select fallo:".$sql);
		for($i=0;$i<@pg_numrows($rs_cargo);$i++){
			$fila=pg_fetch_array($rs_cargo,$i);?>
		<option value="<?=$fila['id_cargo'];?>"><?=$fila['nombre_cargo'];?></option>
		<? } ?>
	</select>
				</span></div></td>
			  </tr>
			  <tr>
				<td class="textosmediano">Nombre Evaluado</td>
				<td colspan="2"><div id="evaluado"><span class="textosmediano">
				  <select name="cmbPAUTA" class="ddlb_x">
					<option value="0">seleccione</option>
				  </select>
				</span></div></td>
			  </tr>
			  <tr>
				<td class="textosmediano">Datos</td>
				<td colspan="2"><input name="radiobutton" type="radio" value="radiobutton" />
				  Ponderado 
				  <input name="radiobutton" type="radio" value="radiobutton" />
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
