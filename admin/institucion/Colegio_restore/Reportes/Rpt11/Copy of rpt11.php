<?include"../Coneccion/conexion.php"?>
<?
	$ls_institucion = $_GET["as_institucion"];
	$ls_alumno = $_GET["as_alumno"];
	$li_ano = $_GET["ai_ano"];
	$li_periodo = $_GET["ai_periodo"];

	if(trim($ls_institucion)==''){
		$ls_institucion = 0;
		$ls_alumno = 0;
		$li_ano = 0;
		$li_periodo = 0;
	}	
	echo "$li_periodo";
//echo "Variables :  $ls_institucion ---  $ls_alumno  ---- $li_ano";
$ls_sql = " select * from area_desarrollo  order by id_area";

	$resultado_query_area = pg_exec($conexion,$ls_sql);
	$total_filas_area = pg_numrows($resultado_query_area);

//-----------------------------------------
$ls_sql = " select min(id_periodo) ";
$ls_sql = $ls_sql . " from periodo, ano_escolar ";
$ls_sql = $ls_sql . " where ano_escolar.id_ano = periodo.id_ano ";
$ls_sql = $ls_sql . " and ano_escolar.id_institucion = $ls_institucion ";
$ls_sql = $ls_sql . " and ano_escolar.nro_ano = $li_ano; ";

	$resultado_query_ano = pg_exec($conexion,$ls_sql);
	$total_filas_ano = pg_numrows($resultado_query_ano);

	$li_periodo_ = pg_result($resultado_query_ano, 0, 0);

if (Trim($li_periodo_)==''){
$li_periodo_ = 0;
}

//echo "Periodo : $li_periodo_";
//------------------------------------------
$ls_sql = " select maestro_eval_sup.id_area, area_desarrollo.glosa, maestro_eval_sup.glosa, ";
$ls_sql = $ls_sql . " evaluacion_detalle_sup.evaluacion as ev, ";
$ls_sql = $ls_sql . " 1 as estado   ";
$ls_sql = $ls_sql . " from maestro_eval_sup, area_desarrollo, evaluacion_detalle_sup ";
$ls_sql = $ls_sql . " where maestro_eval_sup.id_area = area_desarrollo.id_area ";
$ls_sql = $ls_sql . " and evaluacion_detalle_sup.id_area = maestro_eval_sup.id_area ";
$ls_sql = $ls_sql . " and evaluacion_detalle_sup.id_area = area_desarrollo.id_area ";
$ls_sql = $ls_sql . " and evaluacion_detalle_sup.id_pregunta = maestro_eval_sup.id_pregunta ";
$ls_sql = $ls_sql . " and evaluacion_detalle_sup.rut_alumno = $ls_alumno ";
$ls_sql = $ls_sql . " and evaluacion_detalle_sup.id_periodo = $li_periodo_ ";
//$ls_sql = $ls_sql . " and evaluacion_detalle_sup.id_curso = 10 ";
$ls_sql = $ls_sql . " and maestro_eval_sup.id_area <> 4 union ";
$ls_sql = $ls_sql . " select maestro_eval_sup.id_area, area_desarrollo.glosa, maestro_eval_sup.glosa,  ";
$ls_sql = $ls_sql . " '4' as ev, ";
$ls_sql = $ls_sql . " 0 as estado   ";
$ls_sql = $ls_sql . " from maestro_eval_sup, area_desarrollo ";
$ls_sql = $ls_sql . " where maestro_eval_sup.id_area = area_desarrollo.id_area ";
$ls_sql = $ls_sql . " and (maestro_eval_sup.id_area, maestro_eval_sup.id_pregunta) not in ( ";
$ls_sql = $ls_sql . " select maestro_eval_sup.id_area, maestro_eval_sup.id_pregunta ";
$ls_sql = $ls_sql . " from maestro_eval_sup, area_desarrollo, evaluacion_detalle_sup ";
$ls_sql = $ls_sql . " where maestro_eval_sup.id_area = area_desarrollo.id_area ";
$ls_sql = $ls_sql . " and evaluacion_detalle_sup.id_area = maestro_eval_sup.id_area ";
$ls_sql = $ls_sql . " and evaluacion_detalle_sup.id_area = area_desarrollo.id_area ";
$ls_sql = $ls_sql . " and evaluacion_detalle_sup.id_pregunta = maestro_eval_sup.id_pregunta ";
$ls_sql = $ls_sql . " and evaluacion_detalle_sup.rut_alumno = $ls_alumno ";
$ls_sql = $ls_sql . " and evaluacion_detalle_sup.id_periodo = $li_periodo_ ";
//$ls_sql = $ls_sql . " and evaluacion_detalle_sup.id_curso = 10 "
$ls_sql = $ls_sql . " and maestro_eval_sup.id_area <> 4";
$ls_sql = $ls_sql . " ) and maestro_eval_sup.id_area <> 4";


	 //echo "--> $sql";
	$resultado_query = pg_exec($conexion,$ls_sql);
	$total_filas = pg_numrows($resultado_query);
	
