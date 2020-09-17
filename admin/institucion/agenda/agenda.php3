<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$notaAgenda		=$_NOTA_AGENDA;
	$frmModo		=$_FRMMODO;
	$agrupacion		=$_AGRUPACION;
?> 
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM NOTA_AGENDA WHERE ID_NOTA=".$notaAgenda;
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
				if(!chkVacio(form.txtFECHA,'Ingresar FECHA.')){
					return false;
				};

				if(!chkFecha(form.txtFECHA,'Fecha invalida.')){
					return false;
				};

				if(!chkVacio(form.txtHORA,'Ingresar HORA.')){
					return false;
				};

				if(!chkHora(form.txtHORA,'Hora inválida.')){
					return false;
				};

				if(!chkVacio(form.txtCONTENIDO,'Ingresar CONTENIDO.')){
					return false;
				};


				return true;
			}
		</SCRIPT>
<?php }?>
	</HEAD>
<BODY >
	<FORM method=post name="frm" action="procesoAgenda.php3">
	<?php echo tope("../../../util/");?>
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=agrupacion value=".$agrupacion.">";
	?>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR >
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
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
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
						<!--------------------------------------------------------------------->
						<!-- ESTA PARTE DEL DOCUMENTO SE MUESTRA SOLO SI ID_AGRUPACION ES "" -->
						<!--------------------------------------------------------------------->
						<!--TR>
							<TD></TD>
							<TD></TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM AGRUPACION WHERE ID_AGRUPACION=".$agrupacion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
													echo trim($fila1['nombre_agrupacion']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR-->
						<!--------------------------------------------------------------------->
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
							<TD align=right colspan=2>
								<?php if($frmModo=="ingresar"){ ?>
									<INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarAgenda.php3">&nbsp;
								<?php };?>

								<?php if($frmModo=="mostrar"){ ?>
									<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
										<INPUT TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaAgenda.php3?notaAgenda=<?php echo $notaAgenda?>&caso=3">&nbsp;
										<INPUT TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaAgenda.php3?caso=9;">&nbsp;
											<?php }?>
									<?php }//ACADEMICO Y LEGAL?>
										<INPUT TYPE="button" value="LISTADO" onClick=document.location="listarAgenda.php3">&nbsp;
								<?php };?>

								<?php if($frmModo=="modificar"){ ?>
									<INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaAgenda.php3?notaAgenda=<?php echo $notaAgenda?>&caso=1">&nbsp;
								<?php };?>
							</TD>
						</TR>
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>AGENDA <?php echo trim($fila1['nombre_agrupacion'])?></strong>
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
												<STRONG>FECHA</STRONG>
											</FONT>
										</TD>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>HORA</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<input type=text name="txtFECHA" size=8 maxlength=10>
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													impF($fila['fecha']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<input type=text name="txtFECHA" size=8 maxlength=10 value="<?php impF($fila['fecha'])?>">
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
											<?php };?>
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<input type=text name="txtHORA" size=8 maxlength=5>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['hora']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<input type=text name="txtHORA" size=8 maxlength=5 value="<?php echo ($fila['hora'])?>">
											<?php };?>
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
												<STRONG>CONTENIDO</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtCONTENIDO size=85 maxlength=1000>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['contenido_nota']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtCONTENIDO size=85 maxlength=1000 value="<?php echo ($fila['contenido_nota'])?>">
											<?php };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD align=right>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>TIPO DE ANOTACION</STRONG>
											</FONT>
										</TD>
										<TD WIDTH=50></TD>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>ESTADO</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<Select name="cmbTIPO">
													<option value=0 selected>Agenda Normal</option>
													<option value=1>Actividad Especial</option>
												</Select>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													switch ($fila["bool_ae"]) {
														 case 0:
															 imp('Agenda Normal');
															 break;
														 case 1:
															 imp('Actividad Especial');
															 break;
													 };
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<Select name="cmbTIPO">
													<option value=0 selected>Agenda Normal</option>
													<option value=1>Actividad Especial</option>
												</Select>
											<?php };?>
										</TD>
										<TD WIDTH=50></TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<?php if(($_PERFIL==1)||($_PERFIL==0)){?>
													<Select name="cmbESTADO">
														<option value=0 selected>NO publicada</option>
														<option value=1>Publicada</option>
													</Select>
												<?php }else{
													imp('NO publicada');
													echo "<input type=hidden name=cmbESTADO value=0>";
													};?>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													switch ($fila["estado"]) {
														 case 0:
															 imp('NO Publicada');
															 break;
														 case 1:
															 imp('Publicada');
															 break;
													 };
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<?php if(($_PERFIL==1)||($_PERFIL==0)){?>
													<Select name="cmbESTADO">
														<option value=0 selected>NO publicada</option>
														<option value=1>Publicada</option>
													</Select>
												<?php }else{
													switch ($fila["estado"]) {
														 case 0:
															 imp('NO publicada');
															echo "<input type=hidden name=cmbESTADO value=0>";
															 break;
														 case 1:
															 imp('publicada');
															echo "<input type=hidden name=cmbESTADO value=1>";
															 break;
													 };
													};?>
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
														<li>Una vez finalizado el ingreso de la información presionar "GUARDAR" para grabar los datos, o bien "CANCELAR" para anular la operación.</li>
														<li>"TIPO DE ANOTACION" : AGENDA NORMAL indica registrar la anotación como parte de la agenda normal, ACTIVIDAD ESPECIAL indica registrar la anotacion como parde la la s actividades especiales de la institución.</li>
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
														<li>Una vez finalizada la modificación de la información presionar "GUARDAR" para grabar los datos, o bien "CANCELAR" para no realizar modificaciones.</li>
														<li>"TIPO DE ANOTACION" : AGENDA NORMAL indica registrar la anotación como parte de la agenda normal, ACTIVIDAD ESPECIAL indica registrar la anotacion como parde la la s actividades especiales de la institución.</li>
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
	</FORM>
<?
pg_close($conn);
?>	
</BODY>
</HTML>