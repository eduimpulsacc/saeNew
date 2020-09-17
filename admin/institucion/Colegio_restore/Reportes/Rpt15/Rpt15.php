<?include"../Coneccion/conexion.php"?>
<?
	$ls_institucion = $_GET["as_institucion"];
	$ls_alumno = $_GET["as_alumno"];
	$li_ano = $_GET["ai_ano"];
	$tipo_ense = $_GET["ai_tipo_ense"];
	
	if ($ls_institucion=='')
		{
		$ls_institucion = 0;
		$ls_alumno = 0;
		$li_ano = 0;
		$tipo_ense = 0;
		}

	$ls_sql = " select subsector.nombre ";
	$ls_sql = " select subsector.nombre, "; 
	$ls_sql = $ls_sql . " sum(case when curso.grado_curso = 1 then situacion_final.nota_final else 0 end) as G1, "; 
	$ls_sql = $ls_sql . " sum(case when curso.grado_curso = 2 then situacion_final.nota_final else 0 end) as G2, "; 
	$ls_sql = $ls_sql . " sum(case when curso.grado_curso = 3 then situacion_final.nota_final else 0 end) as G3, "; 
	$ls_sql = $ls_sql . " sum(case when curso.grado_curso = 4 then situacion_final.nota_final else 0 end) as G4 "; 
	$ls_sql = $ls_sql . " from ramo, subsector, curso, matricula, situacion_final "; 
	$ls_sql = $ls_sql . " where matricula.id_curso = curso.id_curso "; 
	$ls_sql = $ls_sql . " and matricula.rut_alumno = situacion_final.rut_alumno "; 
	$ls_sql = $ls_sql . " and ramo.id_ramo = situacion_final.id_ramo "; 
	$ls_sql = $ls_sql . " and ramo.cod_subsector = subsector.cod_subsector "; 
	$ls_sql = $ls_sql . " and ramo.id_curso = curso.id_curso  "; 
	//$ls_sql = $ls_sql . " and curso.ensenanza = $tipo_ense "; 
	$ls_sql = $ls_sql . " and matricula.rut_alumno = $ls_alumno "; 
	$ls_sql = $ls_sql . " group by subsector.nombre "; 
	$ls_sql = $ls_sql . " order by subsector.nombre; "; 
	
	//echo "$ls_sql";

	$resultado_query= pg_exec($conexion,$ls_sql);
	$total_filas= pg_numrows($resultado_query);
	
	//echo "$total_filas";
	
	$ls_sql = "select region.nom_reg, provincia.nom_pro, comuna.nom_com  ";
	$ls_sql = $ls_sql . "from comuna, provincia, region, alumno  ";
	$ls_sql = $ls_sql . "where comuna.cor_pro = provincia.cor_pro  ";
	$ls_sql = $ls_sql . "and comuna.cod_reg = region.cod_reg  ";
	$ls_sql = $ls_sql . "and provincia.cod_reg = region.cod_reg  ";
	$ls_sql = $ls_sql . "and alumno.region = region.cod_reg  ";
	$ls_sql = $ls_sql . "and alumno.ciudad = provincia.cor_pro  ";
	$ls_sql = $ls_sql . "and alumno.comuna = comuna.cor_com  ";
	$ls_sql = $ls_sql . "and alumno.rut_alumno = $ls_alumno ";

	$resultado_query_arriba= pg_exec($conexion,$ls_sql);
	$total_filas_arriba = pg_numrows($resultado_query_arriba);
	
// saca la cabecera con los decretos nombres etc

	$ls_sql = "select institucion.nombre_instit, plan_estudio.cod_decreto, plan_estudio.nombre_decreto, ";
	$ls_sql = $ls_sql . "institucion.rdb, Trim(alumno.nombre_alu) || ' ' || Trim(alumno.ape_pat) || ' ' || trim(alumno.ape_mat) as nom,";
	$ls_sql = $ls_sql . "alumno.rut_alumno || '-' || alumno.dig_rut as rut , curso.grado_curso,  ";
	$ls_sql = $ls_sql . "plan_estudio.cod_decreto, plan_estudio.nombre_decreto, evaluacion.cod_eval,  ";
	$ls_sql = $ls_sql . "evaluacion.nombre_decreto_eval ";
	$ls_sql = $ls_sql . "from institucion, matricula, alumno, curso, ano_escolar, evaluacion, plan_estudio ";
	$ls_sql = $ls_sql . "where institucion.rdb = matricula.rdb  ";
	$ls_sql = $ls_sql . "and curso.id_curso = matricula.id_curso ";
	$ls_sql = $ls_sql . "and alumno.rut_alumno = matricula.rut_alumno  ";
	$ls_sql = $ls_sql . "and ano_escolar.id_ano = matricula.id_ano ";
	$ls_sql = $ls_sql . "and curso.cod_decreto = plan_estudio.cod_decreto ";
	$ls_sql = $ls_sql . "and curso.cod_eval = evaluacion.cod_eval ";
	$ls_sql = $ls_sql . "and institucion.rdb = $ls_institucion ";
	$ls_sql = $ls_sql . "and alumno.rut_alumno = $ls_alumno ";
	//$ls_sql = $ls_sql . "and ano_escolar.nro_ano = $li_ano; ";
