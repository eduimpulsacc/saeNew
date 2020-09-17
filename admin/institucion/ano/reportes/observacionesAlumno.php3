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
<BODY>
	<?php echo tope("../../../../util/");?>
	<FORM method=post name="frm" action="procesoAlumno.php3">
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
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
								<INPUT TYPE="button" value="IMPRIMIR" onClick=document.location="observacionesAlumnoIMP.php3?alumno=<?php echo $alumno;?>&curso=<?php echo $curso;?>">
								<INPUT TYPE="button" value="VOLVER" onClick=document.location="observacionesPorAlumno2.php3?curso=<?php echo $curso?>">
							</TD>
						</TR>
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>INFORME DE OBSERVACIONES</strong>
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





										<?php if($_TIPOREGIMEN==2){//TRIMESTRAL?>
											<!-- INICIO TRES PERIDOS -->						
											<!-- PRIMER PERIODO -->
											<TR>
												<TD align=CENTER>
													<? echo $nbPer1?>
												</TD>
											</TR>
										<?php
											$qry="SELECT anotacion.fecha, anotacion.observacion, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM ((anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((matricula.rut_alumno)=".$alumno.") AND ((matricula.rdb)=".$institucion.") AND ((matricula.id_ano)=".$ano.") AND ((anotacion.tipo)=1)) AND anotacion.fecha BETWEEN '".$fInip1."' AND '".$fFinp1."'";
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
											$qry="SELECT anotacion.fecha, anotacion.observacion, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM ((anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((matricula.rut_alumno)=".$alumno.") AND ((matricula.rdb)=".$institucion.") AND ((matricula.id_ano)=".$ano.") AND ((anotacion.tipo)=1)) AND anotacion.fecha BETWEEN '".$fInip2."' AND '".$fFinp2."'";
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
											$qry="SELECT anotacion.fecha, anotacion.observacion, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM ((anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((matricula.rut_alumno)=".$alumno.") AND ((matricula.rdb)=".$institucion.") AND ((matricula.id_ano)=".$ano.") AND ((anotacion.tipo)=1)) AND anotacion.fecha BETWEEN '".$fInip3."' AND '".$fFinp3."'";
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
											$qry="SELECT anotacion.fecha, anotacion.observacion, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM ((anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((matricula.rut_alumno)=".$alumno.") AND ((matricula.rdb)=".$institucion.") AND ((matricula.id_ano)=".$ano.") AND ((anotacion.tipo)=1)) AND anotacion.fecha BETWEEN '".$fInip1."' AND '".$fFinp1."'";
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
											$qry="SELECT anotacion.fecha, anotacion.observacion, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM ((anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((matricula.rut_alumno)=".$alumno.") AND ((matricula.rdb)=".$institucion.") AND ((matricula.id_ano)=".$ano.") AND ((anotacion.tipo)=1)) AND anotacion.fecha BETWEEN '".$fInip2."' AND '".$fFinp2."'";
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
			<tr>
				<td colspan="2">
				<hr width="100%" color="#0099cc">
				</td>
			</tr>
		</TABLE>
	</FORM>
</BODY>
</HTML>