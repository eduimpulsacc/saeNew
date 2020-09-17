<?php require('../../../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$usuario		=$_USUARIO;
	$apoderado		=$_APODERADO;
?>
<html>
	<head>
		<LINK REL="STYLESHEET" HREF="../../../../../../../util/td.css" TYPE="text/css">
		<SCRIPT language="JavaScript" src="../../../../../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">

			function valida(form){
				if(form.txtPW1.length<6){
					alert('Clave de acceso muy corta.\n Clave de acceso debe ser entre 6 y 10 caracteres.');
					return false;
				};
				if(form.txtPW1.length>10){
					alert('Clave de acceso muy larga.\n Clave de acceso debe ser entre 6 y 10 caracteres.');
					return false;
				};

				if(!chkVacio(form.txtPW1,'Ingresar CLAVE.')){
					return false;
				};
				if(!chkVacio(form.txtPW2,'Repetir CLAVE.')){
					return false;
				};
				if (!igual(form.txtPW1,form.txtPW2,'Error al repetir la clave de acceso.')){
					return false;
				};
				return true;
			}
		</SCRIPT>
	</head>
<body>
	<?php echo tope("../../../../../../../util/");?>
	<center>
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR height=15>
				<TD COLSPAN=2>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
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
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
													echo trim($fila['nombre_instit']);
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
									<strong>APODERADO</strong>
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
											$qry="SELECT * FROM APODERADO WHERE RUT_APO='".trim($apoderado)."'";
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
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_apo']);
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
			<tr>
				<td colspan=2 align=right>
					<INPUT TYPE="button" value="VOLVER" onClick=document.location="usuario.php3">
				</td>
			</tr>
			<tr height="20" bgcolor="#0099cc">
				<td align="middle" colspan="2">
					<font face="arial, geneva, helvetica" size="2" color="#ffffff">
						<strong>CREAR ACCESO COLEGIO ELECTRONICO</strong>
					</font>
				</td>
			</tr>
			<FORM method=post name="frm" action="guardaAcceso.php3">
				<TR>
					<TD width=30></TD>
					<TD>
						<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
							<TR>
								<TD>
									<FONT face="arial, geneva, helvetica" size=1 color=#000000>
										<STRONG>NOMBRE USUARIO</STRONG>
									</FONT>
								</TD>
							</TR>
							<TR>
								<TD>
									<?php imp(trim($apoderado));?>
								</TD>
							</TR>
						</TABLE>
					</TD>
				</TR>
				<TR>
					<TD width=30></TD>
					<TD>
						<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 >
							<TR>
								<TD>
									<FONT face="arial, geneva, helvetica" size=1 color=#000000>
										<STRONG>INGRESAR CLAVE</STRONG>
									</FONT>
								</TD>
								<td>&nbsp;&nbsp;</td>
								<TD>
									<FONT face="arial, geneva, helvetica" size=1 color=#000000>
										<STRONG>REPETIR CLAVE</STRONG>
									</FONT>
								</TD>
								<td>&nbsp;&nbsp;</td>
								<TD>
									<FONT face="arial, geneva, helvetica" size=1 color=#000000>
										<STRONG>PERFIL DE ACCESO</STRONG>
									</FONT>
								</TD>
							</TR>
							<TR>
								<TD>
									<input type=password name="txtPW1" size=15 maxlength=8>
								</TD>
								<td></td>
								<TD>
									<input type=password name="txtPW2" size=15 maxlength=8>
								</TD>
								<td></td>
								<TD>
									APODERADO<br>
									<input type=hidden name="cmbPERFIL" value="15">
								</TD>
							</TR>
						</TABLE>
					</TD>
				</TR>
				<TR align=center HEIGHT=50 VALIGN=BOTTOM>
					<TD colspan=2 align=center>
						<input type=submit value=GUARDAR onclick="return valida(this.form);">
					</TD>
				</TR>

			</FORM>
			<tr>
				<td colspan="2">
				<hr width="100%" color="#0099cc">
				</td>
			</tr>
		</table>
	</center>
</body>
</html>