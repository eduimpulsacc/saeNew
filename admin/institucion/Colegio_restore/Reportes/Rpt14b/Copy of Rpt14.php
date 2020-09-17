<?include"../Coneccion/conexion.php"?>
<?
	$li_curso = $_GET["ai_curso"];
	$ls_letra = $_GET["as_letra"];
	$li_tipo_ense = $_GET["ai_tipo_ense"];
	$li_ano = $_GET["ai_ano"];
	$ls_institucion    = $_GET["as_institucion"];
	
	//echo "--> $li_curso <br> --> $ls_letra <br> --> $li_tipo_ense  <br> --> $ls_institucion";

	if(trim($ls_institucion)==''){
		$li_curso = 0;
		$ls_letra = 0;
		$li_tipo_ense = 0;
		$li_ano = 0;
		$ls_institucion = 0;
	}
	
//--------------------------------------------------------------------------------------------------------------------------------
//recoge los alumnos	
	$ls_sql = " select alumno.rut_alumno, curso.id_curso, curso.letra_curso, ";
	$ls_sql = $ls_sql . " curso.grado_curso, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat ";
	$ls_sql = $ls_sql . " from alumno, matricula, curso, ano_escolar ";
	$ls_sql = $ls_sql . " where alumno.rut_alumno = matricula.rut_alumno ";
	$ls_sql = $ls_sql . " and curso.id_curso = matricula.id_curso ";
	$ls_sql = $ls_sql . " and ano_escolar.id_ano = matricula.id_ano ";
	$ls_sql = $ls_sql . " and ano_escolar.id_ano = curso.id_ano ";
	$ls_sql = $ls_sql . " and matricula.rdb = $ls_institucion ";
	$ls_sql = $ls_sql . " and curso.grado_curso = $li_curso ";
	$ls_sql = $ls_sql . " and curso.letra_curso = '$ls_letra' ";
	$ls_sql = $ls_sql . " and curso.ensenanza = $li_tipo_ense ";
	$ls_sql = $ls_sql . " and ano_escolar.nro_ano = $li_ano order by 6,5,4; "; 

	$resultado_query_alumnos = pg_exec($conexion,$ls_sql);
	$total_filas_alumnos = pg_numrows($resultado_query_alumnos);
	
//--------------------------------------------------------------------------------------------------------------------------------		
//Periodos del año seleccionado
	$ls_sql = " select periodo.id_periodo";
	$ls_sql = $ls_sql . " from notas, periodo, ano_escolar";
	$ls_sql = $ls_sql . " where notas.id_periodo = periodo.id_periodo and periodo.id_ano = ano_escolar.id_ano";
	$ls_sql = $ls_sql . " and ano_escolar.nro_ano = $li_ano and ano_escolar.id_institucion = $ls_institucion";
	$ls_sql = $ls_sql . " group by periodo.id_periodo;";

	$resultado_query_periodo = pg_exec($conexion,$ls_sql);
	$total_filas_periodo = pg_numrows($resultado_query_periodo);
	
//--------------------------------------------------------------------------------------------------------------------------------	
// Director
	
	$ls_sql = " select empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat ";
	$ls_sql = $ls_sql . " from trabaja, empleado ";
	$ls_sql = $ls_sql . " where empleado.rut_emp = trabaja.rut_emp ";
	$ls_sql = $ls_sql . " and trabaja.rdb = $ls_institucion ";
	$ls_sql = $ls_sql . " and trabaja.cargo = 1; ";

	$resultado_query_dire= pg_exec($conexion,$ls_sql);
	$total_filas_dire= pg_numrows($resultado_query_dire);
//echo "$ls_sql";
	//pg_close($conexion);

if ($total_filas_dire > 0){
	$ls_nom_dire = TRIM(pg_result($resultado_query_dire, 0, 0)) . ' ' . TRIM(pg_result($resultado_query_dire, 0, 1)) . ' ' . TRIM(pg_result($resultado_query_dire, 0, 2));
}else{
$ls_nom_dire = " ";
}

