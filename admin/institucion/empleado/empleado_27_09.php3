<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$empleado		=$_EMPLEADO;

	$qry="SELECT * FROM INSTITUCION WHERE RDB=".$_INSTIT;
	$result =@pg_Exec($conn,$qry);
	$fila = @pg_fetch_array($result,0);	
	$regINS = $fila['region'];
	$proINS = $fila['ciudad'];
	$comINS = $fila['comuna'];

?>
<?php
		$qryV ="select * from (supervisa inner join trabaja on supervisa.rut_emp=trabaja.rut_emp) where trabaja.rdb=".$institucion." and supervisa.rut_emp='".$empleado."'";
		$resultV =@pg_Exec($conn,$qryV);
		$filaV = @pg_fetch_array($resultV,0);
		/*echo $filaV["id_curso"];
		exit;*/
		if (pg_numrows($resultV)>0){
			$qryVV="select * from (curso inner join ano_escolar on curso.id_ano=ano_escolar.id_ano) where ano_escolar.id_institucion=".$institucion." and curso.id_curso=".$filaV["id_curso"];
			$resultVV =@pg_Exec($conn,$qryVV);
			if (pg_numrows($resultVV)>0){?>
				<SCRIPT language="JavaScript">///$resV=1;
				window.alert("ESTE EMPLEADO ES PROFESOR JEFE. SI DESEA ELIMINARLO PRIMERO DEBE ASIGNAR UN NUEVO PROFESOR JEFE AL CURSO")
				</SCRIPT>
			<!--?php }else{ ?>
					<SCRIPT language="JavaScript">///$resV=1;
						document.location="seteaEmpleado.php3?caso=9";
					</SCRIPT-->
				
		<?php }}?>
	
	<?php
	if($frmModo!="ingresar"){
		$qry="SELECT trabaja.fecha_ingreso, trabaja.fecha_retiro, trabaja.cargo, empleado.*, empleado.rut_emp FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((trabaja.rdb)=".$institucion.") AND ((empleado.rut_emp)=".$empleado."))";
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
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
		<LINK REL="STYLESHEET" HREF="../../../util/td.css" TYPE="text/css">
<?php if($frmModo!="mostrar"){?>
		<?php include('../../../util/rpc.php3');?>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
	<?php if($frmModo=="modificar"){ ?>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtRUT,'Ingresar RUT.')){
					return false;
				};

				if(!nroOnly(form.txtRUT,'Se permiten sólo números en el RUT.')){
					return false;
				};

				if(!chkVacio(form.txtDIGRUT,'Ingresar dígito verificador del RUT.')){
					return false;
				};

				if(!chkCod(form.txtRUT,form.txtDIGRUT,'RUT inválido.')){
					return false;
				};
				
				if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE.')){
					return false;
				};

				if(!alfaOnly(form.txtNOMBRE,'Se permiten sólo caracteres alfanuméricos en el campo NOMBRE.')){
					return false;
				};

				if(!chkVacio(form.txtAPEPAT,'Ingresar APELLIDO PATERNO.')){
					return false;
				};

				if(!alfaOnly(form.txtAPEPAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO PATERNO.')){
					return false;
				};

				if(!chkVacio(form.txtAPEMAT,'Ingresar APELLIDO MATERNO.')){
					return false;
				};

				if(!alfaOnly(form.txtAPEMAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO MATERNO.')){
					return false;
				};

				if(!chkVacio(form.txtCALLE,'Ingresar CALLE.')){
					return false;
				};

				if(form.txtTELEF.value!=''){
					if(!phoneOnly(form.txtTELEF,'Se permiten sólo números telefónicos en el campo TELEFONO.')){
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

				if(!alfaOnly(form.txtTITULO,'Se permiten sólo caracteres alfanuméricos en el campo TITULO.')){
					return false;
				};

				if(!chkSelect(form.cmbSEXO,'Seleccionar SEXO.')){
					return false;
				};

				if(!chkSelect(form.cmbCIVIL,'Seleccionar ESTADO CIVIL.')){
					return false;
				};

				if(!chkSelect(form.cmbCARGO,'Seleccionar CARGO.')){
					return false;
				};
                if(!chkVacio(form.txtFECHA,'Ingresar FECHA.')){
					return false;
				};

				if(!chkFecha(form.txtFECHA,'Fecha invalida.')){
					return false;
				};
				return true;
			}
		</SCRIPT>
	<?php }?>
	<?php if($frmModo=="ingresar"){ ?>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtRUT,'Ingresar RUT.')){
					return false;
				};

				if(!nroOnly(form.txtRUT,'Se permiten sólo números en el RUT.')){
					return false;
				};

				if(!chkVacio(form.txtDIGRUT,'Ingresar dígito verificador del RUT.')){
					return false;
				};

				if(!chkCod(form.txtRUT,form.txtDIGRUT,'RUT inválido.')){
					return false;
				};
				
				if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE.')){
					return false;
				};

				if(!alfaOnly(form.txtNOMBRE,'Se permiten sólo caracteres alfanuméricos en el campo NOMBRE.')){
					return false;
				};

				if(!chkVacio(form.txtAPEPAT,'Ingresar APELLIDO PATERNO.')){
					return false;
				};

				if(!alfaOnly(form.txtAPEPAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO PATERNO.')){
					return false;
				};

				if(!chkVacio(form.txtAPEMAT,'Ingresar APELLIDO MATERNO.')){
					return false;
				};

				if(!alfaOnly(form.txtAPEMAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO MATERNO.')){
					return false;
				};

				if(!chkVacio(form.txtCALLE,'Ingresar CALLE.')){
					return false;
				};

				if(form.txtTELEF.value!=''){
					if(!phoneOnly(form.txtTELEF,'Se permiten sólo números telefónicos en el campo TELEFONO.')){
						return false;
					};
				};

				if(form.txtEMAIL.value!=''){
					if(!isEmail(form.txtEMAIL,'Formato EMAIL incorrecto.')){
						return false;
					};
				};


				if(!alfaOnly(form.txtTITULO,'Se permiten sólo caracteres alfanuméricos en el campo TITULO.')){
					return false;
				};

				if(!chkSelect(form.cmbSEXO,'Seleccionar SEXO.')){
					return false;
				};

				if(!chkSelect(form.cmbCIVIL,'Seleccionar ESTADO CIVIL.')){
					return false;
				};

				if(!chkSelect(form.cmbCARGO,'Seleccionar CARGO.')){
					return false;
				};
				function Confirmacion()
				{
					if(confirm('¿Esta seguro de querer realizar esta operación?') == false) 
					{
						return; 
					}
						document.form.Accion.value = "3";
						document.form.submit();
				}

				return true;
			}
		</SCRIPT>
	<?php }?>
