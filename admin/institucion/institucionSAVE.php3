<?php 
	require('../../util/header.inc');
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$estado = array (
                'pae' =>"disabled",
                'CA' =>"disabled",
                'CP' =>"disabled",
                'WS' =>"disabled",
                'CPA' =>"disabled",
                'EX' =>"disabled"
        );
	if(strcmp($frmModo,"ingresar")){
		$qry2	="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
		$result2	= @pg_Exec($conn,$qry2);
		if (!$result2) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (pg_numrows($result2)!=0){//En caso de estar el arreglo vacio.
				$fila2 = @pg_fetch_array($result2,0);	
				if (!$fila2){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				}else{
					$_TIPOINSTIT = $fila2["tipo_instit"];
					if(!session_is_registered('_TIPOINSTIT')){
						session_register('_TIPOINSTIT');
					};

					$_TIPOREGIMEN = $fila2["tipo_regimen"];
					if(!session_is_registered('_TIPOREGIMEN')){
						session_register('_TIPOREGIMEN');
					};
				}
			}
		}
	}
?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
		}else{
			if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
					exit();
				}
			}
		}
	}
?>
<HTML>
	<HEAD>
		<LINK REL="STYLESHEET" HREF="../../util/td.css" TYPE="text/css">
		<?php if($frmModo!="mostrar"){ ?>
		<?php include('../../util/rpc.php3');?>
			<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
			<?php if($frmModo=="modificar"){ ?>
				<SCRIPT language="JavaScript">
					function valida(form){
						if(!chkVacio(form.txtRDB,'Ingresar RDB.')){
							return false;
						};

						if(!nroOnly(form.txtRDB,'Se permiten sólo numeros en el RDB.')){
							return false;
						};

						if(!chkVacio(form.txtDIGRDB,'Ingresar dígito RDB.')){
							return false;
						};

						if(!chkCod(form.txtRDB,form.txtDIGRDB,'RDB invalido.')){
							return false;
						};
						
						if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE Institución.')){
							return false;
						};

						if(!alfaOnly(form.txtNOMBRE,'Se permiten sólo caracteres alfanuméricos en el campo NOMBRE.')){
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

						if(form.txtFAX.value!=''){
							if(!phoneOnly(form.txtFAX,'Se permiten sólo numeros telefónicos en el campo FAX.')){
								return false;
							};
						};

						if(form.txtEMAIL.value!=''){
							if(!isEmail(form.txtEMAIL,'Formato EMAIL incorrecto.')){
								return false;
							};
						};
						/*
						if(!chkSelect(f1.m1,'Seleccionar REGION.')){
							return false;
						};
						*/

						if(!chkSelect(f2.m2,'Seleccionar PROVINCIA.')){
							return false;
						};

						if(!chkSelect(f3.m3,'Seleccionar COMUNA.')){
							return false;
						};

						if(!chkSelect(form.cmbINSTIT,'Seleccionar TIPO DE INSTITUCION.')){
							return false;
						};

						if(!chkSelect(form.cmbEDUC,'Seleccionar TIPO DE EDUCACION.')){
							return false;
						};

						if(!chkSelect(form.cmbREGIMEN,'Seleccionar TIPO DE REGIMEN.')){
							return false;
						};

						if(!chkSelect(form.cmbIDIOMA,'Seleccionar IDIOMA.')){
							return false;
						};

						if(!chkSelect(form.cmbSEXO,'Seleccionar SEXO.')){
							return false;
						};

						if(!chkSelect(form.cmbMETODO,'Seleccionar METODO.')){
							return false;
						};

						if(!chkSelect(form.cmbFORMACION,'Seleccionar FORMACION.')){
							return false;
						};
						
						return true;
					}
				</SCRIPT>
		<?php };?>
			<?php if($frmModo=="ingresar"){ ?>
				<SCRIPT language="JavaScript">
					function valida(form){
						if(!chkVacio(form.txtRDB,'Ingresar RDB.')){
							return false;
						};

						if(!nroOnly(form.txtRDB,'Se permiten sólo numeros en el RDB.')){
							return false;
						};

						if(!chkVacio(form.txtDIGRDB,'Ingresar dígito RDB.')){
							return false;
						};

						if(!chkCod(form.txtRDB,form.txtDIGRDB,'RDB invalido.')){
							return false;
						};
						
						if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE Institución.')){
							return false;
						};

						if(!alfaOnly(form.txtNOMBRE,'Se permiten sólo caracteres alfanuméricos en el campo NOMBRE.')){
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

						if(form.txtFAX.value!=''){
							if(!phoneOnly(form.txtFAX,'Se permiten sólo numeros telefónicos en el campo FAX.')){
								return false;
							};
						};

						if(form.txtEMAIL.value!=''){
							if(!isEmail(form.txtEMAIL,'Formato EMAIL incorrecto.')){
								return false;
							};
						};

						if(!chkSelect(form.cmbINSTIT,'Seleccionar TIPO DE INSTITUCION.')){
							return false;
						};

						if(!chkSelect(form.cmbEDUC,'Seleccionar TIPO DE EDUCACION.')){
							return false;
						};

						if(!chkSelect(form.cmbREGIMEN,'Seleccionar TIPO DE REGIMEN.')){
							return false;
						};

						if(!chkSelect(form.cmbIDIOMA,'Seleccionar IDIOMA.')){
							return false;
						};

						if(!chkSelect(form.cmbSEXO,'Seleccionar SEXO.')){
							return false;
						};

						if(!chkSelect(form.cmbMETODO,'Seleccionar METODO.')){
							return false;
						};

						if(!chkSelect(form.cmbFORMACION,'Seleccionar FORMACION.')){
							return false;
						};
						
						return true;
					}
				</SCRIPT>
		<?php };?>
	<?php };?>
	</HEAD>
