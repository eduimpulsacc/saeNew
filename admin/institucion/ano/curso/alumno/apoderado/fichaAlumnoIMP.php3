<?php require('../../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO='".trim($alumno)."'";
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				}
			}
		}
	}
?>
<HTML>
	<HEAD>
		<style type="text/css">
		<!--
			table  { 
				color: black; 
				font-style: normal; 
				font-weight: bold; 
				font-size: 11px; 
				font-family: arial, geneva, helvetica; 
				text-decoration: none 
			}
		//-->
		</style>

			<SCRIPT language="JavaScript">
				function round(number,X) {
					// rounds number to X decimal places, defaults to 2
					X = (!X ? 0 : X);
					return Math.round(number*Math.pow(10,X))/Math.pow(10,X);
				}
			</SCRIPT>
	</HEAD>
<body onload="javascript:window.print();history.back();">
	<FORM method=post name="frm" action="procesoAlumno.php3">
		<TABLE WIDTH=800 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>INSTITUCION</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
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
									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>AÑO ESCOLAR</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
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
									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>CURSO</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
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
													echo trim($fila1['grado_curso'])." ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>ALUMNO</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO='".trim($alumno)."'";
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
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat'])." ".trim($fila1['nombre_alu']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50">
							<TD align=right>
								<!--INPUT TYPE="button" value="VOLVER" onClick=document.location="seteaApoderado.php3?caso=5"-->
							</TD>
						</TR>
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>EVALUACION</strong>
								</FONT>
							</TD>
						</TR>

<?php if($_TIPOREGIMEN==1){//BIMESTRAL?>
		<!-- INICIO CUATRO PERIDOS -->						
			EN CONSTRUCCION
		<!-- FIN 4 PERIODOS -->
<?php }//FIN BIMESTRAL?>


