<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$empleado		=$_EMPLEADO;	

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
					<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
						<INPUT TYPE="button" value="AGREGAR" onClick=document.location="seteaCurso.php3?caso=2">
											<?php }?>
					<?php }?>
					<INPUT TYPE="button" value="VOLVER" onClick=document.location="../seteaAno.php3?caso=4">
				</td>
			</tr>
			<tr height="20" bgcolor="#0099cc">
				<td align="middle" colspan="4">
					<font face="arial, geneva, helvetica" size="2" color="#ffffff">
						<strong>TOTAL DE CURSOS =
						<?php
											$qry="SELECT COUNT(*) AS SUMA FROM CURSO WHERE ID_ANO=(".$ano.")";
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
				<td align="center" width="40">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>GRADO</strong>
					</font>
				</td>
				<td align="center" width="40">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>LETRA</strong>
					</font>
				</td>
				<td align="center" width="320">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>ENSEÑANZA</strong>
					</font>
				</td>
				<td align="center" width="200">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>PROFESOR JEFE</strong>
					</font>
				</td>
			</tr>
			<?php
				$qry="SELECT curso.id_curso, curso.cod_decreto, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM tipo_ensenanza INNER JOIN (curso INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((ano_escolar.id_ano)=".$ano.")) order by tipo_ensenanza.nombre_tipo,curso.grado_curso, curso.letra_curso asc"; 

				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila = @pg_fetch_array($result,0);
						if (!$fila){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}
			?>
			<?php
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
			?>
						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaCurso.php3?curso=<?php echo $fila["id_curso"];?>&caso=1')>
							<td align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>
									<?php 
							if ( ($fila['grado_curso']==1) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
								echo "PRIMER NIVEL";
							}else if ( ($fila['grado_curso']==1) and (($fila['cod_decreto']==121987) or ($fila['cod_decreto']==1521989)) ){
								echo "PRIMER CICLO";
							}else if ( ($fila['grado_curso']==2) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
								echo "SEGUNDO NIVEL";
							}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==121987) ){
								echo "SEGUNDO CICLO";
							}else if ( ($fila['grado_curso']==3) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
								echo "TERCER NIVEL";
							}else{
								imp($fila['grado_curso']);
							}
									//echo $fila["grado_curso"];?></strong>
								</font>
							</td>
							<td align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["letra_curso"];?></strong>
								</font>
							</td>
							<td align="left">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["nombre_tipo"];?></strong>
								</font>
							</td>
							<?php
							     
							$qry55="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from (supervisa inner join empleado on supervisa.rut_emp = empleado.rut_emp) where((supervisa.id_curso)=".$fila['id_curso'].")";
							
							
		                     //$qry55=  "SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM curso INNER JOIN (empleado INNER JOIN supervisa ON empleado.rut_emp = supervisa.rut_emp) ON curso.id_curso = supervisa.id_curso WHERE (((curso.id_curso)=".$fila['id_curso']."))";
								$result55 =@pg_Exec($conn,$qry55);
								$fila55 = @pg_fetch_array($result55,0);
							?>
							<td align="center">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila55["ape_pat"]." ".$fila55["ape_mat"].", ".$fila55["nombre_emp"];?></strong>
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

                 
			<tr>
				<td colspan=4 align=center>
					<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
						<tr>
							<td>
								<table WIDTH="100%" BORDER="0" CELLSPACING="3" CELLPADDING="3" bgcolor=white>
									<tr>
										<td>
											<font face="arial, geneva, helvetica" size="1" color=black>
												- Seleccionar presionando con el puntero del mouse sobre el curso que corresponda.<br>
												- Para agregar un  nuevo curso presionar "AGREGAR". <br>
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