<BODY >
	<FORM method=post name="frm" action="procesoInstitucion.php3">
	<?php echo tope("../../util/");?>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
							<TD align=right colspan=2>
								<?php if($frmModo=="ingresar"){ ?>
									<INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);">&nbsp;
									<?php if($_PERFIL==0) {?>
										<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarInstituciones.php3?modo=ini">&nbsp;
									<? }?>
								<?php };?>
								<?php if($frmModo=="mostrar"){ ?>
									<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
										<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
											<INPUT TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaInstitucion.php3?institucion=<?php echo $institucion?>&caso=3">&nbsp;
											<?php if($_PERFIL==0){ //SOLO ADMINISTRADOR GENERAL?>
												<INPUT TYPE="button" value="ELIMINAR"  name=btnEliminar onclick=document.location="seteaInstitucion.php3?caso=9">&nbsp;
												<?php if($_PERFIL==0) {?>
													<INPUT TYPE="button" value="LISTADO" onClick=document.location="listarInstituciones.php3?modo=ini">&nbsp;
												<? }?>
											<?php };?>
										<?php };?>
									<?php }?>
								<?php };?>

								<?php if($frmModo=="modificar"){ ?>
									<INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);">&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaInstitucion.php3?institucion=<?php echo $institucion?>&caso=1">&nbsp;
								<?php };?>
							</TD>
						</TR>
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>INSTITUCION</strong>
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
												<STRONG>RBD</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtRDB size=10 maxlength=10 onChange="checkRutField(this);">
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['rdb']);
												};
											?>
											<?php if($frmModo=="modificar"){ 
												imp($fila['rdb']);
											};?>
										</TD>
										<TD>&nbsp;-&nbsp;</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtDIGRDB size=1 maxlength=1 >
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['dig_rdb']);
												};
											?>
											<?php if($frmModo=="modificar"){ 
												imp($fila['dig_rdb']);
											};?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>NOMBRE</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtNOMBRE size=83 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['nombre_instit']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtNOMBRE size=83 maxlength=50 value="<?php echo trim($fila['nombre_instit'])?>">
											<?php };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
<!---------------------------------------------------------------------------------------------------!-->
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD width=80>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>ACCESO A P.A.E</STRONG>
											</FONT>
										</TD>
										<TD width=80>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>WEB CENTRO DE ALUMNOS</STRONG>
											</FONT>
										</TD>
										<TD width=80>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>WEB CENTRO DE PADRES</STRONG>
											</FONT>
										</TD>
										<TD width=80>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>WEB<BR>SCOUT</STRONG>
											</FONT>
										</TD>
										<TD width=80>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>WEB<BR>PASTORAL</STRONG>
											</FONT>
										</TD>
										<TD width=80>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>WEB<BR>EXALUMNOS</STRONG>
											</FONT>
										</TD>

									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="checkbox" name=pae size=83 maxlength=50 >
												
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp( ($fila['bool_pae']==0)?"NO":"SI");
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
											<INPUT type="checkbox" name=pae size=83 maxlength=50 value=1 
											<?php 
											  echo ($fila['bool_pae']==1)?"checked":"";
											?>>
											<?php };?>
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="checkbox" name=CA size=83 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp( ($fila['bool_ca']==0)?"NO":"SI");
													if ($fila['bool_ca']==1) 
														 $estado['CA']="enabled";
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
													<INPUT type="checkbox" name=CA size=83 maxlength=50	value=1 <?php echo ($fila['bool_ca']==1)? "checked":"" ?>
												>
											<?php };?>
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="checkbox" name=CP size=83 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp( ($fila['bool_cp']==0)?"NO":"SI");
													if ($fila['bool_cp']==1) 
														 $estado['CP']="enabled";

												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="checkbox" name=CP size=83 maxlength=50	value=1 <?php echo ($fila['bool_cp']==1)?"checked":"" ?>
												>
											<?php };?>
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="checkbox" name=WS size=83 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp( ($fila['bool_ws']==0)?"NO":"SI");
													if ($fila['bool_ws']==1) 
														 $estado['WS']="enabled";

												};
											?>
											<?php if($frmModo=="modificar"){ ?>
													<INPUT type="checkbox" name=WS size=83 maxlength=50	value=1 
													<?php echo ($fila['bool_ws']==1)? "checked":"" ?>
												>
											<?php };?>
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="checkbox" name=CPA size=83 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp( ($fila['bool_cpa']==0)?"NO":"SI");
													if ($fila['bool_cpa']==1) 
														 $estado['CPA']="enabled";

												};
											?>
											<?php if($frmModo=="modificar"){ ?>
													<INPUT type="checkbox" name=CPA size=83 maxlength=50 value=1 <?php echo ($fila['bool_cpa']==1)?"checked":"" ?>
												>
											<?php };?>
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="checkbox" name=EX size=83 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp( ($fila['bool_ex']==0)?"NO":"SI");
													if ($fila['bool_ex']==1) 
														 $estado['EX']="enabled";

												};
											?>
											<?php if($frmModo=="modificar"){ ?>
													<INPUT type="checkbox" name=EX size=83 maxlength=50 value=1 <?php echo ($fila['bool_ex']==1)?"checked":"" ?>
												>
											<?php };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
