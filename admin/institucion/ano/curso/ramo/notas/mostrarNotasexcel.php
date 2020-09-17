<?php require('../../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$ramo			=$_RAMO;
	$docente		=5; //Codigo Docente
	$_POSP          =6;
	$_bot           =5;
	$fecha = time();
	$dd = date(d);
	$mm = date(m);
	$aa = date(Y);
	$fechahoy = "$dd-$mm-$aa";
	$fechahoy.="_";
	$hora= date ( "h:i:s" , $fecha );
	$hh = substr($hora,0,2);
	$mm = substr($hora,3,2);
	$ss = substr($hora,6,2);
	
	
//	header("Content-type:application/vnd.ms-excel\n\n");
//    header("Content-disposition:inline;filename=Respaldo_notas_$fechahoy$hh$mm$ss.xls");
	//header('Content-type: application/vnd.ms-excel');
   // header("Content-Disposition: attachment; filename=notas_$fechahoy.xls");
	
	//header("Content-Disposition:inline; filename=notas_$fechahoy.xls");

header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=notas_'.$fechahoy.'.xls');
	
	
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	
	$s_peract = "select nombre_periodo from periodo where id_periodo=$periodo";
	$r_peract = pg_exec($conn,$s_peract);
	$n_peract = pg_result($r_peract,0);	
	
	if($aux!=1)	{//HACER LA CONSULTA Y DESPLEGAR EL PRIMER PERIODO
		$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY NOMBRE_PERIODO";
		$result =@pg_Exec($conn,$qry);
		if (!$result) 
			error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
		else{
			if (pg_numrows($result)!=0){
				$fila1 = @pg_fetch_array($result,0);	
				if (!$fila1){
					error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
					exit();
				};
				$periodo	= $fila1['id_periodo'];
			}else{
				echo "NO EXISTEN PERIODOS INGRESADOS PARA ESTE AÑO";
			}
		};
	}


?>
<?php
											
																															
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													
												}
											}
										?>

								<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=5 width=100% style="font-family:Verdana, Geneva, sans-serif;font-size:10px" >
                                <TR>
                                  <td width="300" align="left"><strong>INSTITUCION</strong></td>
												  <TD align=left nowrap><?php echo $institucion ?>-<?php echo  trim($fila1['dig_rdb']) ?>&nbsp;</TD>
												  <TD align="center"><?php echo trim($fila1['nombre_instit']);?></TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
								  </TR>
												<TR>
												  <td align="left"><strong>CURSO</strong></td>
												  <TD align=left nowrap>
												    <?php
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo,curso.ensenanza FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo WHERE (((curso.id_curso)=".$curso."))";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
													echo trim($fila1['grado_curso'])."-".trim($fila1['letra_curso']);
												}
											}
											
										?>
												 </TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
								  </TR>
												<TR>
												  <td align="left"><strong>TIPO DE ENSENANZA</strong></td>
												  <TD align=left nowrap><?php  echo trim($fila1['ensenanza'])." - ".trim($fila1['nombre_tipo']); ?></TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
								  </TR>
												<TR>
												  <td align="left"><strong>ASIGNATURA</strong></td>
												  <TD align=left nowrap><?php
											$qry="SELECT subsector.nombre, subsector.cod_subsector, modo_eval FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
											$result =@pg_Exec($conn,$qry);
											if (pg_numrows($result)!=0){
												$fila10 = @pg_fetch_array($result,0);	
												echo trim($fila10['cod_subsector'])." - ".trim($fila10['nombre']);
											}
										?></TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
								  </TR>
												<TR>
												  <td align="left"><strong>PERIODO</strong></td>
												  <TD align=left nowrap><?php echo $n_peract ?></TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
								  </TR>
												<TR>
												  <td align="left"><strong>A&Ntilde;O ESCOLAR</strong></td>
												  <TD align=left nowrap><?php echo $nro_ano ?></TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
								  </TR>
												
												<TR>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center" nowrap>&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
												  <TD align="center">&nbsp;</TD>
								  </TR>
								<?php
									//ALUMNOS DEL CURSO
