<?php require('../../../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$usuario		=$_ID_USER;
	$apoderado		=$_APODERADO;
?>
<html>
	<head>
		<LINK REL="STYLESHEET" HREF="../../../../../../../util/td.css" TYPE="text/css">
		<SCRIPT language="JavaScript" src="../../../../../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				return true;
			}
		</SCRIPT>
	
<link href="../../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>
<body>
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
					<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="usuario.php3">
				</td>
			</tr>
			<tr height="20" bgcolor="#003b85">
				<td align="middle" colspan="2">
					<font face="arial, geneva, helvetica" size="2" color="#ffffff">
						<strong>AGREGAR PERFIL DE ACCESO A COLEGIO ELECTRONICO</strong>
					</font>
				</td>
			</tr>
			<FORM method=post name="frm" action="procesoPerfil.php3">
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
										<STRONG>PERFIL DE ACCESO</STRONG>
									</FONT>
								</TD>
							</TR>
							<TR>
								<TD>
									<Select name="cmbPERFIL">
										<!--option value=0 selected></option-->;
										<?php
											$qry="select * from perfil where id_perfil not in (SELECT accede.id_perfil FROM (accede INNER JOIN perfil ON accede.id_perfil = perfil.id_perfil) INNER JOIN usuario ON accede.id_usuario = usuario.id_usuario WHERE (((accede.rdb)=".$_INSTIT.") AND ((accede.id_usuario)=".$usuario.")))";
											$result =@pg_Exec($conn,$qry);
											if (!$result) 
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													};
													for($i=0 ; $i < @pg_numrows($result) ; $i++){
														$fila1 = @pg_fetch_array($result,$i);
															if(($fila1["id_perfil"]!=0)&&($fila1["id_perfil"]!=8)&&($fila1["id_perfil"]!=9))
																echo  "<option value=".$fila1["id_perfil"].">".$fila1["nombre_perfil"]."</option>";
													}
												}
											};
										?>
									</Select>
								</TD>
							</TR>
						</TABLE>
					</TD>
				</TR>
				<TR align=center HEIGHT=50 VALIGN=BOTTOM>
					<TD colspan=2 align=center>
						<input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type=submit value=GUARDAR onclick="return valida(this.form);">
					</TD>
				</TR>

			</FORM>
			<tr>
				<td colspan="2">
				<hr width="100%" color="#003b85">
				</td>
			</tr>
		</table>
	</center>
</body>
</html>