<?php }?>
	
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY>
	<?php //echo tope("../../../util/");?>
	<FORM method=post name="frm" action="procesoEmpleado.php3">
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
	?>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
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
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
												}
												echo trim($fila1['nombre_instit']);
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
								<?php if($frmModo=="ingresar"){ ?>
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR"   name=btnGuardar onclick="return valida(this.form);" >&nbsp;
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarEmpleado.php3">&nbsp;
								<?php };?>
								
								<?php if($frmModo=="mostrar"){ ?>
									<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaEmpleado.php3?empleado=<?php echo $empleado?>&caso=3">&nbsp;
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaEmpleado.php3?caso=9">&nbsp;
											<?php }?>
									<?php }//ACADEMICO Y LEGAL?>
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="LISTADO" onClick=document.location="listarEmpleado.php3">&nbsp;
								<?php };?>


								<?php if($frmModo=="modificar"){ ?>
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR"   name=btnGuardar >&nbsp;
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaEmpleado.php3?empleado=<?php echo $empleado?>&caso=1">&nbsp;
								<?php };?>
							</TD>
						</TR>
						<TR height=20 bgcolor=#003b85>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>PERSONAL</strong>
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
												<INPUT type="text" name=txtRUT size=10 maxlength=10 onchange="checkRutField(this);">
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['rut_emp']);
												};
											?>
											<?php 
												if($frmModo=="modificar"){ 
													imp($fila['rut_emp']);
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
													imp($fila['nombre_emp']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtNOMBRE size=25 maxlength=50 value="<?php echo trim($fila['nombre_emp'])?>">
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
												<INPUT type="text" name=txtAPEPAT size=25 maxlength=50 value="<?php echo trim($fila['ape_pat'])?>">
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
												<INPUT type="text" name=txtAPEMAT size=25 maxlength=50 value="<?php echo trim($fila['ape_mat'])?>">
											<?php };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>

						<TR>
							<TD width=30></TD>
							<TD align=left>
								<TABLE bgcolor=White BORDER=0 CELLSPACING=2 CELLPADDING=0 width=100%>
									<TR>
										<TD>
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
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
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
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
															<INPUT type="text" name=txtEMAIL size=40 maxlength=50 value="<?php echo trim($fila['email'])?>">
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
							<TD align=left>
								<TABLE bgcolor=White BORDER=0 CELLSPACING=2 CELLPADDING=0>
									<TR>
										<TD>
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>TITULO</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<INPUT type="text" name=txtTITULO size=85 maxlength=1000>
														<?php };?>
														<?php
															if($frmModo=="mostrar"){ 
																imp($fila['titulo']);
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<INPUT type="text" name=txtTITULO size=85 maxlength=1000 value="<?php echo trim($fila['titulo'])?>">
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
							<TD align=left>
								<TABLE bgcolor=White BORDER=0 CELLSPACING=2 CELLPADDING=0>
									<TR>
										<TD>
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
                                                 
                                             
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<Select name="cmbTITULO" >
																<option value=0 selected></option>
																<option value=1 >HABILITADO</option>
																<option value=2 >TITULADO EN EDUCACION</option>
																<option value=3 >TITULADO EN OTRAS AREAS</option>
															</Select>
														<?php };?>
														<?php
															if($frmModo=="mostrar"){ 
																switch ($fila['tipo_titulo']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('HABILITADO');
																		 break;
																	 case 2:
																		 imp('TITULADO EN EDUCACION');
																		 break;
																	 case 3:
																		 imp('TITULADO EN OTRAS AREAS');
																		 break;
																 };
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<Select name="cmbTITULO" >
                                                    <option value=0 <?php echo ($fila['tipo_titulo'])==0?" selected ":"" ?>></option>
													<option value=1 <?php echo ($fila['tipo_titulo'])==1?" selected ":"" ?>>HABILITADO</option>
													<option value=2 <?php echo ($fila['tipo_titulo'])==2?" selected ":"" ?>>TITULADO EN EDUCACION</option>
													<option value=3 <?php echo ($fila['tipo_titulo'])==3?" selected ":"" ?>>TITULADO EN OTRAS AREAS</option>
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
							<TD align=center>
								<TABLE bgcolor=White BORDER=0 CELLSPACING=2 CELLPADDING=0 width=100%>
									<TR align=center>
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
																<option value=1 >Masculino</option>
																<option value=2 >Femenino</option>
															</Select>
														<?php };?>
														<?php
															if($frmModo=="mostrar"){ 
																switch ($fila['sexo']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Masculino');
																		 break;
																	 case 2:
																		 imp('Femenino');
																		 break;
																 };
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<Select name="cmbSEXO" >
																<option value=1 <?php echo ($fila['sexo'])==1?" selected ":"" ?>>Masculino</option>
																<option value=2 <?php echo ($fila['sexo'])==2?" selected ":"" ?>>Femenino</option>
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
															<STRONG>ESTADO CIVIL</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<Select name="cmbCIVIL" >
																<option value=0 selected></option>
																<option value=1 >Soltero(a)</option>
																<option value=2 >Casado(a)</option>
																<option value=3 >Viudo(a)</option>
															</Select>
														<?php };?>
														<?php
															if($frmModo=="mostrar"){ 
																switch ($fila['estado_civil']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Soltero(a)');
																		 break;
																	 case 2:
																		 imp('Casado(a)');
																		 break;
																	 case 3:
																		 imp('Viudo(a)');
																		 break;
																 };
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<Select name="cmbCIVIL" >
													<option value=1 <?php echo ($fila['estado_civil'])==1?" selected ":"" ?>>Soltero(a)</option>
													<option value=2 <?php echo ($fila['estado_civil'])==2?" selected ":"" ?>>Casado(a)</option>
													<option value=3 <?php echo ($fila['estado_civil'])==3?" selected ":"" ?>>Viudo(a)</option>
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
															<STRONG>CARGO</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<Select name="cmbCARGO">
																<option value=0 selected></option>
																<option value=1 >Director(a)</option>
																<option value=2 >Jefe UTP</option>
																<option value=3 >Enfermeria</option>
																<option value=4 >Contador(a)</option>
																<option value=5 >Docente</option>
															    <option value=6 >Sub-Director(a)</option>
																<option value=7 >Inspector(a) General</option>
																<!--option value=8 >Titulación</option-->
																<!--option value=9 >Curriculista</option-->
																<!--option value=10 >Evaluador</option-->
																<option value=11 >Orientador(a)</option>
																<option value=12 >Sicopedagogo(a)</option>
																<option value=13 >Sicólogo(a)</option>
																<option value=14 >Inspector(a)</option>
																<option value=15 >Auxiliar</option>
																<option value=16 >Coordinación CRA</option>
																<option value=17 >Coordinación Pastoral</option>
																<option value=18 >Coordinación ACLE</option>
																<option value=19 >Secretaria</option>
																<!--option value=20 >Tesorera</option-->
																<option value=21 >Asistente Social</option>
																<option value=22 >Coordinación Mantenimiento</option>
															</Select>
														<?php };?>
														<?php
															if($frmModo=="mostrar"){ 
																switch ($fila['cargo']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Director');
																		 break;
																	 case 2:
																		 imp('Jefe UTP');
																		 break;
																	 case 3:
																		 imp('Enfermeria');
																		 break;
																	 case 4:
																		 imp('Contador');
																		 break;
																	 case 5:
																		 imp('Docente');
																		 break;
																	 case 6:
																		 imp('Sub-Director');
																		 break;
																   	 case 7:
																		 imp('Inspector General');
																		 break;
																 	 case 8:
																		 imp('Titulacion');
																		 break;
																	 case 9:
																		 imp('Curriculista');
																		 break;
																	 case 10:
																		 imp('Evaluador');
																		 break;
																	 case 11:
																		 imp('Orientador(a)');
																		 break;
																	 case 12:
																		 imp('Sicopedagoga');
																		 break;
																	 case 13:
																		 imp('Sicologo');
																		 break;
																	 case 14:
																		 imp('Inspectora');
																		 break;
																	 case 15:
																		 imp('Auxiliar');
																		 break;
																	 case 16:
																		 imp('Coordinación CRA');
																		 break;
																	 case 17:
																		 imp('Coordinación Pastoral');
																		 break;
																	 case 18:
																		 imp('Coordinación ACLE');
																		 break;
																	 case 19:
																		 imp('Secretaria');
																		 break;
															 		 case 20:
																		 imp('Tesorera');
																		 break;
																	 case 21:
																		 imp('Asistente Social');
																		 break;
															    	 case 22:
																		 imp('Coordinación Mantenimiento');
																		 break;
																 };
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<Select name="cmbCARGO">
													<option value=1 <?php echo ($fila['cargo'])==1?" selected ":"" ?>>Director</option>
													<option value=2 <?php echo ($fila['cargo'])==2?" selected ":"" ?>>Jefe UTP</option>
													<option value=3 <?php echo ($fila['cargo'])==3?" selected ":"" ?>>Enfermeria</option>
													<option value=4 <?php echo ($fila['cargo'])==4?" selected ":"" ?>>Contador</option>
													<option value=5 <?php echo ($fila['cargo'])==5?" selected ":"" ?>>Docente</option>
													<option value=6 <?php echo ($fila['cargo'])==6?" selected ":"" ?>>Sub-Director</option>
													<option value=7 <?php echo ($fila['cargo'])==7?" selected ":"" ?>>Inspector General</option>
													<option value=8 <?php echo ($fila['cargo'])==8?" selected ":"" ?>>Titulación</option>
													<option value=9 <?php echo ($fila['cargo'])==9?" selected ":"" ?>>Curriculista</option>
													<option value=10 <?php echo ($fila['cargo'])==10?" selected ":"" ?>>Evaluador</option>
													<option value=11 <?php echo ($fila['cargo'])==11?" selected ":"" ?>>Orientador(a)</option>
													<option value=12 <?php echo ($fila['cargo'])==12?" selected ":"" ?>>Sicopedagoga</option>
													<option value=13 <?php echo ($fila['cargo'])==13?" selected ":"" ?>>Sicóloga</option>
													<option value=14 <?php echo ($fila['cargo'])==14?" selected ":"" ?>>Inspectora</option>
													<option value=15 <?php echo ($fila['cargo'])==15?" selected ":"" ?>>Auxiliar</option>
													<option value=16 <?php echo ($fila['cargo'])==16?" selected ":"" ?>>Coordinación CRA</option>
													<option value=17 <?php echo ($fila['cargo'])==17?" selected ":"" ?>>Coordinación Pastoral</option>
													<option value=18 <?php echo ($fila['cargo'])==18?" selected ":"" ?>>Coordinación ACLE</option>
													<option value=19 <?php echo ($fila['cargo'])==19?" selected ":"" ?>>Secretaria</option>
													<option value=20 <?php echo ($fila['cargo'])==20?" selected ":"" ?>>Tesorera</option>
													<option value=21 <?php echo ($fila['cargo'])==21?" selected ":"" ?>>Asistente Social</option>
													<option value=22 <?php echo ($fila['cargo'])==22?" selected ":"" ?>>Coordinación Mantenimiento</option>
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
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=98%>

                                  <TR>
										<TD bgcolor=#cccccc width="900">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>AUTORIZACION EJERCICIO DOCENTE</STRONG>  
											</FONT>
										</TD>
								</TR>
								 <TR>
									   <TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>Nº RESOLUCION</STRONG>
											</FONT>
										</TD>
								</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtNROres size=20 maxlength=10>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['nu_resol']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtNROres size=20 maxlength=10 value=<?php echo $fila['nu_resol']?> >
																<?php };?>
										</TD>
									</TR>
                                   <TR>
									   
              <TD height="15"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                <STRONG>FECHA</STRONG> </FONT> </TD>
								</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name="txtFECHA" size=20 maxlength=10 onChange="chkFecha(form.txtFECHA,'Fecha invalida.');">
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		impF($fila['fecha_resol']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name="txtFECHA" size=20 maxlength=10 onChange="checkFechaField(this);" value=<?php impF ($fila['fecha_resol'])?> >
																<?php };?>
										</TD>
									</TR>
                                    <TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>ESTUDIOS</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<textarea name="txtESTUDIOS" cols="60" rows="3"></textarea>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['estudios']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<textarea name="txtESTUDIOS" cols="60" rows="3"> <?php echo trim($fila['estudios'])?></textarea>
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
																	<INPUT type="text" name=txtCALLE size=35 maxlength=50 value="<?php echo trim($fila['calle'])?>" >
																<?php };?>
															</TD>
														</TR>
													</TABLE>
													</TD><TD width="48%">
													<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
														<TR>
															
                      <TD> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                        <STRONG>NRO</STRONG> 
                        <?php 
																						if($frmModo=="mostrar"){
																						 
																	$qryREG		="SELECT * FROM REGION WHERE COD_REG=".$fila['region'];
																	$resultREG	=@pg_Exec($conn,$qryREG);
																	$filaREG	= @pg_fetch_array($resultREG,0);
																	imp($filaREG['nom_reg']);
																						};
																					?>
                        </FONT> </TD>
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
														<INPUT type="hidden" name=txtREG value=<?php echo trim($regINS)?> >
														<INPUT type="hidden" name=txtCIU value=<?php echo trim($proINS)?> >
														<INPUT type="hidden" name=txtCOM value=<?php echo trim($comINS)?> >
													<?php }?>
	</FORM>