//-----------------------------------------------------

$ls_sql = "select maestro_eval_sup.id_area, area_desarrollo.glosa, maestro_eval_sup.glosa, ";
$ls_sql = $ls_sql . " case when maestro_eval_sup.id_pregunta = 1  ";
$ls_sql = $ls_sql . " then evaluacion_detalle_sup.interes_area_voc else  ";
$ls_sql = $ls_sql . " case when maestro_eval_sup.id_pregunta = 2  ";
$ls_sql = $ls_sql . " then evaluacion_detalle_sup.aptitudes_para else ";
$ls_sql = $ls_sql . " case when maestro_eval_sup.id_pregunta = 3 and evaluacion_detalle_sup.congruencia = 0 ";
$ls_sql = $ls_sql . " then 'NO' else ";
$ls_sql = $ls_sql . " case when maestro_eval_sup.id_pregunta = 3 and evaluacion_detalle_sup.congruencia = 1 ";
$ls_sql = $ls_sql . " then 'SI' else ";
$ls_sql = $ls_sql . " case when maestro_eval_sup.id_pregunta = 4  ";
$ls_sql = $ls_sql . " then evaluacion_detalle_sup.aspiraciones else '0' end end end end end as p01, ";
$ls_sql = $ls_sql . " 1 as estado, maestro_eval_sup.id_pregunta   ";
$ls_sql = $ls_sql . " from maestro_eval_sup, area_desarrollo, evaluacion_detalle_sup ";
$ls_sql = $ls_sql . " where maestro_eval_sup.id_area = area_desarrollo.id_area ";
$ls_sql = $ls_sql . " and evaluacion_detalle_sup.id_area = maestro_eval_sup.id_area ";
$ls_sql = $ls_sql . " and evaluacion_detalle_sup.id_area = area_desarrollo.id_area ";
$ls_sql = $ls_sql . " and evaluacion_detalle_sup.id_pregunta = maestro_eval_sup.id_pregunta ";
$ls_sql = $ls_sql . " and evaluacion_detalle_sup.rut_alumno = $ls_alumno ";
$ls_sql = $ls_sql . " and evaluacion_detalle_sup.id_periodo = $li_periodo_ ";
//$ls_sql = $ls_sql . " and evaluacion_detalle_sup.id_curso = 10 ";
$ls_sql = $ls_sql . " and maestro_eval_sup.id_area = 4 ";
$ls_sql = $ls_sql . " group by maestro_eval_sup.id_area, area_desarrollo.glosa, maestro_eval_sup.glosa, ";
$ls_sql = $ls_sql . " maestro_eval_sup.id_pregunta,evaluacion_detalle_sup.interes_area_voc, ";
$ls_sql = $ls_sql . " evaluacion_detalle_sup.aptitudes_para, evaluacion_detalle_sup.congruencia, ";
$ls_sql = $ls_sql . " evaluacion_detalle_sup.aspiraciones ";
$ls_sql = $ls_sql . " union ";
$ls_sql = $ls_sql . " select maestro_eval_sup.id_area, area_desarrollo.glosa, maestro_eval_sup.glosa,  ";
$ls_sql = $ls_sql . " '6' as ev, ";
$ls_sql = $ls_sql . " 0 as estado, maestro_eval_sup.id_pregunta   ";
$ls_sql = $ls_sql . " from maestro_eval_sup, area_desarrollo ";
$ls_sql = $ls_sql . " where maestro_eval_sup.id_area = area_desarrollo.id_area ";
$ls_sql = $ls_sql . " and (maestro_eval_sup.id_area, maestro_eval_sup.id_pregunta) not in ( ";
$ls_sql = $ls_sql . " select maestro_eval_sup.id_area, maestro_eval_sup.id_pregunta ";
$ls_sql = $ls_sql . " from maestro_eval_sup, area_desarrollo, evaluacion_detalle_sup ";
$ls_sql = $ls_sql . " where maestro_eval_sup.id_area = area_desarrollo.id_area ";
$ls_sql = $ls_sql . " and evaluacion_detalle_sup.id_area = maestro_eval_sup.id_area ";
$ls_sql = $ls_sql . " and evaluacion_detalle_sup.id_area = area_desarrollo.id_area ";
$ls_sql = $ls_sql . " and evaluacion_detalle_sup.id_pregunta = maestro_eval_sup.id_pregunta ";
$ls_sql = $ls_sql . " and evaluacion_detalle_sup.rut_alumno = $ls_alumno ";
$ls_sql = $ls_sql . " and evaluacion_detalle_sup.id_periodo = $li_periodo_ ";
//$ls_sql = $ls_sql . " and evaluacion_detalle_sup.id_curso = 10 ";
$ls_sql = $ls_sql . " and maestro_eval_sup.id_area = 4 ";
$ls_sql = $ls_sql . " ) ";
$ls_sql = $ls_sql . " and maestro_eval_sup.id_area = 4 order by id_pregunta";
//order by maestro_eval_sup.id_area, maestro_eval_sup.id_pregunta

