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
	header('Content-type: application/vnd.ms-excel');
   // header("Content-Disposition: attachment; filename=notas_$fechahoy.xls");
	
	header("Content-Disposition:inline; filename=notas_$fechahoy.xls");

	
	
	
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../Sea/cortes/b_ayuda_r.jpg','../../../../../../Sea/cortes/b_info_r.jpg','../../../../../../Sea/cortes/b_mapa_r.jpg','../../../../../../Sea/cortes/b_home_r.jpg')">

								  
								  
								  <!-- inicio codigo antiguo -->
								  
								  

		                          <!--<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
                                    <TR>
                                      <TD align=left><FONT face="arial, geneva, helvetica" size=2> <strong>INSTITUCION</strong> </FONT> 
                                      <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT>
                                      <FONT face="arial, geneva, helvetica" size=2> <strong>
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
													echo trim($fila1['nombre_instit']);
												}
											}
										?>
                                      </strong> </FONT> </TD>
                                    </TR>
                                    <TR>
                                      <TD align=left><FONT face="arial, geneva, helvetica" size=2> <strong>A&Ntilde;O ESCOLAR</strong> </FONT> 
                                      <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT> 
                                      <FONT face="arial, geneva, helvetica" size=2> <strong>
                                        <?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
														exit();
													}
													echo trim($fila1['nro_ano']);
												}
											}
										?>
                                      </strong> </FONT> </TD>
                                    </TR>
                                    <TR>
                                      <TD align=left><FONT face="arial, geneva, helvetica" size=2> <strong>CURSO</strong> </FONT> 
                                      <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT> 
                                      <FONT face="arial, geneva, helvetica" size=2> <strong>
                                        <?php
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo WHERE (((curso.id_curso)=".$curso."))";
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
													echo trim($fila1['grado_curso'])." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
												}
											}
										?>
                                      </strong> </FONT> </TD>
                                    </TR>
                                    <TR>
                                      <TD align=left><FONT face="arial, geneva, helvetica" size=2> <strong>SUBSECTOR</strong> </FONT> 
                                      <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT> 
                                      <FONT face="arial, geneva, helvetica" size=2> <strong>
                                        <?php
											$qry="SELECT subsector.nombre, subsector.cod_subsector, modo_eval FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
											$result =@pg_Exec($conn,$qry);
											if (pg_numrows($result)!=0){
												$fila10 = @pg_fetch_array($result,0);	
												echo trim($fila10['nombre']);
											}
										?>
                                      </strong> </FONT> </TD>
                                    </TR>
                                    <TR>
                                      <TD align=left><FONT face="arial, geneva, helvetica" size=2> <strong>PLAN 
                                        DE ESTUDIO</strong> </FONT> 
                                      <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT>
                                      <FONT face="arial, geneva, helvetica" size=2> <strong>
                                        <?php
											$qry4="SELECT curso.id_curso, plan_estudio.cod_decreto, plan_estudio.nombre_decreto FROM curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto WHERE (((curso.id_curso)=".$curso."))";
														$result4 =@pg_Exec($conn,$qry4);
														$fila4= @pg_fetch_array($result4,0);
													
												echo trim($fila4['nombre_decreto']);
											
										?>
                                      </strong> </FONT> </TD>
                                    </TR>
                                    <TR>
                                      <TD align=left><FONT face="arial, geneva, helvetica" size=2> <strong>DECRETO 
                                        DE EVAL</strong> </FONT> 
                                      <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT> 
                                      <FONT face="arial, geneva, helvetica" size=2> <strong>
                                        <?php 
	                                                     $qry4="SELECT curso.id_curso, evaluacion.cod_eval FROM curso INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval WHERE (((curso.id_curso)=".$curso."))";
														$result4 =@pg_Exec($conn,$qry4);
														$fila4= @pg_fetch_array($result4,0);
                                                           

													$qry5="SELECT * FROM EVALUACION WHERE COD_EVAL=".$fila4['cod_eval'];
													$result5 =@pg_Exec($conn,$qry5);
													if (!$result5) {
														error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
													}else{
														if (pg_numrows($result5)!=0){
															$fila9 = @pg_fetch_array($result5,0);	
															if (!$fila9){
																error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
																exit();
															}
															echo trim($fila9['nombre_decreto_eval'])." (".trim($fila9['cursos']).")";
														}
													
												}
												
												
				$qry1106="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO = '$ano' AND ID_INSTITUCION=".$institucion." ORDER BY NRO_ANO";
				$result1106 =@pg_Exec($conn,$qry1106);
				
				if (!$result1106){
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result1106)!=0){
						$fila1106 = @pg_fetch_array($result1106,0);	
						if (!$fila1106){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}else{
						  $fila1106 = @pg_fetch_array($result1106,0);
					    }	  
					}
											
				}				?>
                                      </strong> </FONT> </TD>
                                    </TR>
                                  </TABLE>
		                          <br>
								  
								  
		      
					         
								 
									<?php
									
																	
									
										$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) order by id_periodo";
										$result =@pg_Exec($conn,$qry);
										if (!$result) 
											error('<B> ERROR :</b>Error al acceder a la BD. (74)</B>');
										else{
											if (pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);	
												if (!$fila1){
													error('<B> ERROR :</b>Error al acceder a la BD. (84)</B>');
													exit();
												};
												for($i=0 ; $i < @pg_numrows($result) ; $i++){
													$fila1 = @pg_fetch_array($result,$i);
													if($fila1['id_periodo']==$periodo){
														echo  "PERIODO: ".$fila1['nombre_periodo'];
													}else{
														//echo  "PERIODO: ".$fila1['id_periodo'];
													}
												}
											}
										};
									?>
								
					      </TD>
						</TR>
						<tr><td></td></tr>
				</table>		
												  
		-->
		
		
		
		
					
								<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=5 width=100% bgcolor=#C0C0C0>
								<?php
									//ALUMNOS DEL CURSO
