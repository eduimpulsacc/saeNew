
<?

header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();

require "../class_reporte/class_motor.php";

$ob_motor = new Motor($_IPDB,$_ID_BASE);


$rs_cargo 	= $ob_motor->busca_cargo(0);

$rs_periodo = $ob_motor->busca_periodo($_ANO);

$rs_ano 	= $ob_motor->Anos($_INSTIT);

$rs_instit = $ob_motor->InstitucionNacional($_NACIONAL);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>

<script>

function carga_periodo(ano){
	var dato = ano.split('-');
	var parametros ="funcion=periodo&ano1="+dato[0];

	$.ajax({
		url:'mod/reportes/reporte_docente/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
				//alert(data)
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#periodo').html(data);
				}
			}
	})
}

function carga_pauta(){

	var ano = $("#cmbANO").val();
	var periodo = $("#cmbPERIODO").val();
	var dato = ano.split('-');
	var datop = periodo.split('-');
	var parametros ="funcion=pauta&ano1="+dato[0]+"&periodo="+datop[0];
	
	$.ajax({
		url:'mod/reportes/reporte_docente/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
				//alert(data);
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#pauta').html(data);
				}
			}
	})
}
function carga_empleado(cargo){
	
	var dato = cargo.split('-');
	var plantilla = $("#cmbPAUTA").val();
	var dato2 = plantilla.split('-');
	var ano = $("#cmbANO").val();
	var dato_ano=ano.split('-');
	var periodo = $("#cmbPERIODO").val();
	var dato_periodo = periodo.split('-');

	var parametros ='funcion=empleado&cargo='+dato[0]+"&plantilla="+dato2[0]+"&ano1="+dato_ano[0]+"&periodo="+dato_periodo[0];
	//alert(parametros);
	$.ajax({
		url:'mod/reportes/reporte_docente/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
				//alert(data);
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#empleado').html(data);
				}
			}
	})
	//carga_pauta(cargo);
}

function carga_anos(rdb){
	var parametros='funcion=anos&rdb='+rdb;

	$.ajax({
		url:'mod/reportes/reporte_docente/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
				//alert(data)
				if(data==0){
					alert("ERROR AL CARGAR11");	
				}else{
					$('#ano').html(data);
				}
			}
	})
	
}

function carga_cargos(dato){
	//alert(dato);
	var cargo = dato.split("-");
	var parametros="funcion=cargos&cargo="+cargo[1];
	
	$.ajax({
		url:'mod/reportes/reporte_docente/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
				//alert(data)
				if(data==0){
					alert("ERROR AL CARGAR");	
				}else{
					$('#cargo').html(data);
				}
			}
	})	
}


function Accion(){
	var opcion=$("input[name='rdTIPO']:checked").val(); 	
	if(opcion==1){
		document.form.action="mod/reportes/reporte_docente/printReporteDocente.php";
	}else{
		document.form.action="mod/reportes/cuadroevaluaciones/printCuadroEvaluaciones.php";
	}
	document.form.submit(true);
}


</script>
</head>

<body><br />
<br />
<form name="form" action="" method="post" target="_blank">
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
					  <select name="cmbANO" id="cmbANO" class="ddlb_x" onchange="carga_periodo(this.value)">
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
                    <select name="cmbPERIODO" class="ddlb_x" onchange='carga_pauta()'>
                        <option value="0">seleccione</option>
                    </select>
					</td></tr>
                </table>          
                </div>      
                </td>
			    </tr>
                <tr>
			    <td class="textosimple">Pauta de Evaluaci�n</td>
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
				<td width="141" class="textosimple">Cargo</td>
				<td width="409" colspan="2"><div id="cargo">
                    <table width="100%" border="0">
                      <tr>
                        <td><select name="cmbCARGO" class="ddlb_x" onchange="carga_empleado(this.value)">
					<option value="0">seleccione</option>
				  </select></td>
                      </tr>
                    </table>
					</div>
                
                </td>
			  </tr>
			  <tr>
				<td class="textosimple">Empleado</td>
				<td colspan="2" class="textosmediano">
				<div id="empleado">
				<table border="0">
					<tr><td>
				  <select name="cmbEMPLEADO" id="cmbEMPLEADO" class="ddlb_x">
					<option value="0">seleccione</option>
				  </select>
				  </td></tr></table>
				 </div>				</td>
			  </tr>
			  
			  <tr>
				<td class="textosimple">Tipo</td>
				<td colspan="2" class="textosimple"><input type="radio" name="rdTIPO" id="rdTIPO1" value="1" checked="checked"/>
				  Evaluacion Final 
			      <input type="radio" name="rdTIPO" id="rdTIPO2" value="0"/>
			      Cuadro Estadistico</td>
			  </tr>
			  <tr>
				<td colspan="3" class="textosimple"><div align="right">
				  <input name="cb_ok" class="botonXX"  type="button" value="Buscar"  onclick="Accion();"/>
				</div></td>
				</tr>
			  <tr>
			    <td colspan="2" class="textosimple"><!--<strong>NOTA:</strong> Por disposici�n de la Uni�n Central, los reportes ser�n emitidos solamente si se cumple con m�s del 90% de las evaluaciones--></td>
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
