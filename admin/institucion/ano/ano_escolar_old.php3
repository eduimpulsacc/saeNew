<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$empleado		=$_EMPLEADO;
 ?>
<SCRIPT language="JavaScript">

			function generar(){
				if(confirm('!!ESTE PROCESO AGREGA TODOS LOS ALUMNOS PROMOVIDOS Y NO RETIRADOS DEL AÑO ANTERIOR¡¡') == false){ return; };
				document.location="procesoMatAuto.php3"
			};


			function Confirmacion(){
			if(alert('¡EL INGRESO DE REGIMEN ES IRREVERSIBLE, DEBE ESTAR SEGURO DEL REGIMEN PARA ESTE AÑO ESCOLAR !') == false){ return; };
			};
</script>
<?php

$qry1="SELECT tipo_regimen FROM ANO_ESCOLAR WHERE id_ano=".$ano;
	$result1 =@pg_Exec($conn,$qry1);
	$fila1 = @pg_fetch_array($result1,0);
	$regimen=$fila1['tipo_regimen'];

?>

	<?php if($frmModo!="ingresar"){
		$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
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
		<LINK REL="STYLESHEET" HREF="../../../util/td.css" TYPE="text/css">
<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtANO,'Ingresar AÑO.')){
					return false;
				};

				if(!chkSelect(form.cmbREGIMEN,'Debe Seleccionar Régimen.')){
					return false;
				};

				if(!nroOnly(form.txtANO,'Se permiten sólo números en el AÑO.')){
					return false;
				};

				if(!chkVacio(form.txtFECHAINI,'Ingresar FECHA INICIO.')){
					return false;
				};

				if(!chkFecha(form.txtFECHAINI,'Fecha Inicio inválida.')){
					return false;
				};

				if(!chkVacio(form.txtFECHATER,'Ingresar FECHA TERMINO.')){
					return false;
				};
				
				if(!chkFecha(form.txtFECHATER,'Fecha Término inválida.')){
					return false;
				};

				if(!chkFecha(form.txtFECHATER,'Fecha Término inválida.')){
					return false;
				};
				
				//VALIDACION INTERVALO DE FECHAS
				if(amd(form.txtFECHAINI.value)>=amd(form.txtFECHATER.value)){
					alert("Fecha de término no puede ser mayor o igual a la Fecha de inicio");
					return false;
				}

				return true;
			}
		</SCRIPT>
<?php }?>
	</HEAD>
