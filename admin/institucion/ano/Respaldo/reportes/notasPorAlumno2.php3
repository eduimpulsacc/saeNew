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
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR height=15>
				<td rowspan=2 valign=meddle>
					<?php
						$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
						$arr=@pg_fetch_array($result,0);

						$output= "select lo_export(".$arr[insignia].",'/var/www/html/tmp/".$arr[rdb]."');";
						$retrieve_result = @pg_exec($conn,$output);
					?>
					<img src=../../../../../tmp/<?php echo $arr[rdb] ?> ALT="NO DISPONIBLE" width=75>
				</td>
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
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";

											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{

												$fila = @pg_fetch_array($result,0);	
												if (!$fila){
													error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
													exit();
												}
												echo trim($fila['grado_curso'])."-".trim($fila['letra_curso'])." ".trim($fila['nombre_tipo']);
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
					<INPUT TYPE="button" value="VOLVER" onClick=document.location="notasPorAlumno1.php3">
				</td>
			</tr>
			<tr height="20" bgcolor="#0099cc">
				<td align="middle" colspan="2">
					<font face="arial, geneva, helvetica" size="2" color="#ffffff">
						<strong>TOTAL DE ALUMNOS</strong>
					</font>
				</td>
			</tr>
			<tr bgcolor="#48d1cc">
				<td align="center" width="80">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>RUT</strong>
					</font>
				</td>
				<td align="center" width="520">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>NOMBRE</strong>
					</font>
				</td>
			</tr>
			<?php
				$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, curso.id_curso FROM ((alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN curso ON matricula.id_curso = curso.id_curso) WHERE (((curso.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano.")) order by alumno.ape_pat, alumno.ape_mat,alumno.nombre_alu ASC";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
				}else{
				if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
					$fila = @pg_fetch_array($result,0);	
					if (!$fila){
						error('<B> ERROR :</b>Error al acceder a la BD. (8) No hay alumnos inscritos en este curso</B>');
						exit();
					}
				}
			?>
			<?php
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
			?>
						<!--tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('notasAlumno.php3?alumno=<?php //echo $fila["rut_alumno"];?>&curso=<?php echo $curso;?>')-->
						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('notas.php3?alumno=<?php echo $fila["rut_alumno"];?>&curso=<?php echo $curso;?>')>
							<td align="right" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["rut_alumno"]." - ".$fila["dig_rut"];?></strong>
								</font>
							</td>
							<td align="left" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["ape_pat"]." ".$fila["ape_mat"].", ".$fila["nombre_alu"];?></strong>
								</font>
							</td>
						</tr>
			<?php
					}
				}
			?>
			<tr>
				<td colspan="4">
				<hr width="100%" color="#0099cc">
				</td>
			</tr>
		</table>
	</center>
</body>
</html>