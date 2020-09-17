<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
?>
<html>
	<head>
		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
	</head>
<body>
	<?php echo tope("../../../../util/");?>
	<center>
		<TABLE WIDTH="600" BORDER=0 CELLSPACING="1" CELLPADDING="3">
			<TR height=15>
				<TD COLSPAN=4>
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
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila['nro_ano']);
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
				<td colspan=4 align=right>
					<INPUT TYPE="button" value="AÑO ESCOLAR" onClick=document.location="../seteaAno.php3?caso=4">
				</td>
			</tr>
			<tr height="20" bgcolor="#0099cc">
				<td align="middle" colspan="4">
					<font face="arial, geneva, helvetica" size="2" color="#ffffff">
						<strong>REPORTES</strong>
					</font>
				</td>
			</tr>
			<tr bgcolor="#48d1cc" height=50>
				<td align="center" bgcolor=white colspan=4>
					<center>
						<INPUT TYPE="button" value="LISTADO CURSOS" onClick=document.location="listarCursos.php3">
						<INPUT TYPE="button" value="ALUMNOS POR CURSO" onClick=document.location="alumnosPorCurso1.php3">
					</center>
				</td>
			</tr>
			<tr bgcolor="#48d1cc" height=50>
				<td align="center" bgcolor=white colspan=4>
					<center>
						<INPUT TYPE="button" value="SUBSECTORES POR CURSO" 
onClick=document.location="asignaturasPorCurso1.php3">
					</center>
				</td>
			</tr>
			<tr bgcolor="#48d1cc" height=50>
				<td align="center" bgcolor=white colspan=4>
					<center>
						<INPUT TYPE="button" value="PAGO MENSUALIDADES POR CURSO" disabled>
					</center>
				</td>
			</tr>
			<tr bgcolor="#48d1cc" height=50>
				<td align="center" bgcolor=white colspan=4>
					<center>
						<INPUT TYPE="button" value="NOTAS POR ALUMNO" onClick=document.location="notasPorAlumno1.php3">
					</center>
				</td>
			</tr>
			<tr bgcolor="#48d1cc" height=50>
				<td align="center" bgcolor=white colspan=4>
					<center>
						
          <INPUT TYPE="button" value="ASISTENCIA Y ATRASOS POR ALUMNO" onClick=document.location="asistenciaPorAlumno1.php3">
					</center>
				</td>
			</tr>
			<tr bgcolor="#48d1cc" height=50>
				<td align="center" bgcolor=white colspan=4>
					<center>
						<INPUT TYPE="button" value="ASISTENCIA POR CURSO" onClick=document.location="asistenciaPorCurso1.php3">
					</center>
				</td>
			</tr>
			<tr bgcolor="#48d1cc" height=50>
				<td align="center" bgcolor=white colspan=4>
					<center>
						<INPUT TYPE="button" value="OBSERVACIONES POR ALUMNO" onClick=document.location="observacionesPorAlumno1.php3">
					</center>
				</td>
			</tr>
			<tr bgcolor="#48d1cc" height=50>
				<td align="center" bgcolor=white colspan=4>
					<center>
						<INPUT TYPE="button" value="CUMPLEAÑOS POR CURSO" onClick=document.location="CumpleanosPorCurso1.php3">
					</center>
				</td>
			</tr>
			<tr>
				<td colspan="4">
				<hr width="100%" color="#0099cc">
				</td>
			</tr>
		</table>
	</center>
</body>
</html>