<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$horario		=$_HORARIO;
    
?>
<?php
	function LLenarCombo($sql,$cone,$param,$flag,$mensaje){
		$Conexion = @pg_exec($cone,$sql);
		echo "<select " . $param . ">";
		$cadena_vacio = $cadena_vacio . "&nbsp;";
		if ($flag=="true"){
			echo "<option style='Courier' value='null'>" . $mensaje . "</option>";
		};
		if ($Conexion){
			if (@pg_numrows($Conexion)!=0){
				$strValue = "       ";
				$fils = @pg_fetch_array($Conexion,0);
				for ($i=0;$i<pg_numrows($Conexion);$i++){
					$fils = @pg_fetch_array($Conexion,$i);
					echo "<option style='Courier' value='" . Trim($fils[0]) . "'>" . Trim($fils[1]) . $strValue . "</option>";
				};
			};
		};
		@pg_close($Conexion);
		echo "</select>";
	};
	
	
	if($frmModo!="ingresar"){
		$qry = "SELECT trim(c.nombre) AS nombre, a.id_estancia, a.dia,  to_char(a.horaini,'HH24:MI') AS horaini, to_char(a.horafin,'HH24:MI') AS horafin FROM horario a, ramo b, subsector c WHERE a.id_ramo=b.id_ramo AND b.cod_subsector=c.cod_subsector AND a.id_curso=" . $curso . "  AND a.id_horario=" . $horario . "";
		$result = @pg_Exec($conn,$qry);
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
	} ?>
<HTML>
	<HEAD>
		<LINK REL="STYLESHEET" HREF="../../../../../util/td.css" TYPE="text/css">
		
		<?php include('../../../../../util/rpc.php3');?>
	<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
		<?php if($frmModo=="modificar"){?>
				<SCRIPT LANGUAGE="JavaScript">
					function SeleccionaCombo(Objeto, valor){
						for (i=0;i < Objeto.options.length; i ++){
							if (Objeto.options[i].value == valor){
								Objeto.options[i].selected = true; 
							};
						};
					};
	
					function valida(form){
						if(!chkSelect(form.cmbESTANCIA,'Seleccionar ESTANCIA.')){
							return false;
						};

						if(!chkSelect(form.cmbDia,'Seleccionar DIA.')){
							return false;
						};

						if(!chkVacio(form.txtHoraIni,'Ingresar HORA INICIO.')){
							return false;
						};
						if(!chkHora(form.txtHoraIni,'Hora inválida.')){
							return false;
						};

						if(!chkVacio(form.txtHoraFin,'Ingresar HORA FIN.')){
							return false;
						};
						if(!chkHora(form.txtHoraFin,'Hora inválida.')){
							return false;
						};
						if (form.txtHoraIni.value > form.txtHoraFin.value){
							alert("La HORA INICIO es mayor a la HORA FIN.");
							form.txtHoraIni.focus();
							return false;
						};
						return true;
					}
				</SCRIPT>
		<?php }?>
		<?php if($frmModo=="ingresar"){?>
				<SCRIPT language="JavaScript">
					function SeleccionaCombo(Objeto, valor){
						for (i=0;i < Objeto.options.length; i ++){
							if (Objeto.options[i].value == valor){
								Objeto.options[i].selected = true; 
							};
						};
					};

					function valida(form){
						if(!chkSelect(form.cmbRAMO,'Seleccionar RAMO.')){
							return false;
						};

						if(!chkSelect(form.cmbESTANCIA,'Seleccionar ESTANCIA.')){
							return false;
						};

						if(!chkSelect(form.cmbDia,'Seleccionar DIA.')){
							return false;
						};

						if(!chkVacio(form.txtHoraIni,'Ingresar HORA INICIO.')){
							return false;
						};
						if(!chkHora(form.txtHoraIni,'Hora inválida.')){
							return false;
						};

						if(!chkVacio(form.txtHoraFin,'Ingresar HORA FIN.')){
							return false;
						};
						if(!chkHora(form.txtHoraFin,'Hora inválida.')){
							return false;
						};
						if (form.txtHoraIni.value > form.txtHoraFin.value){
							alert("La HORA INICIO es mayor a la HORA FIN.");
							form.txtHoraIni.focus();
							return false;
						};
						return true;
					};
				</SCRIPT>
		<?php }?>
	<?php }?>
	
	
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</HEAD>
	<?php 	$str_Set_E = "{";
			if($frmModo=="modificar"){
				if ($fila['id_estancia']!=""){
					$str_Set_E = $str_Set_E . "SeleccionaCombo(frm.cmbESTANCIA," . $fila['id_estancia'] . ");";
				};
			};
			$str_Set_E = $str_Set_E . "}"; 
	?>
