<?include"../Coneccion/conexion.php"?>
<?
set_time_limit(1000);
	$li_curso = $_GET["ai_curso"];
	$ls_letra = $_GET["as_letra"];
	$li_tipo_ense = $_GET["ai_tipo_ense"];
	$li_ano = $_GET["ai_ano"];
	$ls_institucion    = $_GET["as_institucion"];
	$li_id_ano = 0;
	$li_id_curso = 0;


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
	
//------------------------------------------------------------------------------
	//saca el nombre de la institucion
	$ls_sql = "select institucion.nombre_instit from institucion where rdb = $ls_institucion ";
	$resultado_query_instit = pg_exec($conexion,$ls_sql);
	
	$ls_sql = "select ano_escolar.id_ano, periodo.id_periodo from ano_escolar inner join periodo using(id_ano) ";
	$ls_sql = $ls_sql . " where ano_escolar.id_institucion = $ls_institucion and ano_escolar.nro_ano = $li_ano order by periodo.id_periodo;";
	
	//echo "$ls_sql <br><br>";
	//SACA EL ID DEL A�O Y DE LOS PERIODOS
	$resultado_query_periodo = pg_exec($conexion,$ls_sql);
	$total_filas_periodo = pg_numrows($resultado_query_periodo);
	if($total_filas_periodo>0){
		$li_id_ano = pg_result($resultado_query_periodo, 0,0);
	}

	//saca el id_del curso
	$ls_sql = "select curso.id_curso, curso.grado_curso, curso.letra_curso from curso inner join matricula using(id_curso, id_ano) ";
	$ls_sql = $ls_sql . " where curso.id_ano = $li_id_ano and matricula.rdb = $ls_institucion and curso.grado_curso = $li_curso";
	$ls_sql = $ls_sql . " and curso.letra_curso = '$ls_letra' and curso.ensenanza = $li_tipo_ense";
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
	$ls_sql = "select ramo.id_ramo, subsector.cod_subsector, subsector.nombre, ramo.truncado ";
	$ls_sql = $ls_sql . " from ramo inner join subsector using(cod_subsector) where ramo.id_curso = $li_id_curso";
	
	//echo "$ls_sql <br><br>";
	$resultado_query = pg_exec($conexion,$ls_sql);
	$total_filas = pg_numrows($resultado_query);

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
	

//--------------------------------------------------------------------------------------

	

//------------------------------------------------------------------------------
	

	

