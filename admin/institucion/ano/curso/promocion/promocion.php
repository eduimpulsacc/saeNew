<?php require('../../../../../util/header.inc');?>
<?php 

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO; ?>

<?php	if($frmModo!="mostrar"){?>
			<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
			
			<SCRIPT LANGUAGE="JavaScript">
			<!--
				function valida(form){
					for (x=0;x<=form.length-1;x++){
						if (form[x].name.substr(0,12)=="cmbsituacion"){
							if(!chkSelect(form[x],'Seleccionar la SITUACION del alumno curso.')){
								return false;
							};
						};
					};
				};
			//-->
			</SCRIPT>
<?php	};
					
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
/**************************************************************************************************************/
	/*-------------------------------------- FUNCIONES -------------------------------------------------*/
/**************************************************************************************************************/

	/*****************************************************************************************************/
		/*---------------------------- FUNCION CALCULA PORCENTAJE ASISTENCIA -------------------------*/
	/*****************************************************************************************************/
		function CalAsis($alu_rut,$asis_total,$conect){
			/*---- Cuenta asitencia del alumno------*/
			$SQL = "SELECT Count(anotacion.tipo) AS cuentasis, anotacion.rut_alumno FROM anotacion WHERE ((anotacion.tipo=3) AND (anotacion.rut_alumno='" . Trim($alu_rut) . "')) GROUP BY anotacion.rut_alumno";
			$rs_asis = @pg_exec($conect,$SQL);
			if (!$rs_asis){
				error('<B> ERROR :</b>Error al acceder a la BD. (9)</B>');
				exit();
			}else{
				if (@pg_numrows($rs_asis)!=0){
					$filasis = @pg_fetch_array($rs_asis,0);	
					if (!$filasis){
						error('<B> ERROR :</b>Error al acceder a la BD. (10)</B>');
						exit();
					};
					$cantidad = intval(Trim($filasis['cuentasis']));
					$cant_calc = $asis_total - $cantidad;
					$asis = ($cant_calc * 100) / $asis_total;
				}else{
					$asis = "100";
				};
			};
			@pg_close($rs_asis);
			return $asis;
		};
	/*****************************************************************************************************/
		/*-------------------------------------- FIN FUNCION -----------------------------------------*/
	/*****************************************************************************************************/

	/*****************************************************************************************************/
		/*---------------------------- FUNCION CALCULA PROMEDIO FINAL -------------------------*/
	/*****************************************************************************************************/
		function PromedioFinal($alum_rut,$cur_id,$conect,$tipreg){
			$SQL = "SELECT alumno.ape_pat, alumno.nombre_alu, subsector.nombre, Sum(to_number(trim(notas$nro_ano.promedio),'9999999999')) AS sumpromedio, curso.grado_curso, curso.letra_curso FROM alumno INNER JOIN ((((curso INNER JOIN ramo ON curso.id_curso = ramo.id_curso) INNER JOIN notas$nro_ano ON ramo.id_ramo = notas$nro_ano.id_ramo)INNER JOIN tiene$nro_ano ON notas$nro_ano.rut_alumno=tiene$nro_ano.rut_alumno AND notas$nro_ano.id_ramo=tiene$nro_ano.id_ramo) INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector) ON alumno.rut_alumno = notas$nro_ano.rut_alumno WHERE ((curso.id_curso=" . $cur_id . ") AND (tiene$nro_ano.rut_alumno='" . $alum_rut . "') AND (ramo.modo_eval=1) AND (ramo.conex=2) AND notas$nro_ano.promedio not like ' %') GROUP BY alumno.ape_pat, alumno.nombre_alu, subsector.nombre, curso.grado_curso, curso.letra_curso, curso.id_curso, alumno.rut_alumno, ramo.modo_eval";
			$rs_promedio = @pg_exec($conect,$SQL);
			if (!$rs_promedio){
				error('<B> ERROR :</b>Error al acceder a la BD. (13)</B>'.$SQL);
				exit();
			}else{
				if (@pg_numrows($rs_promedio)!=0){
					$filprom = @pg_fetch_array($rs_promedio,0);	
					if (!$filprom){
						error('<B> ERROR :</b>Error al acceder a la BD. (14)</B>');
						exit();
					};
					$SumRamo = 0; /*--- HACE LA SUMATORIA DE LOS PROMEDIOS DE LAS NOTAS ---*/
					$Rojo = 0; /*--- CUENTA LA CANTIDAD DE RAMOS MENORES A CUATRO ---*/
					$count = 0; /*--- CUNTA LA CANTIDAD DE RAMOS ---*/
				
					if (Trim($tipreg)=="2"){ /*--- Trimestre ---*/
						$tipreg = 3;
					}else{ /*--- Semestre ---*/
						$tipreg = 2;
					};

					for($i=0;$i<@pg_numrows($rs_promedio);$i++){
						$filprom = @pg_fetch_array($rs_promedio,$i);
						if (Trim($filprom['sumpromedio'])!=""){
							//$Ramo[$i] = round(intval(Trim($filprom['sumpromedio'])) / $tipreg);
							$Ramo[$i] = intval(Trim($filprom['sumpromedio']));
							if ($Ramo[$i] < 40){ /*--- Ramos Rojos ---*/
								$Rojo = $Rojo + 1;
							};
							$SumRamos = $SumRamos + $Ramo[$i]; /*--- Acumula los ramos---*/
							$count = $count + 1;
						};
					};
					if ($count!=0){
					    $count = $count *2;
						if($institucion==9566){
							$PromedioFinal = intval($SumRamos / $count);
						}
						else{
							$PromedioFinal = round($SumRamos / $count);
						}
						$promFin=$PromedioFinal; /*--- Promedio final de ramos numericos ---*/
					};
				}else {
				  $promFin=0;
				  }
				$SQL1="Select sum(nota_final)as suma, count(ramo.id_ramo)as cantidad  from situacion_final inner join ramo on situacion_final.id_ramo=ramo.id_ramo where ((ramo.id_curso=" . $cur_id . ") AND (situacion_final.rut_alumno='" . $alum_rut . "') AND (ramo.modo_eval=1) AND (ramo.conex=1) AND situacion_final.prom_gral not like ' %')";
					$prom = @pg_exec($conect,$SQL1);
					$filpromedio = @pg_fetch_array($prom,0);
					$SumRamo = $count + $filpromedio['cantidad'];
					$PromeFinal = $SumRamos + $filpromedio['suma'];
					if(($promFin!=0)and ($filpromedio['cantidad']!=0)) {
					$ProFinal=(($PromeFinal)/$SumRamo);
					}
					if(($promFin==0)and ($filpromedio['cantidad']!=0)) {
					$ProFinal=$PromeFinal;
					}
					if(($promFin!=0)and ($filpromedio['cantidad']==0)) {
					$ProFinal=$promFin;
					} 
					if(($promFin==0)and ($filpromedio['cantidad']==0)) {
					$ProFinal=0;
					}
					if($institucion==9566){
						return intval($ProFinal);
					}
					else{
						return round($ProFinal);
					}

			};

		};
	/*****************************************************************************************************/
		/*-------------------------------------- FIN FUNCION -----------------------------------------*/
	/*****************************************************************************************************/

	/*****************************************************************************************************/
		/*----------------------- FUNCION EXTRAE MAXIMO GRADO DE LA INSTITUCION ----------------------*/
	/*****************************************************************************************************/
	/*	function MaxGrado($conect){
			$SQL = "SELECT Max(curso.grado_curso) AS maxgrado FROM (curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN rama ON tipo_ensenanza.cod_tipo = rama.cod_tipo WHERE (((curso.id_ano)=71)) GROUP BY curso.id_ano";
			$rs_maxgrado = @pg_exec($conect,$SQL);
			if (!$rs_maxgrado){
				error('<B> ERROR :</b>Error al acceder a la BD. (21)</B>');
				exit();					
			};
			if (@pg_numrows($rs_maxgrado)!=0){
				$filcurso = @pg_fetch_array($rs_maxgrado,0);
				if (!$filcurso){
					error('<B> ERROR :</b>Error al acceder a la BD. (22)</B>');
					exit();
				};
				$maxgrado = intval(Trim($filcurso['maxgrado']));
			}else{
				$maxgrado = 0;
			};
			return $maxgrado;
		};    */
	/*****************************************************************************************************/
		/*-------------------------------------- FIN FUNCION -----------------------------------------*/
	/*****************************************************************************************************/