//--------------------------------------------------------------------------------------------------------------------------------

	$ls_sql = "select distinct institucion.nombre_instit, curso.grado_curso, ";
	$ls_sql = $ls_sql . " curso.letra_curso, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat ";
	$ls_sql = $ls_sql . " from institucion, curso, alumno, promocion, ano_escolar, supervisa ";
	$ls_sql = $ls_sql . " where promocion.rdb = institucion.rdb ";
	$ls_sql = $ls_sql . " and promocion.rut_alumno = alumno.rut_alumno ";
	$ls_sql = $ls_sql . " and promocion.id_curso = curso.id_curso ";
	$ls_sql = $ls_sql . " and promocion.id_ano = ano_escolar.id_ano ";
	$ls_sql = $ls_sql . " and curso.id_curso = supervisa.id_curso  ";
	$ls_sql = $ls_sql . " and empleado.rut_emp = supervisa.rut_emp ";
	$ls_sql = $ls_sql . " and curso.grado_curso = $li_curso ";
	$ls_sql = $ls_sql . " and curso.letra_curso = '$ls_letra' ";
	$ls_sql = $ls_sql . " and institucion.rdb = $ls_institucion; ";

	$resultado_query_profe = pg_exec($conexion,$ls_sql);
	$total_filas_profe= pg_numrows($resultado_query_profe);

	if($total_filas_profe >0){
		$ls_nom_inst = pg_result($resultado_query_profe, 0, 0);
		$ls_nom_profe = TRIM(pg_result($resultado_query_profe, 0, 3)) . ' ' . TRIM(pg_result($resultado_query_profe, 0, 4)) . ' ' . TRIM(pg_result($resultado_query_profe, 0, 5));
	}else{
		$ls_nom_inst = " ";
		$ls_nom_profe = " ";	
	}
