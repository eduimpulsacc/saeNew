<?include"../Coneccion/conexion.php"?>
<?
	$ls_institucion = $_GET["as_institucion"];
	$ls_alumno = $_GET["as_alumno"];
	$li_ano = $_GET["ai_ano"];
	$li_id_ano = 0;
	$li_id_curso = 0;

	if(trim($ls_institucion)==''){
		$ls_institucion = 0;
		$ls_alumno = 0;
		$li_ano = 0;
	}
//------------------------------------------------------------------------------
	//saca el nombre de la institucion
	$ls_sql = "select institucion.nombre_instit from institucion where rdb = $ls_institucion ";
	$resultado_query_instit = pg_exec($conexion,$ls_sql);
	
	//saca el nombre del alumno
	$ls_sql = "select trim(nombre_alu) || ' ' || trim(ape_pat) || ' ' || trim(ape_mat) from alumno where rut_alumno = $ls_alumno  ";
	$resultado_query_alumno = pg_exec($conexion,$ls_sql);
	
	//SACA EL ID DEL AÑO Y DE LOS PERIODOS
	$ls_sql = "select ano_escolar.id_ano, periodo.id_periodo from ano_escolar inner join periodo using(id_ano) ";
	$ls_sql = $ls_sql . " where ano_escolar.id_institucion = $ls_institucion and ano_escolar.nro_ano = $li_ano;";
	
	//echo "$ls_sql <br><br>";
	$resultado_query_periodo = pg_exec($conexion,$ls_sql);
	$total_filas_periodo = pg_numrows($resultado_query_periodo);
	if($total_filas_periodo>0){
		$li_id_ano = pg_result($resultado_query_periodo, 0,0);
	}
	
	//saca el id_del curso
	$ls_sql = "select curso.id_curso, curso.grado_curso, curso.letra_curso from curso inner join matricula using(id_curso, id_ano) ";
	$ls_sql = $ls_sql . " where matricula.rut_alumno = $ls_alumno and curso.id_ano = $li_id_ano and matricula.rdb = $ls_institucion";
	
	//echo "$ls_sql <br><br>";
	$resultado_query_curso = pg_exec($conexion,$ls_sql);
	$total_filas_curso = pg_numrows($resultado_query_curso);
	if($total_filas_curso>0){
		$li_id_curso = pg_result($resultado_query_curso, 0,0);
	}

	//saca el profesor jefe
	$ls_sql = "select trim(nombre_emp) || ' ' || trim(ape_pat) || ' ' || trim(ape_mat) from empleado inner join supervisa ";
	$ls_sql = $ls_sql . " using(rut_emp) where supervisa.id_curso = $li_id_curso  ;";

	$resultado_query_profe = pg_exec($conexion,$ls_sql);
	$total_filas_profe = pg_numrows($resultado_query_profe);
	if($total_filas_profe>0){
		$ls_nom_profe = pg_result($resultado_query_profe, 0,0);
	}
	
	//ramos, subsectores
	$ls_sql = "select ramo.id_ramo, subsector.cod_subsector, subsector.nombre ";
	$ls_sql = $ls_sql . " from ramo inner join subsector using(cod_subsector) where ramo.id_curso = $li_id_curso";
	
	//echo "$ls_sql <br><br>";
	$resultado_query = pg_exec($conexion,$ls_sql);
	$total_filas = pg_numrows($resultado_query);
	
	$ls_sql = "select promedio, asistencia from promocion where rdb = $ls_institucion and id_ano = $li_id_ano ";
	$ls_sql = $ls_sql . " and id_curso = $li_id_curso and rut_alumno = $ls_alumno";
	
	//echo "$ls_sql <br><br>";
	$resultado_query_prom_ais = pg_exec($conexion,$ls_sql);
	$total_filas_prom_ais = pg_numrows($resultado_query_prom_ais);
	if($total_filas_prom_ais>0){
		$li_prom_final = pg_result($resultado_query_prom_ais,0,0);
		$li_asis_final = pg_result($resultado_query_prom_ais,0,1);
	}
	

//------------------------------------------------------------------------------
	

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
	
	

?>
<html>
<head>
<title>Rpt14</title>
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
if($total_filas>0){
?>

<table width="670" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="titulos"> <div id="capa0" align="right"> 
        <input 
		name="cmdimprimiroriginal2" 
		type="button" 
		class="cb_submit_9_x_75" 
		id="cmdimprimiroriginal2" 
		onclick="imprimir();" 
		value="Imprimir">
      </div></td>
  </tr>
  <tr> 
    <td class="titulos"><font size="3">Informe de Notas Parciales</font></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td class="textosgrande">Colegio : <?print pg_result($resultado_query_instit, 0, 0);?></td>
  </tr>
  <tr> 
    <td class="textosgrande">Nombre Alumno : <?print pg_result($resultado_query_alumno, 0, 0);?> 
    </td>
  </tr>
  <tr> 
    <td class="textosgrande">Curso Alumno : <?print pg_result($resultado_query_curso, 0,1);?> 
      <?print pg_result($resultado_query_curso, 0,2);?> </td>
  </tr>
</table>
<br>
<?
for($i=0;$i<$total_filas_periodo;$i++){
?>
<table width="670" border="1" align="center" cellpadding="0" cellspacing="0">
  <?
  for($j=0;$j<$total_filas;$j++){
  ?>
  <tr class="texto8px"> 
    <td width="250"><? Print pg_result($resultado_query, $j, 2); ?></td>
    <?
		$ls_sql = "select * from notas 	where rut_alumno = $ls_alumno and id_periodo = ";
		$ls_sql = $ls_sql . pg_result($resultado_query_periodo, $i, 1); 
		$ls_sql = $ls_sql . " and id_ramo = ".pg_result($resultado_query, $j, 0);
		//echo "$ls_sql <br>";
		$resultado_query_notas= pg_exec($conexion,$ls_sql);
		$total_filas_notas= pg_numrows($resultado_query_notas);
		if($total_filas_notas>0){
			for($z=0;20>$z;$z++){
				echo "<td width='15'>";
				if(pg_result($resultado_query_notas, 0, $z+3)==0){
					echo "&nbsp;";
				}else{
					print pg_result($resultado_query_notas, 0, $z+3);
				}
				echo "</td>";
			}
		}else{
			for($z=0;20>$z;$z++){
				echo "<td width='15'>&nbsp;</td>";			
			}
		}
		?>
  </tr>
  <?
  }
  ?>
  <tr class="texto8px"> 
    <td colspan="21"><div align="right">Promedio Periodo:</div></td>
  </tr>
  <tr class="texto8px"> 
    <td colspan="21"><div align="right">aSISTENCIA pERIODO: </div></td>
  </tr>
</table>
<br>
<font size="2" face="Verdana, Arial, Helvetica, sans-serif">
<hr width="670">
</font><br>

<?
}

pg_close($conexion);
?>
<table width="670" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="textosmediano"> 
    <td colspan="2"> <div align="right">Promedio General :<?=($li_prom_final);?> 
      </div></td>
  </tr>
  <tr class="textosmediano"> 
    <td colspan="2"> <div align="right">Asistencia General :<?=($li_asis_final);?>% 
      </div></td>
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
    <td><div align="center"> <?=($ls_nom_profe);?> 
       
        <br>
        (Profesor(a) Jefe) </div></td>
    <td><div align="center">
        <?=($ls_nom_dire)?>
        <br>
        (Director(a)) </div></td>
  </tr>
</table>
<?
}
?>
</body>
</html>
