<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$alumno			=$alumno;
//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	
?>

<?php	/************************************************************************************/
		/*--------------------------- FUNCION NOTAS CONCEPTUALES ---------------------------*/
		/************************************************************************************/	
			function  conceptual($nota1,$nota2,$nota3,$periodo){
				$ArrayNotas[0][0] = "MB";
				$ArrayNotas[0][1] = 60;
				$ArrayNotas[0][2] = 70;
				$ArrayNotas[1][0] = "B";
				$ArrayNotas[1][1] = 50;
				$ArrayNotas[1][2] = 60;
				$ArrayNotas[2][0] = "S";
				$ArrayNotas[2][1] = 40;
				$ArrayNotas[2][2] = 50;
				$ArrayNotas[3][0] = "I";
				$ArrayNotas[3][1] = 30;
				$ArrayNotas[3][2] = 40;
				$valnota1 = 0;
				$valnota2 = 0;
				$valnota3 = 0;
				$sumanotas = 0;
				$promedio = "";
				//echo ("Nota1=".$nota1." Nota2=".$nota2." Nota3=".$nota3."<br>");
				for($i=0;$i<count($ArrayNotas);$i++){
					if ($nota1 == $ArrayNotas[$i][0]){
						$valnota1 = $ArrayNotas[$i][2];
					};
					if ($nota2 == $ArrayNotas[$i][0]){
						$valnota2 = $ArrayNotas[$i][2];
					};
					if ($nota3 == $ArrayNotas[$i][0]){
						$valnota3 = $ArrayNotas[$i][2];
					};
				};
				//echo ("Valor1=".$valnota1." Valor2=".$valnota2. "Valor3=".$valnota3."<br>");
				$sumanotas = intval($valnota1) + intval($valnota2) + intval($valnota3);
				//echo ("Sumatoria=".$sumanotas." Periodo=" . $periodo . "<br>");

				if ($periodo!=0)
				$sumanotas = round($sumanotas / $periodo);

				//echo ("Resultado=".$sumanotas. "<br>");
				for($i=0;$i<count($ArrayNotas);$i++){
					if ((round($sumanotas/10)*10> $ArrayNotas[$i][1]) && (round($sumanotas/10)*10 <= $ArrayNotas[$i][2])){
						//echo ("i=".$i."<br>");
						$promedio = $ArrayNotas[$i][0];
						break;
					};
				};
	
				//echo ("Promedio=".$promedio);
				//exit();
				return $promedio;
			};
		
		/************************************************************************************/
		/*------------------------- FIN FUNCION NOTAS CONCEPTUALES -------------------------*/
		/************************************************************************************/
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
<BODY >
	<?php echo tope("../../../../../util/");?>
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
											$qry="SELECT nombre_instit,tipo_regimen FROM INSTITUCION WHERE RDB=".$institucion;
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
													$TipoRegimen = intval(Trim($fila1['tipo_regimen']));
													if ($TipoRegimen==2){ /*--- Trimestre ---*/
														$TipoRegimen = 3;
													}else{ /*--- Semestre ---*/
														$TipoRegimen = 2;
													};
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
								<INPUT TYPE="button" value="VOLVER" onClick=document.location="notasPorAlumno2.php3?curso=<?php echo $curso; ?>">
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




					<?php if(($_TIPOREGIMEN==2 )||($TipoRegimen==2)){//TRIMESTRAL?>
					<!-- INICIO TRES PERIDOS -->						
						<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
							<TR>
								
                  <TD> <table border=1 cellspacing=2 cellpadding=2 width=100%>
                      <tr> 
                        <!--TD COLSPAN=46>NOTAS</TD-->
                        <td colspan=40>NOTAS</td>
                      </tr>
                      <tr> 
                        <?php
											$qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
											$result6 =@pg_Exec($conn,$qry6);
											if (!$result6) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result6)!=0){
												?>
                        <td width="15%">SUBSECTORES</td>
                        <td width="1%"></td>
                        <td colspan=20> 
                          <?php 
															$fila6 = @pg_fetch_array($result6,0);
															echo trim($fila6['nombre_periodo']);
															$idPer1=$fila6['id_periodo'];
														?>
                        </td>
                        <td width="1%"></td>
                        <td width="3%">PT</td>
                        <!--TD>PC</TD-->
                        <td width="3%"></td>
                        <td width="3%"></td>
                        <td width="3%"></td>
                        <?php
												}
											}
										?>
                      </tr>
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

											$qry3="SELECT  subsector.nombre as nombre_ramo, ramo.id_ramo, ramo.modo_eval FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector) INNER JOIN tiene$nro_ano ON (ramo.id_curso = tiene$nro_ano.id_curso)and (ramo.id_ramo =tiene$nro_ano.id_ramo) WHERE (((tiene$nro_ano.id_curso)=".$curso.")and ((tiene$nro_ano.rut_alumno)=".$alumno."))";

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
                      <tr> 
                        <td><?php echo trim($fila3['nombre_ramo']);?></td>
                        <?php
																//PRIMER PERIODO
																$qry8="SELECT notas$nro_ano.* FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)=".$alumno.") AND ((notas$nro_ano.id_periodo)=".$idPer1.") AND ((notas$nro_ano.id_ramo)=".$fila3['id_ramo']."))";
																$result8 =@pg_Exec($conn,$qry8);
															?>
                        <td></td>
                        <!--PRIMER PERIODO-->
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota1']==0)or($fila8['nota1']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota1']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		
																		if(($fila8['nota2']==0)or($fila8['nota2']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota2']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		
																		if(($fila8['nota3']==0)or($fila8['nota3']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota3']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota4']==0)or($fila8['nota4']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota4']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota5']==0)or($fila8['nota5']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota5']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota6']==0)or($fila8['nota6']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota6']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota7']==0)or($fila8['nota7']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota7']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota8']==0)or($fila8['nota8']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota8']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota9']==0)or($fila8['nota9']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota9']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota10']==0)or($fila8['nota10']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota10']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota11']==0)or($fila8['nota11']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota11']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota12']==0)or($fila8['nota12']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota12']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota13']==0)or($fila8['nota13']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota13']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota14']==0)or($fila8['nota14']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota14']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota15']==0)or($fila8['nota15']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota15']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota16']==0)or($fila8['nota16']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota16']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota17']==0)or($fila8['nota17']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota17']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota18']==0)or($fila8['nota18']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota18']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota19']==0)or($fila8['nota19']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota19']));
																		 }
																				?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota20']==0)or($fila8['nota20']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota20']));
																		 }
																				?>
                        </td>
                        <td width="1%"></td>
                        <td width="3%"> 
                          <?php 
																	if($fila8['mostrar_notas'])
																	echo ("&nbsp;");
																	echo trim($fila8['promedio']);
																	if ($fila3['modo_eval']!=2){
																		if ((trim($fila8['promedio'])!="") and (trim($fila8['promedio'])!=0)) {
																			$PGral=(int) trim($fila8['promedio']);
																			$cant=1;

																			$PP1	=$PP1 + (int) trim($fila8['promedio']);
																			$cantP1	=$cantP1 + 1;

																		};
																	}else{
																		if ($fila3['modo_eval']==2){
																			if (trim($fila8['promedio'])!=""){
																				$notacon[0] = trim($fila8['promedio']);
																			};
																		};
																	};
																?>
                        </td>
                        <!--TD>3c</TD-->
                        <td width="3%"></td>
                        <?php //}	?>
                        <td width="3%"></td>
                        <?php

													}//FIN TOTAL RAMOS DEL CURSO
												}//FIN SI LA CANTIDAD DE RESULTADOS ES <> 0
											};//FIN ELSE CONEXION RESULT3
										?>
                        <!--FIN RAMO-->
                        <td> </td>
                      <tr> 
                      <tr> 
                        <td>&nbsp;</td>
                        <td></td>
                        <td colspan=20>&nbsp; </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>PG1</td>
                        <td width="3%"></td>
                        <td width="3%"> 
                          <?php 
						$cont=0;
						$prom=0;
						
						 $qry77="Select distinct notas$nro_ano.* from notas$nro_ano inner join tiene$nro_ano on notas$nro_ano.id_ramo=tiene$nro_ano.id_ramo where notas$nro_ano.rut_alumno='".$alumno."'and id_periodo=".$idPer1;
						 $result77 =@pg_Exec($conn,$qry77);
						    if(@pg_numrows($result77)==0){
							
							}
						 for($i=0 ; $i < @pg_numrows($result77) ; $i++){
						 $fila77 = @pg_fetch_array($result77,$i);
						  if (($fila77['promedio']!=0) and ($fila77['promedio']!="")){
						    $prom=$prom + $fila77['promedio'];
						     $cont=$cont+1;
							}
						}
						if ($cont > 0){
						$Gen1=($prom/$cont);
						echo (round($Gen1));	
						  }						
						 ?>
                        </td>
                      </tr>
                      <?php
											$qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
											$result6 =@pg_Exec($conn,$qry6);
											if (!$result6) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result6)!=0){
												?>
                      <td>SUBSECTORES</td>
                      <td></td>
                      <td colspan=20> 
                        <?php 
															$fila6 = @pg_fetch_array($result6,1);
															echo trim($fila6['nombre_periodo']);
															$idPer2=$fila6['id_periodo'];
														?>
                      </td>
                      <!--TD>PC</TD-->
                      <!--TD>PC</TD-->
                      <td></td>
                      <td>PT</td>
                      <!--TD>PC</TD-->
                      <td></td>
                      <td width="3%"></td>
                      </tr>
                      <?php
												}
											}
										?>
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

											$qry3="SELECT  subsector.nombre as nombre_ramo, ramo.id_ramo, ramo.modo_eval FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector) INNER JOIN tiene$nro_ano ON (ramo.id_curso = tiene$nro_ano.id_curso)and (ramo.id_ramo =tiene$nro_ano.id_ramo) WHERE (((tiene$nro_ano.id_curso)=".$curso.")and ((tiene$nro_ano.rut_alumno)=".$alumno."))";

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
                      <tr> 
                        <td><?php echo trim($fila3['nombre_ramo']);?></td>
                        <?php
																//PRIMER PERIODO
																
																$qry8="SELECT notas$nro_ano.* FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)=".$alumno.") AND ((notas$nro_ano.id_periodo)=".$idPer2.") AND ((notas$nro_ano.id_ramo)=".$fila3['id_ramo']."))";
																$result8 =@pg_Exec($conn,$qry8);
															?>
                        <td></td>
                        <!--PRIMER PERIODO-->
                        <td > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota1']==0)or($fila8['nota1']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota1']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota2']==0)or($fila8['nota2']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota2']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota3']==0)or($fila8['nota3']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota3']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota4']==0)or($fila8['nota4']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota4']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota5']==0)or($fila8['nota5']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota5']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota6']==0)or($fila8['nota6']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota6']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota7']==0)or($fila8['nota7']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota7']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota8']==0)or($fila8['nota8']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota8']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota9']==0)or($fila8['nota9']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota9']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota10']==0)or($fila8['nota10']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota10']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota11']==0)or($fila8['nota11']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota11']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota12']==0)or($fila8['nota12']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota12']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota13']==0)or($fila8['nota13']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota13']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota14']==0)or($fila8['nota14']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota14']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota15']==0)or($fila8['nota15']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota15']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota16']==0)or($fila8['nota16']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota16']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota17']==0)or($fila8['nota17']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota17']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota18']==0)or($fila8['nota18']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota18']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota19']==0)or($fila8['nota19']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota19']));
																		 } 
																				?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota20']==0)or($fila8['nota20']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota20']));
																		 } 
																				?>
                        </td>
                        <td></td>
                        <td> 
                          <?php 
																	if($fila8['mostrar_notas'])
																	echo ("&nbsp;");
																	echo (trim($fila8['promedio']));
																	
																	if ($fila3['modo_eval']!=2){
																		if (trim($fila8['promedio'])!=""){
																			$PGral=((int) trim($fila8['promedio'])) + $PGral;
																			$cant=$cant + 1;

																			$PP2	=$PP2 + (int) trim($fila8['promedio']);
																			$cantP2	=$cantP2 + 1;
																		};
																	}else{
																		if ($fila3['modo_eval']==2){
																			if (trim($fila8['promedio'])!=""){
																				$notacon[1] = trim($fila8['promedio']);
																			};
																		};
																	};
																?>
                        </td>
                        <!--TD>3c</TD-->
                        <td></td>
                        <?php //}	?>
                        <td></td>
                        <td width="3%"></td>
                        <?php

													}//FIN TOTAL RAMOS DEL CURSO
												}//FIN SI LA CANTIDAD DE RESULTADOS ES <> 0
											};//FIN ELSE CONEXION RESULT3
										?>
                        <!--FIN RAMO-->
                      <tr> 
                        <td>&nbsp;</td>
                        <td></td>
                        <td colspan=20>&nbsp; </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>PG2</td>
                        <td width="3%"></td>
                        <td width="3%"> 
                          <?php 
						$cont=0;
						$prom=0;
						
						 $qry77="Select distinct notas$nro_ano.* from notas$nro_ano inner join tiene$nro_ano on notas$nro_ano.id_ramo=tiene$nro_ano.id_ramo where notas$nro_ano.rut_alumno='".$alumno."'and id_periodo=".$idPer2;
						 $result77 =@pg_Exec($conn,$qry77);
						    if(@pg_numrows($result77)==0){
							
							}
						 for($i=0 ; $i < @pg_numrows($result77) ; $i++){
						 $fila77 = @pg_fetch_array($result77,$i);
						  if (($fila77['promedio']!=0) and ($fila77['promedio']!="")){
						    $prom=$prom + $fila77['promedio'];
						     $cont=$cont+1;
							}
						}
						 if ($cont >0){
						$Gen2=($prom/$cont);
						echo (round($Gen2));	
						  }						
						 ?>
                        </td>
                      </tr>
                      <tr> 
                        <?php
											$qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
											$result6 =@pg_Exec($conn,$qry6);
											if (!$result6) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result6)!=0){
												?>
                        <td>SUBSECTORES</td>
                        <td></td>
                        <td colspan=20> 
                          <?php 
															$fila6 = @pg_fetch_array($result6,2);
															echo trim($fila6['nombre_periodo']);
															$idPer3=$fila6['id_periodo'];
														?>
                        </td>
                        <!--TD>PC</TD-->
                        <!--TD>PC</TD-->
                        <td></td>
                        <td>PT</td>
                        <!--TD>PC</TD-->
                        <td></td>
                        <?php
												}
											}
										?>
                      </tr>
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

											$qry3="SELECT  subsector.nombre as nombre_ramo, ramo.id_ramo, ramo.modo_eval FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector) INNER JOIN tiene$nro_ano ON (ramo.id_curso = tiene$nro_ano.id_curso)and (ramo.id_ramo =tiene$nro_ano.id_ramo) WHERE (((tiene$nro_ano.id_curso)=".$curso.")and ((tiene$nro_ano.rut_alumno)=".$alumno."))";

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
                      <tr> 
                        <td><?php echo trim($fila3['nombre_ramo']);?></td>
                        <?php
																//PRIMER PERIODO
																
																$qry8="SELECT notas$nro_ano.* FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)=".$alumno.") AND ((notas$nro_ano.id_periodo)=".$idPer3.") AND ((notas$nro_ano.id_ramo)=".$fila3['id_ramo']."))";
																$result8 =@pg_Exec($conn,$qry8);
															?>
                        <td></td>
                        <!--PRIMER PERIODO-->
                        <td > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota1']==0)or($fila8['nota1']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota1']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota2']==0)or($fila8['nota2']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota2']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota3']==0)or($fila8['nota3']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota3']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota4']==0)or($fila8['nota4']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota4']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota5']==0)or($fila8['nota5']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota5']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota6']==0)or($fila8['nota6']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota6']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota7']==0)or($fila8['nota7']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota7']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota8']==0)or($fila8['nota8']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota8']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota9']==0)or($fila8['nota9']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota9']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota10']==0)or($fila8['nota10']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota10']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota11']==0)or($fila8['nota11']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota11']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota12']==0)or($fila8['nota12']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota12']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota13']==0)or($fila8['nota13']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota13']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota14']==0)or($fila8['nota14']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota14']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota15']==0)or($fila8['nota15']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota15']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota16']==0)or($fila8['nota16']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota16']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota17']==0)or($fila8['nota17']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota17']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota18']==0)or($fila8['nota18']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota18']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota19']==0)or($fila8['nota19']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota19']));
																		 } 
																				?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota20']==0)or($fila8['nota20']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota20']));
																		 } 
																				?>
                        </td>
                        <td></td>
                        <td> 
                          <?php 
																				if($fila8['mostrar_notas'])
																				echo ("&nbsp;");
																				echo trim($fila8['promedio']);
																				if ($fila3['modo_eval']!=2){
																					if (trim($fila8['promedio'])!=""){
																						$PGral=((int) trim($fila8['promedio'])) + $PGral;
																						$cant=$cant + 1;

																						$PP3	=$PP3 + (int) trim($fila8['promedio']);
																						$cantP3	=$cantP3 + 1;
																					};
																				}else{
																					if ($fila3['modo_eval']==2){
																						if (trim($fila8['promedio'])!=""){
																							$notacon[2] = trim($fila8['promedio']);
																						};
																					};
																				};
																			?>
                        </td>
                        <!--TD>3c</TD-->
                        <td></td>
                        <?php //}	?>
                        <td width="3%"></td>
                        <td></td>
                        <?php

													}//FIN TOTAL RAMOS DEL CURSO
												}//FIN SI LA CANTIDAD DE RESULTADOS ES <> 0
											};//FIN ELSE CONEXION RESULT3
										?>
                      <tr> 
                        <td>&nbsp;</td>
                        <td></td>
                        <td colspan=20>&nbsp; </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>PG3</td>
                        <td width="3%"></td>
                        <td width="3%"> 
                          <?php 
						$cont=0;
						$prom=0;
						
						 $qry77="Select distinct notas$nro_ano.* from notas$nro_ano inner join tiene$nro_ano on notas$nro_ano.id_ramo=tiene$nro_ano.id_ramo where notas$nro_ano.rut_alumno='".$alumno."'and id_periodo=".$idPer3;
						 $result77 =@pg_Exec($conn,$qry77);
						    if(@pg_numrows($result77)==0){
							
							}
						 for($i=0 ; $i < @pg_numrows($result77) ; $i++){
						 $fila77 = @pg_fetch_array($result77,$i);
						  if (($fila77['promedio']!=0) and ($fila77['promedio']!="")){
						    $prom=$prom + $fila77['promedio'];
						     $cont=$cont+1;
							}
						}
						if($cont > 0){
						$Gen3=($prom/$cont);
						echo (round($Gen3));	
						  }						
						 ?>
                        </td>
                      </tr>
                      <tr> 
                        <td>&nbsp;</td>
                        <td></td>
                        <td colspan=9>&nbsp; </td>
                        <!--TD>PC</TD-->
                        <td colspan=9>&nbsp; </td>
                        <!--TD>PC</TD-->
                        <td colspan=2>&nbsp; </td>
                        <td></td>
                        <td>&nbsp;</td>
                        <!--TD>PC</TD-->
                       
                      </tr>
                      <!--FIN RAMO-->
                      <tr height=5 bgcolor=black> 
                        <td colspan=39></td>
                      </tr>
                      <tr> 
                        <td colspan=12></td>
                        <td colspan=11></td>
                        <td colspan=9></td>
                        <td width="3%"></td>
                        <td width="2%"></td>
                        <td width="4%"></td>
                      </tr>
                      <tr height=20> 
                        <td colspan=38></td>
                      </tr>
                      <tr> 
                        <td colspan=24></td>
                        <td colspan=10>PROMEDIO GENERAL</td>
                        <td> 
                          <?php 
						  $sum=0; 
						  	   $Total=$Gen1+$Gen2+$Gen3;
							   if ($Gen1 >0){
							    $sum=$sum+1;
								}
								if ($Gen2 >0){
								$sum=$sum+1;
								}
								if ($Gen3 >0){
								$sum=$sum+1;
								}
								if ($sum > 0){
								$PromGen=($Total/$sum);
								echo (round($PromGen));
								}									
													?>
                        </td>
                      </tr>
                    </table></TD>
							</TR>
						</TABLE>
					<!-- FIN TRES PERIODOS-->
					<?php }//FIN TRIMESTRAL?>
					
					<?php if(($_TIPOREGIMEN==3)||($TipoRegimen==3)){//SEMESTRAL?>
					<!-- INICIO DOS PERIDOS -->						
						<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
							<TR>
								<TD>
									<TABLE BORDER=1 CELLSPACING=2 CELLPADDING=2 width=100%>
										<TR>
											<!--TD COLSPAN=46>NOTAS</TD-->
											<TD COLSPAN=40>NOTAS</TD>
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
													 <td width="10%">SUBSECTORES</td>
													<td width="1%"></td>
													<TD colspan=9>
														<?php 
															$fila6 = @pg_fetch_array($result6,0);
															echo trim($fila6['nombre_periodo']);
															$idPer1=$fila6['id_periodo'];
														?>
													</TD>
													
													
                        
													<!--TD>PC</TD-->
													
													
                        <TD colspan=11>&nbsp; </TD>
													 <td width="1%"></td>
													
                        <td width="3%">PS</td>
													<!--TD>PC</TD-->
													<td width="3%"></td>
													<td width="3%"></td>
													<td width="3%"></td>
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
                                            $qry3="SELECT  subsector.nombre as nombre_ramo, ramo.id_ramo, ramo.modo_eval FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector) INNER JOIN tiene$nro_ano ON (ramo.id_curso = tiene$nro_ano.id_curso)and (ramo.id_ramo =tiene$nro_ano.id_ramo) WHERE (((tiene$nro_ano.id_curso)=".$curso.")and ((tiene$nro_ano.rut_alumno)=".$alumno."))";
											//$qry3="SELECT subsector.nombre as nombre_ramo, ramo.id_ramo, ramo.modo_eval FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_curso)=".$curso."))";
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
																
																$qry8="SELECT notas$nro_ano.* FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)=".$alumno.") AND ((notas$nro_ano.id_periodo)=".$idPer1.") AND ((notas$nro_ano.id_ramo)=".$fila3['id_ramo']."))";
																$result8 =@pg_Exec($conn,$qry8);
															?>
															<TD></TD>		<!--PRIMER PERIODO-->
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota1']==0)or($fila8['nota1']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota1']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota2']==0)or($fila8['nota2']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota2']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota3']==0)or($fila8['nota3']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota3']));
																		 } 
																	?> 
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota4']==0)or($fila8['nota4']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota4']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota5']==0)or($fila8['nota5']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota5']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota6']==0)or($fila8['nota6']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota6']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota7']==0)or($fila8['nota7']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota7']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota8']==0)or($fila8['nota8']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota8']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota9']==0)or($fila8['nota9']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota9']));
																		 } 
																	?>
																</TD> 
															
															
                       
															<!--TD>1c</TD-->
															
																	<!--SEGUNDO PERIODO-->
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota10']==0)or($fila8['nota10']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota10']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota11']==0)or($fila8['nota11']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota11']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota12']==0)or($fila8['nota12']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota12']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota13']==0)or($fila8['nota13']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota13']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota14']==0)or($fila8['nota14']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota14']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota15']==0)or($fila8['nota15']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota15']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota16']==0)or($fila8['nota16']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota16']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota17']==0)or($fila8['nota17']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota17']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota18']==0)or($fila8['nota18']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota18']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota19']==0)or($fila8['nota19']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota19']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota20']==0)or($fila8['nota20']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota20']));
																		 } 
																	?>
																</TD> 
															<TD></TD>
															<TD>
																<?php 
																	if($fila8['mostrar_notas'])
																	echo ("&nbsp;");
																	echo trim($fila8['promedio']);
																	if ($fila3['modo_eval']!=2){
																		if ((trim($fila8['promedio'])!="") and (trim($fila8['promedio'])!=0)) {
																			$PGral=(int) trim($fila8['promedio']);
																			$cant=1;

																			$PP1	=$PP1 + (int) trim($fila8['promedio']);
																			$cantP1	=$cantP1 + 1;

																		};
																	}else{
																		if ($fila3['modo_eval']==2){
																			if (trim($fila8['promedio'])!=""){
																				$notacon[0] = trim($fila8['promedio']);
																			};
																		};
																	};
																?>
															</TD>
															<!--TD>2c</TD-->
															<?php

													}//FIN TOTAL RAMOS DEL CURSO
												}//FIN SI LA CANTIDAD DE RESULTADOS ES <> 0
											};//FIN ELSE CONEXION RESULT3
										?>
															
                        <TD>PG1</TD>
								<?php //}	?>
															<TD>
																<?php 
						$cont=0;
						$prom=0;
						
						 $qry77="Select distinct notas$nro_ano.* from notas$nro_ano inner join tiene$nro_ano on notas$nro_ano.id_ramo=tiene$nro_ano.id_ramo where notas$nro_ano.rut_alumno='".$alumno."'and id_periodo=".$idPer1;
						 $result77 =@pg_Exec($conn,$qry77);
						    if(@pg_numrows($result77)==0){
							
							}
						 for($i=0 ; $i < @pg_numrows($result77) ; $i++){
						 $fila77 = @pg_fetch_array($result77,$i);
						  if (($fila77['promedio']!=0) and ($fila77['promedio']!="")){
						    $prom=$prom + $fila77['promedio'];
						     $cont=$cont+1;
							}
						}
						if ($cont > 0){
						$Gen1=($prom/$cont);
						echo (round($Gen1));	
						  }						
						 ?>
															</TD>
									
	<!--FIN RAMO-->
	
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
															$fila6 = @pg_fetch_array($result6,1);
															echo trim($fila6['nombre_periodo']);
															$idPer2=$fila6['id_periodo'];
														?>
													</TD>
													
													
                       
													<!--TD>PC</TD-->
													
													
                        <TD colspan=11>&nbsp; </TD>
													<TD></TD>
													<TD>PS</TD>
													<!--TD>PC</TD-->
													<TD></TD>
													<TD></TD>
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
                                            $qry3="SELECT  subsector.nombre as nombre_ramo, ramo.id_ramo, ramo.modo_eval FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector) INNER JOIN tiene$nro_ano ON (ramo.id_curso = tiene$nro_ano.id_curso)and (ramo.id_ramo =tiene$nro_ano.id_ramo) WHERE (((tiene$nro_ano.id_curso)=".$curso.")and ((tiene$nro_ano.rut_alumno)=".$alumno."))";
											//$qry3="SELECT subsector.nombre as nombre_ramo, ramo.id_ramo, ramo.modo_eval FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_curso)=".$curso."))";
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
																
																$qry8="SELECT notas$nro_ano.* FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)=".$alumno.") AND ((notas$nro_ano.id_periodo)=".$idPer2.") AND ((notas$nro_ano.id_ramo)=".$fila3['id_ramo']."))";
																$result8 =@pg_Exec($conn,$qry8);
															?>
															<TD></TD>		<!--SEGUNDO PERIODO-->
								<td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota1']==0)or($fila8['nota1']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota1']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota2']==0)or($fila8['nota2']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota2']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota3']==0)or($fila8['nota3']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota3']));
																		 } 
																	?> 
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota4']==0)or($fila8['nota4']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota4']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota5']==0)or($fila8['nota5']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota5']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota6']==0)or($fila8['nota6']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota6']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota7']==0)or($fila8['nota7']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota7']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota8']==0)or($fila8['nota8']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota8']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota9']==0)or($fila8['nota9']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota9']));
																		 } 
																	?>
																</TD> 
															
															
                       
															<!--TD>1c</TD-->
															
																	<!--SEGUNDO PERIODO-->
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota10']==0)or($fila8['nota10']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota10']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota11']==0)or($fila8['nota11']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota11']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota12']==0)or($fila8['nota12']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota12']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota13']==0)or($fila8['nota13']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota13']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota14']==0)or($fila8['nota14']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota14']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota15']==0)or($fila8['nota15']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota15']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota16']==0)or($fila8['nota16']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota16']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota17']==0)or($fila8['nota17']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota17']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota18']==0)or($fila8['nota18']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota18']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota19']==0)or($fila8['nota19']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota19']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota20']==0)or($fila8['nota20']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota20']));
																		 } 
																	?>
																</TD> 
															<TD></TD>
															<TD>
																<?php 
																	if($fila8['mostrar_notas'])
																	echo ("&nbsp;");
																	echo trim($fila8['promedio']);
																	if ($fila3['modo_eval']!=2){
																		if ((trim($fila8['promedio'])!="") and (trim($fila8['promedio'])!=0)) {
																			$PGral=(int) trim($fila8['promedio']);
																			$cant=1;

																			$PP1	=$PP1 + (int) trim($fila8['promedio']);
																			$cantP1	=$cantP1 + 1;

																		};
																	}else{
																		if ($fila3['modo_eval']==2){
																			if (trim($fila8['promedio'])!=""){
																				$notacon[0] = trim($fila8['promedio']);
																			};
																		};
																	};
																?>
															</TD>
															<!--TD>2c</TD-->
																<?php

													}//FIN TOTAL RAMOS DEL CURSO
												}//FIN SI LA CANTIDAD DE RESULTADOS ES <> 0
											};//FIN ELSE CONEXION RESULT3
										?>
															
                        <TD>PG2</TD>
								<?php //}	?>
															<TD>
																<?php 
						$cont=0;
						$prom=0;
						
						 $qry77="Select distinct notas$nro_ano.* from notas$nro_ano inner join tiene$nro_ano on notas$nro_ano.id_ramo=tiene$nro_ano.id_ramo where notas$nro_ano.rut_alumno='".$alumno."'and id_periodo=".$idPer2;
						 $result77 =@pg_Exec($conn,$qry77);
						    if(@pg_numrows($result77)==0){
							
							}
						 for($i=0 ; $i < @pg_numrows($result77) ; $i++){
						 $fila77 = @pg_fetch_array($result77,$i);
						  if (($fila77['promedio']!=0) and ($fila77['promedio']!="")){
						    $prom=$prom + $fila77['promedio'];
						     $cont=$cont+1;
							}
						}
						 if ($cont >0){
						$Gen2=($prom/$cont);
						echo (round($Gen2));	
						  }						
						 ?>
															</TD>
									
	<!--FIN RAMO-->
														
														<TR height=5 bgcolor=black>
															<TD colspan=29></TD>
														</TR>
														<TR>
															<TD colspan=12></TD>
															
															<TD colspan=11></TD>
															
															<TD></TD>
															
                        <TD></TD>
																<TD></TD>
														</TR>
														<TR height=20>
															<TD colspan=31></TD>
														</TR>
														<TR>
															<TD colspan=24></TD>
															<TD colspan=10>PROMEDIO GENERAL</TD>
															<TD>
																<?php 
						  $sum=0; 
						  	   $Total=$Gen1+$Gen2+$Gen3;
							   if ($Gen1 >0){
							    $sum=$sum+1;
								}
								if ($Gen2 >0){
								$sum=$sum+1;
								}
								
								if ($sum > 0){
								$PromGen=($Total/$sum);
								echo (round($PromGen));
								}									
													?>
															</TD>
														</TR>
									</TABLE>
								</TD>
							</TR>
						</TABLE>
					
              <!-- FIN DOS PERIDOS -->
              <?php }//FIN SEMESTRAL?>
			  
			  <TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
							<TR>
								<TD>
									<TABLE BORDER=1 CELLSPACING=2 CELLPADDING=2 width=100%>
             
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
               
			  	</table>
			  		</td>
						</tr>
							</table>
			  
			  
			  
			  
			  </TD>
						</TR>
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
	
  <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota18']==0)or($fila8['nota18']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota18']));
																		 } 
																	?>
  <?php 
																		//$fila8 = @pg_fetch_array($result8,7);
//																		if($fila8['mostrar_notas'])
																		imp(trim($fila8['nota17']));
																	?>
  <?php 
																					$fila8 = @pg_fetch_array($result8,1);
//																					if($fila8['mostrar_notas'])
																					imp(trim($fila8['valor']));
																				?>
</FORM>
</BODY>
</HTML>