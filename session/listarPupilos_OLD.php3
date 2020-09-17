<?php require('../util/header.inc');?>
<html>
	<head>
		<SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
	</head>
<body>
	<center>
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<tr>
				<td colspan=4 align=right>
				</td>
			</tr>
			<tr height="20" bgcolor="#0099cc">
				<td align="middle" colspan="4">
					<font face="arial, geneva, helvetica" size="2" color="#ffffff">
						<strong>PUPILOS DEL APODERADO</strong>
					</font>
				</td>
			</tr>
			<tr bgcolor="#48d1cc">
				<td align="center" width="100">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>RUT</strong>
					</font>
				</td>
				<td align="center" width="300">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>NOMBRE</strong>
					</font>
				</td>
				<td align="center" width="200">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>INSTITUCION</strong>
					</font>
				</td>
				<td align="center" width="100">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>AÑO ACADEMICO</strong>
					</font>
				</td>
			</tr>

			<?php
				//TODOS LOS ALUMNOS PARA LOS CUALES A SIDO APODERADO, EN TODOS LOS AÑOS ACADEMICOS
				$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, institucion.nombre_instit, ano_escolar.nro_ano, institucion.rdb, matricula.id_ano, matricula.id_curso FROM (((alumno INNER JOIN (apoderado INNER JOIN tiene2 ON apoderado.rut_apo = tiene2.rut_apo) ON alumno.rut_alumno = tiene2.rut_alumno) INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN institucion ON matricula.rdb = institucion.rdb) INNER JOIN ano_escolar ON matricula.id_ano = ano_escolar.id_ano WHERE (((apoderado.rut_apo)='".$apo."')) ORDER BY matricula.id_ano DESC";

				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
				}else{
					if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
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
						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaPupilo.php3?institucion=<?php echo $fila['rdb'];?>&alumno=<?php echo $fila['rut_alumno'];?>&ano=<?php echo $fila['id_ano'];?>&curso=<?php echo $fila['id_curso'];?>&caso=1')>
							<td align="center">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["rut_alumno"]." - ".$fila["dig_rut"];?></strong>
								</font>
							</td>
							<td align="left" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["ape_pat"]." ".$fila["ape_mat"]." ,".$fila["nombre_alu"];?></strong>
								</font>
							</td>
							<td align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["nombre_instit"];?></strong>
								</font>
							</td>
							<td align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["nro_ano"];?></strong>
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