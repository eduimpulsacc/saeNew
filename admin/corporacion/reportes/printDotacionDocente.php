<?

include("../controlador/controlador_1.php");


$corporacion	= $_CORPORACION;
$ano		= $_POST['cmbANO'];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reporte Sostenedor Corporativo</title>
<link href="../estilo.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-image: url();
}
-->
</style>
<script language="javascript">
<!--

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<script>

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
	  
		  
</script>
<link href="../../../../../admin/corporacion/estilo.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo2 {font-weight: bold; background-color: #CCCCCC; text-align: center;}
.Estilo3 {font-family:Verdana, Arial, Helvetica, sans-serif; text-align:center; font-weight: bold; background-color: #CCCCCC;}
-->
</style>
</head>
<body>
<div id="capa0">
  <table width="650" border="0" align="center">
    <tr>
      <td><input type="button" name="Submit" value="VOLVER" onClick="javascript:history.back(1) " class="botonXX"/></td>
      <td><div align="right">
        <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" />
      </div></td>
	  
    </tr>
  </table>
</div>
<br />
<table width="750" height="843" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td height="113" valign="top">
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><img src="../images/linea2.jpg" width="730" height="4" /></td>
        </tr>
        <tr>
          <td rowspan="5"> <?  echo "<img src='../images/".$corporacion."_logo.jpg' >"; ?></td>
          <td class="membrete">&nbsp;</td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?=$nombre;?></div></td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?=$direc;?></div></td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?=$fono;?></div></td>
        </tr>
        <tr>
          <td class="membrete">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><img src="../images/linea.jpg" width="730" height="4" /></td>
        </tr>
      </table>
      <br />
      <br />
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
          <td class="titulo1">DOTACI&Oacute;N DOCENTE  <?=$ano;?></td>
        </tr>
      </table>
    <br />
	
	<?
	   
	   if($docente==1){
												$primera=0;
												for($i=0;$i<$cont;$i++){
													if(${"instit".$i}!="" and $primera==0){
														$rdb.=${"instit".$i};
														$primera=1;
													}elseif(${"instit".$i}!="" and $primera==1){
														$rdb.=",".${"instit".$i};
													}
												}
												$sql = "SELECT nombre_instit, rdb FROM institucion WHERE rdb in (".$rdb.")";
												$rs_instit = @pg_exec($conn,$sql);
												
										?>
													<br>
													<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
													<? for($x=0;$x<@pg_numrows($rs_instit);$x++){
															$fila_inst = @pg_fetch_array($rs_instit,$x);
									
														}
										
													?>
															
													  <tr>
														<td class="Estilo20"><b></b></td>
													  </tr>
													  <tr>
														<td>
														<table width="100%" border="1" cellpadding="5" cellspacing="0" class="tabla2">
											  <tr>
												<td colspan="11" class="celdas1">DOCENTES</td>
											  </tr>
											  <tr>
												<td class="celdas1">RBD</td>
												<td class="celdas1">INSTITUCI&Oacute;N</td>
												<td class="celdas1">HORAS<br />
												CONT.</td>
												<td class="celdas1">ART.69</td>
											  <td class="celdas1">HORAS<br />
												  AMPLIAC. <br />
												  SIMPLES</td>
												<td class="celdas1">HORAS<br />
												  AMPLIAC.<br />
												  JEC</td>
											  <td class="celdas1">TOTAL<br />
												  HORAS<br />
												  AULA</td>
												<td class="celdas1">HORAS<br />
												EXCED.</td>
											  </tr>
											  <? for($x=0;$x<@pg_numrows($rs_instit);$x++){
											  $fila_inst = @pg_fetch_array($rs_instit,$x);
											  	$sql = "SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_inst['rdb']." AND nro_ano=".$cmbANO."  ";
												$rs_ano = pg_exec($conn,$sql);
												$ano_inst = pg_result($rs_ano,0);
												
												if($ano_inst=="") $ano_inst=0;
																				
												$sql =" SELECT * FROM dotacion_docente a ";
												$sql.=" INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=".$fila_inst['rdb']." and";
												$sql.=" id_ano=".$ano_inst." AND cargo=5";
												$rs_empleado = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (DotacionDocente):".$sql);
										
							
											  ?>
												 <? 
												$sql_inst = "SELECT nombre_instit, rdb FROM institucion WHERE rdb in (".$rdb.")";
												$rs_instit = @pg_exec($conn,$sql_inst);
											
												 $fila_inst = @pg_fetch_array($rs_instit,$x);
												 
												 
											  	$sql = "SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_inst['rdb']." AND nro_ano=".$cmbANO."  ";
												$rs_ano = pg_exec($conn,$sql);
												$ano_inst = pg_result($rs_ano,0);
												
												if($ano_inst=="") $ano_inst=0;
																				
									
												$sql="SELECT COUNT(*) as cantidad,SUM(hrs_contrato) as contrato,SUM(art_69) as ";
												$sql.="art69,SUM(amp_simple) as simple,SUM(amp_jec) as amp_jec,SUM(total_aula) as ";
												$sql.="aula,SUM(hrs_excedente) as excedente FROM dotacion_docente WHERE";
												$sql.=" rdb=".$fila_inst['rdb']." and id_ano=".$ano_inst." AND cargo=5";
												$rs_empleado = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (DotacionDocente):".$sql);
												
											 
												$fila_emp = @pg_fetch_array($rs_empleado,0);										 
												 
												 
												 ?>
											  <tr>
												<td class="text2"><div align="right">
													<?=$fila_inst['rdb'];?>
												</div></td>
												<td class="text2"><div align="left"><?=strtoupper($fila_inst['nombre_instit']);?></div></td>
												<td class="text2"><? if($fila_emp['contrato']==NULL){echo "0";}else{ echo $fila_emp['contrato'];}?></td>
												<td class="text2"><? if($fila_emp['art69']==NULL){echo "0";}else{ echo $fila_emp['art69'];}?></td>
												<td class="text2"><? if($fila_emp['simple']==NULL){echo "0";}else{ echo $fila_emp['simple'];}?></td>
												<td class="text2"><? if($fila_emp['amp_jec']==NULL){echo "0";}else{ echo $fila_emp['amp_jec'];}?></td>
												<td class="text2"><? if($fila_emp['aula']==NULL){echo "0";}else{ echo $fila_emp['aula'];}?></td>
												<td class="text2"><? if($fila_emp['excedente']==NULL){echo "0";}else{ echo $fila_emp['excedente'];}?></td>
											  </tr>
											 
											  <? 	$total_contrato_0 += $fila_emp['contrato'];
											  		$total_69_0 += $fila_emp['art69'];
													$total_simple_0 += $fila_emp['simple'];
													$total_jec_0 += $fila_emp['amp_jec'];
													$total_aula_0 += $fila_emp['aula'];
													$total_ex_0 += $fila_emp['excedente'];
													
											  } ?>
											  <tr>
												<td colspan="2" class="celdas2">TOTALES (<?=$i;?>)</td>
												<td class="celdas2"><?=$total_contrato_0;?></td>
												<td class="celdas2"><?=$total_69_0;?></td>
												<td class="celdas2"><?=$total_simple_0;?></td>
												<td class="celdas2"><?=$total_jec_0;?></td>
												<td class="celdas2"><?=$total_aula_0;?></td>
												<td class="celdas2"><?=$total_ex_0;?></td>
											  </tr>
											   
								 		</table>
														</td>
													  </tr>
													  <tr>
													  	<td>&nbsp;</td>
													  </tr>
													</table>
													
									
		
											<? }  ?>


	
    
			<? if($docente==2){
												$primera=0;
												for($i=0;$i<$cont;$i++){
													if(${"instit".$i}!="" and $primera==0){
														$rdb.=${"instit".$i};
														$primera=1;
													}elseif(${"instit".$i}!="" and $primera==1){
														$rdb.=",".${"instit".$i};
													}
												}
												$sql = "SELECT nombre_instit, rdb FROM institucion WHERE rdb in (".$rdb.")";
												$rs_instit = @pg_exec($conn,$sql);
												
												
												?>
											<br>
											<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
											<? for($x=0;$x<@pg_numrows($rs_instit);$x++){
													$fila_inst = @pg_fetch_array($rs_instit,$x);
											?>
											  <tr>
												<td class="Estilo20"><b></b></td>
											  </tr>
											  <tr>
												<td>
												<table width="100%" border="1" cellpadding="5" cellspacing="0" class="tabla2">
											  <tr>
												<td colspan="11" class="celdas1">DIRECTIVOS DOCENTES</td>
											  </tr>
											  <tr>
												<td class="celdas1">RBD</td>
												<td class="celdas1">INSTITUCI&Oacute;N</td>
												<td class="celdas1">HORAS<br />
												CONT.</td>
											  <td class="celdas1">HORAS<br />
												  AMPLIAC. <br />
												  SIMPLES</td>
												<td class="celdas1">TOTAL<br />
												  HORAS<br />
												  AULA</td>
											  </tr>
											  <? for($x=0;$x<@pg_numrows($rs_instit);$x++){
											  $fila_inst = @pg_fetch_array($rs_instit,$x);
											  	$sql = "SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_inst['rdb']." AND nro_ano=".$cmbANO."  ";
												$rs_ano = pg_exec($conn,$sql);
												$ano_inst = pg_result($rs_ano,0);
												
												if($ano_inst=="") $ano_inst=0;
																				
												$sql =" SELECT * FROM dotacion_docente a ";
												$sql.=" INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=".$fila_inst['rdb']." and";
												$sql.=" id_ano=".$ano_inst." AND cargo in (1,2,6)";
												$rs_empleado = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (DotacionDocente):".$sql);
												

							
											  ?>
												 <? 
												$sql_inst = "SELECT nombre_instit, rdb FROM institucion WHERE rdb in (".$rdb.")";
												$rs_instit = @pg_exec($conn,$sql_inst);
											
												 $fila_inst = @pg_fetch_array($rs_instit,$x);
												 
												 
											  	$sql = "SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_inst['rdb']." AND nro_ano=".$cmbANO."  ";
												$rs_ano = pg_exec($conn,$sql);
												$ano_inst = pg_result($rs_ano,0);
												
												if($ano_inst=="") $ano_inst=0;
																				
									
												$sql="SELECT COUNT(*) as cantidad,SUM(hrs_contrato) as contrato,";
												$sql.="SUM(amp_simple) as simple,SUM(total_aula) as ";
												$sql.="aula FROM dotacion_docente WHERE";
												$sql.=" rdb=".$fila_inst['rdb']." and id_ano=".$ano_inst." AND cargo in (1,2,6)";
												$rs_empleado = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (DotacionDocente):".$sql);
												

											 
											 
												$fila_emp = @pg_fetch_array($rs_empleado,0);										 
												 
												 
												 ?>
											  <tr>
												<td class="text2"><div align="right">
													<?=$fila_inst['rdb'];?>
												</div></td>
												<td class="text2"><div align="left"><?=strtoupper($fila_inst['nombre_instit']);?></div></td>
												<td class="text2"><? if($fila_emp['contrato']==NULL){echo "0";}else{ echo $fila_emp['contrato'];}?></td>
												<td class="text2"><? if($fila_emp['simple']==NULL){echo "0";}else{ echo $fila_emp['simple'];}?></td>
												<td class="text2"><? if($fila_emp['aula']==NULL){echo "0";}else{ echo $fila_emp['aula'];}?></td>

											  </tr>
											 
											  <? 	$total_contrato1 += $fila_emp['contrato'];
													$total_simple1 += $fila_emp['simple'];
													$total_aula1 += $fila_emp['aula'];
													
													

													
											  } ?>
											  <tr>
												<td colspan="2" class="celdas2">TOTALES (<?=$i;?>)</td>
												<td class="celdas2"><?=$total_contrato1;?></td>
												<td class="celdas2"><?=$total_simple1;?></td>
												<td class="celdas2"><?=$total_aula1;?></td>
											  </tr>
											   
								 		</table>
												</td>
											  </tr>
											  <tr>
											  	<td>&nbsp;</td>
											  </tr>
											  <? } ?>
											</table>

											
													
											<? } ?>
											
											
								<? if($docente==3){
																 
												$primera=0;
												for($i=0;$i<$cont;$i++){
													if(${"instit".$i}!="" and $primera==0){
														$rdb.=${"instit".$i};
														$primera=1;
													}elseif(${"instit".$i}!="" and $primera==1){
														$rdb.=",".${"instit".$i};
													}
												}
												
												$sql = "SELECT nombre_instit, rdb FROM institucion WHERE rdb in (".$rdb.")";
												$rs_instit = @pg_exec($conn,$sql);
												
												?>
											
											<br>
											<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
											  <tr>
												<td class="Estilo20"><b></b></td>
											  </tr>
											  <tr>
												<td>
												<table width="100%" border="1" cellpadding="5" cellspacing="0" class="tabla2">
											  <tr>
												<td colspan="11" class="celdas1"> T&Eacute;CNICO-PEDAG&Oacute;GICO</td>
											  </tr>
											  <tr>
												<td class="celdas1">RBD</td>
												<td class="celdas1">INSTITUCI&Oacute;N</td>
												<td class="celdas1">HORAS<br />
												CONT.</td>
											  <td class="celdas1">HORAS<br />
												  AMPLIAC. <br />
												  SIMPLES</td>
												<td class="celdas1">TOTAL<br />
												  HORAS<br />
												  AULA</td>
											  </tr>
											  <? for($x=0;$x<@pg_numrows($rs_instit);$x++){
											  $fila_inst = @pg_fetch_array($rs_instit,$x);
											  	$sql = "SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_inst['rdb']." AND nro_ano=".$cmbANO."  ";
												$rs_ano = pg_exec($conn,$sql);
												$ano_inst = pg_result($rs_ano,0);
												
												if($ano_inst=="") $ano_inst=0;
																				
												$sql =" SELECT * FROM dotacion_docente a ";
												$sql.=" INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=".$fila_inst['rdb']." and";
												$sql.=" id_ano=".$ano_inst." AND cargo not in (1,2,5,6)";
												$rs_empleado = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (DotacionDocente):".$sql);
												

											  ?>
												 <? 
												$sql_inst = "SELECT nombre_instit, rdb FROM institucion WHERE rdb in (".$rdb.")";
												$rs_instit = @pg_exec($conn,$sql_inst);
											
												 $fila_inst = @pg_fetch_array($rs_instit,$x);
												 
												 
											  	$sql = "SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_inst['rdb']." AND nro_ano=".$cmbANO."  ";
												$rs_ano = pg_exec($conn,$sql);
												$ano_inst = pg_result($rs_ano,0);
												
												if($ano_inst=="") $ano_inst=0;
																				
									
												$sql="SELECT COUNT(*) as cantidad,SUM(hrs_contrato) as contrato,";
												$sql.="SUM(amp_simple) as simple,SUM(total_aula) as ";
												$sql.="aula FROM dotacion_docente WHERE";
												$sql.=" rdb=".$fila_inst['rdb']." and id_ano=".$ano_inst." AND cargo not in (1,2,5,6)";
												$rs_empleado = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (DotacionDocente):".$sql);

											 
											 
												$fila_emp = @pg_fetch_array($rs_empleado,0);										 
												 
												 
												 ?>
											  <tr>
												<td class="text2"><div align="right">
													<?=$fila_inst['rdb'];?>
												</div></td>
												<td class="text2"><div align="left"><?=strtoupper($fila_inst['nombre_instit']);?></div></td>
												<td class="text2"><? if($fila_emp['contrato']==NULL){echo "0";}else{ echo $fila_emp['contrato'];}?></td>
												<td class="text2"><? if($fila_emp['simple']==NULL){echo "0";}else{ echo $fila_emp['simple'];}?></td>
												<td class="text2"><? if($fila_emp['aula']==NULL){echo "0";}else{ echo $fila_emp['aula'];}?></td>

											  </tr>
											 
											  <? 	$total_contrato2 += $fila_emp['contrato'];
													$total_simple2 += $fila_emp['simple'];
													$total_aula2 += $fila_emp['aula'];

													
											  } ?>
											  <tr>
												<td colspan="2" class="celdas2">TOTALES (<?=$i;?>)</td>
												<td class="celdas2"><?=$total_contrato2;?></td>
												<td class="celdas2"><?=$total_simple2;?></td>
												<td class="celdas2"><?=$total_aula2;?></td>
											  </tr>
											   
								 		</table>
												</td>
											  </tr>
											  <tr>
											  	<td>&nbsp; </td>
											  </tr>
											 <? //} ?>
											</table>

											
														
											<? }?>
	
	
	
    <br />
    <br />
    <br /></td>
  </tr>
  
  <tr>
    <td valign="baseline"><HR />
       <div align="right" class="fecha">Valparaiso,01 de Junio 2010 </div></td>
  </tr>
</table>
</body>
</html>