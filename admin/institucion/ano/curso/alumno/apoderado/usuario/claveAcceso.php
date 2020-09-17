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



				if(!chkVacio(form.txtPW1,'Ingresar CLAVE ACTUAL.')){

					return false;

				};

				if(!chkVacio(form.txtPW2,'Ingresar NUEVA CLAVE.')){

					return false;

				};

				if(!chkVacio(form.txtPW3,'Repetir NUEVA CLAVE.')){

					return false;

				};

				if (!igual(form.txtPW2,form.txtPW3,'Error al repetir la nueva clave de acceso.')){

					return false;

				};

				return true;

			}

		</SCRIPT>

	

<link href="../../../../../../../util/objeto.css" rel="stylesheet" type="text/css">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body background="../../../../../../../menu/docente/imag/fondomain.gif" leftmargin="75">
<?php //echo tope("../../../../../../../util/");?>
<center>

		
  <table WIDTH="601" BORDER="0" align="left" CELLPADDING="3" CELLSPACING="1">
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

				<?php if($_PERFIL!=15){ ?>

				<td colspan=2 align=right>

					<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="usuario.php">

				</td>

				<?php } ?>

			</tr>

			<tr height="20" bgcolor="#003b85">

				<td align="middle" colspan="2">

					<font face="arial, geneva, helvetica" size="2" color="#ffffff">

						<strong>CAMBIAR CLAVE ACCESO</strong>

					</font>

				</td>

			</tr>

			<TR>

				<TD width=30></TD>

				<TD width="556">

					<FORM method=post name="frm" action="procesoClave.php">

						<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>

							<TR>

								<TD>

									<FONT face="arial, geneva, helvetica" size=1 color=#000000>

										<STRONG>INGRESAR<BR>CLAVE ACTUAL</STRONG>

									</FONT>

								</TD>

								<TD>

									<FONT face="arial, geneva, helvetica" size=1 color=#000000>

										<STRONG>INGRESAR<BR>NUEVA CLAVE ACCESO</STRONG>

									</FONT>

								</TD>

								<TD>

									<FONT face="arial, geneva, helvetica" size=1 color=#000000>

										<STRONG>REPETIR<BR>NUEVA CLAVE ACCESO</STRONG>

									</FONT>

								</TD>

							</TR>

							<TR>

								<TD>

									<input type=password name="txtPW1" size=15 maxlength=8>

								</TD>

								<TD>

									<input type=password name="txtPW2" size=15 maxlength=8>

								</TD>

								<TD>

									<input type=password name="txtPW3" size=15 maxlength=8>

								</TD>

							</TR>

							<TR align=center HEIGHT=50 VALIGN=BOTTOM>

								<TD colspan=3>

									<input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type=submit value=GUARDAR onclick="return valida(this.form);">

								</TD>

							</TR>

						</TABLE>

					</FORM>

				</TD>

			</TR>

			<tr>

				<td colspan="2">

				<hr width="100%" color="#003b85">

				</td>

			</tr>

		</table>

	</center>

</body>

</html>