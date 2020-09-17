
<?

header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();

require "../class_reporte/class_motor.php";



$ob_motor = new Motor($_IPDB,$_ID_BASE);


$rs_ano = $ob_motor->Anos($_INSTIT);


$rs_corp = $ob_motor->corporacion($_INSTIT);
$num_corp=pg_fetch_array($rs_corp,0);
$num_corp[0];

$rs_instit = $ob_motor->busca_institucion2($num_corp[0]);


$rs_mision= $ob_motor->misiones();



//$rs_periodo = $ob_motor->busca_periodo($_ANO);
$perfil	= $_PERFIL;
$corp=$_CORPORACION;
echo"<pre>";
//print_r($GLOBALS);
echo"</pre>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>

<script>
function carga_periodo(ano){
	var parametros ="funcion=periodo&ano="+ano;
	//alert(parametros);
	$.ajax({
		url:'mod/reportes/relacion_evaluacion/cont_motor.php',
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



function carga_anos(rdb){
	var parametros ="funcion=carga_ano&rdb="+rdb;
	//alert(parametros);
	$.ajax({
		url:'mod/reportes/relacion_evaluacion/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
					//alert(data);
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#anos').html(data);
				}
			}
	})
}

function carga_instit(num_corp){
	
	var parametros ="funcion=carga_intit&num_corp="+num_corp;
	//alert(parametros);
	$.ajax({
		url:'mod/reportes/relacion_evaluacion/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
					//alert(data);
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#intitucion').html(data);
				}
			}
	})
}





</script>
</head>

<body><br />
<br />
<form name="form" action="mod/reportes/relacion_evaluacion/printReporteRelaciones.php" method="post" target="_blank">
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
			<td height="27">
            <table width="550" border="0" cellspacing="0" cellpadding="3">
            
            
               <?php
            	if($perfil==45){
			?>
            
             <tr>
				<td width="141" class="textosmediano">Misi&oacute;n</td>
				<td width="409" colspan="2">
                <div align="left"><span class="textosmediano">
				  <select name="cmbMIS" class="ddlb_x" onchange="carga_instit(this.value)" >
					<option value="0">seleccione</option>
					<? 
					for($i=0;$i<pg_numrows($rs_mision);$i++){
						$fila = pg_fetch_array($rs_mision,$i);?>
						<option value="<? echo $fila['num_corp'];?>"><?=$fila['nombre_corp'];?></option>
					<? } ?>
				  </select>
				</span></div></td>
			  </tr>
            
            
            <tr>
				<td width="141" class="textosmediano">Instituci&oacute;n</td>
				<td width="409" colspan="2">
                <div align="left" id="intitucion">
                <span class="textosmediano">
				  <select name="cmbINS" class="ddlb_x" onchange="carga_anos(this.value)" >
					<option value="0">seleccione</option>
				  </select>
				</span></div></td>
			  </tr>
            <?php }?>
            
            
            <?php
            	if($perfil==43){
			?>
            <tr>
				<td width="141" class="textosmediano">Instituci&oacute;n</td>
				<td width="409" colspan="2">
                <div align="left"><span class="textosmediano">
				  <select name="cmbINS" class="ddlb_x" onchange="carga_anos(this.value)" >
					<option value="0">seleccione</option>
					<? 
					for($i=0;$i<pg_numrows($rs_instit);$i++){
						$fila = pg_fetch_array($rs_instit,$i);?>
						<option value="<? echo $fila['rdb'];?>"><?=$fila['nombre_instit'];?></option>
					<? } ?>
				  </select>
				</span></div></td>
			  </tr>
            <?php }?>
             <tr>
				<td width="141" class="textosmediano">Año</td>
				<td width="409" colspan="2">
                <div align="left" id="anos">
                <span class="textosmediano">
				  <select name="cmbANO" class="ddlb_x" onchange="carga_periodo(this.value)">
					<option value="0">seleccione</option>
					<? //$rs_bloque = $ob_motor->Bloque();
					for($i=0;$i<pg_numrows($rs_ano);$i++){
						$fila = pg_fetch_array($rs_ano,$i);?>
						<option value="<? echo $fila['id_ano'];?>"><?=$fila['nro_ano'];?></option>
					<? } ?>
				  </select>
				</span></div></td>
			  </tr>
			  <tr>
              	
                
                        <td class="textosmediano">Periodo</td>
                        <td><div id="periodo">
                  <table width="550" border="0" cellspacing="0" cellpadding="3">
                	<tr>
                    <td>
                        <select name="cmbPERIODO" class="ddlb_x">
                            <option value="0">seleccione</option>
                            <? 
                            for($x=0;$x<pg_numrows($rs_periodo);$x++){
                                $fila_p = pg_fetch_array($rs_periodo,$x);?>
                                <option value="<? echo ($fila_p['id_periodo']."-".$fila_p['nombre_periodo']);?>"><?=$fila_p['nombre_periodo'];?></option>
                            <? } ?>
                          </select></td>
                        </tr>
                        </table>
                        </div>
                       
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
