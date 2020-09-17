<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
?>
<html>
	<head>
		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
	
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>
<body>
	<?php echo tope("../../../../util/");?>
	<center>
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR height=15>
				<TD COLSPAN=5>
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
				<td colspan=5 align=right>
                       <?php  /*$qry="SELECT * FROM (institucion INNER JOIN matricula ON institucion.rdb=matricula.rdb)INNER JOIN (curso INNER JOIN tipo_ensenanza ON cod_tipo=ensenanza ) ON matricula.id_curso=curso.id_curso WHERE (institucion.rdb=(".$institucion.") AND (cod_tipo='410' OR cod_tipo='510' OR cod_tipo='610' OR cod_tipo='710' OR cod_tipo='810' ))";*/
					   			$qry="select * from tipo_ense_inst where rdb=".$institucion." and cod_tipo>310 and estado=0";
											$result =@pg_Exec($conn,$qry);
												if (pg_numrows($result)!=0){  ?>
                     <?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
						<INPUT class="botonZ" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="AGREGAR SIN CURSO" onClick=document.location="seteaMatriculaTP.php3?caso=2">
											<?php }?>
					   <?php }?>
                     <?php }?>

					<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
						<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="AGREGAR" onClick=document.location="seteaMatricula.php3?caso=2">
											<?php }?>
					<?php }?>
					<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="../seteaAno.php3?caso=4">
				</td>
			</tr>
			<tr height="20" bgcolor="#003b85">
				<td align="middle" colspan="5">
					<font face="arial, geneva, helvetica" size="2" color="#ffffff">
						<strong>TOTAL MATRICULAS = 
						<?php
											$qry="SELECT COUNT(*) AS SUMA FROM MATRICULA WHERE ID_ANO=(".$ano.")";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila7 = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila7['suma']);
												}
											}
										?>
						</strong>
					</font>
				</td>
			</tr>
			<tr bgcolor="#48d1cc">
				<td align="center" width="80">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>RUT ALUMNO</strong>
					</font>
				</td>
				<td align="center" width="120">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>APELLIDO PATERNO</strong>
					</font>
				</td>
				<td align="center" width="120">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>APELLIDO MATERNO</strong>
					</font>
				</td>
				<td align="center" width="210">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>NOMBRES</strong>
					</font>
				</td>
				<td align="center" width="280">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>CURSO</strong>
					</font>
				</td>
			</tr>
			<?php
				//$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM tipo_ensenanza INNER JOIN ((((alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN ano_escolar ON matricula.id_ano = ano_escolar.id_ano) INNER JOIN institucion ON matricula.rdb = institucion.rdb) INNER JOIN curso ON (ano_escolar.id_ano = curso.id_ano) AND (matricula.id_curso = curso.id_curso)) ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((matricula.id_ano)=".$ano.") AND ((matricula.rdb)=".$institucion.")) order by curso.grado_curso,curso.letra_curso,tipo_ensenanza.nombre_tipo,alumno.ape_pat,alumno.ape_mat,alumno.nombre_alu ASC";
				$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno  WHERE (((matricula.id_ano)=".$ano.") AND ((matricula.rdb)=".$institucion.")) order by alumno.ape_pat,alumno.ape_mat,alumno.nombre_alu ASC";
				
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila = @pg_fetch_array($result,0);	
						if (!$fila){
							error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
							exit();
						}
					}
			?>
			<?php
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
			?>
						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaMatricula.php3?alumno=<?php echo trim($fila["rut_alumno"]);?>&caso=1')>
							<td align="left">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["rut_alumno"]." - ".$fila["dig_rut"];?></strong>
								</font>
							</td>
							<td align="left">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["ape_pat"];?></strong>
								</font>
							</td>
							<td align="left">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["ape_mat"];?></strong>
								</font>
							</td>
							<td align="left">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["nombre_alu"];?></strong>
								</font>
							</td>
							<td align="center">
							<?php  $qryC = "SELECT grado_curso, letra_curso, nombre_tipo FROM ((curso INNER JOIN matricula ON curso.id_curso=matricula.id_curso) INNER JOIN tipo_ensenanza ON tipo_ensenanza.cod_tipo=curso.ensenanza) WHERE matricula.rut_alumno=".$fila["rut_alumno"]." and matricula.id_ano=".$ano; 
								  $resultC =@pg_Exec($conn,$qryC);
								  $filaC = @pg_fetch_array($resultC,0); 
								?>
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $filaC["grado_curso"]." - ".$filaC["letra_curso"]." ".$filaC["nombre_tipo"];?></strong>
								</font>
							</td>
						</tr>
			<?php
					}
				}
			?>
			<?php $qrySM="select * from (matriculatpsincurso inner join alumno on matriculatpsincurso.rut_alumno=alumno.rut_alumno) where matriculatpsincurso.id_ano=".$ano;
								$resultSM=@pg_Exec($conn,$qrySM);
								$filaSM = @pg_fetch_array($resultSM,0);	
						
						for($i=0 ; $i < @pg_numrows($resultSM) ; $i++){
						$filaSM = @pg_fetch_array($resultSM,$i);
						?>
						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaMatriculaTP.php3?alumno=<?php echo trim($filaSM["rut_alumno"]);?>&caso=1')>
							<td align="left">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $filaSM["rut_alumno"]." - ".$filaSM["dig_rut"];?></strong>
								</font>
							</td>
							<td align="left">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $filaSM["ape_pat"];?></strong>
								</font>
							</td>
							<td align="left">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $filaSM["ape_mat"];?></strong>
								</font>
							</td>
							<td align="left">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $filaSM["nombre_alu"];?></strong>
								</font>
							</td>
							<td align="center">
							<font face="arial, geneva, helvetica" size="1" color="#000000">
								SIN CURSO</font>
							</td>
						</tr>
						<?php } ?>
			<tr>
				<td colspan="5">
				<hr width="100%" color="#0099cc">
				</td>
			</tr>
			<tr>
				<td colspan=5 align=center>
					<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
						<tr>
							<td>
								<table WIDTH="100%" BORDER="0" CELLSPACING="3" CELLPADDING="3" bgcolor=white>
									<tr>
										<td>
											<font face="arial, geneva, helvetica" size="1" color=black>
												- Seleccionar presionando con el puntero del mouse sobre el apoderado que corresponda.<br>
												- Para agregar un nuevo apoderado presionar "AGREGAR".<br>
												- Para abandonar la sesión de usuario presionar "CERRAR SESION". <br>
											</font>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</center>
</body>
</html>