?>
<html>
<head>
<title>Rpt14</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<script>

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
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
</table>
<?
if($total_filas>0){
for ($li_row=0;$li_row<$total_filas_alumnos;$li_row++){

	//saca el nombre del alumno
	$ls_sql = "select trim(nombre_alu) || ' ' || trim(ape_pat) || ' ' || trim(ape_mat) from alumno where rut_alumno =".pg_result($resultado_query_alumnos, $li_row, 0);
	$resultado_query_alumno = pg_exec($conexion,$ls_sql);
	
		
	//saca el promedio y asistencia final del alumno
	$ls_sql = "select promedio, asistencia from promocion where rdb = $ls_institucion and id_ano = $li_id_ano ";
	$ls_sql = $ls_sql . " and id_curso = $li_id_curso and rut_alumno =".pg_result($resultado_query_alumnos, $li_row, 0);
	
	//echo "$ls_sql <br><br>";
	$resultado_query_prom_ais = pg_exec($conexion,$ls_sql);
	$total_filas_prom_ais = pg_numrows($resultado_query_prom_ais);
	if($total_filas_prom_ais>0){
		$li_prom_final = pg_result($resultado_query_prom_ais,0,0);
		$li_asis_final = pg_result($resultado_query_prom_ais,0,1);
	}

?>

<table width="670" border="0" align="center" cellpadding="0" cellspacing="0">
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
  <tr class="textos"> 
    <td width="250">Subsectores</td>
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
    <td width="15">Prom</td>
 
 </tr>
  <?
  $prom_gen = 0;
  $cont_gen = 0;
  $sw = 0;
  for($j=0;$j<$total_filas;$j++){
  ?>
  <tr class="texto8px"> 
    <td width="250"><? Print pg_result($resultado_query, $j, 2); 
	$sw = pg_result($resultado_query, $j, 3);
	?></td>
    <?
		$ls_sql = "select * from notas 	where rut_alumno = ". pg_result($resultado_query_alumnos, $li_row, 0) ." and id_periodo = ";
		$ls_sql = $ls_sql . pg_result($resultado_query_periodo, $i, 1); 
		$ls_sql = $ls_sql . " and id_ramo = ".pg_result($resultado_query, $j, 0);
		//echo "$ls_sql <br>";
		$resultado_query_notas= pg_exec($conexion,$ls_sql);
		$total_filas_notas= pg_numrows($resultado_query_notas);
		if($total_filas_notas>0){
			for($z=0;21>$z;$z++){
				echo "<td width='15'>";
				if(pg_result($resultado_query_notas, 0, $z+3)==0){
					echo "&nbsp;";
				}else{
					print pg_result($resultado_query_notas, 0, $z+3);
					if ($z == 20)
					{
					  if (pg_result($resultado_query_notas, 0, 23)>0)
					  {
					  	$prom_gen = $prom_gen + pg_result($resultado_query_notas, 0, 23);
						$cont_gen = $cont_gen + 1;
					  }
					}
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
    <td colspan="22" ><div align="right">Promedio Periodo:
	<?
	if ($cont_gen>0)
	{
	if ($sw == 1) $prom_gen = round(($prom_gen / $cont_gen)/10,1);
	if ($sw == 0) $prom_gen = floor(($prom_gen / $cont_gen))/10; 
	echo $prom_gen;
	}
	
			$ls_sql = " select periodo.id_periodo, periodo.nombre_periodo,periodo.fecha_inicio, periodo.fecha_termino ,";
	$ls_sql = $ls_sql . " to_char(periodo.fecha_inicio,'yyyymmdd'), to_char(periodo.fecha_termino,'yyyymmdd'), ";
	$ls_sql = $ls_sql . " periodo.dias_habiles, ano_escolar.nro_ano, ano_escolar.id_ano";
	$ls_sql = $ls_sql . " from periodo, ano_escolar, matricula";
	$ls_sql = $ls_sql . " where matricula.id_ano = ano_escolar.id_ano  ";
	$ls_sql = $ls_sql . " and ano_escolar.id_ano = periodo.id_ano ";
	$ls_sql = $ls_sql . " and ano_escolar.nro_ano = $li_ano";
	$ls_sql = $ls_sql . " and matricula.rut_alumno = ". pg_result($resultado_query_alumnos, $li_row, 0) ."and matricula.rdb = $ls_institucion";
	$ls_sql = $ls_sql . " order by periodo.id_periodo";
 	
	//echo "$ls_sql";
	
	$resultado_query_fecha = pg_exec($conexion,$ls_sql);
	$total_filas_fecha= pg_numrows($resultado_query_fecha);
	
	$ls_coma = "";
	For ($j=0; $j < $total_filas_fecha; $j++)
		{
			$ldt_fehca_ini =  substr(pg_result($resultado_query_fecha, $j, 4),4,2)."/".substr(pg_result($resultado_query_fecha, $j, 4),6,2)."/".substr(pg_result($resultado_query_fecha, $j, 4),0,4);
			$ldt_fehca_fin =  substr(pg_result($resultado_query_fecha, $j, 5),4,2)."/".substr(pg_result($resultado_query_fecha, $j, 5),6,2)."/".substr(pg_result($resultado_query_fecha, $j, 5),0,4);
			if ($j == 1){
			   $ls_coma = ","; 
			}
			$ls_sum_case = $ls_sum_case . $ls_coma . "Sum((case when fecha >='".$ldt_fehca_ini;
			$ls_sum_case = $ls_sum_case . "' and fecha <= '".$ldt_fehca_fin;
			$ls_sum_case = $ls_sum_case . "' then 1 else 0 end)) as p".$j;
						
			$ls_coma = ",";
		}
	
if($total_filas>0){
	$ls_sql = " select $ls_sum_case ";
	$ls_sql = $ls_sql . " from asistencia where asistencia.rut_alumno =". pg_result($resultado_query_alumnos, $li_row, 0) ." and ";
	$ls_sql = $ls_sql . " asistencia.ano = ".pg_result($resultado_query_fecha, 0, 8);
	$resultado_query_asistencia = pg_exec($conexion,$ls_sql);
	$total_filas_asistencia= pg_numrows($resultado_query_asistencia);
}

	
	?>
	
	</div></td>
  </tr>
  <tr class="texto8px"> 
    <td colspan="22"><div align="right">INASISTENCIA:<? print number_format((pg_result($resultado_query_asistencia, 0, $x)/pg_result($resultado_query_fecha, $x, 6))*100,0);?>% 
 </div></td>
  </tr>
</table>
<br>
<font size="2" face="Verdana, Arial, Helvetica, sans-serif">
<hr width="670">
</font><br>

<?
}

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
<H1 class=SaltoDePagina>&nbsp;</H1>
<?
}
}
pg_close($conexion);

?>
</body>
</html>