<?php if($_TIPOREGIMEN==2){//TRIMESTRAL?>
		<!-- INICIO TRES PERIDOS -->						
								<TR>
									<TD>
										<TABLE BORDER=1 CELLSPACING=2 CELLPADDING=2 width=100%>
											<TR>
												<!--TD COLSPAN=46>NOTAS</TD-->
												<TD COLSPAN=43>NOTAS</TD>
											</TR>
											<TR>
											<?php
												$qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
												$result6 =@pg_Exec($conn,$qry6);
												if (!$result6) {
													error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												}else{
													if (pg_numrows($result6)!=0){
													?>
														<TD>SUBSECTORES</TD>
														<TD></TD>
														<TD colspan=9>
															<?php 
																$fila6 = @pg_fetch_array($result6,0);
																echo trim($fila6['nombre_periodo']);
																$idPer1=$fila6['id_periodo'];
															?>
														</TD>
														<TD></TD>
														<TD>PT</TD>
														<!--TD>PC</TD-->
														<TD></TD>
														<TD colspan=9>
															<?php 
																$fila6 = @pg_fetch_array($result6,1);
																echo trim($fila6['nombre_periodo']);
																$idPer2=$fila6['id_periodo'];
															?>
														</TD>
														<TD></TD>
														<TD>PT</TD>
														<!--TD>PC</TD-->
														<TD></TD>
														<TD colspan=9>
															<?php 
																$fila6 = @pg_fetch_array($result6,2);
																echo trim($fila6['nombre_periodo']);
																$idPer3=$fila6['id_periodo'];
															?>
														</TD>
														<TD></TD>
														<TD>PT</TD>
														<!--TD>PC</TD-->
														<TD></TD>
														<TD>PG</TD>
													<?php
													}
												}
											?>
														</TR>
											<!--OBTENER RAMOS DEL CURSO Y POR CADA RAMO LAS NOTAS DEL ALUMNO-->
											<?php
												$PTot	=0;	//PROMEDIO TOTAL
												$cantT	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO TOTAL
												$PP1	=0;	//PROMEDIO PRIMER PERIODO
												$cantP1	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO PRIMER PERIODO
												$PP2	=0;	//PROMEDIO SEGUNDO PERIODO
												$cantP2	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO SEGUNDO PERIODO
												$PP3	=0;	//PROMEDIO TERCER PERIODO
												$cantP3	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO TERCER PERIODO

												$qry3="SELECT * FROM RAMO WHERE ID_CURSO=".$curso;
												$result3 =@pg_Exec($conn,$qry3);
												if (!$result3) 
													error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
												else{
													if (pg_numrows($result3)!=0){
														$fila3 = @pg_fetch_array($result3,0);	
														if (!$fila3){
															error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
															exit();
														};
														for($i=0 ; $i < @pg_numrows($result3) ; $i++){//TOTAL RAMOS DEL CURSO
															//POR CADA RAMO DEL CURSO, PARA LOS TRES PERIODOS
															$fila3 = @pg_fetch_array($result3,$i);
															$PGral	=0;	//PROMEDIO GENERAL
															$cant	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO
											?>
															<TR>
																<TD><?php echo trim($fila3['nombre_ramo']);?></TD>
																<?php
																	//PRIMER PERIODO
																	$qry8="SELECT periodo.mostrar_notas, alumno.rut_alumno, nota.id_nota, nota.valor, periodo.id_periodo, califica.promedio FROM nota INNER JOIN (((alumno INNER JOIN califica ON alumno.rut_alumno = califica.rut_alumno) INNER JOIN ramo ON califica.id_ramo = ramo.id_ramo) INNER JOIN periodo ON califica.id_periodo = periodo.id_periodo) ON (nota.id_periodo = califica.id_periodo) AND (nota.rut_alumno = califica.rut_alumno) AND (nota.id_ramo = califica.id_ramo) WHERE (((alumno.rut_alumno)='".trim($alumno)."') AND ((periodo.id_periodo)=".$idPer1.") AND ((califica.id_ramo)=".$fila3['id_ramo']."))";
																	$result8 =@pg_Exec($conn,$qry8);
																?>
																<TD></TD>		<!--PRIMER PERIODO-->
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,0);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,1);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,2);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,3);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,4);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,5);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,6);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,7);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,8);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																<TD></TD>
																<TD>
																	<?php 
																		if($fila8['mostrar_notas'])
																		echo trim($fila8['promedio']);
																		if ($fila3['modo_eval']!=2){
																			if (trim($fila8['promedio'])!=""){
																				$PGral=(int) trim($fila8['promedio']);
																				$cant=1;

																				$PP1	=$PP1 + (int) trim($fila8['promedio']);
																				$cantP1	=$cantP1 + 1;

																			}
																		}
																	?>
																</TD>
																<!--TD>1c</TD-->
																<?php
																	//SEGUNDO PERIODO
																	$qry8="SELECT periodo.mostrar_notas, alumno.rut_alumno, nota.id_nota, nota.valor, periodo.id_periodo, califica.promedio FROM nota INNER JOIN (((alumno INNER JOIN califica ON alumno.rut_alumno = califica.rut_alumno) INNER JOIN ramo ON califica.id_ramo = ramo.id_ramo) INNER JOIN periodo ON califica.id_periodo = periodo.id_periodo) ON (nota.id_periodo = califica.id_periodo) AND (nota.rut_alumno = califica.rut_alumno) AND (nota.id_ramo = califica.id_ramo) WHERE (((alumno.rut_alumno)='".trim($alumno)."') AND ((periodo.id_periodo)=".$idPer2.") AND ((califica.id_ramo)=".$fila3['id_ramo']."))";
																	$result8 =@pg_Exec($conn,$qry8);
																?>
																<TD></TD>		<!--SEGUNDO PERIODO-->
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,0);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,1);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,2);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,3);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,4);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,5);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,6);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,7);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,8);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																<TD></TD>
																<TD>
																	<?php 
																		if($fila8['mostrar_notas'])
																		echo trim($fila8['promedio']);
																		if ($fila3['modo_eval']!=2){
																			if (trim($fila8['promedio'])!=""){
																				$PGral=((int) trim($fila8['promedio'])) + $PGral;
																				$cant=$cant + 1;

																				$PP2	=$PP2 + (int) trim($fila8['promedio']);
																				$cantP2	=$cantP2 + 1;
																			}
																		}
																	?>
																</TD>
																<!--TD>2c</TD-->
																<?php
																	//TERCER PERIODO
																	$qry8="SELECT periodo.mostrar_notas, alumno.rut_alumno, nota.id_nota, nota.valor, periodo.id_periodo, califica.promedio FROM nota INNER JOIN (((alumno INNER JOIN califica ON alumno.rut_alumno = califica.rut_alumno) INNER JOIN ramo ON califica.id_ramo = ramo.id_ramo) INNER JOIN periodo ON califica.id_periodo = periodo.id_periodo) ON (nota.id_periodo = califica.id_periodo) AND (nota.rut_alumno = califica.rut_alumno) AND (nota.id_ramo = califica.id_ramo) WHERE (((alumno.rut_alumno)='".trim($alumno)."') AND ((periodo.id_periodo)=".$idPer3.") AND ((califica.id_ramo)=".$fila3['id_ramo']."))";
																	$result8 =@pg_Exec($conn,$qry8);
																?>
									<?php //if (@pg_numrows($result8)!=0){ //PARA SABER SI HAY 3º TRIMESTRE?>
																			<TD></TD>		<!--TERCER PERIODO-->
																				<TD >
																					<?php 
																						$fila8 = @pg_fetch_array($result8,0);
																						if($fila8['mostrar_notas'])
																						imp(trim($fila8['valor']));
																					?>
																				</TD> 
																				<TD >
																					<?php 
																						$fila8 = @pg_fetch_array($result8,1);
																						if($fila8['mostrar_notas'])
																						imp(trim($fila8['valor']));
																					?>
																				</TD> 
																				<TD >
																					<?php 
																						$fila8 = @pg_fetch_array($result8,2);
																						if($fila8['mostrar_notas'])
																						imp(trim($fila8['valor']));
																					?>
																				</TD> 
																				<TD >
																					<?php 
																						$fila8 = @pg_fetch_array($result8,3);
																						if($fila8['mostrar_notas'])
																						imp(trim($fila8['valor']));
																					?>
																				</TD> 
																				<TD >
																					<?php 
																						$fila8 = @pg_fetch_array($result8,4);
																						if($fila8['mostrar_notas'])
																						imp(trim($fila8['valor']));
																					?>
																				</TD> 
																				<TD >
																					<?php 
																						$fila8 = @pg_fetch_array($result8,5);
																						if($fila8['mostrar_notas'])
																						imp(trim($fila8['valor']));
																					?>
																				</TD> 
																				<TD >
																					<?php 
																						$fila8 = @pg_fetch_array($result8,6);
																						if($fila8['mostrar_notas'])
																						imp(trim($fila8['valor']));
																					?>
																				</TD> 
																				<TD >
																					<?php 
																						$fila8 = @pg_fetch_array($result8,7);
																						if($fila8['mostrar_notas'])
																						imp(trim($fila8['valor']));
																					?>
																				</TD> 
																				<TD >
																					<?php 
																						$fila8 = @pg_fetch_array($result8,8);
																						if($fila8['mostrar_notas'])
																						imp(trim($fila8['valor']));
																					?>
																				</TD> 
																			<TD></TD>
																			<TD>
																				<?php 
																					if($fila8['mostrar_notas'])
																					echo trim($fila8['promedio']);
																					if ($fila3['modo_eval']!=2){
																						if (trim($fila8['promedio'])!=""){
																							$PGral=((int) trim($fila8['promedio'])) + $PGral;
																							$cant=$cant + 1;

																							$PP3	=$PP3 + (int) trim($fila8['promedio']);
																							$cantP3	=$cantP3 + 1;
																						}
																					}
																				?>
																			</TD>
																			<!--TD>3c</TD-->
																			<TD></TD>
									<?php //}	?>
																<TD>
																	<?php 
																		if ($fila3['modo_eval']!=2){
																			if($cant!=0){
																				//echo ($PGral/$cant);
																				echo "<script>document.write(round((".$PGral."/".$cant."),0))</script>";

																				$PTot =((int) ($PGral/$cant)) + $PTot;
																				$cantT=$cantT+1;
																			}
																		}
																	?>
																</TD>
											<?php

														}//FIN TOTAL RAMOS DEL CURSO
													}//FIN SI LA CANTIDAD DE RESULTADOS ES <> 0
												};//FIN ELSE CONEXION RESULT3
											?>
		<!--FIN RAMO-->
															<TR height=5 bgcolor=black>
																<TD colspan=39></TD>
															</TR>
															<TR>
																<TD colspan=12></TD>
																<TD>
																	<?php 
																		if($cantP1!=0)
																			echo "<script>document.write(round((".$PP1."/".$cantP1."),0))</script>";
																	?>
																</TD>
																<TD colspan=11></TD>
																<TD>
																	<?php 
																		if($cantP2!=0)
																			echo "<script>document.write(round((".$PP2."/".$cantP2."),0))</script>";
																	?>
																</TD>
																<TD colspan=11></TD>
																<TD>
																	<?php 
																		if($cantP3!=0)
																			echo "<script>document.write(round((".$PP3."/".$cantP3."),0))</script>";
																	?>
																</TD>
																<TD></TD>
																<TD></TD>
															</TR>
															<TR height=20>
																<TD colspan=38></TD>
															</TR>
															<TR>
																<TD colspan=28></TD>
																<TD colspan=10>PROMEDIO GENERAL</TD>
																<TD>
																	<?php 
																		if($cantT!=0)
																			echo "<script>document.write(round((".$PTot."/".$cantT."),0))</script>";
																	?>
																</TD>
															</TR>
										</TABLE>
									</TD>
								</TR>
		<!-- FIN TRES PERIDOS -->