?>
<html>
<head>
<title>Rpt14b</title>
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
for($j=0;$j < $total_filas_alumnos;$j++){
?>
<table width="670" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="titulos">
	<div id="capa0" align="right"> </div>
	</td>
  </tr>
  <tr> 
    <td class="titulos"><font size="3">Informe de Notas Parciales</font></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td class="textosgrande">Colegio : <?=($ls_nom_inst)?></td>
  </tr>
  <tr> 
    <td class="textosgrande">Nombre Alumno : 
	<? print pg_result($resultado_query_alumnos, $j, 5); ?>
	<? print pg_result($resultado_query_alumnos, $j, 6); ?>
	<? print pg_result($resultado_query_alumnos, $j, 4); ?> 
	</td>
  </tr>
  <tr> 
    <td class="textosgrande">Curso Alumno : 
	<? print pg_result($resultado_query_alumnos, $j, 3); ?>  
	<? print pg_result($resultado_query_alumnos, $j, 2); ?>
	</td>
  </tr>
  <tr> 
    <td> 
      <?
for($li_periodo=0;$li_periodo < $total_filas_periodo;$li_periodo++){
		if($total_filas_periodo==3)	{
			$ls_tipo_ed = "Trimestre";
		}Else{
			$ls_tipo_ed = "Semestre";}
		?>
      <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
      <?
	  if($li_periodo==0){
	  echo "Primer $ls_tipo_ed";
	  }elseif($li_periodo==1){
	  echo "Segundo $ls_tipo_ed";
	  }elseif($li_periodo==2){
	  echo "Tercer $ls_tipo_ed";}
	  
	  ?>
      </font> 
	  <hr width="670"></hr>
      <!------- inicio ------->
      <?
	$ls_sql = "select subsector.nombre,notas.*, periodo.id_periodo ";
	$ls_sql = $ls_sql . " from notas, periodo, ramo, subsector ";
	$ls_sql = $ls_sql . " where notas.id_periodo = periodo.id_periodo ";
	$ls_sql = $ls_sql . " and notas.id_ramo = ramo.id_ramo ";
	$ls_sql = $ls_sql . " and ramo.cod_subsector = subsector.cod_subsector ";
	$ls_sql = $ls_sql . " and periodo.id_ano = ano_escolar.id_ano  ";
	$ls_sql = $ls_sql . " and ano_escolar.nro_ano = $li_ano ";
	$ls_sql = $ls_sql . " and notas.rut_alumno = ".pg_result($resultado_query_alumnos, $j, 0);
	$ls_sql = $ls_sql . " order by periodo.id_periodo, subsector.nombre ";

	$resultado_query_notas = pg_exec($conexion,$ls_sql);
	$total_filas_notas = pg_numrows($resultado_query_notas);

?>
      <!-------Fin------->
      <table width="670" border="1" cellspacing="0" cellpadding="0">
        <tr class="texto8px"> 
          <td width="350">Subsectores</td>
          <td width="15">1</td>
          <td width="15">2</td>
          <td width="15">3</td>
          <td width="15">4</td>
          <td width="15">5</td>
          <td width="15">6</td>
          <td width="15">7</td>
          <td width="15">8</td>
          <td width="15">9</td>
          <td width="15">10</td>
          <td width="15">11</td>
          <td width="15">12</td>
          <td width="15">13</td>
          <td width="15">14</td>
          <td width="15">15</td>
          <td width="15">16</td>
          <td width="15">17</td>
          <td width="15">18</td>
          <td width="15">19</td>
          <td width="15">20</td>
          <td >Prom</td>
        </tr>
        <?
for($li_notas=0;$li_notas<$total_filas_notas;$li_notas++){
	if(pg_result($resultado_query_periodo, $li_periodo, 0)==pg_result($resultado_query_notas, $li_notas, 25)){
?>
        <tr class="texto8px"> 
          <td width="350"><? print(pg_result($resultado_query_notas, $li_notas, 0));?></td>
          <td width="15"><? print(pg_result($resultado_query_notas, $li_notas, 4));?></td>
          <td width="15"><? print(pg_result($resultado_query_notas, $li_notas, 5));?></td>
          <td width="15"><? print(pg_result($resultado_query_notas, $li_notas, 6));?></td>
          <td width="15"><? print(pg_result($resultado_query_notas, $li_notas, 7));?></td>
          <td width="15"><? print(pg_result($resultado_query_notas, $li_notas, 8));?></td>
          <td width="15"><? print(pg_result($resultado_query_notas, $li_notas, 9));?></td>
          <td width="15"><? print(pg_result($resultado_query_notas, $li_notas, 10));?></td>
          <td width="15"><? print(pg_result($resultado_query_notas, $li_notas, 11));?></td>
          <td width="15"><? print(pg_result($resultado_query_notas, $li_notas, 12));?></td>
          <td width="15"><? print(pg_result($resultado_query_notas, $li_notas, 13));?></td>
          <td width="15"><? print(pg_result($resultado_query_notas, $li_notas, 14));?></td>
          <td width="15"><? print(pg_result($resultado_query_notas, $li_notas, 15));?></td>
          <td width="15"><? print(pg_result($resultado_query_notas, $li_notas, 16));?></td>
          <td width="15"><? print(pg_result($resultado_query_notas, $li_notas, 17));?></td>
          <td width="15"><? print(pg_result($resultado_query_notas, $li_notas, 18));?></td>
          <td width="15"><? print(pg_result($resultado_query_notas, $li_notas, 19));?></td>
          <td width="15"><? print(pg_result($resultado_query_notas, $li_notas, 20));?></td>
          <td width="15"><? print(pg_result($resultado_query_notas, $li_notas, 21));?></td>
          <td width="15"><? print(pg_result($resultado_query_notas, $li_notas, 22));?></td>
          <td width="15"><? print(pg_result($resultado_query_notas, $li_notas, 23));?></td>
          <td ><? print(pg_result($resultado_query_notas, $li_notas, 24));?></td>
        </tr>
        <?
	}
}
	?>
      </table>
	  <?
}
?>
      <table width="670" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td class="textosmediano"><div align="right"></div></td>
        </tr>
        <tr> 
          <td class="textosmediano"><div align="right"></div></td>
        </tr>
      </table>
      <table width="670" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td colspan="2" class="titulos"><hr width="670"></td>
        </tr>
        <tr class="textosmediano"> 
          <td colspan="2"> 
            <div align="right">Promedio General : </div></td>
        </tr>
        <tr class="textosmediano"> 
          <td colspan="2"> 
            <div align="right">Asistencia General :% </div></td>
        </tr>
        <tr> 
          <td colspan="2" class="titulos">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="2"> Observaciones_____________________________________________________</td>
        </tr>
        <tr> 
          <td colspan="2">________________________________________________________________</td>
        </tr>
        <tr> 
          <td colspan="2">________________________________________________________________</td>
        </tr>
        <tr> 
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr> 
          <td><div align="center">_______________________</div></td>
          <td><div align="center">_______________________</div></td>
        </tr>
        <tr class="textosmediano"> 
          <td><div align="center"><?=($ls_nom_profe)?><br>
              (Profesor(a) Jefe)
</div></td>
          <td><div align="center"><? echo("$ls_nom_dire");?><br>
              (Director(a))
            </div></td>
        </tr>
      </table>
      &nbsp; </td>
  </tr>
</table>
<br>
<br>
<?
}
?>
</body>
</html>
