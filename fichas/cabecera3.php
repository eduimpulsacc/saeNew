

<?php
// ---------Cabecera de las evaluaciones de los alumnos ----------//
$_qry="SELECT * FROM alumno as a, matricula as m,curso as c,tipo_ensenanza as te WHERE m.id_curso=c.id_curso and m.rut_alumno=a.rut_alumno and c.id_ano=$_ANO and m.rut_alumno=$alumno AND te.cod_tipo=c.ensenanza";

	$_r1 =@pg_Exec($conn,"select sum(dias_habiles) from periodo where id_ano=$_ANO");
	$_r2 =@pg_Exec($conn,"select count(*) from anotacion where rut_alumno=$_ALUMNO");
	$_dias = @pg_fetch_array($_r1,0);	
	$_faltas = @pg_fetch_array($_r2,0);	
    if (trim($_faltas[0])==0) $_faltas=1;
	$_inasistencia=ceil((((int) $_dias[0] * (int)$_faltas[0])/100));
	$_asistencia= 100 - $_inasistencia;

//----------------------/ Año escolar /---------------------------------------------
	$_rt =@pg_Exec($conn,"SELECT nro_ano FROM ano_escolar WHERE id_ano=$_ANO");    
	$_ano_esc = @pg_fetch_array($_rt,0);	
//----------------------------------------------------------------------------------

	$_result =@pg_Exec($conn,$_qry);
	if (!$_result) 
		error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
	else
		{
			if (pg_numrows($_result)!=0)
				$_fila = @pg_fetch_array($_result,0);	
			if (!$_fila){
				error('<B> ERROR :</b>Error al acceder a la BD. (8) No hay alumnos inscritos');
				exit();
			}
	}
?>
<table border="0" cellpadding="0" cellspacing="1" width="60" bgcolor="black">
		<tr>
			<td>
				<table border="0" cellpadding="3" cellspacing="0" width="373" height="91">
					<tr height="19">
						<td bgcolor="#3399cc" width="120" height="19"><b><font color="white" size="2" 
face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">ALUMNO</font></b></td>
						<td bgcolor="#3399cc" height="19"></td>
					</tr>
					<tr>
						<td bgcolor="#336699" width="120"><font color="white" size="2" 
face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">Nombre</font></td>
						<td bgcolor="white"><font color="black" size="2" 
face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular"><?php echo $_fila[nombre_alu]," ",$_fila[ape_pat]," ",$_fila[ape_mat]; 
?></font></td>
					</tr>
					<tr>
						<td bgcolor="#336699" width="120"><font color="white" size="2" 
face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">Fecha Nacimiento</font></td>
						<td bgcolor="white"><font color="black" size="2" 
face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular"><?php echo $_fila[fecha_nac]; ?></font></td>
					</tr>
					<tr>
						<td bgcolor="#336699" width="120"><font color="white" size="2" 
face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">A&ntilde;o Escolar</font></td>
						<td bgcolor="white"><font color="black" size="2" 
face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">
						<?php echo $_ano_esc[0]; ?>
						</font></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
<p><br></p>
