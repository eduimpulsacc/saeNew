<?php require('../../../../../../util/header.inc');?>

<?php 

	$institucion	=$_INSTIT;

	$ano			=$_ANO;

	$curso			=$_CURSO;

	$alumno			=$_ALUMNO;



?>

<html>

	<head>

		<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>

	

<link href="../../../../../../util/objeto.css" rel="stylesheet" type="text/css">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body background="../../../../../../menu/docente/imag/fondomain.gif" leftmargin="75">
<center>

		
  <table WIDTH="600" BORDER="0" align="left" CELLPADDING="3" CELLSPACING="1">
    <TR height=15>

				<TD COLSPAN=3>

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

						<TR>

							<TD align=left>

								<FONT face="arial, geneva, helvetica" size=2>

									<strong>ALUMNO</strong>

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

											$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO='".trim($alumno)."'";

											$result =@pg_Exec($conn,$qry);

											if (!$result) {

												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');

											}else{



												$fila = @pg_fetch_array($result,0);	

												if (!$fila){

													error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');

													exit();

												}

												echo trim($fila['ape_pat'])." ".trim($fila['ape_mat']).", ".trim($fila['nombre_alu']);

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

				<td colspan=3 align=right>

					<INPUT TYPE="button" class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="AGREGAR" onClick=document.location="../../../../empleado/anotacion/seteaAnotacion.php?alumno=<?php echo $alumno ?>&caso=2&desde=alumno">

					<!--PARA AGREGAR UNA ANOTACION SE HACE DESDE EMPLEADO-->

					<INPUT TYPE="button" class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="VOLVER" onClick=document.location="../seteaAlumno.php?caso=4">

				</td>

			</tr>

			<tr height="20" bgcolor="#003b85">

				<td align="middle" colspan="3">

					<font face="arial, geneva, helvetica" size="2" color="#ffffff">

						<strong>ANOTACIONES</strong>

					</font>

				</td>

			</tr>

			<tr bgcolor="#48d1cc">

				<td align="center" width="150">

					<font face="arial, geneva, helvetica" size="1" color="#000000">

						<strong>FECHA</strong>

					</font>

				</td>

				<td align="center" width="300">

					<font face="arial, geneva, helvetica" size="1" color="#000000">

						<strong>RESPONSABLE</strong>

					</font>

				</td>

				<td align="center" width="150">

					<font face="arial, geneva, helvetica" size="1" color="#000000">

						<strong>TIPO</strong>

					</font>

				</td>

			</tr>

			<?php

				$qry="SELECT anotacion.id_anotacion,empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, anotacion.fecha, anotacion.tipo, empleado.rut_emp, anotacion.tipo_conducta  FROM (anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) INNER JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((alumno.rut_alumno)='".trim($alumno)."'))";

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

						if ($fila['tipo_conducta']==1)

							$tipo_conducta = " - Positiva";

						if ($fila['tipo_conducta']==2)

							$tipo_conducta = " - Negativa";						

			?>

						<!--tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaAnotacion.php3?empleado=<?php// echo trim($fila["rut_emp"])?>&anotacion=<?php// echo $fila["id_anotacion"];?>&caso=1')-->

						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('../../../../empleado/anotacion/seteaAnotacion.php?alumno=<?php echo trim($alumno)?>&anotacion=<?php echo $fila["id_anotacion"];?>&caso=1&desde=alumno')>

							<td align="center" >

								<font face="arial, geneva, helvetica" size="1" color="#000000">

									<strong>

										<?php echo impF($fila["fecha"]);?>

									</strong>

								</font>

							</td>

							<td align="left" >

								<font face="arial, geneva, helvetica" size="1" color="#000000">

									<strong><?php echo $fila["ape_pat"]." ".$fila["ape_mat"].", ".$fila["nombre_emp"];?></strong>

								</font>

							</td>

							<td align="center" >

								<font face="arial, geneva, helvetica" size="1" color="#000000">

									<strong>

										<?php 

											switch ($fila['tipo']) {

												 case 0:

													 imp('INDETERMINADO');

													 break;

												 case 1:

													 imp("Conductas".$tipo_conducta);

													 break;

												 case 2:

													 imp('Atraso');

													 break;

												 case 3:

													 imp('Inasistencia');

													 break;

												 case 4:

													 imp('Enfermería');

													 break;

											 };

										?>

									</strong>

								</font>

							</td>

						</tr>

			<?php

					}

				}

			?>

			<tr>

				<td colspan="3">

				<hr width="100%" color="#003b85">

				</td>

			</tr>

		</table>
<? pg_close($conn); ?>
</center>
</body>
</html>