/**************************************************************************************************************/
	/*------------------------------------ FIN FUNCIONES -----------------------------------------------*/
/**************************************************************************************************************/


	
	/***************************************************************************************************/
		/*-------------------------- EXTRAE DIAS HABILES DE CADA PERIODO ------------------------*/
	/***************************************************************************************************/
		//$SQL = "SELECT SUM(periodo.dias_habiles) AS diashabiles, ano_escolar.id_ano FROM periodo INNER JOIN ano_escolar ON periodo.id_ano = ano_escolar.id_ano WHERE (((ano_escolar.id_institucion)=" . $institucion . ") AND ((ano_escolar.id_ano)=" . $ano . ")) GROUP BY ano_escolar.id_institucion, ano_escolar.id_ano;";
		$SQL = "SELECT SUM(periodo.dias_habiles) AS diashabiles, periodo.id_ano FROM periodo  WHERE  (periodo.id_ano=" . $ano . ") GROUP BY  periodo.id_ano;";
		$rs_diastot = @pg_exec($conn,$SQL);
		if (!$rs_diastot){
			error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>');
			exit();
		}else{
			if (@pg_numrows($rs_diastot)!=0){ /*-- Existen periodos --*/
				$fildias = @pg_fetch_array($rs_diastot,0);	
				if (!$fildias){
					error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
					exit();
				};
				$totdias = intval(trim($fildias['diashabiles']));
			}else{ /*-- No se han ingresado periodos --*/
				$totdias = 0;
			};
		};
		@pg_close($rs_diastot);
	/***************************************************************************************************/
		/*------------------------------------------- FIN ----------------------------------------*/
	/***************************************************************************************************/ 
	

	/***************************************************************************************************/
		/*------------------------ VERIFICA SI EXISTEN DATOS INGRESADOS --------------------------*/
	/***************************************************************************************************/
		$SQL = "SELECT * FROM promocion WHERE rdb=" . $institucion . " AND id_ano=" . $ano . " AND id_curso=" .  $curso . "";
		//echo ($SQL);
		//exit();
		$rs_promoc = @pg_exec($conn,$SQL);
		if (!$rs_promoc){
			error('<B> ERROR :</b>Error al acceder a la BD. (21)</B>');
			exit();
		}else{
			if (@pg_numrows($rs_promoc)!=0){ /*-- Existen periodos --*/
				$Accion = "2"; /*--- Modifica datos ---*/
			}else{
				$Accion = "1"; /*--- Imgresa datos ---*/
			};
		};
	/***************************************************************************************************/
		/*------------------------------------------- FIN ----------------------------------------*/
	/***************************************************************************************************/

	/***************************************************************************************************/
		/*---------------------- VERIFICA SI EL CURSO ES TECNICO PROFESIONAL ---------------------*/
	/***************************************************************************************************/
		//$SQL = "SELECT rama.cod_rama FROM (curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN rama ON tipo_ensenanza.cod_tipo = rama.cod_tipo WHERE (((curso.id_curso)=" . $curso . ") AND ((curso.id_ano)=" . $ano . "))";
		//$rs_espec = @pg_exec($conn,$SQL);
		//$flag = 0;
		//if (!$rs_espec){
		//	error('<B> ERROR :</b>Error al acceder a la BD. (22)</B>');
		//	exit();
		//}else{
		//	if (@pg_numrows($rs_espec)!=0){
		//		$flag = 1;
		//	};
		//};
	/***************************************************************************************************/
		/*------------------------------------------- FIN ----------------------------------------*/
	/***************************************************************************************************/

	?>


