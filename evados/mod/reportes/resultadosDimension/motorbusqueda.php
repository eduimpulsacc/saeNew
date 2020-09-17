
<?

header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();

require "../class_reporte/class_motor.php";

$ob_motor = new Motor($_IPDB,$_ID_BASE);

$rs_instit = $ob_motor->InstitucionNacional($_NACIONAL);

$rs_cargo 	= $ob_motor->busca_cargo(0);

//$rs_periodo = $ob_motor->busca_periodo($_ANO);

$rs_ano 	= $ob_motor->Anos($_INSTIT);



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>

<script>


function carga_anos(rdb){
	var parametros ="funcion=ano&rdb="+rdb;
	//alert(parametros);
	$.ajax({
		url:'mod/reportes/cuadroevaluaciones/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#ano').html(data);
				}
			}
	})	
}
function carga_periodo(ano){
	
	var dato = ano.split('-');
	//alert(dato);
	var parametros ="funcion=periodo&ano1="+dato[0];
	//alert(parametros);
	$.ajax({
		url:'mod/reportes/cuadroevaluaciones/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#periodo').html(data);
				}
			}
	})
}

function carga_pauta(cargo){
	
	var dato = cargo.split(',');
	var parametros ="funcion=pauta&cargo="+dato[0];
	//alert(parametros);
	$.ajax({
		url:'mod/reportes/cuadroevaluaciones/cont_motor.php',
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
/*function carga_empleado(cargo){
	
	<? 	if($_PERFIL==45 || $_PERFIL==43){?>
		var rdb = $('#cmbINSTIT').val();
		<? 	}else{ ?>
		var rdb=<?=$_INSTIT;?>
	<? 	} ?>
	
	

	var dato = cargo.split(',');
	var parametros ='funcion=empleado&cargo='+dato[0]+'&rdb='+rdb;
	//alert(parametros);
	$.ajax({
		url:'mod/reportes/cuadroevaluaciones/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#empleado').html(data);
				}
			}
	})
	//carga_pauta(cargo);
}*/

function carga_empleado(cargo){
	
	<? 	if($_PERFIL==45 || $_PERFIL==43){?>
		var rdb = $('#cmbINSTIT').val();
		<? 	}else{ ?>
		var rdb=<?=$_INSTIT;?>
	<? 	} ?>
	
	
	var ano =$("#cmbANO").val();
	var per = $("#cmbPERIODO").val();
	var periodo = per.split('-');
	var dato = cargo.split(',');
	var anios = ano.split('-');
	var parametros ='funcion=empleado&cargo='+dato[0]+'&rdb='+rdb+"&ano="+anios[0]+"&periodo="+periodo[0];


	$.ajax({
		url:'mod/reportes/cuadroevaluaciones/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#empleado').html(data);
				}
			}
	})

}



</script>
</head>

<body><br />
<br />
<form name="form" action="mod/reportes/resultadosDimension/printResultadosDimension.php" method="post" target="_blank">
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
            <? if($_PERFIL==43 || $_PERFIL==45){?>
			  <tr>
			    <td class="textosimple">Institucion</td>
			    <td colspan="2">
                <select name="cmbINSTIT" id="cmbINSTIT" class="ddlb_x" onchange="carga_anos(this.value)">
					<option value="0">seleccione</option>
					<? 
					for($x=0;$x<pg_numrows($rs_instit);$x++){
						$fila_a = pg_fetch_array($rs_instit,$x);?>
						<option value="<? echo ($fila_a['rdb']);?>"><?=$fila_a['nombre_instit'];?></option>
					<? } ?>
				  </select></td>
			    </tr>
                <tr>
			    <td class="textosimple">A&ntilde;o Academico</td>
			    <td colspan="2"> <div id="ano">
					<table border="0">
						<tr><td>
					  <select name="cmbANO" id="cmbANO" class="ddlb_x">
						<option value="0">seleccione</option>
					  </select>
					  </td></tr></table>
				 </div></td>
			    </tr>
             <? }else{ ?>
			  <tr>
			    <td class="textosimple">A&ntilde;o Academico</td>
			    <td colspan="2"> <select name="cmbANO" id="cmbANO" class="ddlb_x" onchange="carga_periodo(this.value)">
					<option value="0">seleccione</option>
					<? 
					for($x=0;$x<pg_numrows($rs_ano);$x++){
						$fila_a = pg_fetch_array($rs_ano,$x);?>
						<option value="<? echo ($fila_a['id_ano']."-".$fila_a['nro_ano']);?>"><?=$fila_a['nro_ano'];?></option>
					<? } ?>
				  </select></td>
			    </tr>
             <? } ?>
			  <tr>
			    <td class="textosimple">Periodo</td>
			    <td colspan="2">
				<div id="periodo">
                <table border="0">
                	<tr><td>
                    <select name="cmbPERIODO" id="cmbPERIODO" class="ddlb_x">
                        <option value="0">seleccione</option>
                    </select>
					</td></tr>
                </table>          
                </div>      
                </td>
			    </tr>
			  <tr>
				<td width="141" class="textosimple">Cargo</td>
				<td width="409" colspan="2"><div align="left"><span class="textosmediano">
				  <select name="cmbCARGO" class="ddlb_x" onchange="carga_pauta(this.value)">
					<option value="0">seleccione</option>
					<? //$rs_bloque = $ob_motor->Bloque();
					for($i=0;$i<pg_numrows($rs_cargo);$i++){
						$fila = pg_fetch_array($rs_cargo,$i);?>
						<option value="<? echo $fila['id_cargo'];?>,<? echo $fila['nombre_cargo'];?>"><?=$fila['nombre_cargo'];?></option>
					<? } ?>
				  </select>
				</span></div></td>
			  </tr>
			  
			  <tr>
			    <td class="textosimple">Pauta de Evaluación</td>
			    <td colspan="2" class="textosmediano" >
			      <div id="pauta">
					<table border="0">
						<tr><td>
					  <select name="cmbPAUTA" id="cmbPAUTA" class="ddlb_x">
						<option value="0">seleccione</option>
					  </select>
					  </td></tr></table>
				 </div>
                </td>
		      </tr>
			  <tr>
				<td class="textosimple">&nbsp;</td>
				<td colspan="2" class="textosimple">&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="3" class="textosimple"><div align="right">
				   <input name="cb_ok" class="botonXX"  type="submit" value="Buscar"  />
				</div></td>
				</tr>
			  <tr>
			    <td colspan="2" class="textosimple"><strong>NOTA:</strong> Por disposición de la Unión Central, los reportes serán emitidos solamente si se cumple con más del 90% de las evaluaciones</td>
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