//                                     $qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$nro_ano.id_curso FROM (alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno) WHERE tiene$nro_ano.id_ramo=".$ramo." ORDER BY ape_pat, ape_mat, nombre_alu, rut_alumno asc";
    	                                $qry="SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$nro_ano.id_curso, matricula.nro_lista "; 
										$qry = $qry . " FROM alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno ";
										$qry = $qry . " INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno ";
										$qry = $qry . " WHERE tiene$nro_ano.id_ramo=".$ramo." AND matricula.id_ano=".$ano." ";
										$qry = $qry . " AND matricula.bool_ar=0 ";
										$qry = $qry . " ORDER BY  ape_pat, ape_mat, nombre_alu, rut_alumno asc ";
										$result =@pg_Exec($conn,$qry);
										// matricula.nro_lista asc,

									if (!$result) 
										error('<B> ERROR :</b>Error al acceder a la BD. (75)</B>'.$qry);
									else{
										if (pg_numrows($result)!=0){
											$fila1 = @pg_fetch_array($result,0);	
                                                ?>
												<TR>
												
												<TD align=center>ALUMNO</TD>
												<TD align=center nowrap>RUT</TD>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(1º)</STRONG></FONT></TD>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(2º)</STRONG></FONT></TD>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(3º)</STRONG></FONT></TD>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(4º)</STRONG></FONT></TD>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(5º)</STRONG></FONT></TD>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(6º)</STRONG></FONT></TD>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(7º)</STRONG></FONT></TD>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(8º)</STRONG></FONT></TD>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(9º)</STRONG></FONT></TD>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(10º)</STRONG></FONT></TD>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(11º)</STRONG></FONT></TD>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(12º)</STRONG></FONT></TD>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(13º)</STRONG></FONT></TD>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(14º)</STRONG></FONT></TD>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(15º)</STRONG></FONT></TD>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(16º)</STRONG></FONT></TD>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(17º)</STRONG></FONT></TD>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(18º)</STRONG></FONT></TD>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(19º)</STRONG></FONT></TD>
												<TD align=center><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(20º)</STRONG></FONT></TD>
												<TD align=center>PROM</TD>
												</TR>
				                         <?

											for($i=0 ; $i < @pg_numrows($result) ; $i++){
												$fila1 = @pg_fetch_array($result,$i);
												if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL
													if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
														?>
															<!--TR bgcolor=#ffffff onmouseover=this.style.background='yellow'; this.style.cursor='hand'; onmouseout=this.style.background='transparent'; onClick="go('ingresoNota.php3?alumno=<?php echo $fila1['rut_alumno'];?>');"-->
															<TR >
														<?php
													}else{
														echo "<TR bgcolor=#ffffff>";
													}
												}else{
													echo "<TR bgcolor=#ffffff>";
												}

												//echo "<TD align=left width=20>";
												//echo  $fila1["nro_lista"];
												//echo "</TD>";

												echo "<TD align=left width=380>";
												echo  $fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_alu"];
												echo "</TD>";
												
												echo "<TD align=left nowrap>";
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
															echo "<TD align=center width=100 bgcolor=white>";
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
															echo "<TD align=center width=100 bgcolor=white>";
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
															echo "<TD align=center width=100 bgcolor=white>";
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
							
				
			
                               