<html>
	<head>
		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
	
<link href="../../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>
<body>
	<?php //echo tope("../../../../../util/");?>
	<center>
	<FORM method=post name="frm" action="procesoPromocion.php">
		<INPUT TYPE="hidden" name="Accion" value="<?php echo $Accion; ?>">
		<INPUT TYPE="hidden" name="institucion" value="<?php echo $institucion; ?>">
		<INPUT TYPE="hidden" name="ano" value="<?php echo $ano; ?>">
		<INPUT TYPE="hidden" name="curso" value="<?php echo $curso; ?>">
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR height=15>
				<TD COLSPAN=5>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
						<TR>
							<TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>INSTITUCION</strong></FONT></TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>
										<?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result = @pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (@pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													};
													echo trim($fila['nombre_instit']);
													
												};
											};	?>
								</strong></FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>AÑO ESCOLAR</strong></FONT></TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>
								<?php
									$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
									$result =@pg_Exec($conn,$qry);
									if (!$result) {
										error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
									}else{
										if (@pg_numrows($result)!=0){
											$fila = @pg_fetch_array($result,0);	
											if (!$fila){
												error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
												exit();
											}
											echo trim($fila['nro_ano']);
											$TipoRegimen = trim($fila['tipo_regimen']);
										}
									}
								?>
									</strong></FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>CURSO</strong></FONT></TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>
							<?php
									$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo,curso.ensenanza FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
									$result = @pg_Exec($conn,$qry);
									if (!$result) {
										error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
									}else{

										$fila = @pg_fetch_array($result,0);	
										if (!$fila){
											error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
											exit();
										}
										$grado = trim($fila['grado_curso']);
										echo trim($fila['grado_curso'])."-".trim($fila['letra_curso'])." ".trim($fila['nombre_tipo']);
										$ensenanza = trim($fila['ensenanza']);
										if ($ensenanza >= "410"){
											$gradomax = MaxGrado($conn);
										}else{
											$gradomax = 0;
										};
									}
								?>
									<INPUT TYPE="hidden" name="grado" value="<?php echo $grado; ?>">
									<INPUT TYPE="hidden" name="gradomax" value="<?php echo $gradomax; ?>">
									<INPUT TYPE="hidden" name="ensenanza" value="<?php echo $ensenanza; ?>">
									</strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<tr>
				<td colspan=5 align=right>
					<?php	if ($frmModo!="ingresar"){
								if ($_PERFIL==14 || $_PERFIL==0){
								//if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL
									//if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR ?>
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="AGREGAR" onClick=document.location="seteapromocion.php3?institucion=<?php echo $institucion; ?>&ano=<?php echo $ano; ?>&curso=<?php echo $curso; ?>&caso=2">&nbsp;
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="../seteaCurso.php3?caso=4">&nbsp;
					<?php			//};
								};
							};
							
							if ($frmModo=="ingresar"){ ?>
								<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);">&nbsp;
								<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="seteapromocion.php3?institucion=<?php echo $institucion; ?>&ano=<?php echo $ano; ?>&curso=<?php echo $curso; ?>&caso=1">&nbsp;
					<?php	}; ?>			
					<?php	//if($frmModo=="mostrar"){
							//	if($_PERFIL!=17){
							//		if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL 
							//			if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR ?>
											<!---INPUT TYPE="button" value="MODIFICAR" name=btnModificar  onClick="document.location='seteapromocion.php3?caso=3'"--->

					<?php	//			};
							//		}; ?>
					<?php	//	}; ?>
					<?php	//};	?>
				</td>
			</tr>
			<tr height="20" bgcolor="#003b85">
				<td align="middle" colspan="5">
					<font face="arial, geneva, helvetica" size="2" color="#ffffff">
						<strong>TOTAL DE ALUMNOS =
						<b><?php $cuntalum = 0;
											$qry="SELECT COUNT(*) AS SUMA FROM MATRICULA WHERE ID_ANO=(".$ano.")  AND ID_CURSO=(".$curso.")";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila7 = @pg_fetch_array($result,0);	
													if (!$fila7){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila7['suma']);
													$cuntalum = intval(trim($fila7['suma']));
												}
											}
										?>
								<INPUT TYPE="hidden" name="contalum" value="<?php echo $cuntalum; ?>">	
						</b></strong>
					</font>
				</td>
			</tr>
			<tr bgcolor="#48d1cc">
				<td align="center" width="80">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>RUT</strong>
					</font>
				</td>
				<td align="center" width="320">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>NOMBRE</strong>
					</font>
				</td>
				<td align="center" width="50">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>PROMEDIO</strong>
					</font>
				</td>
				<td align="center" width="50">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>ASISTENCIA (%)</strong>
					</font>
				</td>
				<td align="center" width="100">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>SITUACIÓN</strong>
					</font>
				</td>
			</tr>
			<?php
				$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano.")) order by matricula.nro_lista";
				 //order by ape_pat, ape_mat, nombre_alu asc
				$result = @pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
				}else{
				if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
					$fila = @pg_fetch_array($result,0);	
					if (!$fila){
						error('<B> ERROR :</b>Error al acceder a la BD. (8) No hay alumnos inscritos en este curso</B>');
						exit();
					}
				}
			?>
			<?php
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
			?>
						<tr bgcolor=#ffffff>
							<td align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<INPUT TYPE="hidden" name="rutalum[<?php echo $i; ?>]" value="<?php echo $fila["rut_alumno"]; ?>">
									<strong><?php echo $fila["rut_alumno"]." - ".$fila["dig_rut"];?></strong>
								</font>
							</td>
							<td align="left" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["ape_pat"]." ".$fila["ape_mat"].", ".$fila["nombre_alu"];?></strong>
								</font>
							</td>
							<td align="center">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>
									<?php echo $promfinal = PromedioFinal($fila["rut_alumno"],$curso,$conn,$TipoRegimen); ?></strong>
								</font>
							</td>
							<INPUT TYPE="hidden" NAME="promedio[<?php echo $i; ?>]" value="<?echo PromedioFinal($fila["rut_alumno"],$curso,$conn,$TipoRegimen); ?>">
							<?php /*-------- Calcula asistencia -------*/ 
									if ($totdias!=0 && $totdias!=""){
										$AsistenciaAlum = CalAsis($fila["rut_alumno"],$totdias,$conn);
									}else{
										$AsistenciaAlum = "Periodos no ingresados";
									};
									?>
							<td align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo round($AsistenciaAlum); ?></strong>
								</font>
							</td>
							<INPUT TYPE="hidden" name="asistencia[<?php echo $i; ?>]" value="<?php echo round($AsistenciaAlum); ?>">
							<?php /*------ Fin calcula asistencia -----*/ ?>
							<td align="center">
							   <?php $sqlF="Select situacion_final from promocion where rut_alumno='".$fila["rut_alumno"]."'and id_curso=".$curso;
							          $resultF = @pg_Exec($conn,$sqlF);
									  $filaF = @pg_fetch_array($resultF,0);
									     ?>
								<?php if ($frmModo!="ingresar"){
								          if (@pg_numrows($resultF)==0){  ?>
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php if (($promfinal>40) && ($AsistenciaAlum>70)){ echo("Aprobado"); $situacion="1"; }else{ echo ("Reprobado"); $situacion="2"; }; ?></strong>
								</font>
								<?php
									}else{ 
										   $situacion= $filaF['situacion_final'];
										 ?>
									     <font face="arial, geneva, helvetica" size="1" color="#000000">
											<strong>
											<?php 
											  if ($situacion==1){
											 echo ("Aprobado"); $situacion="1"; }; 
											  if ($situacion==2){
											 echo ("Reprobado"); $situacion="2"; }; 
											  if ($situacion==3){
											 echo ("Retirado"); $situacion="3"; }; 
											 } 
											 ?>
</strong>
										</font>  
									    <?php  
								  }else{ 
								      if (pg_numrows($resultF)==0){
								       ?>
											<SELECT name="cmbsituacion[<?php echo $i; ?>]" style="FONT-FAMILY:Verdana; FONT-SIZE:8pt">
												<OPTION value=""></OPTION>
												<OPTION value="1">Aprobado</OPTION>
												<OPTION value="2">Reprobado</OPTION>
												<OPTION value="3">Retirado</OPTION>
											</SELECT>
								<?php 
								  
								     }else{
									      if (@pg_numrows($resultF)!=0){
										   $situacion= $filaF['situacion_final'];
									        ?>
									 	 <SELECT name="cmbsituacion[<?php echo $i; ?>]" style="FONT-FAMILY:Verdana; FONT-SIZE:8pt">
												<OPTION value=""></OPTION>
												<OPTION value="1" <?php if ($situacion=="1"){ echo("SELECTED"); }; ?>>Aprobado</OPTION>
												<OPTION value="2" <?php if ($situacion=="2"){ echo("SELECTED"); }; ?>>Reprobado</OPTION>
												<OPTION value="3" <?php if ($situacion=="3"){ echo("SELECTED"); }; ?>>Retirado</OPTION>
							  </SELECT>	
						  <?php
									 	  }
									 	}
									  }; ?>						  </td>
						</tr>
			<?php
					}
				}
			?>
			<tr>
				<td colspan="5">
				<hr width="100%" color="#003b85">
				</td>
			</tr>
			<tr>
				<td colspan=5 align=center>
					<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
						<tr>
							<td>
								<table WIDTH="100%" BORDER="0" CELLSPACING="3" CELLPADDING="3" bgcolor=white>
									<tr>
										<td>
											<font face="arial, geneva, helvetica" size="1" color=black>												<br>
												<br>
										  </font>									  </td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</FORM>
	</center>
</body>
</html>
<? pg_close($conn);?>