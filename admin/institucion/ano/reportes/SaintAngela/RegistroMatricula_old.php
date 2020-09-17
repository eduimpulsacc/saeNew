<?php require('../../../../../util/header.inc');
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $c_curso;
	$docente		= 5; //Codigo Docente
	if ($c_curso==0) exit;
	
	$fecha1 		= $anoN."-04-30"; 

	//------------------------------------
	// Encabezado Izquierdo
	//------------------------------------
	$sql = "SELECT curso.cod_decreto, plan_estudio.nombre_decreto, empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp,  institucion.nombre_instit ";
	$sql = $sql . "FROM curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto, institucion INNER JOIN (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) ON institucion.rdb = trabaja.rdb ";
	$sql = $sql . "WHERE (((curso.id_curso)=".$curso.") AND ((trabaja.cargo)=1) AND ((institucion.rdb)=".$institucion.")); ";
	$resultado_query2= pg_exec($conn,$sql);
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

	$resultado_query1= pg_exec($conn,$sql);
	$total_filas1= pg_numrows($resultado_query1);	
	
	for ($jj=0; $jj < $total_filas1; $jj++)
	{
		$Rbd = trim(pg_result($resultado_query1, $jj, 0)) . " - " . trim(pg_result($resultado_query1, $jj, 1));
		$Region = trim(pg_result($resultado_query1, $jj, 2));
		$Ciudad = trim(pg_result($resultado_query1, $jj, 3));
		$Comuna = trim(pg_result($resultado_query1, $jj, 4));
		$AnoEscolar =  trim(pg_result($resultado_query1, $jj, 5));
		
	}
		
	//------------------------------------
	//$sql = "SELECT distinct matricula.num_mat, curso.grado_curso, curso.letra_curso, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, alumno.sexo, alumno.rut_alumno, alumno.dig_rut, alumno.fecha_nac, alumno.calle, alumno.nro, alumno.depto, alumno.block, alumno.villa, matricula.fecha, apoderado.ape_pat, apoderado.ape_mat, apoderado.nombre_apo, apoderado.calle, apoderado.nro, apoderado.depto, apoderado.block, apoderado.villa, matricula.fecha_retiro ";
	//$sql = $sql . "FROM (((curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN tiene2 ON alumno.rut_alumno = tiene2.rut_alumno) INNER JOIN apoderado ON tiene2.rut_apo = apoderado.rut_apo ";
	//$sql = $sql . "WHERE (((matricula.rdb)=".$institucion.") AND ((curso.id_curso)=".$curso.") AND ((tiene2.responsable)=1) AND ((matricula.id_ano)=".$ano.")) and ";
	//$sql = $sql . "(((matricula.fecha <= '".$fecha1."') and  (matricula.bool_ar = 1) and (matricula.fecha_retiro >= '".$fecha1."')) or ((matricula.fecha <= '".$fecha1."') and (matricula.bool_ar = 0))) ";
	//$sql = $sql . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	$sql = "SELECT matricula.num_mat, curso.grado_curso, curso.letra_curso, matricula.rut_alumno, alumno.dig_rut, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, alumno.sexo, alumno.calle, alumno.nro, comuna.nom_com, matricula.fecha, matricula.fecha_retiro, alumno.fecha_nac ";
	$sql = $sql . "FROM (((curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
	$sql = $sql . "WHERE (((curso.id_curso)=".$curso.") AND ((matricula.rdb)=".$institucion.")) ";
	$sql = $sql . "ORDER BY matricula.num_mat; ";


	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

	?>
	<script>
		function imprimir() 


{


	document.getElementById("capa0").style.display='none';


	window.print();


	document.getElementById("capa0").style.display='block';


}
	</script>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<html>
	<head>
	<title>.</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
	</head>
