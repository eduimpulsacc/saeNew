<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
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
		<LINK REL="STYLESHEET" HREF="../../../../../util/td.css" TYPE="text/css">
<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtRUT,'Ingresar RUT.')){
					return false;
				};

				if(!nroOnly(form.txtRUT,'Se permiten sólo numeros en el RUT.')){
					return false;
				};

				if(!chkVacio(form.txtDIGRUT,'Ingresar dígito verificador del RUT.')){
					return false;
				};

				if(!chkCod(form.txtRUT,form.txtDIGRUT,'RUT invalido.')){
					return false;
				};
				
				if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE del alumno.')){
					return false;
				};

				if(!alfaOnly(form.txtNOMBRE,'Se permiten sólo caracteres alfanuméricos en el campo NOMBRE.')){
					return false;
				};

				if(!chkVacio(form.txtAPEPAT,'Ingresar APELLIDO PATERNO del alumno.')){
					return false;
				};

				if(!alfaOnly(form.txtAPEPAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO PATERNO.')){
					return false;
				};

				if(!chkVacio(form.txtAPEMAT,'Ingresar APELLIDO MATERNO del alumno.')){
					return false;
				};

				if(!alfaOnly(form.txtAPEMAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO MATERNO.')){
					return false;
				};

				if(!chkSelect(form.cmbSEXO,'Seleccionar SEXO.')){
					return false;
				};

				if(!chkVacio(form.txtNAC,'Ingresar FECHA NACIMIENTO.')){
					return false;
				};

				if(!chkFecha(form.txtNAC,'FECHA NACIMIENTO invalida.')){
					return false;
				};
				
				if(!chkVacio(form.txtCALLE,'Ingresar CALLE.')){
					return false;
				};

				if(form.txtTELEF.value!=''){
					if(!phoneOnly(form.txtTELEF,'Se permiten sólo numeros telefónicos en el campo TELEFONO.')){
						return false;
					};
				};

				if(form.txtEMAIL.value!=''){
					if(!isEmail(form.txtEMAIL,'Formato EMAIL incorrecto.')){
						return false;
					};
				};

				//PENDIENTE HASTA TENER LA FUNCION DEL DESPLIEGUE DE LAS REGIONES EN COMBOS
/*
				if(!chkSelect(form.cmbREG,'Seleccionar REGION.')){
					return false;
				};

				if(!chkSelect(form.cmbCIU,'Seleccionar CIUDAD.')){
					return false;
				};

				if(!chkSelect(form.cmbCOM,'Seleccionar COMUNA.')){
					return false;
				};
*/
				return true;
			}
		</SCRIPT>
<?php }?>
	</HEAD>