<!---------------------------------------------------------------------------------------------------!-->
						<TR>
							<TD width=30></TD>
							<TD align=center>
								<TABLE bgcolor=White BORDER=0 CELLSPACING=2 CELLPADDING=0 width=100%>
									<TR>
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
															<INPUT type="text" name=txtTELEF size=20 maxlength=30 value="<?php echo trim($fila['telefono'])?>">
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
															<STRONG>FAX</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<INPUT type="text" name=txtFAX size=20 maxlength=30>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"){ 
																imp($fila['fax']);
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<INPUT type="text" name=txtFAX size=20 maxlength=30 value="<?php echo trim($fila['fax'])?>">
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
															<INPUT type="text" name=txtEMAIL size=20 maxlength=50>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"){ 
																imp($fila['email']);
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<INPUT type="text" name=txtEMAIL size=20 maxlength=50 value="<?php echo trim($fila['email'])?>">
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
							<TD width=30></TD>
							<TD>
								<TABLE bgcolor=White BORDER=0 CELLSPACING=2 CELLPADDING=0 width=100%>
									<TR>
										<TD>
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>TIPO INSTITUCION</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<Select name="cmbINSTIT">
																<option value=0 selected></option>
																<option value=1 >Colegio</option>
																<option value=2 >Jardin Infantil</option>
																<option value=3 >Sala Cuna</option>
															</Select>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"){ 
																switch ($fila['tipo_instit']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Colegio');
																		 break;
																	 case 2:
																		 imp('Jardin Infantil');
																		 break;
																	 case 3:
																		 imp('Sala Cuna');
																		 break;
																 };
															};
	 														if($frmModo=="modificar"){ ?>
															<Select name="cmbINSTIT">
									<option value=0 ></option>
									<option value=1 <?php echo ($fila['tipo_instit'])==1?"selected":"" ?>>Colegio</option>
									<option value=2 <?php echo ($fila['tipo_instit'])==2?"selected":"" ?>>Jardin Infantil</option>
									<option value=3 <?php echo ($fila['tipo_instit'])==3?"selected":"" ?>>Salacuna</option>
															</Select>
														<?php }; ?>

													</TD>
												</TR>
											</TABLE>
										</TD>
										<TD>
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>TIPO EDUCACION</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<Select name="cmbEDUC" >
																<option value=0 selected></option>
																<option value=1 >Kinder</option>
																<option value=2 >Basica</option>
																<option value=3 >Media</option>
																<option value=4 >Kinder - Basica</option>
																<option value=5 >Basica - Media</option>
																<option value=6>Completa</option>
															</Select>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"){ 
																switch ($fila['tipo_educ']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Kinder');
																		 break;
																	 case 2:
																		 imp('Básica');
																		 break;
																	 case 3:
																		 imp('Media');
																		 break;
																	 case 4:
																		 imp('Kinder - Basica');
																		 break;
																	 case 5:
																		 imp('Básica - Media');
																		 break;
																	 case 6:
																		 imp('Completa');
																		 break;
																 };
															};
														?>
															<?php 
															if($frmModo=="modificar"){ 
														  ?>
															<Select name="cmbEDUC" >
									<option value=0 ></option>
									<option value=1 <?php echo ($fila['tipo_educ'])==1?"selected":"" ?>>Kinder</option>
									<option value=2 <?php echo ($fila['tipo_educ'])==2?"selected":"" ?>>Basica</option>
									<option value=3 <?php echo ($fila['tipo_educ'])==3?"selected":"" ?>>Media</option>
									<option value=4 <?php echo ($fila['tipo_educ'])==4?"selected":"" ?>>Kinder - Basica</option>
									<option value=5 <?php echo ($fila['tipo_educ'])==5?"selected":"" ?>>Basica - Media</option>
									<option value=6 <?php echo ($fila['tipo_educ'])==6?"selected":"" ?>>Completa</option>
															</Select>
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
															<STRONG>TIPO REGIMEN</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<Select name="cmbREGIMEN" >
																<option value=0 selected></option>
																<!--option value=1>Bimestral</option-->
																<option value=2>Trimestral</option>
																<option value=3>Semestral</option>
															</Select>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"){ 
																switch ($fila['tipo_regimen']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 2:
																		 imp('Trimestral');
																		 break;
																	 case 3:
																		 imp('Semestral');
																		 break;
																 };
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<Select name="cmbREGIMEN" >
								<option value=0 ></option>
								<!--option value=1 <?php echo ($fila['tipo_regimen'])==1?"selected":"" ?>>Bimestral</option-->
								<option value=2 <?php echo ($fila['tipo_regimen'])==2?"selected":"" ?>>Trimestral</option>
								<option value=3 <?php echo ($fila['tipo_regimen'])==3?"selected":"" ?>>Semestral</option>
															</Select>
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
															<STRONG>IDIOMA</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<Select name="cmbIDIOMA">
																<option value=0 selected></option>
																<option value=1 >Español</option>
																<option value=2 >Ingles</option>
																<option value=3 >Alemán</option>
																<option value=4 >Bilingüe</option>
																<option value=5 >Otros</option>
															</Select>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"){ 
																switch ($fila['idioma']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Español');
																		 break;
																	 case 2:
																		 imp('Ingles');
																		 break;
																	 case 3:
																		 imp('Alemán');
																		 break;
																	 case 4:
																		 imp('Bilingue');
																		 break;
																	 case 5:
																		 imp('Otros');
																		 break;
																 };
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<Select name="cmbIDIOMA">
									<option value=0 ></option>
									<option value=1 <?php echo ($fila['idioma'])==1?"selected":"" ?>>Español</option>
									<option value=2 <?php echo ($fila['idioma'])==2?"selected":"" ?>>Ingles</option>
									<option value=3 <?php echo ($fila['idioma'])==3?"selected":"" ?>>Alemán</option>
									<option value=4 <?php echo ($fila['idioma'])==4?"selected":"" ?>>Bilingüe</option>
									<option value=5 <?php echo ($fila['idioma'])==5?"selected":"" ?>>Otros</option>
															</Select>
														<?php };?>
													</TD>
												</TR>
											</TABLE>
										</TD>
									</TR>
									<TR>
										<TD>
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>SEXO</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<Select name="cmbSEXO" >
																<option value=0 selected></option>
																<option value=1 >Mixto</option>
																<option value=2 >Masculino</option>
																<option value=3 >Femenino</option>
															</Select>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"){ 
																switch ($fila['sexo']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Mixto');
																		 break;
																	 case 2:
																		 imp('Masculino');
																		 break;
																	 case 3:
																		 imp('Femenino');
																		 break;
																 };
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<Select name="cmbSEXO" >
										<option value=0 ></option>
										<option value=1 <?php echo ($fila['sexo'])==1?"selected":"" ?>>Mixto</option>
										<option value=2 <?php echo ($fila['sexo'])==2?"selected":"" ?>>Masculino</option>
										<option value=3 <?php echo ($fila['sexo'])==3?"selected":"" ?>>Femenino</option>
															</Select>
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
															<STRONG>METODO</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<Select name="cmbMETODO">
																<option value=0 selected></option>
																<option value=1 >Tradicional</option>
																<option value=2 >Personalizado</option>
																<option value=3 >Montessori</option>
																<option value=4 >Internacional</option>
																<option value=5 >Activa</option>
																<option value=6 >Transtorno</option>
																<option value=7 >Curriculum Integrado</option>
																<option value=8 >Waldorf</option>
															</Select>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"){ 
																switch ($fila['metodo']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Tradicional');
																		 break;
																	 case 2:
																		 imp('Personalizado');
																		 break;
																	 case 3:
																		 imp('Montessori');
																		 break;
																	 case 4:
																		 imp('Internacional');
																		 break;
																	 case 5:
																		 imp('Activa');
																		 break;
																	 case 6:
																		 imp('Transtorno');
																		 break;
																	 case 7:
																		 imp('Curriculum Integrado');
																		 break;
																	 case 6:
																		 imp('Waldorf');
																		 break;
																 };
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<Select name="cmbMETODO">
																
								<option value=0 ></option>
								<option value=1 <?php echo ($fila['metodo'])==1?"selected":"" ?> >Tradicional</option>
								<option value=2 <?php echo ($fila['metodo'])==2?"selected":"" ?> >Personalizado</option>
								<option value=3 <?php echo ($fila['metodo'])==3?"selected":"" ?>>Montessori</option>
								<option value=4 <?php echo ($fila['metodo'])==4?"selected":"" ?>>Internacional</option>
								<option value=5 <?php echo ($fila['metodo'])==5?"selected":"" ?>>Activa</option>
								<option value=6 <?php echo ($fila['metodo'])==6?"selected":"" ?>>Transtorno</option>
								<option value=6 <?php echo ($fila['metodo'])==7?"selected":"" ?>>Curriculum Integrado</option>
								<option value=8 <?php echo ($fila['metodo'])==8?"selected":"" ?>>Waldorf</option>
															</Select>
														<?php };?>
													</TD>
												</TR>
											</TABLE>
										</TD>
										<TD colspan=2>
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>FORMACION</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<Select name="cmbFORMACION">
																<option value=0 selected></option>
																<option value=1 >Católico</option>
																<option value=2 >Laico</option>
																<option value=3 >Cristiana</option>
															</Select>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"){ 
																switch ($fila['formacion']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Católico');
																		 break;
																	 case 2:
																		 imp('Laico');
																		 break;
																	 case 3:
																		 imp('Cristiana');
																		 break;
																 };
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<Select name="cmbFORMACION">
										<option value=0 ></option>
										<option value=1 <?php echo ($fila['formacion'])==1?"selected":"" ?>>Católico</option>
										<option value=2 <?php echo ($fila['formacion'])==2?"selected":"" ?>>Laico</option>
										<option value=3 <?php echo ($fila['formacion'])==3?"selected":"" ?>>Cristiana</option>
															</Select>
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
																	<INPUT type="text" name=txtCALLE size=35 maxlength=50 value="<?php echo trim($fila['calle'])?>" >
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
																	<INPUT type="text" name=txtNRO size=10 maxlength=5 value=<?php echo $fila['nro']?> >
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
																	<INPUT type="text" name=txtDEP size=12 maxlength=10 value="<?php echo $fila['depto']?>" >
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
																	<INPUT type="text" name=txtBLO size=12 maxlength=10 value="<?php echo $fila['txtBLO']?>">
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
																	<INPUT type="text" name=txtVIL size=34 maxlength=50 value="<?php echo trim($fila['villa'])?>">
																<?php };?>
															</TD>
														</TR>
													</TABLE>
													</TD>
													</TR>

													<?php if($frmModo=="modificar"){ ?>
														<INPUT type="hidden" name=txtREG value=<?php echo $fila['region']?>>
														<INPUT type="hidden" name=txtCIU value=<?php echo $fila['ciudad']?>>
														<INPUT type="hidden" name=txtCOM value=<?php echo $fila['comuna']?>>
													<?php }else{?>
														<INPUT type="hidden" name=txtREG>
														<INPUT type="hidden" name=txtCIU>
														<INPUT type="hidden" name=txtCOM>
													<?php }?>
	</FORM>
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
<FORM method=post name=f1 onSubmit="return false;">
	<SELECT class=saveHistory id=m1 name=m1 onChange="relate(this.form,0,this.selectedIndex);document.frm.txtREG.value=document.f1.m1.value;">
	<?php
		//SELECCIONAR TODAS LAS REGIONES
		$qryREG		="SELECT * FROM REGION ORDER BY COD_REG ASC";
		$resultREG	=@pg_Exec($connRPC,$qryREG);
		for($i=0 ; $i < @pg_numrows($resultREG) ; $i++){
			$filaREG = @pg_fetch_array($resultREG,$i);
			echo "<OPTION value=\"".trim($filaREG['cod_reg'])."\">".trim($filaREG['nom_reg'])." </OPTION>\n";
		}//for resultREG
	?>
	</SELECT>