<?php }//FIN TRIMESTRAL?>

<?php if($_TIPOREGIMEN==3){//SEMESTRAL?>
		<!-- INICIO DOS PERIDOS -->						
								<TR>
									<TD>
										<TABLE BORDER=1 CELLSPACING=2 CELLPADDING=2 width=100%>
											<TR>
												<!--TD COLSPAN=46>NOTAS</TD-->
												<TD COLSPAN=31>NOTAS</TD>
											</TR>
											<TR>
											<?php
												$qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
												$result6 =@pg_Exec($conn,$qry6);
												if (!$result6) {
													error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												}else{
													if (pg_numrows($result6)!=0){
													?>
														<TD>SUBSECTORES</TD>
														<TD></TD>
														<TD colspan=9>
															<?php 
																$fila6 = @pg_fetch_array($result6,0);
																echo trim($fila6['nombre_periodo']);
																$idPer1=$fila6['id_periodo'];
															?>
														</TD>
														<TD></TD>
														<TD>PT</TD>
														<!--TD>PC</TD-->
														<TD></TD>
														<TD colspan=9>
															<?php 
																$fila6 = @pg_fetch_array($result6,1);
																echo trim($fila6['nombre_periodo']);
																$idPer2=$fila6['id_periodo'];
															?>
														</TD>
														<TD></TD>
														<TD>PT</TD>
														<!--TD>PC</TD-->
														<TD></TD>
														<TD>PG</TD>
													<?php
													}
												}
											?>
														</TR>
											<!--OBTENER RAMOS DEL CURSO Y POR CADA RAMO LAS NOTAS DEL ALUMNO-->
											<?php
												$PTot	=0;	//PROMEDIO TOTAL
												$cantT	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO TOTAL
												$PP1	=0;	//PROMEDIO PRIMER PERIODO
												$cantP1	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO PRIMER PERIODO
												$PP2	=0;	//PROMEDIO SEGUNDO PERIODO
												$cantP2	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO SEGUNDO PERIODO

												$qry3="SELECT * FROM RAMO WHERE ID_CURSO=".$curso;
												$result3 =@pg_Exec($conn,$qry3);
												if (!$result3) 
													error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
												else{
													if (pg_numrows($result3)!=0){
														$fila3 = @pg_fetch_array($result3,0);	
														if (!$fila3){
															error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
															exit();
														};
														for($i=0 ; $i < @pg_numrows($result3) ; $i++){//TOTAL RAMOS DEL CURSO
															//POR CADA RAMO DEL CURSO, PARA LOS TRES PERIODOS
															$fila3 = @pg_fetch_array($result3,$i);
															$PGral	=0;	//PROMEDIO GENERAL
															$cant	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO
											?>
															<TR>
																<TD><?php echo trim($fila3['nombre_ramo']);?></TD>
																<?php
																	//PRIMER PERIODO
																	$qry8="SELECT periodo.mostrar_notas, alumno.rut_alumno, nota.id_nota, nota.valor, periodo.id_periodo, califica.promedio FROM nota INNER JOIN (((alumno INNER JOIN califica ON alumno.rut_alumno = califica.rut_alumno) INNER JOIN ramo ON califica.id_ramo = ramo.id_ramo) INNER JOIN periodo ON califica.id_periodo = periodo.id_periodo) ON (nota.id_periodo = califica.id_periodo) AND (nota.rut_alumno = califica.rut_alumno) AND (nota.id_ramo = califica.id_ramo) WHERE (((alumno.rut_alumno)='".trim($alumno)."') AND ((periodo.id_periodo)=".$idPer1.") AND ((califica.id_ramo)=".$fila3['id_ramo']."))";
																	$result8 =@pg_Exec($conn,$qry8);
																?>
																<TD></TD>		<!--PRIMER PERIODO-->
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,0);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,1);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,2);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,3);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,4);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,5);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,6);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,7);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,8);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																<TD></TD>
																<TD>
																	<?php 
																		if($fila8['mostrar_notas'])
																		echo trim($fila8['promedio']);
																		if ($fila3['modo_eval']!=2){
																			if (trim($fila8['promedio'])!=""){
																				$PGral=(int) trim($fila8['promedio']);
																				$cant=1;

																				$PP1	=$PP1 + (int) trim($fila8['promedio']);
																				$cantP1	=$cantP1 + 1;

																			}
																		}
																	?>
																</TD>
																<!--TD>1c</TD-->
																<?php
																	//SEGUNDO PERIODO
																	$qry8="SELECT periodo.mostrar_notas, alumno.rut_alumno, nota.id_nota, nota.valor, periodo.id_periodo, califica.promedio FROM nota INNER JOIN (((alumno INNER JOIN califica ON alumno.rut_alumno = califica.rut_alumno) INNER JOIN ramo ON califica.id_ramo = ramo.id_ramo) INNER JOIN periodo ON califica.id_periodo = periodo.id_periodo) ON (nota.id_periodo = califica.id_periodo) AND (nota.rut_alumno = califica.rut_alumno) AND (nota.id_ramo = califica.id_ramo) WHERE (((alumno.rut_alumno)='".trim($alumno)."') AND ((periodo.id_periodo)=".$idPer2.") AND ((califica.id_ramo)=".$fila3['id_ramo']."))";
																	$result8 =@pg_Exec($conn,$qry8);
																?>
																<TD></TD>		<!--SEGUNDO PERIODO-->
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,0);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,1);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,2);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,3);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,4);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,5);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,6);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,7);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																	<TD >
																		<?php 
																			$fila8 = @pg_fetch_array($result8,8);
																			if($fila8['mostrar_notas'])
																			imp(trim($fila8['valor']));
																		?>
																	</TD> 
																<TD></TD>
																<TD>
																	<?php 
																		if($fila8['mostrar_notas'])
																		echo trim($fila8['promedio']);
																		if ($fila3['modo_eval']!=2){
																			if (trim($fila8['promedio'])!=""){
																				$PGral=((int) trim($fila8['promedio'])) + $PGral;
																				$cant=$cant + 1;

																				$PP2	=$PP2 + (int) trim($fila8['promedio']);
																				$cantP2	=$cantP2 + 1;
																			}
																		}
																	?>
																</TD>
																<!--TD>2c</TD-->
																<TD></TD>
									<?php //}	?>
																<TD>
																	<?php 
																		if ($fila3['modo_eval']!=2){
																			if($cant!=0){
																				//echo ($PGral/$cant);
																				echo "<script>document.write(round((".$PGral."/".$cant."),0))</script>";

																				$PTot =((int) ($PGral/$cant)) + $PTot;
																				$cantT=$cantT+1;
																			}
																		}
																	?>
																</TD>
											<?php

														}//FIN TOTAL RAMOS DEL CURSO
													}//FIN SI LA CANTIDAD DE RESULTADOS ES <> 0
												};//FIN ELSE CONEXION RESULT3
											?>
		<!--FIN RAMO-->
															<TR height=5 bgcolor=black>
																<TD colspan=29></TD>
															</TR>
															<TR>
																<TD colspan=12></TD>
																<TD>
																	<?php 
																		if($cantP1!=0)
																			echo "<script>document.write(round((".$PP1."/".$cantP1."),0))</script>";
																	?>
																</TD>
																<TD colspan=11></TD>
																<TD>
																	<?php 
																		if($cantP2!=0)
																			echo "<script>document.write(round((".$PP2."/".$cantP2."),0))</script>";
																	?>
																</TD>
																<TD></TD>
																<TD></TD>
															</TR>
															<TR height=20>
																<TD colspan=31></TD>
															</TR>
															<TR>
																<TD colspan=16></TD>
																<TD colspan=10>PROMEDIO GENERAL</TD>
																<TD>
																	<?php 
																		if($cantT!=0)
																			echo "<script>document.write(round((".$PTot."/".$cantT."),0))</script>";
																	?>
																</TD>
															</TR>
										</TABLE>
									</TD>
								</TR>
		<!-- FIN DOS PERIDOS -->