//echo "$ls_sql";
	$resultado_query_area_v_p = pg_exec($conexion,$ls_sql);
	$total_filas_area_v_p = pg_numrows($resultado_query_area_v_p);

$ls_sql =  " select alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.rut_alumno,";
$ls_sql = $ls_sql . " alumno.dig_rut, curso.grado_curso, curso.letra_curso, institucion.nombre_instit,";
$ls_sql = $ls_sql . " empleado.nombre_emp, empleado.ape_pat, empleado.ape_MAT, institucion.rdb";
$ls_sql = $ls_sql . " from alumno, matricula,institucion, curso, supervisa, empleado";
$ls_sql = $ls_sql . " where institucion.rdb = matricula.rdb ";
$ls_sql = $ls_sql . " and alumno.rut_alumno = matricula.rut_alumno ";
$ls_sql = $ls_sql . " and curso.id_curso = matricula.id_curso ";
$ls_sql = $ls_sql . " and curso.id_curso = supervisa.id_curso";
$ls_sql = $ls_sql . " and supervisa.rut_emp = empleado.rut_emp";
$ls_sql = $ls_sql . " and institucion.rdb = $ls_institucion";
$ls_sql = $ls_sql . " and alumno.rut_alumno = $ls_alumno; ";

	$resultado_query_cabecera = pg_exec($conexion,$ls_sql);
	$total_filas_area_cabecera = pg_numrows($resultado_query_cabecera);

//----------------------------------------------------------------

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


	pg_close($conexion);