<BODY >
	<FORM method=post name="frm" action="procesoAlumno.php3">
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
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
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
							<TD align=right colspan=2>
								<?php if(($_PERFIL!=16)&&($_PERFIL!=15)){ ?>
									<?php if($frmModo=="ingresar"){ ?>
										<INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
										<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarAlumnos.php3">&nbsp;
									<?php };?>
									<?php if($frmModo=="mostrar"){ ?>
										<INPUT TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaAlumno.php3?alumno=<?php echo $alumno?>&caso=3">&nbsp;
										<!--INPUT TYPE="button" value="ELIMINAR"  name=btnEliminar disabled-->
										<INPUT TYPE="button" value="LISTADO" onClick=document.location="listarAlumnos.php3">&nbsp;
									<?php };?>
									<?php if($frmModo=="modificar"){ ?>
										<INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar>&nbsp;
										<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaAlumno.php3?alumno=<?php echo $alumno?>&caso=1">&nbsp;
									<?php };?>
								<?php };?>
							</TD>
						</TR>
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>ALUMNO</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD colspan=3>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>RUT</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtRUT size=10 maxlength=10 onChange="checkRutField(this);">
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['rut_alumno']);
												};
											?>
											<?php 
												if($frmModo=="modificar"){ 
													imp($fila['rut_alumno']);
												};
											?>
										</TD>
										<TD>&nbsp;-&nbsp;</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtDIGRUT size=1 maxlength=1 >
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['dig_rut']);
												};
											?>
											<?php 
												if($frmModo=="modificar"){ 
													imp($fila['dig_rut']);
												};
											?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0 width=100%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>NOMBRES</STRONG>
											</FONT>
										</TD>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>APELLIDO PATERNO</STRONG>
											</FONT>
										</TD>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>APELLIDO MATERNO</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtNOMBRE size=25 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['nombre_alu']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtNOMBRE size=25 maxlength=50 value="<?php echo $fila['nombre_alu']?>">
											<?php };?>
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtAPEPAT size=25 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['ape_pat']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtAPEPAT size=25 maxlength=50 value="<?php echo $fila['ape_pat']?>">
											<?php };?>
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtAPEMAT size=25 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['ape_mat']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtAPEMAT size=25 maxlength=50 value="<?php echo $fila['ape_mat']?>">
											<?php };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD align=CENTER>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0 WIDTH=50%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>FECHA<BR>NACIMIENTO</STRONG>
											</FONT>
										</TD>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>SEXO</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtNAC size=10 maxlength=10>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													impF($fila['fecha_nac']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtNAC size=10 maxlength=10 value="<?php echo impF($fila['fecha_nac'])?>">
											<?php };?>
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<Select name="cmbSEXO" >
													<option value=0 selected></option>
													<option value=1 >Femenino</option>
													<option value=2 >Masculino</option>
												</Select>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													switch ($fila['sexo']) {
														 case 0:
															 imp('INDETERMINADO');
															 break;
														 case 1:
															 imp('Femenino');
															 break;
														 case 2:
															 imp('Masculino');
															 break;
													 };
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<Select name="cmbSEXO">
													<option value=0></option>
											<option value=1 <?php echo ($fila['sexo'])==1?"selected":"" ?>>Femenino</option>
											<option value=2 <?php echo ($fila['sexo'])==2?"selected":"" ?>>Masculino</option>
												</Select>
											<?php };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE width=520 bgcolor=#cccccc height=100 Border=0 cellpadding=1 cellspacing=0>
									<TR>
										<TD align=left height=10>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>&nbsp;&nbsp;DIRECCION</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<TABLE width=100% height=100% bgcolor=White BORDER=0>
												<TR>
													<TD>
													<TR height="100%">
													<TD width="4%"></TD>
													<TD width="48%">
													<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
														<TR>
															<TD>
																<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																	<STRONG>CALLE</STRONG>
																</FONT>
															</TD>
														</TR>
														<TR>
															<TD>
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtCALLE size=35 maxlength=50>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['calle']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtCALLE size=35 maxlength=50 value="<?php echo $fila['calle']?>">
																<?php };?>
															</TD>
														</TR>
													</TABLE>
													</TD><TD width="48%">
													<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
														<TR>
															<TD>
																<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																	<STRONG>NRO</STRONG>
																</FONT>
															</TD>
														</TR>
														<TR>
															<TD>
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtNRO size=10 maxlength=5>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['nro']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtNRO size=10 maxlength=5 value="<?php echo $fila['nro']?>">
																<?php };?>
															</TD>
														</TR>
													</TABLE>
													</TD></TR>
													<!--F7-->
													<TR height="100%">
													<TD width="4%"></TD>
													<TD width="48%">
													<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
														<TR>
															<TD>
																<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																	<STRONG>DEPTO&nbsp;&nbsp;&nbsp;(OPCIONAL)</STRONG>
																</FONT>
															</TD>
															<TD>
																<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																	<STRONG>BLOCK&nbsp;&nbsp;&nbsp;(OPCIONAL)</STRONG>
																</FONT>
															</TD>
														</TR>
														<TR>
															<TD>
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtDEP size=12 maxlength=10>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['depto']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtDEP size=12 maxlength=10 value="<?php echo $fila['depto']?>">
																<?php };?>
															</TD>
															<TD>
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtBLO size=12 maxlength=10>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['block']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtBLO size=12 maxlength=10 value="<?php echo $fila['block']?>">
																<?php };?>
															</TD>
														</TR>
													</TABLE>
													</TD>
													<TD width="48%">
													<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
														<TR>
															<TD>
																<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																	<STRONG>VILLA/POBL&nbsp;&nbsp;&nbsp;(OPCIONAL)</STRONG>
																</FONT>
															</TD>
														</TR>
														<TR>
															<TD>
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtVIL size=34 maxlength=50>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['villa']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtVIL size=34 maxlength=50 value="<?php echo $fila['villa']?>">
																<?php };?>
															</TD>
														</TR>
													</TABLE>
													</TD>
													</TR>

													<TR height="100%">
														<TD width="4%"></TD>
														<TD COLSPAN=2>
															<TABLE width=100% height=100% bgcolor=White BORDER=0  CELLSPACING=0 CELLPADDING=0>
																<TR>
																	<TD>
																		<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
																			<TR>
																				<TD>
																					<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																						<STRONG>REGION</STRONG>
																					</FONT>
																				</TD>
																			</TR>
																			<TR>
																				<TD>
																					<?php if($frmModo=="ingresar"){ ?>
																						<INPUT type="text" name=txtREG size=20 value=1>
																					<?php };?>
																					<?php 
																						if($frmModo=="mostrar"){ 
																							imp($fila['region']);
																						};
																					?>
																					<?php if($frmModo=="modificar"){ ?>
																						<INPUT type="text" name=txtREG size=20 value=1 value="<?php echo $fila['region']?>">
																					<?php };?>
																				</TD>
																			</TR>
																		</TABLE>
																	</TD>
																	<TD>
																		<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
																			<TR>
																				<TD>
																					<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																						<STRONG>CIUDAD</STRONG>
																					</FONT>
																				</TD>
																			</TR>
																			<TR>
																				<TD>
																					<?php if($frmModo=="ingresar"){ ?>
																						<INPUT type="text" name=txtCIU size=20 value=1>
																					<?php };?>
																					<?php 
																						if($frmModo=="mostrar"){ 
																							imp($fila['ciudad']);
																						};
																					?>
																					<?php if($frmModo=="modificar"){ ?>
																						<INPUT type="text" name=txtCIU size=20 value=1 value="<?php echo $fila['ciudad']?>">
																					<?php };?>
																				</TD>
																			</TR>
																		</TABLE>
																	</TD>
																	<TD>
																		<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
																			<TR>
																				<TD>
																					<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																						<STRONG>COMUNA</STRONG>
																					</FONT>
																				</TD>
																			</TR>
																			<TR>
																				<TD>
																					<?php if($frmModo=="ingresar"){ ?>
																						<INPUT type="text" name=txtCOM size=20 value=1>
																					<?php };?>
																					<?php 
																						if($frmModo=="mostrar"){ 
																							imp($fila['comuna']);
																						};
																					?>
																					<?php if($frmModo=="modificar"){ ?>
																						<INPUT type="text" name=txtCOM size=20 value=1 value="<?php echo $fila['comuna']?>">
																					<?php };?>
																				</TD>
																			</TR>
																		</TABLE>
																	</TD>
																</TR>
															</TABLE>
														</TD>
													</TR>
													</TD>
												</TR>
											</TABLE>
										</TD>
									</TR>
								</TABLE>						
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD align=CENTER>
								<TABLE bgcolor=White BORDER=0 CELLSPACING=2 CELLPADDING=0 WIDTH=100%>
									<TR align=CENTER>
										<TD>
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>TELEFONO</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<INPUT type="text" name=txtTELEF size=20 maxlength=30>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"){ 
																imp($fila['telefono']);
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<INPUT type="text" name=txtTELEF size=20 maxlength=30 value="<?php echo $fila['telefono']?>">
														<?php };?>
													</TD>
												</TR>
											</TABLE>
										</TD>
										<TD>
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>EMAIL</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<INPUT type="text" name=txtEMAIL size=40 maxlength=50>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"){ 
																imp($fila['email']);
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<INPUT type="text" name=txtEMAIL size=40 maxlength=50 value="<?php echo $fila['email']?>">
														<?php };?>
													</TD>
												</TR>
											</TABLE>
										</TD>
									</TR>
								</TABLE>
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
						<TR height=15>
							<TD width="100%" colspan=2>
								<?php if($frmModo=="mostrar"){?>
									<INPUT TYPE="button" value="APODERADOS" onClick=document.location="apoderado/listarApoderado.php3">
									<INPUT TYPE="button" value="ANOTACIONES" onClick=document.location="anotacion/listarAnotacion.php3">
									<?php if(($_PERFIL==16)||($_PERFIL==14)||($_PERFIL==0)){ ?>
										<INPUT TYPE="button" value="ACCESO WEB" onClick=document.location="usuario/usuario.php3">
									<?php }?>
									<BR>
									<?php
										$qry="SELECT periodo.id_periodo, ano_escolar.id_ano FROM ano_escolar INNER JOIN periodo ON ano_escolar.id_ano = periodo.id_ano WHERE (((ano_escolar.id_ano)=".$ano."))";
										$result =@pg_Exec($conn,$qry);
										if (!$result) {
											error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
										}else{
											if (pg_numrows($result)!=0){
									?>
										<INPUT TYPE="button" value="EVALUACION" onClick=document.location="notas.php3">
									<?php

											}else{
									?>
										<INPUT TYPE="button" value="EVALUACION" disabled> 
										<FONT face="arial, geneva, helvetica" size=1 color=#000000>
											<STRONG>(No existen PERIODOS ingresados para este AÑO ACADEMICO)</STRONG>
										</FONT>
									<?php
											}
										}
									?>

								<?php }else{?>
										<INPUT TYPE="button" value="APODERADOS" disabled>
										<INPUT TYPE="button" value="ANOTACIONES" disabled>
										<?php if(($_PERFIL==16)||($_PERFIL==14)||($_PERFIL==0)){ ?>
											<INPUT TYPE="button" value="ACCESO WEB" disabled>
										<?php }?>
										<BR>
										<INPUT TYPE="button" value="EVALUACION" disabled>
								<?php }?>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	</FORM>
<? pg_close($conn); ?>	
</BODY>
</HTML>