<?php }//FIN SEMESTRAL?>













		<TABLE WIDTH=800 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>ASISTENCIAS Y ATRASOS</strong>
								</FONT>
							</TD>
						</TR>
						<?php
							$qry="SELECT periodo.id_periodo, ano_escolar.id_ano FROM ano_escolar INNER JOIN periodo ON ano_escolar.id_ano = periodo.id_ano WHERE (((ano_escolar.id_ano)=".$ano."))";
							$result =@pg_Exec($conn,$qry);
							if (!$result) {
								error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
							}else{
								if (pg_numrows($result)!=0){//SI EXISTEN PERIODOS INGRESADOS
							?>

				<!-- DESPIEGUE PARA TRES PERIDOS -->
					<!-- ASISTENCIAS -->
							<!-- INICIO TRES PERIDOS -->						
							<TR>
								<TD>
									<TABLE BORDER=1 CELLSPACING=2 CELLPADDING=2 width=100%>
										<TR>
										<?php
											$qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
											$result6 =@pg_Exec($conn,$qry6);
											if (!$result6) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result6)!=0){
												?>
													<TD COLSPAN=3></TD>
													<TD colspan=12 ALIGN=CENTER>
														<?php 
															$fila6 = @pg_fetch_array($result6,0);
															echo trim($fila6['nombre_periodo']);
															$idPer1=$fila6['id_periodo'];
														?>
													</TD>
													<TD></TD>
													<TD colspan=12 ALIGN=CENTER>
														<?php 
															$fila6 = @pg_fetch_array($result6,1);
															echo trim($fila6['nombre_periodo']);
															$idPer2=$fila6['id_periodo'];
														?>
													</TD>
													<TD></TD>
													<TD colspan=12 ALIGN=CENTER>
														<?php 
															$fila6 = @pg_fetch_array($result6,2);
															echo trim($fila6['nombre_periodo']);
															$idPer3=$fila6['id_periodo'];
														?>
													</TD>
													<TD></TD>
													<TD colspan=12 ALIGN=CENTER>
														TOTAL AÑO
													</TD>
												<?php
												}
											}
										?>
										</TR>
										<TR>
											<TD COLSPAN=3 ROWSPAN=3>ASISTENCIAS</TD>
											<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
											<TD colspan=3 ALIGN=CENTER>SI ASIST.</TD>
											<TD colspan=3 ALIGN=CENTER>NO ASIST.</TD>
											<TD colspan=3 ALIGN=CENTER>%</TD>
											<TD></TD>
											<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
											<TD colspan=3 ALIGN=CENTER>SI ASIST.</TD>
											<TD colspan=3 ALIGN=CENTER>NO ASIST.</TD>
											<TD colspan=3 ALIGN=CENTER>%</TD>
											<TD></TD>
											<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
											<TD colspan=3 ALIGN=CENTER>SI ASIST.</TD>
											<TD colspan=3 ALIGN=CENTER>NO ASIST.</TD>
											<TD colspan=3 ALIGN=CENTER>%</TD>
											<TD></TD>
											<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
											<TD colspan=3 ALIGN=CENTER>SI ASIST.</TD>
											<TD colspan=3 ALIGN=CENTER>NO ASIST.</TD>
											<TD colspan=3 ALIGN=CENTER>%</TD>
										</TR>
										<TR>
											<?php
												$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$idPer1;
												$result =@pg_Exec($conn,$qry);
												if (!$result) {
													error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												}else{
													if (pg_numrows($result)!=0){
														$fila = @pg_fetch_array($result,0);	
														if (!$fila){
															error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
															exit();
														}
														$hP1  =$fila['dias_habiles'];
														$fIni =$fila['fecha_inicio'];
														$fTer =$fila['fecha_termino'];

														$qry="SELECT * FROM ANOTACION WHERE TIPO=3 AND FECHA BETWEEN '".$fIni."' AND '".$fTer."'";
														$result			=@pg_Exec($conn,$qry);
														$cantInasist1	=pg_numrows($result);
														$cantAsist1		= ($hP1-$cantInasist1);
													}
												}
											?>
											<TD colspan=3 ALIGN=CENTER><?php echo $hP1;?></TD>
											<TD colspan=3 ALIGN=CENTER><?php echo $cantAsist1;?></TD>
											<TD colspan=3 ALIGN=CENTER><?php echo $cantInasist1;?></TD>
											<TD colspan=3 ALIGN=CENTER><?php echo round((($cantAsist1*100)/$hP1));?>%</TD>
											<TD></TD>
											<?php
												$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$idPer2;
												$result =@pg_Exec($conn,$qry);
												if (!$result) {
													error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												}else{
													if (pg_numrows($result)!=0){
														$fila = @pg_fetch_array($result,0);	
														if (!$fila){
															error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
															exit();
														}
														$hP2  =$fila['dias_habiles'];
														$fIni =$fila['fecha_inicio'];
														$fTer =$fila['fecha_termino'];

														$qry="SELECT * FROM ANOTACION WHERE TIPO=3 AND FECHA BETWEEN '".$fIni."' AND '".$fTer."'";
														$result			=@pg_Exec($conn,$qry);
														$cantInasist2	=pg_numrows($result);
														$cantAsist2		= ($hP2-$cantInasist2);
													}
												}
											?>
											<TD colspan=3 ALIGN=CENTER><?php echo $hP2;?></TD>
											<TD colspan=3 ALIGN=CENTER><?php echo $cantAsist2;?></TD>
											<TD colspan=3 ALIGN=CENTER><?php echo $cantInasist2;?></TD>
											<TD colspan=3 ALIGN=CENTER><?php echo round((($cantAsist2*100)/$hP2),0);?>%</TD>
											<TD></TD>
											<?php
												$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$idPer3;
												$result =@pg_Exec($conn,$qry);
												if (!$result) {
													error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												}else{
													if (pg_numrows($result)!=0){
														$fila = @pg_fetch_array($result,0);	
														if (!$fila){
															error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
															exit();
														}
														$hP3  =$fila['dias_habiles'];
														$fIni =$fila['fecha_inicio'];
														$fTer =$fila['fecha_termino'];

														$qry="SELECT * FROM ANOTACION WHERE TIPO=3 AND FECHA BETWEEN '".$fIni."' AND '".$fTer."'";
														$result			=@pg_Exec($conn,$qry);
														$cantInasist3	=pg_numrows($result);
														$cantAsist3		= ($hP3-$cantInasist3);
													}
												}
											?>
											<TD colspan=3 ALIGN=CENTER><?php echo $hP3;?></TD>
											<TD colspan=3 ALIGN=CENTER><?php echo $cantAsist3;?></TD>
											<TD colspan=3 ALIGN=CENTER><?php echo $cantInasist3;?></TD>
											<TD colspan=3 ALIGN=CENTER><?php echo round((($cantAsist3*100)/$hP3),0);?>%</TD>
											<TD></TD>
											<TD colspan=3 ALIGN=CENTER><?php echo ($hP1+$hP2+$hP3);?></TD>
											<TD colspan=3 ALIGN=CENTER><?php echo ($cantAsist1+$cantAsist2+$cantAsist3);?></TD>
											<TD colspan=3 ALIGN=CENTER><?php echo $cantInasist1+$cantInasist2+$cantInasist3;?></TD>
											<TD colspan=3 ALIGN=CENTER><?php echo round(((($cantAsist1+$cantAsist2+$cantAsist3)*100)/($hP1+$hP2+$hP3)),1);?>%</TD>
										</TR>
										<TR>
											<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
											<TD></TD>
											<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
											<TD></TD>
											<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
											<TD></TD>
											<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
										</TR>
									</TABLE>
								</TD>
							</TR>
							<!--TR>
								<TD colspan=4>
									<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
										<TR>
											<TD>
												<HR width="100%" color=#0099cc>
											</TD>
										</TR>
									</TABLE>
								</TD>
							</TR-->
							<!-- FIN TRES PERIDOS -->

					<!-- ATRASOS -->
							<!-- INICIO TRES PERIDOS -->
							<TR>
								<TD>
									<TABLE BORDER=1 CELLSPACING=2 CELLPADDING=2 width=100%>
										<TR>
										<?php
											$qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
											$result6 =@pg_Exec($conn,$qry6);
											if (!$result6) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result6)!=0){
												?>
													<TD COLSPAN=3></TD>
													<TD colspan=12 ALIGN=CENTER>
														<?php 
															$fila6 = @pg_fetch_array($result6,0);
															echo trim($fila6['nombre_periodo']);
															$idPer1=$fila6['id_periodo'];
														?>
													</TD>
													<TD></TD>
													<TD colspan=12 ALIGN=CENTER>
														<?php 
															$fila6 = @pg_fetch_array($result6,1);
															echo trim($fila6['nombre_periodo']);
															$idPer2=$fila6['id_periodo'];
														?>
													</TD>
													<TD></TD>
													<TD colspan=12 ALIGN=CENTER>
														<?php 
															$fila6 = @pg_fetch_array($result6,2);
															echo trim($fila6['nombre_periodo']);
															$idPer3=$fila6['id_periodo'];
														?>
													</TD>
													<TD></TD>
													<TD colspan=12 ALIGN=CENTER>
														TOTAL AÑO
													</TD>
												<?php
												}
											}
										?>
										</TR>
										<TR>
											<TD COLSPAN=3 ROWSPAN=3>ATRASOS</TD>
											<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
											<TD colspan=6 ALIGN=CENTER>DIAS ATRASADOS</TD>
											<!--TD colspan=3 ALIGN=CENTER>TIEMPO ATRASO</TD-->
											<TD colspan=3 ALIGN=CENTER>%</TD>
											<TD></TD>
											<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
											<TD colspan=6 ALIGN=CENTER>DIAS ATRASADOS</TD>
											<!--TD colspan=3 ALIGN=CENTER>TIEMPO ATRASO</TD-->
											<TD colspan=3 ALIGN=CENTER>%</TD>
											<TD></TD>
											<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
											<TD colspan=6 ALIGN=CENTER>DIAS ATRASADOS</TD>
											<!--TD colspan=3 ALIGN=CENTER>TIEMPO ATRASO</TD-->
											<TD colspan=3 ALIGN=CENTER>%</TD>
											<TD></TD>
											<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
											<TD colspan=6 ALIGN=CENTER>DIAS ATRASADOS</TD>
											<!--TD colspan=3 ALIGN=CENTER>TIEMPO ATRASO</TD-->
											<TD colspan=3 ALIGN=CENTER>%</TD>
										</TR>
										<TR>
											<?php
												$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$idPer1;
												$result =@pg_Exec($conn,$qry);
												if (!$result) {
													error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												}else{
													if (pg_numrows($result)!=0){
														$fila = @pg_fetch_array($result,0);	
														if (!$fila){
															error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
															exit();
														}
														$hP1  =$fila['dias_habiles'];
														$fIni =$fila['fecha_inicio'];
														$fTer =$fila['fecha_termino'];

														$qry="SELECT * FROM ANOTACION WHERE TIPO=2 AND FECHA BETWEEN '".$fIni."' AND '".$fTer."'";
														$result			=@pg_Exec($conn,$qry);
														$cantDiasAt1	=pg_numrows($result);

													}
												}
											?>
											<TD colspan=3 ALIGN=CENTER><?php echo $hP1;?></TD>
											<TD colspan=6 ALIGN=CENTER><?php echo $cantDiasAt1;?></TD>
											<!--TD colspan=3 ALIGN=CENTER><?php echo $cantHrAt1;?></TD-->
											<TD colspan=3 ALIGN=CENTER><?php echo round(((($cantDiasAt1)*100)/($hP1)),1);?>%</TD>
											<TD></TD>
											<?php
												$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$idPer2;
												$result =@pg_Exec($conn,$qry);
												if (!$result) {
													error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												}else{
													if (pg_numrows($result)!=0){
														$fila = @pg_fetch_array($result,0);	
														if (!$fila){
															error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
															exit();
														}
														$hP2  =$fila['dias_habiles'];
														$fIni =$fila['fecha_inicio'];
														$fTer =$fila['fecha_termino'];

														$qry="SELECT * FROM ANOTACION WHERE TIPO=2 AND FECHA BETWEEN '".$fIni."' AND '".$fTer."'";
														$result			=@pg_Exec($conn,$qry);
														$cantDiasAt2	=pg_numrows($result);

													}
												}
											?>
											<TD colspan=3 ALIGN=CENTER><?php echo $hP2;?></TD>
											<TD colspan=6 ALIGN=CENTER><?php echo $cantDiasAt2;?></TD>
											<!--TD colspan=3 ALIGN=CENTER><?php echo $cantHrAt2;?></TD-->
											<TD colspan=3 ALIGN=CENTER><?php echo round(((($cantDiasAt2)*100)/($hP2)),1);?>%</TD>
											<TD></TD>
											<?php
												$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$idPer3;
												$result =@pg_Exec($conn,$qry);
												if (!$result) {
													error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												}else{
													if (pg_numrows($result)!=0){
														$fila = @pg_fetch_array($result,0);	
														if (!$fila){
															error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
															exit();
														}
														$hP3  =$fila['dias_habiles'];
														$fIni =$fila['fecha_inicio'];
														$fTer =$fila['fecha_termino'];

														$qry="SELECT * FROM ANOTACION WHERE TIPO=2 AND FECHA BETWEEN '".$fIni."' AND '".$fTer."'";
														$result			=@pg_Exec($conn,$qry);
														$cantDiasAt3	=pg_numrows($result);

													}
												}
											?>
											<TD colspan=3 ALIGN=CENTER><?php echo $hP3;?></TD>
											<TD colspan=6 ALIGN=CENTER><?php echo $cantDiasAt3;?></TD>
											<!--TD colspan=3 ALIGN=CENTER><?php echo $cantHrAt3;?></TD-->
											<TD colspan=3 ALIGN=CENTER><?php echo round(((($cantDiasAt3)*100)/($hP3)),1);?>%</TD>
											<TD></TD>
											<TD colspan=3 ALIGN=CENTER><?php echo ($hP1+$hP2+$hP3);?></TD>
											<TD colspan=6 ALIGN=CENTER><?php echo ($cantDiasAt1+$cantDiasAt2+$cantDiasAt3);?></TD>
											<TD colspan=3 ALIGN=CENTER><?php echo round(((($cantDiasAt1+$cantDiasAt2+$cantDiasAt3)*100)/($hP1+$hP2+$hP3)),1);?>%</TD>

										</TR>
										<TR>
											<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
											<TD></TD>
											<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
											<TD></TD>
											<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
											<TD></TD>
											<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
										</TR>
									</TABLE>
								</TD>
							</TR>
							<!--TR>
								<TD colspan=4>
									<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
										<TR>
											<TD>
												<HR width="100%" color=#0099cc>
											</TD>
										</TR>
									</TABLE>
								</TD>
							</TR-->
							<!-- FIN TRES PERIDOS -->
				<!-- FIN DESPLIEGUE PARA 3 PERIODOS -->

							<?php

								}else{
							?>
						<TR>
							<TD colspan=4>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=2 color=#000000>
												<STRONG>(No existen PERIODOS ingresados para este AÑO ACADEMICO)</STRONG>
											</FONT>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>

							<?php
								}
							}
						?>































































		<TABLE WIDTH=800 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>OBSERVACIONES</strong>
								</FONT>
							</TD>
						</TR>
						<?php
							$qry="SELECT periodo.id_periodo, ano_escolar.id_ano FROM ano_escolar INNER JOIN periodo ON ano_escolar.id_ano = periodo.id_ano WHERE (((ano_escolar.id_ano)=".$ano."))";
							$result =@pg_Exec($conn,$qry);
							if (!$result) {
								error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
							}else{
								if (pg_numrows($result)!=0){//SI EXISTEN PERIODOS INGRESADOS
							?>

							<!--NOMBRES DE LOS PERIODOS-->
							<?php
								$qry6="SELECT periodo.fecha_inicio,periodo.fecha_termino, periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
								$result6 =@pg_Exec($conn,$qry6);
								if (!$result6) {
									error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
								}else{
									if (pg_numrows($result6)!=0){
										$fila6 =@pg_fetch_array($result6,0);
										$nbPer1=$fila6['nombre_periodo'];
										$idPer1=$fila6['id_periodo'];
										$fInip1=$fila6['fecha_inicio'];
										$fFinp1=$fila6['fecha_termino'];
										
										$fila6 =@pg_fetch_array($result6,1);
										$nbPer2=$fila6['nombre_periodo'];
										$idPer2=$fila6['id_periodo'];
										$fInip2=$fila6['fecha_inicio'];
										$fFinp2=$fila6['fecha_termino'];

										$fila6 =@pg_fetch_array($result6,2);
										$nbPer3=$fila6['nombre_periodo'];
										$idPer3=$fila6['id_periodo'];
										$fInip3=$fila6['fecha_inicio'];
										$fFinp3=$fila6['fecha_termino'];
									}
								}
							?>
<?php if($_TIPOREGIMEN==1){//BIMESTRAL?>
		<!-- INICIO CUATRO PERIDOS -->						
			EN CONSTRUCCION
		<!-- FIN 4 PERIODOS -->
<?php }//FIN BIMESTRAL?>

<?php if($_TIPOREGIMEN==2){//TRIMESTRAL?>
		<!-- INICIO TRES PERIDOS -->						
		<!-- PRIMER PERIODO -->
	<TR>
		<TD align=CENTER>
			<? echo $nbPer1?>
		</TD>
	</TR>
	<?php
		$qry="SELECT anotacion.fecha, anotacion.observacion, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM ((anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((matricula.rut_alumno)='".trim($alumno)."') AND ((matricula.rdb)=".$institucion.") AND ((matricula.id_ano)=".$ano.") AND ((anotacion.tipo)=1)) AND anotacion.fecha BETWEEN '".$fInip1."' AND '".$fFinp1."'";
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
				for($i=0 ; $i < @pg_numrows($result) ; $i++){
					$fila1 = @pg_fetch_array($result,$i);
					?>
						<TR>
							<TD >
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR valign=top>
										<TD width=50>FECHA</TD><TD>:</TD><TD><?php impF($fila1["fecha"])?></TD>
									</TR>
									<TR>
										<TD>OBS</TD><TD>:</TD><TD>&nbsp;&nbsp;&nbsp;<?php echo $fila1['observacion']?></TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD align=center>
								<hr width="80%" color="black">
							</TD>
						</TR>
					<?php
				}
			}else{
			?>
			<TR>
				<TD>NO EXISTEN OBSERVACIONES REGISTRADAS
				</TD>
			</TR>
			<?php
			}
		};
	?>

	<!-- SEGUNDO PERIODO -->
	<TR>
		<TD align=CENTER>
			<? echo $nbPer2?>
		</TD>
	</TR>
	<?php
		$qry="SELECT anotacion.fecha, anotacion.observacion, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM ((anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((matricula.rut_alumno)='".trim($alumno)."') AND ((matricula.rdb)=".$institucion.") AND ((matricula.id_ano)=".$ano.") AND ((anotacion.tipo)=1)) AND anotacion.fecha BETWEEN '".$fInip2."' AND '".$fFinp2."'";
		$result =@pg_Exec($conn,$qry);
		if (!$result) 
			error('<B> ERROR :</b>Error al acceder a la BD. (9)</B>');
		else{
			if (pg_numrows($result)!=0){
				$fila1 = @pg_fetch_array($result,0);	
				if (!$fila1){
					error('<B> ERROR :</b>Error al acceder a la BD. (10)</B>');
					exit();
				};
				for($i=0 ; $i < @pg_numrows($result) ; $i++){
					$fila1 = @pg_fetch_array($result,$i);
					?>
						<TR>
							<TD >
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR valign=top>
										<TD width=50>FECHA</TD><TD>:</TD><TD><?php impF($fila1["fecha"])?></TD>
									</TR>
									<TR>
										<TD>OBS</TD><TD>:</TD><TD>&nbsp;&nbsp;&nbsp;<?php echo $fila1['observacion']?></TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD align=center>
								<hr width="80%" color="black">
							</TD>
						</TR>
					<?php
				}
			}else{
			?>
			<TR>
				<TD>NO EXISTEN OBSERVACIONES REGISTRADAS
				</TD>
			</TR>
			<?php
			}
		};
	?>

	<!-- TERCER PERIODO -->
	<TR>
		<TD align=CENTER>
			<? echo $nbPer3?>
		</TD>
	</TR>
	<?php
		$qry="SELECT anotacion.fecha, anotacion.observacion, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM ((anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((matricula.rut_alumno)='".trim($alumno)."') AND ((matricula.rdb)=".$institucion.") AND ((matricula.id_ano)=".$ano.") AND ((anotacion.tipo)=1)) AND anotacion.fecha BETWEEN '".$fInip3."' AND '".$fFinp3."'";
		$result =@pg_Exec($conn,$qry);
		if (!$result) 
			error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>'.$qry);
		else{
			if (pg_numrows($result)!=0){
				$fila1 = @pg_fetch_array($result,0);	
				if (!$fila1){
					error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
					exit();
				};
				for($i=0 ; $i < @pg_numrows($result) ; $i++){
					$fila1 = @pg_fetch_array($result,$i);
					?>
						<TR>
							<TD >
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR valign=top>
										<TD width=50>FECHA</TD><TD>:</TD><TD><?php impF($fila1["fecha"])?></TD>
									</TR>
									<TR>
										<TD>OBS</TD><TD>:</TD><TD>&nbsp;&nbsp;&nbsp;<?php echo $fila1['observacion']?></TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD align=center>
								<hr width="80%" color="black">
							</TD>
						</TR>
					<?php
				}
			}else{
			?>
			<TR>
				<TD>NO EXISTEN OBSERVACIONES REGISTRADAS
				</TD>
			</TR>
			<?php
			}
		};
	?>
<!-- FIN 3 PERIODOS -->
<?php }//FIN TRIMESTRAL?>