?>
<html>
<head>
<title>Rpt11</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<?
if ($ls_institucion<> 0){
?>
<table width="650" border="0" align="center" cellpadding="1" cellspacing="3">
  <tr> 
    <td rowspan="5" valign="top" class="titulos"><font size="3">INFORME EDUCACIONAL</font></td>
    <td width="39%" class="textos">REGI&Oacute;N : <?print Trim(pg_result($resultado_query_arriba, 0, 0));?></td>
  </tr>
  <tr>
    <td class="textos">PROVINCIA : <?print Trim(pg_result($resultado_query_arriba, 0, 1));?></td>
  </tr>
  <tr>
    <td class="textos">COMUNA : <?print Trim(pg_result($resultado_query_arriba, 0, 2));?></td>
  </tr>
  <tr> 
    <td class="textos">ROL BASE DE DATOS:<?print pg_result($resultado_query_cabecera, 0, 11);?></td>
  </tr>
  <tr> 
    <td class="textos">A&Ntilde;O ESCOLAR: <?=($li_ano)?></td>
  </tr> 
</table>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="textosgrande">Alumno(a) <u><?print pg_result($resultado_query_cabecera, 0, 0);?> 
      <?print pg_result($resultado_query_cabecera, 0, 1);?> <?print pg_result($resultado_query_cabecera, 0, 2);?> 
      </u> R.U.N <u><?print pg_result($resultado_query_cabecera, 0, 3);?> - <?print pg_result($resultado_query_cabecera, 0, 4);?></u> 
      Curso <u><?print pg_result($resultado_query_cabecera, 0, 5);?> <?print pg_result($resultado_query_cabecera, 0, 6);?></u> 
      Especialidad -- Establecimiento <u><?print pg_result($resultado_query_cabecera, 0, 7);?></u> 
      Pofesor de Curso o Profesor Jefe <u><?print pg_result($resultado_query_cabecera, 0, 8);?> 
      <?print pg_result($resultado_query_cabecera, 0, 9);?> <?print pg_result($resultado_query_cabecera, 0, 10);?></u></td>
  </tr>
</table>
<br>
<table width="650" border="1" align="center" cellpadding="1" cellspacing="0">
  <tr class="titulos"> 
    <td width="444">&Aacute;REAS DE DESARROLLO</td>
    <td width="196">CONCEPTO EVALUATIVO</td>
  </tr>
  <?
	for ($x=0; $x < $total_filas_area; $x++){
		echo "<tr><td><b><FONT SIZE='1' >". pg_result($resultado_query_area, $x, 1) ."</FONT></b></td><td>&nbsp;</td></tr>";
		for ($j=0; $j < $total_filas; $j++){
			if(pg_result($resultado_query_area, $x, 0)==pg_result($resultado_query, $j, 0)){
				?>
  <tr class="textosmediano"> 
    <td ><?print pg_result($resultado_query, $j, 2);?> </td>
    <td> 
      <?
	if (pg_result($resultado_query, $j, 3)==0){
		echo "SIEMPRE";
	}elseif(pg_result($resultado_query, $j, 3)==1){
		echo "GENERALMENTE";
	}elseif(pg_result($resultado_query, $j, 3)==2){
		echo "OCACIONALMENTE";
	}elseif(pg_result($resultado_query, $j, 3)==3){
		echo "NUNCA";
	}elseif(pg_result($resultado_query, $j, 3)==4){
		echo "&nbsp;";
	}
	?>
    </td>
  </tr>
  <?
			}	
		}
	}
		?>
  <!---------------------------------------------------------------------->
<tr class="textosmediano">
<td colspan="2" >
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
        <TR>
          <td  class="textosmediano"> 
            <?
for ($j=0; $j < $total_filas_area_v_p; $j++){
	if ($j==0){
		echo " - Intereses <br><br>";
	}elseif($j==1){
		echo " - Aptitudes y/o habilidades <br><br>";
	}elseif($j==2){
		echo " - ";
	}elseif($j==3){
		echo " - ";
	}

?>
            <?print pg_result($resultado_query_area_v_p, $j, 2);?> <u><?print pg_result($resultado_query_area_v_p, $j, 3);?> 
            </u> <br>
<br>

<?
}
?>
</td></TR></table> 
    </td>

  </tr>

</table>
<?
}
?>
</body>
</html>
