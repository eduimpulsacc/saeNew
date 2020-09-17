<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$pago			=$_PAGOS;
	$frmModo		=$_FRMMODO;
	$agrupacion		=$_AGRUPACION;	//	1:CP	2:CA	3:WS	4:CP
	$agrupacion		=1;
	$ano			=$_ANO;

$db = pg_connect("dbname=coe_traspaso user=postgres port=1550 password=cole#newaccess");
if (trim($caso)!="moroso"){
							$qry="SELECT pagos.id_tipo,pagos.rdb, pagos.descripcion, Count(fecha_vencimiento.fecha_venc) AS ncuotas  FROM (fecha_vencimiento INNER JOIN pagos ON fecha_vencimiento.id_tipo = pagos.id_tipo) INNER JOIN fechaxalumno ON (fecha_vencimiento.fecha_venc = fechaxalumno.fecha_venc) AND (fecha_vencimiento.id_tipo =  fechaxalumno.id_tipo) GROUP BY pagos.id_tipo,pagos.rdb, pagos.descripcion HAVING (((pagos.rdb)=$institucion));";

							$qry2="SELECT pagos.rdb, pagos.descripcion, Count(fecha_vencimiento.fecha_venc) AS ncuotas  FROM fecha_vencimiento INNER JOIN pagos ON fecha_vencimiento.id_tipo = pagos.id_tipo GROUP BY pagos.rdb, pagos.descripcion HAVING (((pagos.rdb)=$institucion));";

							$qry3="(select count(*) as nalumnos from matricula where id_ano=$ano and rdb=$institucion)";

							$qry4="select * from fecha_vencimiento where extract(month from fecha_venc)=(select extract(month from current_date())) and id_tipo=4";

							$result3 = @pg_exec($db, $qry3);  //  numero de alumnos
							if (!$result3) 
								echo "ERROR "; 

							$result2 = @pg_exec($db, $qry2); // 
							if (!$result2) 
								echo "ERROR "; 

							$result = @pg_exec($db, $qry);
							if (!$result) 
								echo "ERROR"; 
							php?>

							<center>
							<table border="0" cellpadding="0" cellspacing="0" width="600" height="80%" >
										<tr><td align="left"><font face="arial, geneva, helvetica" size="2" color="black"><b>INSTITUCION:<b>
										<strong>			<?php
																		$_qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
																		$_result =@pg_Exec($conn,$_qry);
																		if (!$_result) {
																			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
																		}else{
																			if (pg_numrows($_result)!=0){
																				$_fila = @pg_fetch_array($_result,0);	
																				if (!$_fila){
																					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
																					exit();
																				}
																				echo trim($_fila['nombre_instit']);
																			}
																		}
																	?>
																</strong>

										</tr>
										<tr><td align="right"><input type="button" value="VOLVER" onclick="window.location='listarPagos.php'">
										<hr width="600" color="#0099cc">
										</td></tr>

										<tr>
											<td valign="top">
																	
													<font face="Arial"><center><b>RESUMEN</b>
													<table border="0" cellpadding="0" cellspacing="1" cellspacing="0"  bgcolor="black" width="600">
													<tr>
																	<td bgcolor="#0099cc" width="15%"><font face="arial, geneva, helvetica" size="1" color="white"><center>Tipo Pago:</center></font></td>
																	<td bgcolor="#0099cc"" width="15%"><font face="arial, geneva, helvetica" size="1" color="white"><center>N° Cuotas </center></font></td>
																	<td bgcolor="#0099cc"" width="15%"><font face="arial, geneva, helvetica" size="1" color="white"><center>N° Alumnos </center></font></td>
																	<td bgcolor="#0099cc" width="15%"><font face="arial, geneva, helvetica" size="1" color="white"><center>% Pagado a la fecha</center></font></td>
																	<td bgcolor="#0099cc" width="15%"><font face="arial, geneva, helvetica" size="1" color="white"><center>Cuota Vigente</center></font></td>
													</tr>
													<?php 
													  $fila3  = @pg_fetch_array($result3,0);
													  for ($i=0 ; $i< @pg_numrows($result) ; $i++){  
														  $fila   = @pg_fetch_array($result,$i);
														  $fila2  = @pg_fetch_array($result2,$i);

													 $cvijente="select * from fecha_vencimiento where extract(month from fecha_venc)=(select extract(month from current_date())) and 		id_tipo=$fila[id_tipo];";
													 $rcvijente = @pg_exec($db, $cvijente);
													 $rcj  = @pg_fetch_array($rcvijente,0);
													 ?>
																	
																<tr>		

																	<td bgcolor="white"  width="5%"><center><font face="arial, geneva, helvetica" size="1" color="black"><?php echo $fila['descripcion']; ?></center></td>
																	
																	<td bgcolor="white"  width="5%"><center><font face="arial, geneva, helvetica" size="1" color="black"><?php echo $fila2['ncuotas']; ?></center></td>

																	<td bgcolor="white"  width="5%"><center><font face="arial, geneva, helvetica" size="1" color="black"><?php echo $fila3['nalumnos']; ?></center></td>
																	
																	<td bgcolor="white"  width="5%"><center><font face="arial, geneva, helvetica" size="1" color="black"><?php echo round((100*($fila['ncuotas']/($fila3['nalumnos']*$fila2['ncuotas'])))),"%"; ?></center></td>

																	<td bgcolor="white"  width="5%"><center><font face="arial, geneva, helvetica" size="1" color="black"><?php echo  ($rcj['fecha_venc']!="")?Cfecha($rcj['fecha_venc']):"<font color=red>Plazo vencido </font>" ?></center></td>
																</tr>
													 <?php 
													}
													?>
													</table>
													<hr width="600" color="#0099cc">
													<b>DETALLE</b>
													<?php

														$qrypago="select * from pagos where rdb=$institucion and id_ano=$ano";
														$res_qrypago = @pg_exec($db, $qrypago);
														if (!$res_qrypago) 
															echo "ERROR"; 

													for ($c=0;$c<@pg_numrows($res_qrypago);$c++ ){
														$qpago  = @pg_fetch_array($res_qrypago,$c);
													 

														$qry="SELECT pagos.rdb, pagos.id_tipo, pagos.descripcion, fecha_vencimiento.fecha_venc AS cuotas, Count(fecha_vencimiento.fecha_venc) AS cuotaspagadas FROM (fecha_vencimiento INNER JOIN pagos ON fecha_vencimiento.id_tipo = pagos.id_tipo) INNER JOIN fechaxalumno ON (fecha_vencimiento.id_tipo = fechaxalumno.id_tipo) AND (fecha_vencimiento.fecha_venc = fechaxalumno.fecha_venc) GROUP BY pagos.rdb, pagos.id_tipo, pagos.descripcion, fecha_vencimiento.fecha_venc HAVING (((pagos.rdb)=$institucion) AND ((pagos.id_tipo)=$qpago[id_tipo]));";
														$result = @pg_exec($db, $qry);
														$titulos   = @pg_fetch_array($result,$c);
														
														if (!$result) 
															echo "ERROR"; 
														?>
														<table border="0" cellpadding="0" cellspacing="1" cellspacing="0"  bgcolor="black" width="600">
														<tr>
																			<td bgcolor="#0099cc" width="83"><font color="white" face="arial, geneva, helvetica" size="1" color="#000000">Tipo Pago</font></td>
																			<td bgcolor="#0099cc"><b><font face="arial, geneva, helvetica" size="1" color="white"><?php echo $titulos['descripcion'] ?></font></b></td>
																			<td bgcolor="#0099cc"></td>
																			<td bgcolor="#0099cc"></td>
																		</tr>
																		<tr>
																			<td width="83" bgcolor="#48d1cc"><font face="arial, geneva, helvetica" size="1" color="#000000"><center>Cuota</font></td>
																			<td bgcolor="#48d1cc"><font face="arial, geneva, helvetica" size="1" color="#000000"><center>% Cuotas canceladas </font></td>
																			<td bgcolor="#48d1cc"><font face="arial, geneva, helvetica" size="1" color="#000000"><center>Morosos</font></td>
																			<td bgcolor="#48d1cc"><font face="arial, geneva, helvetica" size="1" color="#000000"><center>ver Morosos</font></td>
																		</tr>
														<?php 
														  for ($i=0 ; $i< @pg_numrows($result) ; $i++){  
															  $fila   = @pg_fetch_array($result,$i);

							//----------/ query muestra posibles morosos a una fecha y un tipo de pago /--------------------------//
															  $qrymo="select *,(select current_date()) as fecha_actual  from anxapoderado where rdb=$institucion and rut_apo in (select rut_apo from tiene2 where responsable=1 and to_number(rut_alumno,99999999) not in (select rut_emp from fechaxalumno where fecha_venc='$fila[cuotas]' and id_tipo=$qpago[id_tipo]))";
															  $resultqrymo = @pg_exec($db, $qrymo);

															  $conta=0; // cuenta morosos

															  for ($ii=0; $ii< @pg_numrows($resultqrymo); $ii++)  {
																	  $posibles_morosos = @pg_fetch_array($resultqrymo,$ii);
																	  

																	  $dia_cuota= $posibles_morosos[fecha];
																	  $mes_cuota= substr($fila[cuotas],5,2); 
																	  $ano_cuota= substr($fila[cuotas],0,4); 

																	  $fecha_actual   = $posibles_morosos[fecha_actual];
																	  $fecha_pago_apo = $ano_cuota."-".$dia_cuota."-".$mes_cuota;
																	  $cf=ComparaFecha($fecha_actual,$fecha_pago_apo);
																	  if ($cf==1){
																		  $_morosos[$qpago[id_tipo]][$fila[cuotas]][$conta]=$posibles_morosos[rut_apo]; 
																		  $conta++;
																	  }

							// LINEA PARA DEPURACION echo "<script>alert('fecha_actual:$fecha_actual - fecha_pago_apo :$fecha_pago_apo - compara : $cf')</script>";
															 }
							// LINEA PARA DEPURACION echo "<script>alert('contafinal:",$conta,"')</script>";
							// echo $qrymo;
														?>

															  

																	<tr>
																			<td bgcolor="white"><center><font face="arial, geneva, helvetica" size="1" color="black"><?php echo Cfecha($fila['cuotas']) ?></font></center></td>
																			<td bgcolor="white"><center><font face="arial, geneva, helvetica" size="1" color="black"><?php echo (100*($fila['cuotaspagadas']/$fila3['nalumnos'])),"%" ?></font></center></td>
																			<td bgcolor="white"><center><font face="arial, geneva, helvetica" size="1" color="black"><?php echo (100*($conta/$fila3['nalumnos'])),"%" ?></center></td>
																			

																			<td bgcolor="white" onmouseover="this.style.background='yellow';this.style.cursor='hand'" onmouseout="this.style.background='white'" onclick="window.location='reportepagp.php?caso=moroso&tp=<?php echo $qpago[id_tipo],"&cuota=",$fila[cuotas],"&nmoro=",$conta,"'";?>"
																			 
																					<font face="arial, geneva, helvetica" size="1" color="black">
																						<center>Ver
																					</font>
																			</td>

																	</tr>
														<?php
																		
														}
														?>
															</table>

														<?php
													}
							?>
							</td>
										</tr>
									</table>
							<?php

session_register(_morosos);
}
else {
?>
<center>
						<table border="0" cellpadding="0" cellspacing="0" width="600" >
									<tr><td align="left"><font face="arial, geneva, helvetica" size="2" color="black"><b>INSTITUCION:<b>
									<strong>			<?php
																		$_qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
																		$_result =@pg_Exec($conn,$_qry);
																		if (!$_result) {
																			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
																		}else{
																			if (pg_numrows($_result)!=0){
																				$_fila = @pg_fetch_array($_result,0);	
																				if (!$_fila){
																					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
																					exit();
																				}
																				echo trim($_fila['nombre_instit']);
																			}
																		}
																	?>
																</strong>

										</tr>
										<tr>
											
											<td align="right">
												<div align="left"><font face="arial, geneva, helvetica" size="2" color="black">INFORME DE MOROSOS</div><input type="button" value="VOLVER" onclick="window.location='listarPagos.php'"><hr width="600" color="#0099cc">
											</td>
										</tr>

										<tr>
											<td valign="top">
<?php

$qry="select * from apoderado where rut_apo in (";			
for ($i=0; $i<$nmoro ;$i++){
	$qry.="'".$_morosos[$tp][$cuota][$i]."',";
	
}
$qry.="'')";
$result= @pg_exec($db,$qry);

$rqrytp= @pg_exec($db, "select * from pagos where id_tipo=$tp");
$rtp  = @pg_fetch_array($rqrytp,0);

?>
		<table border="0" cellpadding="0" cellspacing="1" cellspacing="0"  bgcolor="black" width="600">
						<tr>
							<td bgcolor="#0099cc" width="83"><font color="white" face="arial, geneva, helvetica" size="1" color="#000000">Tipo Pago</font></td>
							<td bgcolor="#0099cc"><b><font face="arial, geneva, helvetica" size="1" color="white">
							<?php echo trim($rtp['descripcion']); ?></font></b></td>
							<td bgcolor="#0099cc"></td>
							
						</tr>
						<tr>
							<td width="83" bgcolor="#48d1cc"><font face="arial, geneva, helvetica" size="1" color="#000000"><center>Cuota</font></td>
							<td bgcolor="#48d1cc"><font face="arial, geneva, helvetica" size="1" color="#000000"><center>Rut Apoderado</font></td>
							<td bgcolor="#48d1cc"><font face="arial, geneva, helvetica" size="1" color="#000000"><center>Día vencimiento cuota</font></td>
							
						</tr>
<?php
						for ($i=0;$i< pg_numrows($result) ;$i++ ){
							 $fla=@pg_fetch_array($result,$i);

							 $rs=@pg_exec($db, "select * from anxapoderado where rut_apo='$fla[rut_apo]'");
							 $anx  = @pg_fetch_array($rs,0);
							?>
							<tr>
							<td width="83" bgcolor="white"><font face="arial, geneva, helvetica" size="1" color="black"><center><?php echo Cfecha($cuota); ?></font></td>
							<td bgcolor="white"><font face="arial, geneva, helvetica" size="1" color="black"><center><?php echo $fla[rut_apo]; ?></font></td>
							<td bgcolor="white"><font face="arial, geneva, helvetica" size="1" color="black"><center><?php echo $anx[fecha] ?></font></td>
						    </tr>
						<?php
						}

}
?>