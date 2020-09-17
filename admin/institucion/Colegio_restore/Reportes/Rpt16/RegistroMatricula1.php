<?include"../Coneccion/conexion.php"?>

<?php 
	$institucion	=$_GET["as_institucion"];
//	$frmModo		=$_FRMMODO;
	$anoN			=$_GET["ai_ano"];
	$cursoN			=$_GET["ai_curso"];
	$ls_letra		= $_GET["as_letra"];
	$docente		=5; //Codigo Docente
	$li_tipo_ense   = $_GET["ai_tipo_ense"];
//	$empleado		=$_EMPLEADO;
//	$ext1			=$ext;
	
	$sql = "SELECT id_ano from ano_escolar where id_institucion=".$institucion." and nro_ano=".$anoN;
	$result_ano= pg_exec($conexion,$sql);
	$ano =  trim(pg_result($result_ano,0));
	
	$sqlC = "SELECT id_curso from curso where id_ano=".$ano." and grado_curso=".$cursoN."and letra_curso='".$ls_letra."'and ensenanza=".$li_tipo_ense;
	$result_curso= pg_exec($conexion,$sqlC);
	$curso =  trim(pg_result($result_curso,0));

	
	//------------------------------------
	// Encabezado Izquierdo
	//------------------------------------
	$sql = "SELECT curso.cod_decreto, plan_estudio.nombre_decreto, empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp,  institucion.nombre_instit ";
	$sql = $sql . "FROM curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto, institucion INNER JOIN (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) ON institucion.rdb = trabaja.rdb ";
	$sql = $sql . "WHERE (((curso.id_curso)=".$curso.") AND ((trabaja.cargo)=1) AND ((institucion.rdb)=".$institucion.")); ";

	$resultado_query2= pg_exec($conexion,$sql);
	$total_filas2= pg_numrows($resultado_query2);	
	$Decreto =  trim(pg_result($resultado_query2, 0, 1));
	$NombreDirector = trim(pg_result($resultado_query2, 0, 2)) . " " . trim(pg_result($resultado_query2, 0, 3)) . " " . trim(pg_result($resultado_query2, 0, 4));
	$NombreColegio = trim(pg_result($resultado_query2, 0, 5));
	//------------------------------------
	// Encabezado Derecho
	//------------------------------------
	$sql = "SELECT institucion.rdb, institucion.dig_rdb, region.nom_reg, provincia.nom_pro, comuna.nom_com, ano_escolar.nro_ano, ano_escolar.id_ano " ;
	$sql = $sql . "FROM ano_escolar, ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (region.cod_reg = provincia.cod_reg)) INNER JOIN comuna ON (institucion.comuna = comuna.cor_com) AND (provincia.cor_pro = comuna.cor_pro) AND (provincia.cod_reg = comuna.cod_reg) ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.")); ";
	
	$resultado_query1= pg_exec($conexion,$sql);
	$total_filas1= pg_numrows($resultado_query1);	
	
	for ($jj=0; $jj < $total_filas1; $jj++)
	{
		$Rbd = trim(pg_result($resultado_query1, $jj, 0)) . " " . trim(pg_result($resultado_query1, $jj, 1));
		$Region = trim(pg_result($resultado_query1, $jj, 2));
		$Ciudad = trim(pg_result($resultado_query1, $jj, 3));
		$Comuna = trim(pg_result($resultado_query1, $jj, 4));
		$AnoEscolar =  trim(pg_result($resultado_query1, $jj, 5));
		
	}

	//------------------------------------
	$sql = "SELECT distinct matricula.num_mat, curso.grado_curso, curso.letra_curso, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, alumno.sexo, alumno.rut_alumno, alumno.dig_rut, alumno.fecha_nac, alumno.calle, alumno.nro, alumno.depto, alumno.block, alumno.villa, matricula.fecha, apoderado.ape_pat, apoderado.ape_mat, apoderado.nombre_apo, apoderado.calle, apoderado.nro, apoderado.depto, apoderado.block, apoderado.villa, matricula.fecha_retiro ";
	$sql = $sql . "FROM (((curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN tiene2 ON alumno.rut_alumno = tiene2.rut_alumno) INNER JOIN apoderado ON tiene2.rut_apo = apoderado.rut_apo ";
	$sql = $sql . "WHERE (((matricula.rdb)=".$institucion.") AND ((curso.id_curso)=".$curso.") AND ((tiene2.responsable)=1) AND ((matricula.id_ano)=".$ano.")) ";
	$sql = $sql . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);
	?>
	
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<html>
	<head>
	<title>.</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
