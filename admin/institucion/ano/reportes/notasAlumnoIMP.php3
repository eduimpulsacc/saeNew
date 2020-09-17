<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
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
							<td rowspan=4 valign=meddle>
								<?php
									$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
									$arr=@pg_fetch_array($result,0);

									$output= "select lo_export(".$arr[insignia].",'/var/www/html/tmp/".$arr[rdb]."');";
									$retrieve_result = @pg_exec($conn,$output);
								?>
								<img src=../../../../../tmp/<?php echo $arr[rdb] ?> ALT="NO DISPONIBLE" width=75>
							</td>
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
											$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
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

							</TD>
						</TR>
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>INFORME DE NOTAS</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD>

					
					<?php if($_TIPOREGIMEN==2 ){//TRIMESTRAL?>
					<!-- INICIO TRES PERIDOS -->						
						<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
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

											$qry3="SELECT subsector.nombre as nombre_ramo, ramo.id_ramo FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_curso)=".$curso."))";

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
																$qry8="SELECT periodo.mostrar_notas, alumno.rut_alumno, nota.id_nota, nota.valor, periodo.id_periodo, califica.promedio FROM nota INNER JOIN (((alumno INNER JOIN califica ON alumno.rut_alumno = califica.rut_alumno) INNER JOIN ramo ON califica.id_ramo = ramo.id_ramo) INNER JOIN periodo ON califica.id_periodo = periodo.id_periodo) ON (nota.id_periodo = califica.id_periodo) AND (nota.rut_alumno = califica.rut_alumno) AND (nota.id_ramo = califica.id_ramo) WHERE (((alumno.rut_alumno)=".$alumno.") AND ((periodo.id_periodo)=".$idPer1.") AND ((califica.id_ramo)=".$fila3['id_ramo']."))";
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
																$qry8="SELECT periodo.mostrar_notas, alumno.rut_alumno, nota.id_nota, nota.valor, periodo.id_periodo, califica.promedio FROM nota INNER JOIN (((alumno INNER JOIN califica ON alumno.rut_alumno = califica.rut_alumno) INNER JOIN ramo ON califica.id_ramo = ramo.id_ramo) INNER JOIN periodo ON califica.id_periodo = periodo.id_periodo) ON (nota.id_periodo = califica.id_periodo) AND (nota.rut_alumno = califica.rut_alumno) AND (nota.id_ramo = califica.id_ramo) WHERE (((alumno.rut_alumno)=".$alumno.") AND ((periodo.id_periodo)=".$idPer2.") AND ((califica.id_ramo)=".$fila3['id_ramo']."))";
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
																$qry8="SELECT periodo.mostrar_notas, alumno.rut_alumno, nota.id_nota, nota.valor, periodo.id_periodo, califica.promedio FROM nota INNER JOIN (((alumno INNER JOIN califica ON alumno.rut_alumno = califica.rut_alumno) INNER JOIN ramo ON califica.id_ramo = ramo.id_ramo) INNER JOIN periodo ON califica.id_periodo = periodo.id_periodo) ON (nota.id_periodo = califica.id_periodo) AND (nota.rut_alumno = califica.rut_alumno) AND (nota.id_ramo = califica.id_ramo) WHERE (((alumno.rut_alumno)=".$alumno.") AND ((periodo.id_periodo)=".$idPer3.") AND ((califica.id_ramo)=".$fila3['id_ramo']."))";
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
						</TABLE>
					<!-- FIN TRES PERIODOS-->
					<?php }//FIN TRIMESTRAL?>
					
					<?php if($_TIPOREGIMEN==3){//SEMESTRAL?>
					<!-- INICIO DOS PERIDOS -->						
						<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
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

											$qry3="SELECT subsector.nombre as nombre_ramo, ramo.id_ramo FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_curso)=".$curso."))";
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
																$qry8="SELECT periodo.mostrar_notas, alumno.rut_alumno, nota.id_nota, nota.valor, periodo.id_periodo, califica.promedio FROM nota INNER JOIN (((alumno INNER JOIN califica ON alumno.rut_alumno = califica.rut_alumno) INNER JOIN ramo ON califica.id_ramo = ramo.id_ramo) INNER JOIN periodo ON califica.id_periodo = periodo.id_periodo) ON (nota.id_periodo = califica.id_periodo) AND (nota.rut_alumno = califica.rut_alumno) AND (nota.id_ramo = califica.id_ramo) WHERE (((alumno.rut_alumno)=".$alumno.") AND ((periodo.id_periodo)=".$idPer1.") AND ((califica.id_ramo)=".$fila3['id_ramo']."))";
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
																$qry8="SELECT periodo.mostrar_notas, alumno.rut_alumno, nota.id_nota, nota.valor, periodo.id_periodo, califica.promedio FROM nota INNER JOIN (((alumno INNER JOIN califica ON alumno.rut_alumno = califica.rut_alumno) INNER JOIN ramo ON califica.id_ramo = ramo.id_ramo) INNER JOIN periodo ON califica.id_periodo = periodo.id_periodo) ON (nota.id_periodo = califica.id_periodo) AND (nota.rut_alumno = califica.rut_alumno) AND (nota.id_ramo = califica.id_ramo) WHERE (((alumno.rut_alumno)=".$alumno.") AND ((periodo.id_periodo)=".$idPer2.") AND ((califica.id_ramo)=".$fila3['id_ramo']."))";
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
						</TABLE>
					<!-- FIN DOS PERIDOS -->
					<?php }//FIN SEMESTRAL?>
					
					
					
					
					
					

							</TD>
						</TR>

					
					
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	</FORM>
</BODY>
</HTML>