//	echo "$ls_sql";
	$resultado_query_cabecera= pg_exec($conexion,$ls_sql);
	$total_filas_cabecera = pg_numrows($resultado_query_cabecera);
	
// promedios y % asistencia

	$ls_sql = "select  ";
	$ls_sql = $ls_sql . "sum(case when curso.grado_curso = 1 then promocion.promedio else 0 end) as G1, ";
	$ls_sql = $ls_sql . "sum(case when curso.grado_curso = 2 then promocion.promedio else 0 end) as G2, ";
	$ls_sql = $ls_sql . "sum(case when curso.grado_curso = 3 then promocion.promedio else 0 end) as G3, ";
	$ls_sql = $ls_sql . "sum(case when curso.grado_curso = 4 then promocion.promedio else 0 end) as G4, ";
	$ls_sql = $ls_sql . "sum(case when curso.grado_curso = 1 then promocion.asistencia else 0 end) as G1b, ";
	$ls_sql = $ls_sql . "sum(case when curso.grado_curso = 2 then promocion.asistencia else 0 end) as G2b, "; 
	$ls_sql = $ls_sql . "sum(case when curso.grado_curso = 3 then promocion.asistencia else 0 end) as G3b, ";
	$ls_sql = $ls_sql . "sum(case when curso.grado_curso = 4 then promocion.asistencia else 0 end) as G4b ";
	$ls_sql = $ls_sql . "from  curso, matricula, promocion  ";
	$ls_sql = $ls_sql . "where matricula.id_curso = curso.id_curso ";
	$ls_sql = $ls_sql . "and matricula.rut_alumno = promocion.rut_alumno ";
	$ls_sql = $ls_sql . "and matricula.id_ano = promocion.id_ano  ";
	//$ls_sql = $ls_sql . "and curso.ensenanza = $tipo_ense ";
	$ls_sql = $ls_sql . "and matricula.rut_alumno = $ls_alumno ";
	//echo "$ls_sql ";
	$resultado_query_prom= pg_exec($conexion,$ls_sql);
	$total_filas_prom = pg_numrows($resultado_query_prom);

	
	$ls_sql = "select  ";
	$ls_sql = $ls_sql . "curso.grado_curso, ";
	$ls_sql = $ls_sql . "institucion.nombre_instit, comuna.nom_com, plan_estudio.nombre_decreto,  ";
	$ls_sql = $ls_sql . "evaluacion.nombre_decreto_eval, ano_escolar.nro_ano ";
	$ls_sql = $ls_sql . "from institucion, region, comuna, provincia, matricula, ano_escolar, curso, evaluacion,  ";
	$ls_sql = $ls_sql . "plan_estudio ";
	$ls_sql = $ls_sql . "where ";
	$ls_sql = $ls_sql . "comuna.cod_reg = region.cod_reg ";
	$ls_sql = $ls_sql . "and comuna.cor_pro = provincia.cor_pro ";
	$ls_sql = $ls_sql . "and provincia.cod_reg = region.cod_reg ";
	$ls_sql = $ls_sql . "and institucion.comuna = comuna.cor_com  ";
	$ls_sql = $ls_sql . "and institucion.region = comuna.cod_reg  ";
	$ls_sql = $ls_sql . "and institucion.ciudad = comuna.cor_pro ";
	$ls_sql = $ls_sql . "and institucion.region = provincia.cod_reg ";
	$ls_sql = $ls_sql . "and institucion.ciudad = provincia.cor_pro ";
	$ls_sql = $ls_sql . "and institucion.region = region.cod_reg ";
	$ls_sql = $ls_sql . "and institucion.rdb = matricula.rdb  ";
	$ls_sql = $ls_sql . "and ano_escolar.id_ano = matricula.id_ano  ";
	$ls_sql = $ls_sql . "and curso.id_curso = matricula.id_curso ";
	$ls_sql = $ls_sql . "and curso.cod_decreto = plan_estudio.cod_decreto ";
	$ls_sql = $ls_sql . "and curso.cod_eval = evaluacion.cod_eval ";
	$ls_sql = $ls_sql . "and matricula.rut_alumno = $ls_alumno ";
	$ls_sql = $ls_sql . "and institucion.rdb = $ls_institucion ";
	$ls_sql = $ls_sql . "order by ano_escolar.nro_ano ";

	

	$resultado_query_rigth = pg_exec($conexion,$ls_sql);
	$total_filas_rigth = pg_numrows($resultado_query_rigth);

	pg_close($conexion);
	