<body>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<center>
<table width="999" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<div id="capa0">
		<div align="right">
		  <input name="button3" TYPE="button" class="botonX" onclick="imprimir();" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR">	
          <!--INPUT name="button" TYPE="button" class="botonX" onClick=document.location="curso.php3" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="VOLVER"-->
  		</div>
	</div>
	</div>
	</td>
  </tr>
  <tr>
    <td>
      <table width="1055" height="132" border="0" >
        <tr>
          <td width="184" align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>DECRETO COOPERADOR</strong></font></td>
          <td colspan="12" align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo strtoupper($Decreto) ?></font></td>
          <td width="112" align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>REGION</strong></font></td>
          <td width="196" align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo trim(strtoupper($Region)) ?></font></td>
        </tr>
        <tr>
          <td> <div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>DIRECTOR - RECTOR </strong></font></div></td>
          <td colspan="12"> <div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo strtoupper($NombreDirector) ?></font></div></td>
          <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROVINCIA</strong></font></div></td>
          <td class="Estilo13 Estilo17">
            <div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo trim(strtoupper($Ciudad)) ?></font></div></td>
        </tr>
        <tr>
          <td ><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>ESTABLECIMIENTO EDUCACIONAL </strong></font></div></td>
          <td colspan="12" ><div align="left"> <font face="Arial, Helvetica, sans-serif" size="-2"><? echo strtoupper($NombreColegio) ?></font></div></td>
            <td class="Estilo12 Estilo18"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>COMUNA</strong></font></div></td>
          <td class="Estilo13 Estilo17">
            <div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo trim(strtoupper($Comuna)) ?></font></div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td width="205"></td>
		            <td colspan="11" align="left">&nbsp;</td>
          <td class="Estilo12 Estilo18"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>A&Ntilde;O ESCOLAR </strong></font></div></td>
          <td class="Estilo13 Estilo17"><div align="left"> <font face="Arial, Helvetica, sans-serif" size="-2"><? echo trim(strtoupper($AnoEscolar)) ?></font></div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td></td>
		            <td colspan="11" align="left">&nbsp;</td>
          <td class="Estilo12 Estilo18"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>ROL BASE DE DATOS </strong></font></div></td>
          <td class="Estilo13 Estilo17"><div align="left"> <font face="Arial, Helvetica, sans-serif" size="-2"><? echo trim(strtoupper($Rbd)) ?></font></div></td>
        </tr>
        <tr>
          <td height="16" colspan="15"><div align="center" class="Estilo4 Estilo19"><font face="Arial, Helvetica, sans-serif" size="2"><strong>LIBRO DE REGISTRO DE MATR&Iacute;CULA </strong></font></div></td>
        </tr>
        <tr>
          <td colspan="2" ><div align="center" class="Estilo4 Estilo20"><span class="Estilo4 Estilo19"><font face="Arial, Helvetica, sans-serif" size="2"><strong>Datos del Alumno </strong></font></span></div></td>
          <td colspan="13" ><div align="center" class="Estilo21"><span class="Estilo4 Estilo19"><font face="Arial, Helvetica, sans-serif" size="2"><strong>Datos del Tutor </strong></font></span></div></td>
        </tr>
      </table>
      <table width="1055" border="1" cellpadding="0" cellspacing="0" align=center>
        <tr>
          <td width="19"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N&ordm;</strong></font></td>
          <td width="19"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N&ordm; DE MAT </strong></font></td>
          <td width="27"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>CURSO</strong></font></td>
          <td width="106"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>APELLIDOS</strong></font></td>
          <td width="17"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>SEXO</strong></font></td>
          <td width="71"><span class="Estilo15"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>RUT</strong></font></span></td>
          <td width="46"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>FECHA NAC </strong></font></td>
          <td width="98"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>DOMICILIO</strong></font></td>
          <td width="40"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>FECHA INGRESO </strong></font></td>
          <td width="123"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>NOMBRE</strong></font></td>
          <td width="92"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>OCUPACI&Oacute;N</strong></font></td>
          <td width="102"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>DOMICILIO</strong></font></td>
          <td width="49"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>FECHA RETIRO </strong></font></td>
          <td width="89"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>CAUSAL RETIRO </strong></font></td>
          <td width="125" class="Estilo15"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>OBSERVACIONES GENERALES </strong></font></td>
        </tr>
        <?

		for ($j=0; $j < $total_filas; $j++)
		{
			if ($j==18 or $j==44 )
			{
				echo "<td colspan=15><H1 class=SaltoDePagina>&nbsp;</H1></td>";
			}
			//------------------------------------------
			$NumMat= trim(pg_result($resultado_query, $j, 0));
			if (empty($NumMat)) $NumMat = 0;
			$Curso = trim(pg_result($resultado_query, $j, 1)) . "-" . trim(pg_result($resultado_query, $j, 2)) ;
			$NombreAlu = trim(pg_result($resultado_query, $j, 5)) . " " . trim(pg_result($resultado_query, $j, 6)) . " " . trim(pg_result($resultado_query, $j, 7));
			if (trim(pg_result($resultado_query, $j, 8)) == "2")
				$Sexo = "M";
			else
				$Sexo = "F";
			$RutAlumno = trim(pg_result($resultado_query, $j, 3)) . "-" . trim(pg_result($resultado_query, $j, 4));
			$RutAlumno2 = trim(pg_result($resultado_query, $j, 3));
			$FechaNacimiento = Cfecha2(trim(pg_result($resultado_query, $j, 14)));
			$DomicilioAlumno = trim(pg_result($resultado_query, $j, 9)) . " " . trim(pg_result($resultado_query, $j, 10)) . " " . trim(pg_result($resultado_query, $j, 11)) ;
			$FechaMatricula = Cfecha2(trim(pg_result($resultado_query, $j, 12)));
			//$NombreApo = trim(pg_result($resultado_query, $j, 16)) . " " . trim(pg_result($resultado_query, $j, 17)) . " " . trim(pg_result($resultado_query, $j, 18)) ;
			//$DomicilioApo = trim(pg_result($resultado_query, $j, 19)) . " " . trim(pg_result($resultado_query, $j, 20)) . " " . trim(pg_result($resultado_query, $j, 21)) . " " . trim(pg_result($resultado_query, $j, 22)) . " " . trim(pg_result($resultado_query, $j, 23)) ;
			$FechaRetiro = cfecha2(trim(pg_result($resultado_query, $j, 13))) ;
			if ($FechaRetiro = "//") $FechaRetiro = "&nbsp;";
			//--------------------------------------------------
			$sql = "SELECT tiene2.rut_alumno, apoderado.ape_pat, apoderado.ape_mat, apoderado.nombre_apo, apoderado.calle, apoderado.nro, comuna.nom_com ";
			$sql = $sql . "FROM (tiene2 INNER JOIN apoderado ON tiene2.rut_apo = apoderado.rut_apo) INNER JOIN comuna ON (apoderado.comuna = comuna.cor_com) AND (apoderado.region = comuna.cod_reg) AND (apoderado.ciudad = comuna.cor_pro) ";
			$sql = $sql . "WHERE (((tiene2.rut_alumno)=".$RutAlumno2.")); ";

			$result =@pg_Exec($conn,$sql);
			if (!$result) 
			{
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
			}
			else
			{
				if (pg_numrows($result)!=0)
				{
					$fila = @pg_fetch_array($result,0);	
					if (!$fila)
					{
						error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						exit();
					}
				}
			}
			//--------------------------------------------------
			$NombreApo = trim($fila['ape_pat'])	 . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_apo']);
			$DomiApo = trim($fila['calle']) . " " . trim($fila['nro']) . " " . trim($fila['nom_com']);
			if (pg_numrows($result)==0)
			{
			$NombreApo = "&nbsp;" ;
			$DomiApo = "&nbsp;" ;
			}
			
		?>
        <tr>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><?	echo ($j+1);	?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><?	echo $NumMat;	?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><?	echo $Curso; 	?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><?	echo $NombreAlu;	?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><?	echo $Sexo; 	?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><?	echo $RutAlumno; 	?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><?	echo $FechaNacimiento; 	?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><?	echo $DomicilioAlumno; 	?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><?	echo $FechaMatricula; 	?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><?	echo $NombreApo; ?></font></td>
          <td>&nbsp;</td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><?	echo $DomiApo;	?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><?	echo $FechaRetiro; 	?></font></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
		<? }?>
      </table>
      <?
	
	pg_close($conn);
	?>
    </td>
  </tr>
</table>
</center>
</body>
</html>