<?php if($_TIPOREGIMEN==3){//SEMESTRAL?>
		<!-- INICIO 2 PERIDOS -->						
	<!-- PRIMER PERIODO -->
	<TR>
		<TD align=CENTER>
			<? echo $nbPer1?>
		</TD>
	</TR>
	<?php
		$qry="SELECT anotacion.fecha, anotacion.observacion, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM ((anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((matricula.rut_alumno)='".trim($alumno)."') AND ((matricula.rdb)=".$institucion.") AND ((matricula.id_ano)=".$ano.") AND ((anotacion.tipo)=1)) AND anotacion.fecha BETWEEN '".$fInip1."' AND '".$fFinp1."'";
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
				for($i=0 ; $i < @pg_numrows($result) ; $i++){
					$fila1 = @pg_fetch_array($result,$i);
					?>
						<TR>
							<TD >
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR valign=top>
										<TD width=50>FECHA</TD><TD>:</TD><TD><?php impF($fila1["fecha"])?></TD>
									</TR>
									<TR>
										<TD>OBS</TD><TD>:</TD><TD>&nbsp;&nbsp;&nbsp;<?php echo $fila1['observacion']?></TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD align=center>
								<hr width="80%" color="black">
							</TD>
						</TR>
					<?php
				}
			}else{
			?>
			<TR>
				<TD>NO EXISTEN OBSERVACIONES REGISTRADAS
				</TD>
			</TR>
			<?php
			}
		};
	?>

	<!-- SEGUNDO PERIODO -->
	<TR>
		<TD align=CENTER>
			<? echo $nbPer2?>
		</TD>
	</TR>
	<?php
		$qry="SELECT anotacion.fecha, anotacion.observacion, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM ((anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((matricula.rut_alumno)='".trim($alumno)."') AND ((matricula.rdb)=".$institucion.") AND ((matricula.id_ano)=".$ano.") AND ((anotacion.tipo)=1)) AND anotacion.fecha BETWEEN '".$fInip2."' AND '".$fFinp2."'";
		$result =@pg_Exec($conn,$qry);
		if (!$result) 
			error('<B> ERROR :</b>Error al acceder a la BD. (9)</B>');
		else{
			if (pg_numrows($result)!=0){
				$fila1 = @pg_fetch_array($result,0);	
				if (!$fila1){
					error('<B> ERROR :</b>Error al acceder a la BD. (10)</B>');
					exit();
				};
				for($i=0 ; $i < @pg_numrows($result) ; $i++){
					$fila1 = @pg_fetch_array($result,$i);
					?>
						<TR>
							<TD >
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR valign=top>
										<TD width=50>FECHA</TD><TD>:</TD><TD><?php impF($fila1["fecha"])?></TD>
									</TR>
									<TR>
										<TD>OBS</TD><TD>:</TD><TD>&nbsp;&nbsp;&nbsp;<?php echo $fila1['observacion']?></TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD align=center>
								<hr width="80%" color="black">
							</TD>
						</TR>
					<?php
				}
			}else{
			?>
			<TR>
				<TD>NO EXISTEN OBSERVACIONES REGISTRADAS
				</TD>
			</TR>
			<?php
			}
		};
	?>
<?php }//FIN SEMESTRAL?>
						
							<?php
								}else{
								?>
									<TR>
										<TD colspan=4>
											<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD>
														<FONT face="arial, geneva, helvetica" size=2 color=#000000>
															<STRONG>(No existen PERIODOS ingresados para este AÑO ACADEMICO)</STRONG>
														</FONT>
													</TD>
												</TR>
											</TABLE>
										</TD>
									</TR>
								<?php
								}
							}
						?>
					</TABLE>
				</TD>
			</TR>
		</TABLE>











































						<TR>
							<TD colspan=4>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<HR width="100%" color=#0099cc>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
					</TABLE>

				</TD>
			</TR>
		</TABLE>
	</FORM>
</BODY>
</HTML>