?>
<html>
<head>
<title>rpt15</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?
if ($total_filas>0){
?>
<table width="670" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr> 
    <td colspan="2"><div align="right" id="capa0"> 
        <input 
		name="cmdimprimiroriginal" 
		type="button" 
		class="cb_submit_9_x_75" 
		id="cmdimprimiroriginal" 
		onclick="imprimir();" 
		value="Imprimir">
      </div></td>
  </tr>
  <tr> 
    <td width="446" rowspan="4" class="titulos"> <div align="center"><font size="3">CERTIFICADO 
        CONCENTRACI&Oacute;N DE NOTAS<br>
        ENSE&Ntilde;ANZA MEDIA</font></div></td>
    <td width="39%" class="textos">REGI&Oacute;N : <?print Trim(pg_result($resultado_query_arriba, 0, 0));?></td>
  </tr>
  <tr> 
    <td class="textos">PROVINCIA : <?print Trim(pg_result($resultado_query_arriba, 0, 1));?></td>
  </tr>
  <tr> 
    <td class="textos">COMUNA : <?print Trim(pg_result($resultado_query_arriba, 0, 2));?></td>
  </tr>
  <tr> 
    <td class="textos">A&Ntilde;O escolar : 
      <?=(date(Y))?>
    </td>
  </tr>
</table>
<br>
<table width="670" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="textosgrande"><u><?print Trim(pg_result($resultado_query_cabecera, 0, 0));?> </u>
      reconocido oficialmente por el ministerio de educaci&oacute;n de chile seg&uacute;n 
      decreto <u><?print Trim(pg_result($resultado_query_cabecera, 0, 1));?></u> n&ordm; 
      <u><?print Trim(pg_result($resultado_query_cabecera, 0, 2));?></u> rol base datos 
      n&ordm; <u><?print Trim(pg_result($resultado_query_cabecera, 0, 3));?></u>, otorga 
      el presente certificado de calificaciones anuales y situaci&oacute;n final 
      a don(a) <u><?print Trim(pg_result($resultado_query_cabecera, 0, 4));?></u> r.u.n 
     <u> <?print Trim(pg_result($resultado_query_cabecera, 0, 5));?></u>.</td>
  </tr>
</table>
<br>
<table width="670" border="1" align="center" cellpadding="1" cellspacing="3">
  <tr> 
    <td rowspan="2" class="textosgrande">Subsector, Asignatura, Modulo:</td>
    <td colspan="4" class="textosmediano">CURSO DE ENSE&Ntilde;ANZA MEDIA</td>
    <td rowspan="2" class="textosgrande">A&Ntilde;O ESCOLAR Y ESTABLECIMIENTO</td>
  </tr>
  <tr> 
    <td class="textosgrande">1&ordm;</td>
    <td class="textosgrande">2&ordm;</td>
    <td class="textosgrande">3&ordm;</td>
    <td class="textosgrande">4&ordm;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td rowspan="<?=($total_filas + 7)?>"> 
	<table width="230" border="0" cellspacing="0" cellpadding="0">
        <?
For ($j=0; $j < $total_filas_rigth; $j++)
{
?>
        <tr> 
          <td class="textosgrande"><strong>
		  <?
		  if (($j+1)==1){
		  	echo "Primer";	
		  }elseif(($j+1)==2){
		  	echo "Segundo";
		  }elseif(($j+1)==3){
			echo "Tercer";
		  }elseif(($j+1)==4){
			echo "Cuarto";
		  }	
		  ?>
		   
		  
		  
		  A&ntilde;o </strong></td>
        </tr>
        <tr> 
          <td class="textosmedianoMinus">Establecimiento <strong><u><?php print pg_result($resultado_query_rigth, $j, 1);?></u></strong> 
            ciudad <strong><u><?php print pg_result($resultado_query_rigth, $j, 2);?></u></strong> 
            Plan y Programas de Estudio, Decreto exento o Resoluci&oacute;n exenta 
            de Educaci&oacute;n N&ordm; <strong><u><?php print pg_result($resultado_query_rigth, $j, 3);?></u></strong> 
            Reglamento de evaluaci&oacute;n y Promoci&oacute;n escolar, Decreto 
            exento de educaci&oacute;n N&ordm; <strong><u><?php print pg_result($resultado_query_rigth, $j, 4);?></u></strong></td>
        </tr>
        <tr>
          <td class="textosgrande">&nbsp;</td>
        </tr>

<?
}

For ($j=$total_filas_rigth; $j < 4; $j++)
{
?>
        <tr> 
          <td class="textosgrande"><strong>
		  <?
		  if (($j+1)==1){
		  	echo "Primer";	
		  }elseif(($j+1)==2){
		  	echo "Segundo";
		  }elseif(($j+1)==3){
			echo "Tercer";
		  }elseif(($j+1)==4){
			echo "Cuarto";
		  }	
		  ?>
		   A&ntilde;o </strong></td>
        </tr>
        <tr> 
          <td class="textosmedianoMinus">Establecimiento &nbsp;&nbsp;&nbsp;&nbsp; 
            ciudad &nbsp;&nbsp;&nbsp;&nbsp; Plan y Programas de Estudio, Decreto 
            exento o Resoluci&oacute;n exenta de Educaci&oacute;n N&ordm; &nbsp;&nbsp;&nbsp;&nbsp; 
            Reglamento de evaluaci&oacute;n y Promoci&oacute;n escolar, Decreto 
            exento de educaci&oacute;n N&ordm; &nbsp;&nbsp;&nbsp;&nbsp; </td>
        </tr>
		        <tr>
          <td class="textosgrande">&nbsp;</td>
        </tr>

        <?
}
?>
      </table>
	  </td>
  </tr>
  <?
For ($j=0; $j < $total_filas; $j++)
{
?>
  <tr> 
    <td class="textosmediano"><?print pg_result($resultado_query, $j, 0);?></td>
    <td class="textosmediano"><?print number_format(pg_result($resultado_query, $j, 1)/10,1);?></td>
    <td class="textosmediano"><?print number_format(pg_result($resultado_query, $j, 2)/10,1);?></td>
    <td class="textosmediano"><?print number_format(pg_result($resultado_query, $j, 3)/10,1);?></td>
    <td class="textosmediano"><?print number_format(pg_result($resultado_query, $j, 4)/10,1);?></td>
  </tr>
  <?
}
?>
  <tr> 
    <td class="textosmedianoMinus">Ejercitar el Acondicionamiento F&iacute;sico 
      y el cuidado de la salud</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td class="titulos">Promedio General</td>
    <td class="textosmediano"><?print number_format(pg_result($resultado_query_prom, 0, 0)/10,1);?></td>
    <td class="textosmediano"><?print number_format(pg_result($resultado_query_prom, 0, 1)/10,1);?></td>
    <td class="textosmediano"><?print number_format(pg_result($resultado_query_prom, 0, 2)/10,1);?></td>
    <td class="textosmediano"><?print number_format(pg_result($resultado_query_prom, 0, 3)/10,1);?></td>
  </tr>
  <tr> 
    <td class="titulos">Religi&oacute;n(Optativo)</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td class="titulos">Porcentaje de Asistencia</td>
    <td class="textosmediano"><?print pg_result($resultado_query_prom, 0, 4);?></td>
    <td class="textosmediano"><?print pg_result($resultado_query_prom, 0, 5);?></td>
    <td class="textosmediano"><?print pg_result($resultado_query_prom, 0, 6);?></td>
    <td class="textosmediano"><?print pg_result($resultado_query_prom, 0, 7);?></td>
  </tr>
</table>
<br>
<table width="670" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="textosmediano"> 
      <div align="right"> 
        <?
$fecha_day = array('Domingo','Lunes','Martes','Miercoles','Jueves', 'Viernes', 'Sabado');
$fecha_month = array('--','Enero','Febrero','Marzo','Abril','Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

print_r($fecha_day[date(w)]);
echo ", ". date(j) ." de ";
print_r($fecha_month[date(n)]);
echo " de "; 
print date(Y);
	?>
      </div></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><div align="right">________________________</div></td>
  </tr>
  <tr> 
    <td class="textosmediano">
<div align="right">Firma&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
  </tr>
</table>
<?
}
?>
</body>
</html>
