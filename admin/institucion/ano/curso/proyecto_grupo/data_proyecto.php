<?php 
require('../../../../../util/header.inc');
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	

$sql = "SELECT * FROM alumno_proyecto WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_proy=".$cmbPROYECTO." AND rut_alumno=".$cmbALUMNO."
and fecha_reporte='".$fechar."'
";
$rs_existe = @pg_exec($conn,$sql);
$fila_alumno = @pg_fetch_array($rs_existe,0);
	
if($cmbALUMNO!=0 && $cmbPROYECTO!=0 && $caso!=2){
		$caso=1;

	}
	
	function CambioFechaDisplay($fecha)   //    cambia fecha del tipo   aaaa/mm/dd  ->  dd/mm/aaaa   para mostrarlo en pantalla
{
	$retorno="";
	if(strlen($fecha) <10 )
		return $retorno;
	$d=substr($fecha,8,2);
	$m=substr($fecha,5,2);
	$a=substr($fecha,0,4);
	if (checkdate($m,$d,$a))
		$retorno=$d."/".$m."/".$a;
	else
		$retorno="";
	return $retorno;
}

function CambioFecha($fecha)   //    cambia fecha del tipo  dd/mm/aaaa  ->  aaaa/mm/dd    para poder hacer insert y update
{
	$retorno="";
	if(strlen($fecha) !=10)
		return $retorno;
	$d=substr($fecha,0,2);
	$m=substr($fecha,3,2);
	$a=substr($fecha,6,4);
	if (checkdate($m,$d,$a))
		$retorno=$a."-".$m."-".$d;
	else
		$retorno="";
	return $retorno;
}

?>


<script>



$(document).ready(function() {
	$( "#fecha_reporte" ).datepicker({
    'dateFormat':'dd/mm/yy',
	firstDay: 1,
	yearRange: "2000:<?php echo date("Y") ?>",
	dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
    // Dias cortos en castellano
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    // Nombres largos de los meses en castellano
    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
    // Nombres de los meses en formato corto 
    monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dec" ],
    onSelect: function(dateText){
        var seldate = $(this).datepicker('getDate');
		seldate = seldate.toDateString();
        seldate = seldate.split(' ');
		//alert(dateText);
		var dataString = 'date='+dateText+"&cmbPROYECTO="+$('#cmbPROYECTO').val()+"&cmbALUMNO="+$('#cmbALUMNO').val()+"&fec_ant="+$('#fa2').val()+"&caso="+$('#caso').val();
           
		    $.ajax({
                type: "POST",
                url: "ver_fecha.php",
                data: dataString,
                success: function(data) {
                   console.log(data);
				  if(data==1){
					 alert("Ya existen registros asociados a esa fecha. Por favor seleccione otra");
					 $('#sub').attr('disabled','disabled');
					 }else{
					 $('#sub').attr('disabled','');
					}
                }
            });
		 
    }
	
});

});

	


</script>
<table width="650" border="0" align="center">
                                  <tr>
                                    <td><div align="right">
                                      <input type="submit" name="Submit" value="GUARDAR" class="botonXX" id="sub">
										&nbsp;<input type="button" name="button" value="CANCELAR" class="botonXX" onClick="window.location='fichaProyecto.php'">
                                    </div></td>
                                  </tr>
                                </table>
