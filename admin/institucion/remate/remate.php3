<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$remate			=$_REMATE;
?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM REMATE WHERE ID_REMATE=".$remate;
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
				if(!chkVacio(form.txtFECHAINI,'Ingresar FECHA INICIO.')){
					return false;
				};

				if(!chkFecha(form.txtFECHAINI,'Fecha inicio invalida.')){
					return false;
				};

				if(!chkVacio(form.txtFECHATER,'Ingresar FECHA TERMINO.')){
					return false;
				};
				
				if(!chkFecha(form.txtFECHATER,'Fecha termino invalida.')){
					return false;
				};

				if(!chkVacio(form.txtTITULAR,'Ingresar TITULAR.')){
					return false;
				};

				if(!chkVacio(form.txtDETALLE,'Ingresar DETALLE.')){
					return false;
				};

				return true;
			}
		</SCRIPT>
<?php }?>
	</HEAD>
<BODY >
	<?php echo tope("../../../util/");?>
	<FORM method=post name="frm" action="procesoRemate.php3">
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
						<TR height="50">
							<TD align=right colspan=2>
								<?php if($frmModo=="ingresar"){ ?>
									<INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar onclick="return valida(this.form);">&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarRemates.php3">&nbsp;
								<?php };?>

								<?php if($frmModo=="mostrar"){ ?>
									<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
										<INPUT TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaRemate.php3?remate=<?php echo $remate?>&caso=3">&nbsp;
										<INPUT TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaRemate.php3?caso=9;">&nbsp;
											<?php }?>
									<?php } //ACADEMICO Y LEGAL?>
										<INPUT TYPE="button" value="LISTADO" onClick=document.location="listarRemates.php3">&nbsp;
								<?php };?>

								<?php if($frmModo=="modificar"){ ?>
									<INPUT TYPE="submit" value="GUARDAR" name=btnGuardar onclick="return valida(this.form);">&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaRemate.php3?remate=<?php echo $remate?>&caso=1">&nbsp;
								<?php };?>
							</TD>
						</TR>
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>MARKET PLACE</strong>
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
												<STRONG>FECHA INICIO</STRONG>
											</FONT>
										</TD>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>FECHA TERMINO</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtFECHAINI size=10 maxlength=10 onChange="chkFecha(form.txtFECHAINI,'Fecha inicio invalida.');">
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													impF($fila['fecha_i']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtFECHAINI size=10 maxlength=10 value=<?php impF($fila['fecha_i'])?>>
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
											<?php };?>
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtFECHATER size=10 maxlength=10 onChange="chkFecha(form.txtFECHATER,'Fecha termino invalida.');">
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													impF($fila['fecha_t']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtFECHATER size=10 maxlength=10 value=<?php impF($fila['fecha_t'])?>>
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
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
												<STRONG>TITULAR REMATE</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtTITULAR size=80 maxlength=100>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['titular']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtTITULAR size=80 maxlength=100 value=<?php imp($fila['titular'])?>>
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
												<STRONG>DETALLE REMATE</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<textarea name="txtDETALLE" cols="60" rows="3"></textarea>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['detalle']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<textarea name="txtDETALLE" cols="60" rows="3"> <?php echo ($fila['detalle'])?></textarea>
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
		</TABLE>
	</FORM>
</BODY>
</HTML>