<!--
.Estilo4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; }
.Estilo12 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; }
.Estilo15 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 8px; }
.Estilo17 {
	font-size: 10px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.Estilo18 {font-size: 9px}
.Estilo19 {font-size: 12px}
.Estilo20 {font-size: 10px}
.Estilo21 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 10px; }
-->
    </style>
</head>
<body>
<center>

<FORM method=post name="frm" action="">

<table width="1055" height="132" border="0" >
  <tr>
    <td width="184" class="Estilo12 Estilo18">DECRETO COOPERADOR</td>
    <td width="185" class="Estilo13 Estilo17"> <? echo strtoupper($Decreto) ?> </td>
    <td colspan="11" rowspan="5" class="Estilo13 Estilo17">&nbsp;</td>
    <td width="112" class="Estilo12 Estilo18">REGION</td>
    <td width="196" class="Estilo13 Estilo17"> <? echo $Region ?></td>
  </tr>
  <tr>
    <td class="Estilo12 Estilo18">DIRECTOR</span></td>
    <td class="Estilo13 Estilo17">  <? echo strtoupper($NombreDirector) ?> </td>
    <td class="Estilo12 Estilo18">PROVINCIA</td>
    <td class="Estilo13 Estilo17"> <? echo $Ciudad ?></td>
  </tr>
  <tr>
    <td class="Estilo12 Estilo18">ESTABLECIMIENTO EDUCACIONAL</span></td>
    <td class="Estilo13 Estilo17"> <? echo strtoupper($NombreColegio) ?> </td>
    <td class="Estilo12 Estilo18">COMUNA</td>
    <td class="Estilo13 Estilo17"> <? echo $Comuna ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td class="Estilo12 Estilo18">AÑO ESCOLAR</span></td>
    <td class="Estilo13 Estilo17"> <? echo $AnoEscolar ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td class="Estilo12 Estilo18">ROL BASE DE DATOS</span></td>
    <td class="Estilo13 Estilo17"> <? echo $Rbd ?></td>
  </tr>
  <tr>
        <td height="16" colspan="15"><div align="center" class="Estilo4 Estilo19">LIBRO DE REGISTRO DE MATRÍCULAS</div></td>
  </tr>
  <tr>
    <td colspan="2" ><div align="center" class="Estilo4 Estilo20"><strong>Datos del Alumno </strong></div></td>
	<td colspan="13" ><div align="center" class="Estilo21">Datos del Tutor </div></td>
	</tr>