<table width="650" border="0" align="center" cellpadding="3" cellspacing="5">
                                  <tr>
                                    <td colspan="6" bgcolor="#CCCCCC"><span class="Estilo16">FECHA</span></td>
                                  </tr>
                                  <tr>
                                    <td colspan="6" >
                                   <input name="fecha_reporte" type="text" id="fecha_reporte" readonly value="<?php echo ($caso==2)?CambioFechaDisplay($fila_alumno['fecha_reporte']):"" ?>"> <input id="fa2" name="fa2" type="text" hidden="" />
                                   <span class="Estilo25">(Seleccione una fecha)</span></td>
                                  </tr>
                                  <tr>
                                    <td colspan="6" bgcolor="#CCCCCC"><span class="Estilo16">TRASTORNO</span></td>
                                  </tr>
								
                                  <tr>
                                    <td colspan="6" class="Estilo25"><span class="Estilo21">
                                      <? 	 $sql = "SELECT id_dignos,nombre FROM diagnostico WHERE  tipo in(select tipo from proyecto_grupo where id_proy=".$cmbPROYECTO.")  AND rdb=".$institucion." ORDER BY nombre ASC";
											$rs_diag = @pg_exec($conn,$sql);
											
											if($caso==1){ ?>
                                      <select name="cmbDIAGNOSTICO">
                                        <option value="0">seleccione</option>
                                        <? for($i=0;$i<@pg_numrows($rs_diag);$i++){
														$fila_dia = @pg_fetch_array($rs_diag,$i); 
														if($cmbDIAGNOSTICO==$fila_dia['id_dignos']){?>
                                        <option value="<?=$fila_dia['id_dignos'];?>" selected="selected">
                                          <?=$fila_dia['nombre'];?>
                                        </option>
                                        <? 	}else{ ?>
                                        <option value="<?=$fila_dia['id_dignos'];?>">
                                          <?=$fila_dia['nombre'];?>
                                        </option>
                                        <? }
													}?>
                                      </select>
                                      <? }elseif($caso==2){ ?>
                                      <select name="cmbDIAGNOSTICO">
                                        <option value="0">seleccione</option>
                                        <? for($i=0;$i<@pg_numrows($rs_diag);$i++){
														$fila_dia = @pg_fetch_array($rs_diag,$i); 
														if($fila_alumno['id_dignos']==$fila_dia['id_dignos']){?>
                                        <option value="<?=$fila_dia['id_dignos'];?>" selected="selected">
                                          <?=$fila_dia['nombre'];?>
                                        </option>
                                        <? 	}else{ ?>
                                        <option value="<?=$fila_dia['id_dignos'];?>">
                                          <?=$fila_dia['nombre'];?>
                                        </option>
                                        <? }
													}?>
                                      </select>
                                      <? }elseif($caso==4){
												  $sql = "SELECT id_dignos,nombre FROM diagnostico WHERE rdb=".$institucion." AND id_dignos=".$fila_alumno['id_dignos']." ORDER BY nombre ASC";
												 $rs_diag = @pg_exec($conn,$sql);
												 $fila_diag = @pg_fetch_array($rs_diag,0);
											 		echo $fila_diag['nombre'];	
											 } ?>
                                    </span></td>
                                  </tr>
								  
                                  <tr>
                                    <td colspan="6"><span class="Estilo22"></span></td>
                                  </tr>
                                  <tr>
                                    <td colspan="6" bgcolor="#CCCCCC"><span class="Estilo16">AVANCES</span></td>
                                  </tr>
                                  <tr>
                                    <td width="133" class="Estilo25"><span class="Estilo25">Mejora rendimiento<br> 
                                    Lenguaje </span></td>
                                    <td class="Estilo25">
									<? if($caso==1){?>	
										<select name="mejora_leng">
											<option value="1">Mejora rendimiento</option>
											<option value="2">Disminuye rendimiento</option>
											<option value="3">Sin avance</option>
										</select>								
										
									<? }elseif($caso==2){?>	
									<select name="mejora_leng">
											<option value="1" <? echo ($fila_alumno['mejora_lenguaje']==1)?"selected":""?>>Mejora rendimiento</option>
											<option value="2" <? echo ($fila_alumno['mejora_lenguaje']==2)?"selected":""?>>Disminuye rendimiento</option>
											<option value="3" <? echo ($fila_alumno['mejora_lenguaje']==3)?"selected":""?>>Sin avance</option>
										</select>	
									
									<? }elseif($caso==4){
												if($fila_alumno['mejora_lenguaje']==1){
													echo "Mejora rendimiento";
												}elseif($fila_alumno['mejora_lenguaje']==2){
													echo "Disminuye rendimiento";
												}else{
													echo "Sin avance";
												}
									   		}		
									 	?>									</td>
                                    <td colspan="3" class="Estilo25"><span class="Estilo25">Mejora rendimiento <br>
  Matem&aacute;ticas</span></td>
                                    <td width="44" class="Estilo25">
									  <div align="left">
									    <? if($caso==1){?>	
										<select name="mejora_mat">
											<option value="1">Mejora rendimiento</option>
											<option value="2">Disminuye rendimiento</option>
											<option value="3">Sin avance</option>
										</select>	
									  
								        <? }elseif($caso==2){?>	
										<select name="mejora_mat">
											<option value="1" <? echo ($fila_alumno['mejora_matematica']==1)?"selected":""?>>Mejora rendimiento</option>
											<option value="2" <? echo ($fila_alumno['mejora_matematica']==2)?"selected":""?>>Disminuye rendimiento</option>
											<option value="3" <? echo ($fila_alumno['mejora_matematica']==3)?"selected":""?>>Sin avance</option>
										</select>	
									  
								        <? }elseif($caso==4){
												if($fila_alumno['mejora_matematica']==1){
													echo "Mejora rendimiento";
												}elseif($fila_alumno['mejora_matematica']==2){
													echo "Disminuye rendimiento";
												}else{
													echo "Sin avance";
												}
									   		}		
								 	?>
							          </div></td>
                                  </tr>
                                  <tr>
                                    <td colspan="6"><span class="Estilo22"></span></td>
                                  </tr>
                                  <tr>
                                    <td colspan="6" bgcolor="#CCCCCC"><span class="Estilo16">SITUACI&Oacute;N</span></td>
                                  </tr>
                                  <tr>
                                    <td><span class="Estilo25">Aprobado</span></td>
                                    <td class="Estilo25">
									<? if($caso==1){?>	
										<input name="aprobado" type="checkbox" value="1">
									<? }elseif($caso==2){?>		
										<input name="aprobado" type="checkbox" value="1" <? if($fila_alumno['aprobado']==1) echo "checked=checked'";?>>
									<? }elseif($caso==4){
												if($fila_alumno['aprobado']==1)
													echo "SI";
												else
													echo "NO";
									   		}		
								 	?>									</td>
                                    <td width="143" class="Estilo25"><span class="Estilo25">Reprobado</span></td>
                                    <td width="20" class="Estilo25">
									<? if($caso==1){?>
										<input name="reprobado" type="checkbox" value="1">
									<? }elseif($caso==2){?>		
										<input name="reprobado" type="checkbox" value="1" <? if($fila_alumno['reprobado']==1) echo "checked=checked'";?>>
									<? }elseif($caso==4){
												if($fila_alumno['reprobado']==1)
													echo "SI";
												else
													echo "NO";
									   		}		
								 	?>									</td>
                                    <td width="113" class="Estilo25"><span class="Estilo25">Retirado</span></td>
                                    <td class="Estilo25">
									<? if($caso==1){?>
										<input name="retirado" type="checkbox" value="1">
									<? }elseif($caso==2){?>	
										<input name="retirado" type="checkbox" value="1" <? if($fila_alumno['retirado	']==1) echo "checked=checked'";?>>
									<? }elseif($caso==4){
												if($fila_alumno['retirado']==1)
													echo "SI";
												else
													echo "NO";
									   		}		
								 	?>									</td>
                                  </tr>
                                  <tr>
                                    <td colspan="6"><span class="Estilo22"></span></td>
                                  </tr>
                                  <tr>
                                    <td colspan="6" bgcolor="#CCCCCC"><span class="Estilo16">Informe</span></td>
                                  </tr>
                                  <tr>
                                    <td><span class="Estilo25">Instituci&oacute;n que emite Informe </span></td>
                                    <td colspan="3"><span class="Estilo25">
                                      <? if($caso==1){?>
                                      <input name="txtINSTIT" type="text" value="">
                                      <? }elseif($caso==2){ ?>
                                      <input name="txtINSTIT" type="text" value="<?=$fila_alumno['institucion'];?>">
                                      <? }elseif($caso==4){
											echo $fila_alumno['institucion'];	
								   		}		
								 	?>
                                    </span></td>
                                    <td colspan="2" class="Estilo25">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td colspan="6"><span class="Estilo25">Observaciones</span></td>
                                  </tr>
                                  <tr>
                                    <td colspan="6"><span class="Estilo25">
									<? if($caso==1){?>
										<textarea name="txtOBS" cols="50" rows="15"></textarea>
									<? }elseif($caso==2){ ?>		
										<textarea name="txtOBS" cols="50" rows="15"><?=$fila_alumno['obs'];?></textarea>
									<? }elseif($caso==4){
											echo nl2br($fila_alumno['obs']);	
								   		}		
								 	?>	
									</span></td>
                                  </tr>
                                </table>
                                