<BODY >
	<?php echo tope("../../../util/");?>
	<FORM method=post name="frm" action="procesoAno.php3">
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">"
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
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
							<TD align=right colspan=2>
								<?php if($frmModo=="ingresar"){ ?>
									<INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar onclick="return valida(this.form);" >&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarAno.php3">&nbsp;
								<?php };?>

								<?php if($frmModo=="mostrar"){ ?>
									<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
										<INPUT TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaAno.php3?ano=<?php echo $ano?>&caso=3">&nbsp;
										<!--INPUT TYPE="button" value="ELIMINAR"  name=btnEliminar onClick="Confirmacion()"-->&nbsp;
											<?php }?>
									<?php } //ACADEMICO Y LEGAL?>
										<INPUT TYPE="button" value="LISTADO" onClick=document.location="listarAno.php3">
              &nbsp; 
              <?php };?>
              <?php if($frmModo=="modificar"){ ?>
              <!--<input name="treprte" type="button" onclick=document.location="anos.php3" value="ANO">-->
              <INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar onclick="return valida(this.form);">&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaAno.php3?ano=<?php echo $ano?>&caso=1">&nbsp;
								<?php };?>
							</TD>
						</TR>
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>AÑO ESCOLAR</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD width=20></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										<TD width="13%">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>AÑO</STRONG>
											</FONT>
										</TD>
										<TD width="18%">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>FECHA INICIO</STRONG>
											</FONT>
										</TD>
										<TD width="18%">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>FECHA TERMINO</STRONG>
											</FONT>
										</TD>
										<TD width="22%">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>TIPO DE REGIMEN</STRONG>
											</FONT>
										</TD>
										<TD width="29%">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>SITUACION</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										
                  <TD valign="top"> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <INPUT type="text" name=txtANO size=6 maxlength=4> <br> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>(AAAA)</STRONG> </FONT> 
                    <?php };?>
                    <?php 
												if($frmModo=="mostrar"){ 
													imp($fila['nro_ano']);
												};
											?>
                    <?php if($frmModo=="modificar"){ ?>
                    <INPUT type="text" name=txtANO size=6 maxlength=4 value=<?php echo $fila['nro_ano']?>> 
                    <br> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>(AAAA)</STRONG> </FONT> 
                    <?php };?>
                  </TD>
										
                  <TD valign="top"> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <INPUT type="text" name=txtFECHAINI size=10 maxlength=10 onChange="chkFecha(form.txtFECHAINI,'Fecha inicio invalida.');"> 
                    <br> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>(DD-MM-AAAA)</STRONG> </FONT> 
                    <?php };?>
                    <?php 
												if($frmModo=="mostrar"){ 
													impF($fila['fecha_inicio']);
												};
											?>
                    <?php if($frmModo=="modificar"){ ?>
                    <INPUT type="text" name=txtFECHAINI size=10 maxlength=10 value=<?php impF($fila['fecha_inicio'])?>> 
                    <br> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>(DD-MM-AAAA)</STRONG> </FONT> 
                    <?php };?>
                  </TD>
										
                  <TD valign="top"> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <INPUT type="text" name=txtFECHATER size=10 maxlength=10 onChange="chkFecha(form.txtFECHATER,'Fecha termino invalida.');"> 
                    <br> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>(DD-MM-AAAA)</STRONG> </FONT> 
                    <?php };?>
                    <?php 
												if($frmModo=="mostrar"){ 
													impF($fila['fecha_termino']);
												};
											?>
                    <?php if($frmModo=="modificar"){ ?>
                    <INPUT type="text" name=txtFECHATER size=10 maxlength=10 value=<?php impF($fila['fecha_termino'])?>> 
                    <br> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>(DD-MM-AAAA)</STRONG> </FONT> 
                    <?php };?>
                  </TD>
										
                  <TD valign="top"> 
                    <?php  if($frmModo=="ingresar"){ ?>
                    <Select name="cmbREGIMEN" onChange="Confirmacion()">
                      <option value=0 selected></option>
                      <option value=2>Trimestral</option>
                      <option value=3>Semestral</option>
                    </Select> 
                    <?php }; ?>
                    <?php 
															if(($frmModo=="mostrar")||($frmModo=="modificar")){ 
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
                    <?php /* if($frmModo=="modificar"){ ?>
                    <Select name="cmbREGIMEN" >
                      <option value=0 ></option>
                      <option value=1 <?php echo ($fila['tipo_regimen'])==1?"selected":"" ?>>Indeterminado</option>
                      <option value=2 <?php echo ($fila['tipo_regimen'])==2?"selected":"" ?>>Trimestral</option>
                      <option value=3 <?php echo ($fila['tipo_regimen'])==3?"selected":"" ?>>Semestral</option>
                    </Select> 
                    <?php }; */?>
                  </TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<table WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
													<tr>
														<td align=LEFT>
															<TABLE WIDTH="150" BORDER=0 CELLSPACING=1 CELLPADDING=0 bgcolor=#cccccc>
																<TR>
																	<TD>
																		<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0 bgcolor=White>
																			<TR>
																				<TD width=5></TD>
																				
                                    <TD align=left valign="top"> 
                                      <p>
                                        <input type=radio value=0 name=rdSIT>
                                        CERRADO&nbsp;&nbsp; </p>
                                      <p>
                                        <input type=radio value=1 name=rdSIT checked>
                                        ABIERTO </p></TD>
																			</TR>
																		</TABLE>													
																	</TD>
																</TR>
															</TABLE>
														</td>
													</tr>
												</table>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){
													switch ($fila['situacion']) {
														 case 0:
															 imp('CERRADO');
															 break;
														 case 1:
															 imp('ABIERTO');
															 break;
														 default:
															 imp('INDETERMINADO');
															 break;
													 };
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<table WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
													<tr>
														<td align=LEFT>
															<TABLE WIDTH="150" BORDER=0 CELLSPACING=1 CELLPADDING=0 bgcolor=#cccccc>
																<TR>
																	<TD>
																		<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0 bgcolor=White>
																			<TR>
																				<TD width=5></TD>
																				
                                    <TD align=left valign="top"> <p>
                                        <input type=radio value=0 name=rdSIT <?php if($fila['situacion']==0) echo "checked"?>>
                                        CERRADO&nbsp;&nbsp;</p>
                                      <p> 
                                        <input type=radio value=1 name=rdSIT <?php if($fila['situacion']==1) echo "checked"?>>
                                        ABIERTO </p></TD>
																			</TR>
																		</TABLE>													
																	</TD>
																</TR>
															</TABLE>
														</td>
													</tr>
												</table>
											<?php };?>
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
									<INPUT TYPE="button" value="PERIODOS" onClick=document.location="periodo/listarPeriodo.php3">
									<?php
										$sw=0;
										$qry="SELECT * FROM PERIODO WHERE ID_ANO=".$ano;
										$result =@pg_Exec($conn,$qry);
										if (!$result) 
											error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
										else{
											$periodosIngresados=pg_numrows($result);
											if($_TIPOREGIMEN==2)//TRIMESTRAL
												if($periodosIngresados<3)
													$sw=1;
											if($_TIPOREGIMEN==3)//SEMESTRAL
												if($periodosIngresados<2)
													$sw=1;
										};
									?>
									<INPUT TYPE="button" value="PLANES DE ESTUDIO" onClick=document.location="../planEstudio/listarPlanesEstudio.php3">
										<INPUT TYPE="button" value="TIPOS DE ENSEÑANZA"    onClick=document.location="../atributos/listarTiposEnsenanza.php3">
										<input type="button" name="Button" value="FERIADOS" onClick=document.location="feriado/listaFeriado.php3">
										<INPUT TYPE="button" value="CURSOS" onClick=document.location="curso/listarCursos.php3">
              
              
           
              <input name="button" type="button" onClick=document.location="matricula/listarMatricula.php3" value="MATRICULA"> 
              <INPUT TYPE="button" value="REPORTES" onClick=document.location="reportes/listados.php3">
										<?php if($_PERFIL==0 || $_PERFIL==1 || $_PERFIL==2 || $_PERFIL==3 || $_PERFIL==14){?>
										<?php //if($_PERFIL=!14) ?> 
											
												<!--<INPUT TYPE="button" value="CTA CORRIENTE" onClick=document.location="pagos/listarPagos.php">-->
											
										<?php }?>
				
					<INPUT TYPE="button" value="FICHA MEDICA" onClick=document.location="fichas/listarAlumnosMatriculados.php3?tipoFicha=1">
				
				
					<INPUT TYPE="button" value="FICHA DEPORTIVA" onClick=document.location="fichas/listarAlumnosMatriculados.php3?tipoFicha=2">
				
					<?php if (($fila['situacion']==1) and ($fila['ano_anterior']!="")){ 
					    ?>
					<INPUT TYPE="button" value="GENERAR MATRICULAS" onClick="generar();">
				<?php }?>
					
									<?php }else{?>
										<INPUT TYPE="button" value="CURSOS" disabled >
										<INPUT TYPE="button" value="MATRICULA" disabled >
										<INPUT TYPE="button" value="REPORTES" disabled >
										<?php if($_PERFIL!=14){?>
											<?php if($_PLAN>=2){ //PLUS O +?>
												<INPUT TYPE="button" value="CTA CORRIENTE" disabled >
											<?php }?>
										<?php }?>

										
				<?php if($_PLAN>=2){ //PLUS O +?>
					<INPUT TYPE="button" value="FICHA MEDICA"  disabled >
				<?php }?>
				<?php if($_PLAN>=1){ //basico O +?>
							<INPUT TYPE="button" value="FICHA DEPORTIVA"  disabled >
				<?php }?>
		
		</center>
									<?php }?>
								<?php //}?>

							</TD>
						</TR>
						<TR height=15>
							
            <TD width="100%" colspan=2 ALIGN=CENTER> <FONT face="arial, geneva, helvetica" size=2 COLOR=RED> 
              <?php if(($_PERFIL==14)||($_PERFIL==0)||($_PERFIL==1)){ ?>
              <?php if($frmModo=="mostrar"){ ?>
              <?php
												$qry="SELECT * FROM PERIODO WHERE ID_ANO=".$ano;
												$result =@pg_Exec($conn,$qry);
												if (!$result) 
													error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
												else{
													$periodosIngresados=pg_numrows($result);
													
													if($regimen==1){//BIMESTRAL
														if($periodosIngresados<4){
															echo "\"FALTAN PERIODOS POR INGRESAR\"";
														}
													}
													if($regimen==2){//TRIMESTRAL
														if($periodosIngresados<3){
															echo "\"FALTAN PERIODOS POR INGRESAR\"";
														}
													}
													if($regimen==3){//SEMESTRAL
														if($periodosIngresados<2){
															echo "\"FALTAN PERIODOS POR INGRESAR\"";
														}
													}
												};
											?>
              <?php };?>
              <?php };?>
              </FONT> </TD>
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
                      <li>EL INGRESO DE "REGIMEN" ES IRREVERSIBLE Y AFECTA A TODO 
                        EL AÑO ESCOLAR. UD. DEBE ESTAR SEGURO DE ESTE DATO 
                        AL MOMENTO DE INGRESARLO.</li>
                      <li>Una vez finalizado el ingreso de la información presionar 
                        "GUARDAR" para grabar los datos, o bien "CANCELAR" para 
                        volver al listado de años escolares ingresados al sistema.</li>
                      <li>Para abandonar la sesión de usuario presionar "CERRAR 
                        SESION".</li>
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
                      <?php if ($W==0){ ?>
                      <?php };?>
                      <li>EL INGRESO DE "REGIMEN" ES IRREVERSIBLE Y AFECTA A TODO 
                        EL AÑO ESCOLAR. UD. DEBE ESTAR SEGURO DE ESTE DATO 
                        AL MOMENTO DE INGRESARLO.</li>
                      <li>"SITUACION" : ABIERTO : Año escolar en curso con que 
                        se trabaja y se realizan las actualizaciones. CERRADO 
                        : Año escolar sobre el cual solo se pueden hacer consultas 
                        históricas.</li>
                      <li>"PERIODOS" : Períodos ingresados para el año escolar.</li>
                      <li>"CURSOS" : Cursos ingresados para el año escolar.</li>
                      <li>"MATRICULA" : Matrículas ingresadas para el año escolar.</li>
                      <li>"REPORTES" : Variados reportes para el año académico.</li>
                      <li>"CTA CORRIENTE" : Manejo financiero de las cuentas existentes 
                        por alumno en la institución.</li>
                      <li>"FICHA MEDICA" : Acceso a fichas medicas de los alumnos.</li>
                      <li>"FICHA DEPORTIVA" : Acceso a fichas deportivas de los 
                        alumnos.</li>
                      <li>"ELIMINAR" : Elimina toda la información del año ingresado.</li>
                      <li>"LISTADO" : Despliega el total de años escolares ingresados.</li>
                      <li>Para abandonar la sesión de usuario presionar "CERRAR 
                        SESION".</li>
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
                      <li>EL INGRESO DE "REGIMEN" ES IRREVERSIBLE Y AFECTA A TODO 
                        EL AÑO ESCOLAR. UD. DEBE ESTAR SEGURO DE ESTE DATO 
                        AL MOMENTO DE INGRESARLO.</li>
                      <li>Una vez finalizado la modificación de la información 
                        presionar "GUARDAR" para grabar los datos, o bien "CANCELAR" 
                        para no realizar modificaciones.</li>
                      <li>Para abandonar la sesión de usuario presionar "CERRAR 
                        SESION".</li>
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
	</FORM>
</BODY>
</HTML>