//                                     $qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$nro_ano.id_curso FROM (alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno) WHERE tiene$nro_ano.id_ramo=".$ramo." ORDER BY ape_pat, ape_mat, nombre_alu, rut_alumno asc";
    	                                $qry="SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$nro_ano.id_curso, matricula.nro_lista "; 
										$qry = $qry . " FROM alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno ";
										$qry = $qry . " INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno ";
										$qry = $qry . " WHERE tiene$nro_ano.id_ramo=".$ramo." AND matricula.id_ano=".$ano." ";
										$qry = $qry . " AND matricula.bool_ar=0 ";
										$qry = $qry . " ORDER BY  matricula.nro_lista,ape_pat, ape_mat, nombre_alu, rut_alumno asc ";
										$result =@pg_Exec($conn,$qry);
										// matricula.nro_lista asc,

									if (!$result) 
										error('<B> ERROR :</b>Error al acceder a la BD. (75)</B>'.$qry);
									else{
										if (pg_numrows($result)!=0){
											$fila1 = @pg_fetch_array($result,0);	
                                                ?>
												
												<TR bgcolor="#C0C0C0">
												
												<TD align="center">ALUMNO</TD>
												<TD align="center" nowrap>RUT</TD>
												<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(1º)</STRONG></FONT></TD>
												<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(2º)</STRONG></FONT></TD>
												<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(3º)</STRONG></FONT></TD>
												<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(4º)</STRONG></FONT></TD>
												<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(5º)</STRONG></FONT></TD>
												<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(6º)</STRONG></FONT></TD>
												<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(7º)</STRONG></FONT></TD>
												<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(8º)</STRONG></FONT></TD>
												<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(9º)</STRONG></FONT></TD>
												<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(10º)</STRONG></FONT></TD>
												<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(11º)</STRONG></FONT></TD>
												<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(12º)</STRONG></FONT></TD>
												<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(13º)</STRONG></FONT></TD>
												<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(14º)</STRONG></FONT></TD>
												<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(15º)</STRONG></FONT></TD>
												<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(16º)</STRONG></FONT></TD>
												<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(17º)</STRONG></FONT></TD>
												<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(18º)</STRONG></FONT></TD>
												<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(19º)</STRONG></FONT></TD>
												<TD align="center"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(20º)</STRONG></FONT></TD>
												<TD align="center">PROM</TD>
												</TR>
				                         <?

											for($i=0 ; $i < @pg_numrows($result) ; $i++){
												$fila1 = @pg_fetch_array($result,$i);
												if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL
													if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
														?>
															<!--TR bgcolor=#ffffff onmouseover=this.style.background='yellow'; this.style.cursor='hand'; onmouseout=this.style.background='transparent'; onClick="go('ingresoNota.php3?alumno=<?php echo $fila1['rut_alumno'];?>');"-->
															<TR>
														<?php
													}else{
														echo "<TR bgcolor='#ffffff'>";
													}
												}else{
													echo "<TR bgcolor='#ffffff'>";
												}

												//echo "<TD align=left width=20>";
												//echo  $fila1["nro_lista"];
												//echo "</TD>";

												echo "<TD align='left' width=380>";
												echo  $fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_alu"];
												echo "</TD>";
												
												echo "<TD align='left' nowrap>";
												echo   $fila1["rut_alumno"];
												echo "</TD>";
													
												//NOTAS ALUMNO POR RAMO Y PERIODO
  											    $qry2="SELECT * FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)=".$fila1['rut_alumno'].") AND ((notas$nro_ano.id_periodo)=".$periodo.") AND ((notas$nro_ano.id_ramo)=".$ramo."))"; 
												$result2 =@pg_Exec($conn,$qry2);
												if (!$result2) 
													error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>');
												else{
													if (pg_numrows($result2)!=0){
														$fila2 = @pg_fetch_array($result2,0);
														if (!$fila2){
															error('<B> ERROR :</b>Error al acceder a la BD. (86)</B>');
															exit();
														};
														for($j=1;$j<22;$j++){
															$var="nota"."$j";
															echo "<TD align='center' width=100 bgcolor='white'>";
															if ($j==21){
															       if ($fila10['modo_eval']==2){
															    		if ((trim($fila2['promedio'])==MB) OR (trim($fila2['promedio'])==B) OR (trim($fila2['promedio'])==S) OR (trim($fila2['promedio'])==I)){
															       			echo($fila2['promedio']);
															      		}
																	}
															       if ($fila10['modo_eval']==1){
															            if ( trim($fila2['promedio'])!=0){
															                echo($fila2['promedio']);
															            }
															        }
															       if ($fila10['modo_eval']==3){
															            if ((trim($fila2['promedio'])==MB) OR (trim($fila2['promedio'])==B) OR (trim($fila2['promedio'])==S) OR (trim($fila2['promedio'])==I)){
															                echo($fila2['promedio']);
															            }
															        }
															       if ($fila10['modo_eval']==4){
															            if ($fila2['promedio']!=0){
															                echo($fila2['promedio']);
															            }
															        }

															}
															else{
															     if ($fila10['modo_eval']==2){
																	   if ((trim($fila2["$var"])==MB) OR (trim($fila2["$var"])==B) OR (trim($fila2["$var"])==S) OR (trim($fila2["$var"])==I) OR $fila2["$var"]!=0){
																	      echo($fila2["$var"]);
																	   }
																 }
															     if ($fila10['modo_eval']==1){
																 	if(!strcmp($var,'nota20')){
															           if ((trim($fila2["$var"])==MB) OR (trim($fila2["$var"])==B) OR (trim($fila2["$var"])==S) OR (trim($fila2["$var"])==I)){
															              echo($fila2["$var"]);
																		}
																		else{
																		   if ($fila2["$var"]!=0){
																			  echo($fila2["$var"]);
																		   }
																		}
																	}
																	else{
															           if ($fila2["$var"]!=0){
															              echo($fila2["$var"]);
															           }
																	}
															     }
															     if ($fila10['modo_eval']==3){
															           if ($fila2["$var"]!=0){
															              echo($fila2["$var"]);
															           }
															     }
															     if ($fila10['modo_eval']==4){
															           if ((trim($fila2["$var"])==MB) OR (trim($fila2["$var"])==B) OR (trim($fila2["$var"])==S) OR (trim($fila2["$var"])==I)){
															              echo($fila2["$var"]);
															           }
															     }
															}
															echo "</TD>";
														}
													}else{
															echo "<TD align='center' width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align='center' width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
													}
												};
											
											};


										};
									};
								?>
									</TR>
								</TABLE>
							
				
			
                               