</table>
<table width="1055" border="1" cellpadding="0" cellspacing="0" align=center>
		<tr>
		
    		<td width="19"><span class="Estilo15">N&ordm;</span></td>
  		    <td width="19"><span class="Estilo15">N&ordm; de M. </span></td>
  		    <td width="27"><span class="Estilo15">Curso</span></td>
  		    <td width="106"><span class="Estilo15">Apellidos</span></td>
  		    <td width="19"><span class="Estilo15">S<br></b>e<br></b>x<br></b>o</span></td>
  		    <td width="69"><span class="Estilo15">Rut</span></td>
  		    <td width="46"><span class="Estilo15">Fecha de Nac. </span></td>
  		    <td width="98"><span class="Estilo15">Domicilio</span></td>
  		    <td width="40"><span class="Estilo15">Fecha Ingreso </span></td>
  		    <td width="123"><span class="Estilo15">Nombre</span></td>
  		    <td width="92"><span class="Estilo15">Ocupaci&oacute;n</span></td>
  		    <td width="102"><span class="Estilo15">Domicilio</span></td>
  		    <td width="49"><span class="Estilo15">Fecha Retiro </span></td>
  		    <td width="89"><span class="Estilo15">Causal Retiro </span></td>
  		    <td width="125" class="Estilo15">Observaciones Generales </td>

		</tr>
	
	<?

	for ($j=0; $j < $total_filas; $j++)
	{
	
		$NumMat= trim(pg_result($resultado_query, $j, 0));
		$Curso = trim(pg_result($resultado_query, $j, 1)) . "-" . trim(pg_result($resultado_query, $j, 2)) ;
		$NombreAlu = trim(pg_result($resultado_query, $j, 3)) . " " . trim(pg_result($resultado_query, $j, 4)) . " " . trim(pg_result($resultado_query, $j, 5));
		if (trim(pg_result($resultado_query, $j, 6)) == "2")
			$Sexo = "M";
		else
			$Sexo = "F";
		$RutAlumno = trim(pg_result($resultado_query, $j, 7)) . "-" . trim(pg_result($resultado_query, $j, 8));
		$FechaNacimiento = Cfecha2(trim(pg_result($resultado_query, $j, 9)));
		$DomicilioAlumno = trim(pg_result($resultado_query, $j, 10)) . " " . trim(pg_result($resultado_query, $j, 11)) . " " . trim(pg_result($resultado_query, $j, 12)) . " " . trim(pg_result($resultado_query, $j, 13)) . " " . trim(pg_result($resultado_query, $j, 14));
		$FechaMatricula = Cfecha2(trim(pg_result($resultado_query, $j, 15)));
		$NombreApo = trim(pg_result($resultado_query, $j, 16)) . " " . trim(pg_result($resultado_query, $j, 17)) . " " . trim(pg_result($resultado_query, $j, 18)) ;
		$DomicilioApo = trim(pg_result($resultado_query, $j, 19)) . " " . trim(pg_result($resultado_query, $j, 20)) . " " . trim(pg_result($resultado_query, $j, 21)) . " " . trim(pg_result($resultado_query, $j, 22)) . " " . trim(pg_result($resultado_query, $j, 23)) ;
		$FechaRetiro = cfecha2(trim(pg_result($resultado_query, $j, 24))) ;
		if (empty($FechaRetiro)) $FechaRetiro = "."
	?>
	
		<tr>
			<td><span class="Estilo16 Estilo17 Estilo18">			<?	echo $j;	?>				</span></td>
			<td><span class="Estilo16 Estilo17 Estilo18">			<?	echo $NumMat;	?>			</span></td>
			<td><span class="Estilo16 Estilo17 Estilo18">			<?	echo $Curso; 	?>			</span></td>
			<td><span class="Estilo16 Estilo17 Estilo18">			<?	echo $NombreAlu;	?>		</span></td>
			<td><span class="Estilo16 Estilo17 Estilo18">			<?	echo $Sexo; 	?>			</span></td>
			<td><span class="Estilo16 Estilo17 Estilo18">			<?	echo $RutAlumno; 	?>		</span></td>
			<td><span class="Estilo16 Estilo17 Estilo18">			<?	echo $FechaNacimiento; 	?>	</span></td>
			<td><span class="Estilo16 Estilo17 Estilo18">			<?	echo $DomicilioAlumno; 	?>	</span></td>
			<td><span class="Estilo16 Estilo17 Estilo18">			<?	echo $FechaMatricula; 	?>	</span></td>
			<td><span class="Estilo16 Estilo17 Estilo18">			<?	echo $NombreApo; 	?>		</span></td>
			<td><span class="Estilo16 Estilo17 Estilo18">			&nbsp;							</span></td>
			<td><span class="Estilo16 Estilo17 Estilo18">			<?	echo $DomicilioApo; 	?>	</span></td>
			<td><span class="Estilo16 Estilo17 Estilo18">			<?	echo $FechaRetiro; 	?>		</span></td>
			<td><span class="Estilo16 Estilo17 Estilo18">			&nbsp;							</span></td>
			<td><span class="Estilo16 Estilo17 Estilo18">			&nbsp;							</span></td>


	  </tr>
</table>

	<?
	}
	pg_close($conexion);
	?>
</form>
</center>
</body>
</html>