<!-------------------// COMBO REGION-PROVINCIA-COMUNA//------------------------------------------------>

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
<FORM method=post name=f1 onsubmit="return false;">
	<SELECT class=saveHistory id=m1 name=m1 onchange="relate(this.form,0,this.selectedIndex);document.frm.txtREG.value=document.f1.m1.value;">
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


<FORM method=post name=f1 onsubmit="return false;">
	<SELECT class=saveHistory id=m1 name=m1 onchange="relate(this.form,0,this.selectedIndex);document.frm.txtREG.value=document.f1.m1.value;">
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
<FORM method=post name=f2 onsubmit="return false;">
	<SELECT class=saveHistory id=m2 name=m2 onchange="relate2(this.form,0,this.selectedIndex,0);document.frm.txtCIU.value=document.f2.m2.value;"> 
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

<FORM method=post name=f2 onsubmit="return false;">
	<SELECT class=saveHistory id=m2 name=m2 onchange="relate2(this.form,0,this.selectedIndex,0);document.frm.txtCIU.value=document.f2.m2.value;"> 
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
<FORM  method=post name=f3 onsubmit="return false;">
	<SELECT class=saveHistory id=m3 name=m3 onchange="document.frm.txtCOM.value=document.f3.m3.value;"> 
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

<FORM method=post name=f3 onsubmit="return false;">
	<SELECT class=saveHistory id=m3 name=m3 onchange="document.frm.txtCOM.value=document.f3.m3.value;"> 
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
										
        <TD> <hr width="100%" color=#003b85></TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR height=15>
							<TD width="100%" colspan=2>
								<?php if($frmModo=="mostrar"){?>
									<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="ACCESO WEB" onClick=document.location="usuario/usuario.php3">
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="ANOTACIONES" onClick=document.location="anotacion/listarAnotacion.php3">
										<?php
											echo "<INPUT class='botonX' onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE=button value=FOTO onClick=window.open('frmFoto.php3?rut=",$empleado,"','CodigoProducto','height=200,width=380,scrollbar=no,location=no,resizable=no')			
											>";
										?>
									<?php }?>
								<?php }else{?>
										<!--INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="ACCESO WEB" disabled>
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="ANOTACIONES" disabled>
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="FOTO" disabled-->
								<?php }?>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
</BODY>
</HTML>