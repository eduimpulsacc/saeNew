<?php require('../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$empleado		=$_EMPLEADO;
?>
<html>
	<head>
		<SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body background="../menu/docente/imag/fondomain.gif" leftmargin="75">
<?php //echo tope("../util/");?>
<div align="center">&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <!---<INPUT TYPE="button" value="VOLVER" onClick=document.location="listarPerfiles.php3">-->
   </div>
	<center>
		
  <table WIDTH="600" BORDER="0" align="left" CELLPADDING="3" CELLSPACING="1">
    <tr>
				<td colspan=4 align=left>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR >
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>USUARIO</strong>
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
											$qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$_USUARIO;
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
												}
											}
											
											$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP='".$fila1['nombre_usuario']."'";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila2 = @pg_fetch_array($result,0);	
													if (!$fila2){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													
													echo trim($fila2['nombre_emp']." ".$fila2['ape_pat']." ".$fila2['ape_mat']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</td>
			</tr>
			<tr>
				<td align=center>
					<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
						<tr>
							<td colspan=4 align=right></td>
						</tr>
						<tr height="20" bgcolor="#003b85">
							<td align="middle" colspan="5">
								<font face="arial, geneva, helvetica" size="2" color="#ffffff">
									<strong>CURSOS COMO PROFESOR JEFE</strong>
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
							<td align="center" width="50">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>AÑO</strong>
								</font>
							</td>
							<td align="center" width="150">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>INSTITUCION</strong>
								</font>
							</td>
						</tr>
						<?php
							$qry="SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, ano_escolar.nro_ano, institucion.nombre_instit, supervisa.rut_emp, ano_escolar_1.id_ano, institucion.rdb FROM institucion INNER JOIN (((tipo_ensenanza INNER JOIN (curso INNER JOIN supervisa ON curso.id_curso = supervisa.id_curso) ON tipo_ensenanza.cod_tipo = curso.ensenanza) INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) INNER JOIN ano_escolar AS ano_escolar_1 ON curso.id_ano = ano_escolar_1.id_ano) ON institucion.rdb = ano_escolar_1.id_institucion WHERE (((supervisa.rut_emp)='".$empleado."')) ORDER BY curso.grado_curso ASC";
							$result =@pg_Exec($conn,$qry);
							if (!$result) {
								error('<B> ERROR :</b>Error al acceder a la BD. (52)</B>');
							}else{
								if (pg_numrows($result)!=0){
									/*$fila = @pg_fetch_array($result,0);	
									if (!$fila){
										error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
										exit();
									}*/
								//}
						?>
						<?php
								for($i=0 ; $i < @pg_numrows($result) ; $i++){
									$fila = @pg_fetch_array($result,$i);
						?>
									<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaDocente.php3?ano=<?php echo $fila['id_ano'];?>&institucion=<?php echo $fila['rdb'];?>&curso=<?php echo $fila['id_curso'];?>&caso=1&from=1')>
										<td align="center" >
											<font face="arial, geneva, helvetica" size="1" color="#000000">
												<strong><?php echo $fila["grado_curso"];?></strong>
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
										<td align="center">
											<font face="arial, geneva, helvetica" size="1" color="#000000">
												<strong><?php echo $fila["nro_ano"];?></strong>
											</font>
										</td>
										<td align="center">
											<font face="arial, geneva, helvetica" size="1" color="#000000">
												<strong><?php echo $fila["nombre_instit"];?></strong>
											</font>
										</td>
									</tr>
						<?php
								}
							}
						}	
						?>
						<tr>
							<td colspan="5">
								<hr width="100%" color="#003b85">
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align=center height=10>
								<hr width="100%" color="#000000" height=50>
				</td>
			</tr>
			<tr>
				<td align=center>
					<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
						<tr height="20" bgcolor="#003b85">
							<td align="middle" colspan="4">
								<font face="arial, geneva, helvetica" size="2" color="#ffffff">
									<strong>SUBSECTOR COMO DOCENTE</strong>
								</font>
							</td>
						</tr>
						<tr bgcolor="#48d1cc">
							<td align="center"  >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>SUBSECTOR</strong>
								</font>
							</td>
							<td align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>CURSO</strong>
								</font>
							</td>
							<td align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>AÑO</strong>
								</font>
							</td>
							<td align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>INSTITUCION</strong>
								</font>
							</td>
						</tr>
						<?php
							$qry="SELECT empleado.rut_emp, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, ano_escolar.nro_ano, institucion.nombre_instit, institucion.rdb, empleado.rut_emp, ramo.id_ramo, curso.id_curso, ano_escolar.id_ano, subsector.nombre FROM (institucion INNER JOIN ((tipo_ensenanza INNER JOIN (((empleado INNER JOIN dicta ON empleado.rut_emp = dicta.rut_emp) INNER JOIN ramo ON dicta.id_ramo = ramo.id_ramo) INNER JOIN curso ON ramo.id_curso = curso.id_curso) ON tipo_ensenanza.cod_tipo = curso.ensenanza) INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) ON institucion.rdb = ano_escolar.id_institucion) INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((empleado.rut_emp)='".$empleado."')) ORDER BY curso.grado_curso ASC";

							$result =@pg_Exec($conn,$qry);
							if (!$result) {
								error('<B> ERROR :</b>Error al acceder a la BD. (51)</B>');
							}else{
								if (pg_numrows($result)!=0){
									/*$fila = @pg_fetch_array($result,0);	
									if (!$fila){
										error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
										exit();
									}
								}*/
						?>
						<?php
								for($i=0 ; $i < @pg_numrows($result) ; $i++){
									$fila = @pg_fetch_array($result,$i);
						?>
									<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaDocente.php3?ano=<?php echo $fila['id_ano']?>&institucion=<?php echo $fila['rdb']?>&curso=<?php echo $fila['id_curso']?>&ramo=<?php echo $fila['id_ramo']?>&caso=2&from=1')>

										<td align="left" >
											<font face="arial, geneva, helvetica" size="1" color="#000000">
												<strong><?php echo $fila["nombre"];?></strong>
											</font>
										</td>
										<td align="center" >
											<font face="arial, geneva, helvetica" size="1" color="#000000">
												<strong><?php echo $fila["grado_curso"]." - ".$fila["letra_curso"]." ".$fila["nombre_tipo"];?></strong>
											</font>
										</td>
										<td align="center">
											<font face="arial, geneva, helvetica" size="1" color="#000000">
												<strong><?php echo $fila["nro_ano"];?></strong>
											</font>
										</td>
										<td align="center">
											<font face="arial, geneva, helvetica" size="1" color="#000000">
												<strong><?php echo $fila["nombre_instit"];?></strong>
											</font>
										</td>
									</tr>
						<?php
								}
							}
						}	
						?>
						<tr>
							<td colspan="4">
							<hr width="100%" color="#003b85">
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</center>
</body>
</html>