<BODY onload="<?php echo $str_Set_E; ?>">
	<?php //echo tope("../../../../../util/");?>
	<FORM method=post name="frm" action="procesoHorario.php">
		<INPUT TYPE="hidden" name="curso" value="<?php echo $curso; ?>">
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
											if (!$result){
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
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, tipo_ensenanza.cod_tipo as tpe FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
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
								<?php 
								if(($_PERFIL!=16)&&($_PERFIL!=15)){ ?>
									<?php if($frmModo=="ingresar"){ ?>
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR"   name=btnGuardar onclick="return valida(this.form);" >&nbsp;
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarHorario.php">&nbsp;
									<?php }; ?>
									<?php if($frmModo=="mostrar"){ ?>
										<?php if($_PERFIL!=17){?>
											<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
												<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
												<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaHorario.php?horario=<?php echo trim($horario)?>&caso=3">&nbsp;
												<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="ELIMINAR" name=btnEliminar onClick="document.location='seteaHorario.php?caso=9'">
												<?php }?>
											<?php }?>
										<?php }?>
											<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VER HORARIO" onClick=document.location="listarHorario.php">&nbsp;
										<?php };?>
									<?php if($frmModo=="modificar"){ ?>
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR"   name=btnGuardar>&nbsp;
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaHorario.php?horario=<?php echo trim($horario)?>&caso=1">&nbsp;
									<?php };?>
								<?php };?>
							</TD>
						</TR>
						<TR height=20 bgcolor=#003b85>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>HORARIO</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>RAMO</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ 
													LlenarCombo("SELECT a.id_ramo,trim(b.nombre) as subsector FROM ramo a, subsector b WHERE a.id_curso=".$curso." AND a.cod_subsector=b.cod_subsector order by id_ramo", $conn, "name='cmbRAMO' size='1' width='40' syle='FONT-FAMILY:Verdana; FONT-SIZE:8pt'","true","");	
											?>
											<?php };?>
											<?php 
												if($frmModo!="ingresar"){ 
													imp($fila['nombre']);
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
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>ESTANCIA</STRONG>
											</FONT>
										</TD>

									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ 
													LlenarCombo("SELECT a.id_estancia, trim(a.nombre) || CAST('-' AS CHARACTER) || trim(b.nombre) AS nomestancia FROM estancia a, sede b WHERE a.id_institucion=".$institucion." AND a.id_sede=b.id_sede", $conn, "name='cmbESTANCIA' size='1' width='40' syle='FONT-FAMILY:Verdana; FONT-SIZE:8pt'","true","");
												?>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													$qry="SELECT trim(a.nombre) || CAST('-' AS CHARACTER) || trim(b.nombre) AS nombre FROM estancia a, sede b WHERE a.id_estancia=" . $fila['id_estancia'] . " AND a.id_sede=b.id_sede";
													$result =@pg_Exec($conn,$qry);
													if (!$result) {
														error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
													}else{
														if (pg_numrows($result)!=0){
															$fila3 = @pg_fetch_array($result,0);	
															if (!$fila3){
																error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
																exit();
															}
															echo trim($fila3['nombre']);
														}
													}
												};
											?>
											<?php 
												if($frmModo=="modificar"){ 
													LlenarCombo("SELECT a.id_estancia, trim(a.nombre) || CAST('-' AS CHARACTER) || trim(b.nombre) AS nomestancia FROM estancia a, sede b WHERE a.id_institucion=".$institucion." AND a.id_sede=b.id_sede", $conn, "name='cmbESTANCIA' size='1' width='40' syle='FONT-FAMILY:Verdana; FONT-SIZE:8pt'","true","");									
											?>
											<?php };
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
										<TD width="30%">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>DIA</STRONG>
											</FONT>
										</TD>
										<TD width="20%">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>HORA INICIO<BR>(HH:MM)</STRONG>
											</FONT>
										</TD>
										<TD width="50%">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>HORA TERMINO<BR>(HH:MM)</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
										<?php if($frmModo=="ingresar"){ ?>
												<SELECT name="cmbDia">
													<OPTION value=""></OPTION>
													<OPTION value=0>LUNES</OPTION>
													<OPTION value=1>MARTES</OPTION>
													<OPTION value=2>MIERCOLES</OPTION>
													<OPTION value=3>JUEVES</OPTION>
													<OPTION value=4>VIERNES</OPTION>
													<OPTION value=5>SABADO</OPTION>
													<OPTION value=6>DOMINGO</OPTION>
												</SELECT>
										<?php };?>
										<?php 
											if($frmModo=="mostrar"){ 
												switch ($fila['dia']){
													case 0:
														echo ("LUNES");
														break;
													case 1:
														echo ("MARTES");
														break;
													case 2:
														echo ("MIERCOLES");
														break;
													case 3:
														echo ("JUEVES");
														break;
													case 4:
														echo ("VIERNES");
														break;
													case 5:
														echo ("SABADO");
														break;
													case 6:
														echo ("DOMINGO");
														break;
												};
										};
										?>
										<?php if($frmModo=="modificar"){ ?>
												<SELECT name="cmbDia">
													<OPTION value=""></OPTION>
													<OPTION value=0 <?php if ($fila['dia']==0){ echo ("SELECTED"); };?>>LUNES</OPTION>
													<OPTION value=1 <?php if ($fila['dia']==1){ echo ("SELECTED"); };?>>MARTES</OPTION>
													<OPTION value=2 <?php if ($fila['dia']==2){ echo ("SELECTED"); };?>>MIERCOLES</OPTION>
													<OPTION value=3 <?php if ($fila['dia']==3){ echo ("SELECTED"); };?>>JUEVES</OPTION>
													<OPTION value=4 <?php if ($fila['dia']==4){ echo ("SELECTED"); };?>>VIERNES</OPTION>
													<OPTION value=5 <?php if ($fila['dia']==5){ echo ("SELECTED"); };?>>SABADO</OPTION>
													<OPTION value=6 <?php if ($fila['dia']==6){ echo ("SELECTED"); };?>>DOMINGO</OPTION>
												</SELECT>
										<?php };?>
										</TD>
										<TD>
										<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtHoraIni size=10 maxlength=50>
										<?php };?>
										<?php 
											if($frmModo=="mostrar"){ 
												imp($fila['horaini']);
											};
										?>
										<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtHoraIni size=10 maxlength=50 value="<?php echo trim($fila['horaini'])?>">
										<?php }; ?>
										</TD>
										<TD>
										<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtHoraFin size=10 maxlength=50>
										<?php };?>
										<?php 
											if($frmModo=="mostrar"){ 
												imp($fila['horafin']);
										};
										?>
										<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtHoraFin size=10 maxlength=50 value="<?php echo trim($fila['horafin'])?>">
										<?php };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD colspan=2>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<HR width="100%" color=#003b85>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<?php if($frmModo=="ingresar"){?>
						<tr>
							<td colspan="2" align=center>
								<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
									<tr>
										<td>
											<table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
												<tr>
													<td>
														<font face="arial, geneva, helvetica" size="1" color=black>
															<ul>
																<li>Una vez finalizado el ingreso de la información presionar "GUARDAR" para grabar los datos, o bien "CANCELAR" para volver al listado de alumnos ingresados al sistema.</li>
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
						<?php if($frmModo=="mostrar"){?>
						<tr>
							<td colspan=2 align=center>
								<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
									<tr>
										<td>
											<table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
												<tr>
													<td>
														<font face="arial, geneva, helvetica" size="1" color=black>
															<ul>
															<li>"MODIFICAR" : Modifica toda la información del ramo ingresado.</li>
															<li>" ELIMINAR" : Elimina el ramo del horario.</li>
															<li>" VER HORARIO" : Despliega el horario del curso.</li>
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
							<td colspan=2 align=center>
								<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
									<tr>
										<td>
											<table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
												<tr>
													<td>
														<font face="arial, geneva, helvetica" size="1" color=black>
															<ul>
																<li>Una vez finalizada la modificación de la información presionar "GUARDAR" para grabar los datos, o bien "CANCELAR" para no realizar modificaciones.</li>
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
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	</BODY>
</HTML>