</FORM>

																					<?php };?>
																					<?php 
																						if($frmModo=="mostrar"){ 
																	$qryREG		="SELECT * FROM REGION WHERE COD_REG=".$fila['region'];
																	$resultREG	=@pg_Exec($conn,$qryREG);
																	$filaREG	= @pg_fetch_array($resultREG,0);
																	imp($filaREG['nom_reg']);
																						};
																					?>
			<?php if($frmModo=="modificar"){ ?>
				<!--INPUT type="text" name=txtREG size=20 value="<?php echo $fila['region']?>"-->
<FORM method=post name=f1 onSubmit="return false;">
	<SELECT class=saveHistory id=m1 name=m1 onChange="relate(this.form,0,this.selectedIndex);document.frm.txtREG.value=document.f1.m1.value;">
	<?php
		//SELECCIONAR TODAS LAS REGIONES
		$qryREG		="SELECT * FROM REGION ORDER BY COD_REG ASC";
		$resultREG	=@pg_Exec($connRPC,$qryREG);
		for($i=0 ; $i < @pg_numrows($resultREG) ; $i++){
			$filaREG = @pg_fetch_array($resultREG,$i);
			if($filaREG['cod_reg']==$fila['region'])
				echo "<OPTION value=\"".trim($filaREG['cod_reg'])."\" selected>".trim($filaREG['nom_reg'])." </OPTION>\n";
				else
					echo "<OPTION value=\"".trim($filaREG['cod_reg'])."\">".trim($filaREG['nom_reg'])." </OPTION>\n";
		}//for resultREG
	?>
	</SELECT>
</FORM>

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
																						<STRONG>PROVINCIA</STRONG>
																					</FONT>
																				</TD>
																			</TR>
																			<TR>
																				<TD>
																					<?php if($frmModo=="ingresar"){ ?>
<FORM method=post name=f2 onSubmit="return false;">
	<SELECT class=saveHistory id=m2 name=m2 onChange="relate2(this.form,0,this.selectedIndex,0);document.frm.txtCIU.value=document.f2.m2.value;"> 
	<?php
		//SELECCIONAR TODAS LAS PROVINCIAS
		$qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=1 ORDER BY NOM_PRO ASC";
		$resultPRO	=@pg_Exec($connRPC,$qryPRO);
		for($i=0 ; $i < @pg_numrows($resultPRO) ; $i++){
			$filaPRO = @pg_fetch_array($resultPRO,$i);
			echo "<OPTION value=\"".trim($filaPRO['cor_pro'])."\">".trim($filaPRO['nom_pro'])." </OPTION>\n";
		}//for resultPRO
	?>
	</SELECT>
</FORM>

																					<?php };?>
																					<?php 
																						if($frmModo=="mostrar"){ 
										$qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad'];
										$resultPRO	=@pg_Exec($conn,$qryPRO);
										$filaPRO	= @pg_fetch_array($resultPRO,0);
										imp($filaPRO['nom_pro']);
																						};
																					?>
<?php if($frmModo=="modificar"){ ?>
	<!--INPUT type="text" name=txtCIU size=20 value=<?php echo $fila['ciudad']?>-->

<FORM method=post name=f2 onSubmit="return false;">
	<SELECT class=saveHistory id=m2 name=m2 onChange="relate2(this.form,0,this.selectedIndex,0);document.frm.txtCIU.value=document.f2.m2.value;"> 
	<?php
		//SELECCIONAR TODAS LAS PROVINCIAS
		$qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=".$fila['region']." ORDER BY NOM_PRO ASC";
		$resultPRO	=@pg_Exec($connRPC,$qryPRO);
		for($i=0 ; $i < @pg_numrows($resultPRO) ; $i++){
			$filaPRO = @pg_fetch_array($resultPRO,$i);
			if($filaPRO['cor_pro']==$fila['ciudad'])
				echo "<OPTION value=\"".trim($filaPRO['cor_pro'])."\" selected>".trim($filaPRO['nom_pro'])." </OPTION>\n";
				else
					echo "<OPTION value=\"".trim($filaPRO['cor_pro'])."\">".trim($filaPRO['nom_pro'])." </OPTION>\n";
		}//for resultPRO
	?>
	</SELECT>
</FORM>


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
<FORM  method=post name=f3 onSubmit="return false;">
	<SELECT class=saveHistory id=m3 name=m3 onChange="document.frm.txtCOM.value=document.f3.m3.value;"> 
	<?php
		//SELECCIONAR TODAS LAS COMUNAS
		$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=1 AND COR_PRO=1 ORDER BY NOM_COM ASC";
		$resultCOM	=@pg_Exec($connRPC,$qryCOM);
		for($i=0 ; $i < @pg_numrows($resultCOM) ; $i++){
			$filaCOM = @pg_fetch_array($resultCOM,$i);
			echo "<OPTION value=\"".trim($filaCOM['cor_com'])."\">".trim($filaCOM['nom_com'])." </OPTION>\n";
		}//for resultPRO
	?>
	</SELECT> 
</FORM>
																					<?php };?>
																					<?php 
																						if($frmModo=="mostrar"){ 
			$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad']." AND COR_COM=".$fila['comuna'];
			$resultCOM	=@pg_Exec($conn,$qryCOM);
			$filaCOM	= @pg_fetch_array($resultCOM,0);
			imp($filaCOM['nom_com']);
																						};
																					?>
																					<?php if($frmModo=="modificar"){ ?>
											<!--INPUT type="text" name=txtCOM size=20 value=<?php echo $fila['comuna']?>-->

<FORM method=post name=f3 onSubmit="return false;">
	<SELECT class=saveHistory id=m3 name=m3 onChange="document.frm.txtCOM.value=document.f3.m3.value;"> 
	<?php
		//SELECCIONAR TODAS LAS COMUNAS
		$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad']." ORDER BY NOM_COM ASC";
		$resultCOM	=@pg_Exec($connRPC,$qryCOM);
		for($i=0 ; $i < @pg_numrows($resultCOM) ; $i++){
			$filaCOM = @pg_fetch_array($resultCOM,$i);
			if($filaCOM['cor_com']==$fila['comuna'])
				echo "<OPTION value=\"".trim($filaCOM['cor_com'])."\" selected>".trim($filaCOM['nom_com'])." </OPTION>\n";
				else
					echo "<OPTION value=\"".trim($filaCOM['cor_com'])."\" >".trim($filaCOM['nom_com'])." </OPTION>\n";
		}//for resultPRO
	?>
	</SELECT> 
</FORM>

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
									<center>
										<INPUT TYPE="button" value="AÑO ESCOLAR" onClick=document.location="ano/listarAno.php3" >
										<INPUT TYPE="button" value="NOTICIA" onClick=document.location="noticia/listarNoticia.php3?agrupacion=1">
										<INPUT TYPE="button" value="AGENDA" onClick=document.location="agenda/listarAgenda.php3?agrupacion=1">
										<INPUT TYPE="button" value="PERSONAL" onClick=document.location="empleado/listarEmpleado.php3">
										<INPUT TYPE="button" value="ESTANCIA" disabled>
										<BR>
										<BR>
										<INPUT TYPE="button" value="CARTA DIRECCION" onClick=document.location="atributos/cartaDireccion.php3">
										<INPUT TYPE="button" value="PROYECTO EDUCATIVO" onClick=document.location="atributos/proyectoEducativo.php3">
										<INPUT TYPE="button" value="UNIFORME" onClick=document.location="atributos/uniforme.php3">
										<BR>
										<BR>
										<INPUT TYPE="button" value="REGLAMENTO INTERNO" onClick=document.location="atributos/reglamentoInterno.php3">
										<INPUT TYPE="button" value="NUESTRA INSTITUCION" onClick=document.location="atributos/nuestraInstitucion.php3">
										<BR>
										<BR>
										<INPUT TYPE="button" value="PROCESO ADMISION"    onClick=document.location="atributos/procesoAdmision.php3">
										<BR>
										<BR>
										<INPUT TYPE="button" value="BIBLIOTECA" onClick=document.location="biblioteca/listarLibros.php">
										<BR>
										<BR>
										<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
												<INPUT TYPE="button" value="INSIGNIA" onClick=window.open('insignia.php?rut=<?php echo $institucion ?>','CodigoProducto','height=200,width=380,scrollbar=no,location=no,resizable=no')>
												<INPUT TYPE="button" value="MAPA" onClick=window.open('mapa.php?rut=<?php echo $institucion ?>','CodigoProducto','height=200,width=380,scrollbar=no,location=no,resizable=no')>
												<INPUT TYPE="button" onClick="window.location='bolsa/listarSolicitudes.php'" value="BOLSA DE TRABAJO">
												<INPUT 
TYPE="button" onClick="window.location='remate/listarRemates.php3'" value="LICITACIONES">
											<?php }?>
										<?php }else{?>
												<INPUT TYPE="button" value="INSIGNIA" disabled>
												<INPUT TYPE="button" value="MAPA" disabled>
										<?php }?>
										<BR>
										<BR>
										<INPUT TYPE="button" value="CENTRO DE ALUMNOS" onClick=document.location="centroAlumnos.php3" <?php echo $estado['CA'];?>>
										<INPUT TYPE="button" value="CENTRO DE PADRES" onClick=document.location="centroPadres.php3" <?php echo $estado['CP'];?>>
										<BR>
										<BR>
										<INPUT TYPE="button" value="WEB SCOUT" onClick=document.location="webScout.php3" <?php echo $estado['WS'];?>>
										<INPUT TYPE="button" value="CENTRO PASTORAL" onClick=document.location="centroPastoral.php3" <?php echo $estado['CPA'];?>>
										<INPUT TYPE="button" value="EXALUMNOS" onClick=document.location="exalumnos.php3" <?php echo $estado['EX'];?>>
										<BR>
										<BR>
			<INPUT TYPE="button" value="MOVIL ESCOLAR" 
				onClick=document.location="../../tesc/fichaTesc.php3?rdb=<?php echo trim($_INSTIT);?>"
			>
								<?php }else{?>
										<center>
											<INPUT TYPE="button" value="AÑO ESCOLAR" disabled>
											<INPUT TYPE="button" value="NOTICIA" disabled>
											<INPUT TYPE="button" value="AGENDA" disabled>
											<INPUT TYPE="button" value="PERSONAL" disabled>
											<INPUT TYPE="button" value="ESTANCIA" disabled>
											<BR>
											<BR>
											<INPUT TYPE="button" value="CARTA DIRECCION" disabled>
											<INPUT TYPE="button" value="PROYECTO EDUCATIVO" disabled>
											<INPUT TYPE="button" value="UNIFORME" disabled>
											<BR>
											<BR>
											<INPUT TYPE="button" value="REGLAMENTO INTERNO" disabled>
											<INPUT TYPE="button" value="NUESTRA INSTITUCION" disabled>
											<BR>
											<BR>
											<INPUT TYPE="button" value="PROCESO ADMISION" disabled>
											<BR>
											<BR>
											<INPUT TYPE="button" value="BIBLIOTECA" disabled>
											<BR>
											<BR>
											<INPUT TYPE="button" value="INSIGNIA" disabled>
											<INPUT TYPE="button" value="MAPA" disabled>
											<BR>
											<BR>
											<INPUT TYPE="button" value="CENTRO DE ALUMNOS" disabled>
											<INPUT TYPE="button" value="CENTRO DE PADRES" disabled>
											<BR>
											<BR>
											<INPUT TYPE="button" value="WEB SCOUT" disabled>
											<INPUT TYPE="button" value="CENTRO PASTORAL" disabled>
											<INPUT TYPE="button" value="EXALUMNOS" disabled>
											<BR>
											<BR>
											<INPUT TYPE="button" value="MOVIL ESCOLAR" disabled>
										</center>
								<?php }?>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<?php if($frmModo=="ingresar"){?>
				<tr>
					<td colspan=3 align=center>
						<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
							<tr>
								<td>
									<table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
										<tr>
											<td>
												<font face="arial, geneva, helvetica" size="1" color=black>
													<ul>
														<li>Una vez finalizado el ingreso de la información presionar "GUARDAR" para grabar los datos, o bien "CANCELAR" para volver al listado de instituciones ingresadas al sistema.</li>
														
<li>Para abandonar la sesión de usuario presionar "CERRAR SESION".</li>
													</ul>
												</font>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<?php }?>
			<?php if($frmModo=="mostrar"){?>
				<tr>
					<td colspan=3 align=center>
						<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
							<tr>
								<td>
									<table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
										<tr>
											<td>
												<font face="arial, geneva, helvetica" size="1" color=black>
													<ul>
													
													<li>"AÑO ACADEMICO" : Años académicos ingresados a la institución.</li>
													<li>"NOTICIA" : Total de  noticias de la institución.</li>
													<li>"AGENDA" : Total de  notas de la agenda de la institución.</li>
													<li>"PERSONAL" : Empleados de la institución.</li>
													<li>"CARTA DIRECCION", "PROYECTO EDUCATIVO", "UNIFORME", "REGLAMENTO INTERNO", "NUESTRA INSTITUCION" y "PROCESO ADMISION" : Accede al texto que corresponde.</li>
													<li>"BIBLIOTECA" : Accede al total de libros registrados para la institución.</li>
													<li>"INSIGNIA" y "MAPA" : Permiten el ingreso de las imagenes correspondientes.</li>
													<li>"BOLSA DE TRABAJO" : Permite el ingreso de ofertas de trabajo.</li>
													
<li>"LICITACIONES" : Permite el ingreso de avisos para publicarlos en web.</li>
													<li>"CENTRO DE ALUMNOS", "CENTRO DE PADRES", "WEB SCOUT", "CENTRO PASTORAL" y "EXALUMNOS"  : Permite el ingreso de noticias y notas de agenda, para cada agrupación segun corresponda.</li>
													<li>"ELIMINAR" : Elimina toda la información de la institución ingresada</li>
													<li>"LISTADO" : Despliega el total de instituciones ingresadas.</li>
													<li>Para abandonar la sesión de usuario presionar "CERRAR SESION".</li>
													</ul>
												</font>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<?php }?>
			<?php if($frmModo=="modificar"){?>
				<tr>
					<td colspan=3 align=center>
						<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
							<tr>
								<td>
									<table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
										<tr>
											<td>
												<font face="arial, geneva, helvetica" size="1" color=black>
													<ul>
														<li>Una vez finalizado la modificación de la información presionar "GUARDAR" para grabar los datos, o bien "CANCELAR" para no realizar modificaciones.</li>
														<li>Para abandonar la sesión de usuario presionar "CERRAR SESSION".</li>
													</ul>
												</font>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<?php }?>
		</TABLE>
	<!--/FORM-->
</BODY>
</HTML>
