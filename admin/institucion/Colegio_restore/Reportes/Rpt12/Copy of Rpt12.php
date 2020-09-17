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

//-------------------------------------
if($tipo_ense==110){
	$ls_nom_tipo = "Enseñanza Basica";
}
elseif($tipo_ense==310){
	$ls_nom_tipo = "Enseñanza Media Humanista - Cientifica";
}
elseif($tipo_ense==410){
	$ls_nom_tipo = "Enseñanza Media Técnico - Profesional Comercial";
}
elseif($tipo_ense==510){
	$ls_nom_tipo = "Enseñanza Media Técnico - Profesional Industrial";
}
//-------------------------------------

// saca las notas		
	$ls_sql = "select subsector.nombre, situacion_final.nota_final, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from ";
	$ls_sql = $ls_sql . "situacion_final, ramo, subsector, curso, ano_escolar, supervisa, empleado where situacion_final.id_ramo = ";
	$ls_sql = $ls_sql . " ramo.id_ramo and situacion_final.id_ramo = ramo.id_ramo and ramo.cod_subsector = subsector.cod_subsector  ";
	$ls_sql = $ls_sql . "and ramo.id_curso = curso.id_curso and curso.id_ano = ano_escolar.id_ano and curso.id_curso = ";
	$ls_sql = $ls_sql . "supervisa.id_curso and empleado.rut_emp = supervisa.rut_emp ";
	$ls_sql = $ls_sql . "and rut_alumno = $ls_alumno and ano_escolar.nro_ano = $li_ano ";
	$ls_sql = $ls_sql . "and curso.ensenanza = $tipo_ense order by ramo.id_ramo;";
	
//echo "$ls_sql";
	
	$resultado_query= pg_exec($conexion,$ls_sql);
	$total_filas= pg_numrows($resultado_query);
	
/* 	For ($j=0; $j < $total_filas; $j++){
		print pg_result($resultado_query, $j, 0);
		echo "<br>";
	} */
	
		
// saca la region, ciudad, provincia
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

//saca el promedio gral la asistencia y la situacion final del alumno
	$ls_sql = "select promocion.promedio, promocion.asistencia, promocion.situacion_final ";
	$ls_sql = $ls_sql . "from promocion, ano_escolar ";
	$ls_sql = $ls_sql . "where promocion.id_ano = ano_escolar.id_ano ";
	$ls_sql = $ls_sql . "and promocion.rdb = $ls_institucion ";
	$ls_sql = $ls_sql . "and promocion.rut_alumno = $ls_alumno ";
	$ls_sql = $ls_sql . "and ano_escolar.nro_ano = $li_ano; ";

	$resultado_query_abajo= pg_exec($conexion,$ls_sql);
	$total_filas_abajo = pg_numrows($resultado_query_abajo);

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
	$ls_sql = $ls_sql . "and ano_escolar.nro_ano = $li_ano; ";

	$resultado_query_cabecera= pg_exec($conexion,$ls_sql);
	$total_filas_cabecera = pg_numrows($resultado_query_cabecera);


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


	
	pg_close($conexion);

?>
<?
//funciones para convertir de numeros a palabras.
function words999 ($number, $zero=false) { 

//if ($zero and $number*1==0) return false; 

$digits = array ( 0 => "cero", 
1 => "uno", 
2 => "dos", 
3 => "tres", 
4 => "cuatro", 
5 => "cinco", 
6 => "seis", 
7 => "siete", 
8 => "ocho", 
9 => "nueve", 
10 => "diez", 
11 => "once", 
12 => "doce", 
13 => "trece", 
14 => "catorce", 
15 => "quince", 
20 => "veinte", 
30 => "treinta", 
40 => "cuarenta", 
50 => "cincuenta", 
60 => "sesenta", 
70 => "setenta", 
80 => "ochenta", 
90 => "noventa", 
100 => "ciento", 
200 => "doscientas", 
300 => "trescientas", 
400 => "cuatrocientas", 
500 => "quinientas", 
600 => "seiscientas", 
700 => "setecientas", 
800 => "ochocientas", 
900 => "novecientas" ); 

if (strlen($number)==1 or $number=='10'): 

$words = $digits [$number*1]; 

elseif (strlen($number)==2 and ($number * 1) <= 15): 

$words = $digits [$number*1]; 

elseif (strlen($number)==2 and ($number * 1) <= 19): 

$words = 'dieci'.$digits [substr($number,1,1)]; 

elseif (strlen($number)==2 and ($number * 1) <= 99): 

$left = substr ($number,0,1)*10; 
$right = substr ($number,1,1); 
$words = $digits [$left].($right ? ' coma '.$digits [$right]:''); 

elseif (strlen($number)==3): 

$left = substr($number,0,1)*100; 
$right = words999 (substr($number,1,2) * 1, true); 
$words = $digits[$left].($right ? ' '.$right : ''); 

endif; 

return $words; 
} 


function num_to_words ($number) { 

# enteros y centemos 
$parts = floor($number); 
$cents = substr (number_format($number,2),-2,2); 

# enteros en 3 partes 
$part1 = number_format( $parts % 1000 ,0); 
$part2 = number_format((($parts % 1000000) - $part1 ) / 1000 ,0); 
$part3 = number_format((($parts % 1000000000) - $part1 - $part2*1000) / 1000000,0); 

# convertir los 3 partes 
$_part1 = words999 ($part1, true); 
$_part2 = words999 ($part2, true); 
$_part3 = words999 ($part3, true); 

# construct 
$words = substr($part3,0,1)*1 == 1 ? 'Un millon ' : (substr($part3,0,1)*1 >= 2 ? $_part3.' millones ': ''); 
$words .= substr($part2,0,1)*1 >= 1 ? $_part2.' mil ' : ''; 
$words .= $_part1; 

return $words; 
} 

//funciones para convertir de numeros a palabras dos.
function words9992 ($number, $zero=false) { 

//if ($zero and $number*1==0) return false; 

$digits = array ( 0 => "cero", 
1 => "uno", 
2 => "dos", 
3 => "tres", 
4 => "cuatro", 
5 => "cinco", 
6 => "seis", 
7 => "siete", 
8 => "ocho", 
9 => "nueve", 
10 => "diez", 
11 => "once", 
12 => "doce", 
13 => "trece", 
14 => "catorce", 
15 => "quince", 
20 => "veinte", 
30 => "treinta", 
40 => "cuarenta", 
50 => "cincuenta", 
60 => "sesenta", 
70 => "setenta", 
80 => "ochenta", 
90 => "noventa", 
100 => "ciento", 
200 => "doscientas", 
300 => "trescientas", 
400 => "cuatrocientas", 
500 => "quinientas", 
600 => "seiscientas", 
700 => "setecientas", 
800 => "ochocientas", 
900 => "novecientas" ); 

if (strlen($number)==1 or $number=='10'): 

$words = $digits [$number*1]; 

elseif (strlen($number)==2 and ($number * 1) <= 15): 

$words = $digits [$number*1]; 

elseif (strlen($number)==2 and ($number * 1) <= 19): 

$words = 'dieci'.$digits [substr($number,1,1)]; 

elseif (strlen($number)==2 and ($number * 1) <= 99): 

$left = substr ($number,0,1)*10; 
$right = substr ($number,1,1); 
$words = $digits [$left].($right ? ' y '.$digits [$right]:''); 

elseif (strlen($number)==3): 

$left = substr($number,0,1)*100; 
$right = words9992 (substr($number,1,2) * 1, true); 
$words = $digits[$left].($right ? ' '.$right : ''); 

endif; 

return $words; 
} 


function num_to_words2 ($number) { 

# enteros y centemos 
$parts = floor($number); 
$cents = substr (number_format($number,2),-2,2); 

# enteros en 3 partes 
$part1 = number_format( $parts % 1000 ,0); 
$part2 = number_format((($parts % 1000000) - $part1 ) / 1000 ,0); 
$part3 = number_format((($parts % 1000000000) - $part1 - $part2*1000) / 1000000,0); 

# convertir los 3 partes 
$_part1 = words9992 ($part1, true); 
$_part2 = words9992 ($part2, true); 
$_part3 = words9992 ($part3, true); 

# construct 
$words = substr($part3,0,1)*1 == 1 ? 'Un millon ' : (substr($part3,0,1)*1 >= 2 ? $_part3.' millones ': ''); 
$words .= substr($part2,0,1)*1 >= 1 ? $_part2.' mil ' : ''; 
$words .= $_part1; 

return $words; 
} 
?>
<html>
<head>
<title>rpt12</title>
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
if ($total_filas > 0)  
{
?>
<table width="670" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr>
 <td colspan="2">
	<div id="capa0" align="right"> 
        <input 
		name="cmdimprimiroriginal" 
		type="button" 
		class="cb_submit_9_x_75" 
		id="cmdimprimiroriginal" 
		onclick="imprimir();" 
		value="Imprimir">
      </div>
 </td>
 </tr>
  <tr> 
    <td width="61%" rowspan="4" class="titulos"> <div align="center"><font size="3">CERTIFICADO 
        ANUAL DE ESTUDIOS<br>
        <?=($ls_nom_tipo)?>
        </font></div></td>
    <td width="39%" class="textos">REGI&Oacute;N : <?print Trim(pg_result($resultado_query_arriba, 0, 0));?></td>
  </tr>
  <tr> 
    <td class="textos">PROVINCIA : <?print Trim(pg_result($resultado_query_arriba, 0, 1));?></td>
  </tr>
  <tr> 
    <td class="textos">COMUNA : <?print Trim(pg_result($resultado_query_arriba, 0, 2));?></td>
  </tr>
  <tr> 
    <td class="textos">A&Ntilde;O ESCOLAR : <?print $li_ano;?></td>
  </tr>
</table>
<br>
<table width="670" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="textosgrande"><u><?print Trim(pg_result($resultado_query_cabecera, 0, 0));?></u> 
      reconocido oficialmente por el ministerio de educaci&oacute;n de chile seg&uacute;n 
      decreto <u><?print Trim(pg_result($resultado_query_cabecera, 0, 1));?></u> n&ordm; 
     <u> <?print Trim(pg_result($resultado_query_cabecera, 0, 2));?></u> rol base datos 
      n&ordm; <u><?print Trim(pg_result($resultado_query_cabecera, 0, 3));?></u>, otorga 
      el presente certificado de calificaciones anuales y situaci&oacute;n final 
      a don(a) <u><?print Trim(pg_result($resultado_query_cabecera, 0, 4));?></u> r.u.n 
     <u> <?print Trim(pg_result($resultado_query_cabecera, 0, 5));?></u>, del <u><?print Trim(pg_result($resultado_query_cabecera, 0, 6));?></u> 
      a&ntilde;o de 
      <u><?=($ls_nom_tipo)?></u>
      de acuerdo al plan de estudios aprobado por decreto <u><?print Trim(pg_result($resultado_query_cabecera, 0, 7));?> </u>
      n&ordm; <u><?print Trim(pg_result($resultado_query_cabecera, 0, 8));?></u> reglamento 
      de evaluaci&oacute;n y promoci&oacute;n escolar dto. exento n&ordm; </u>
	  <?print Trim(pg_result($resultado_query_cabecera, 0, 10));?></u></td>
  </tr>
</table>
<br>

<table width="670" border="1" align="center" cellpadding="3" cellspacing="3">
  <tr> 
    <td width="423" rowspan="2" class="titulos">SUBSECTOR, ASIGNATURAS O ACTIVIDADES 
      DE APRENDIZAJE</td>
    <td colspan="2" class="titulos">CALIFICACI&Oacute;N ANUAL</td>
  </tr>
  <tr> 
    <td width="59" class="textos"><div align="center"><strong>CIFRAS</strong></div></td>
    <td width="310" class="textos"><div align="center"><strong>EN PALABRAS</strong></div></td>
  </tr>
  <?
For ($j=0; $j < $total_filas; $j++)
{
?>
  <tr class="textos"> 
    <td><?print Trim(pg_result($resultado_query, $j, 0));?></td>
    <td><?print Trim(number_format(pg_result($resultado_query, $j, 1)/10,1));?></td>
    <td><?
	print num_to_words(substr(pg_result($resultado_query, $j, 1),0,1));
	echo " coma ";
	print num_to_words(substr(pg_result($resultado_query, $j, 1),1,1));
	//num_to_words2((pg_result($resultado_query, $j, 1)/10))
	?></td>
  </tr>
  <?
}
?>
  <tr class="textos"> 
    <td><strong>Promedio General</strong></td>
    <td><?print Trim(pg_result($resultado_query_abajo, 0, 0)/10);?></td>
    <td><?
	print num_to_words(substr(pg_result($resultado_query_abajo, 0, 0),0,1));
	echo " coma ";
	print num_to_words(substr(pg_result($resultado_query_abajo, 0, 0),1,1));	
	?>
	</td>
  </tr>
  <tr class="textos"> 
    <td><strong>Porcentaje de asistencia</strong></td>
    <td><?print Trim(pg_result($resultado_query_abajo, 0, 1));?>%</td>
    <td><?print num_to_words2(pg_result($resultado_query_abajo, 0, 1));?> Por ciento</td>
  </tr>
  <tr class="textos"> 
    <td colspan="3"><strong>situacion final 
	<u>
      <?
			if (pg_result($resultado_query_abajo, 0, 2) == 1)
				{echo "Aprobado";}
			elseif (pg_result($resultado_query_abajo, 0, 2) == 2)
				{echo "Reprobado";}
			elseif (pg_result($resultado_query_abajo, 0, 2) == 3)
				{echo "Retirado";}
		?>
		</u>
      </strong></td>
  </tr>
</table>
<br>
<table width="670" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td colspan="2" class="textosmediano">
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
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td width="400"><div align="center">___________________________</div></td>
    <td width="400"><div align="center">___________________________</div></td>
  </tr>
  <tr class="textosdiminuto"> 
    <td><div align="center">
	<?print pg_result($resultado_query, 0, 2);?> <?print pg_result($resultado_query, 0, 3);?>  <?print pg_result($resultado_query, 0, 4);?> <br>
        Profesor(a) Jefe
        
      </div></td>
    <td valign="top"> <div align="center"><?=($ls_nom_dire)?><br>(Director(a) del Establecimiento)
</div></td>
  </tr>
</table>
<?
}else{

echo "<br><br><br><br><br>"
?>
<table width="650" border="1" align="center" cellpadding="1" cellspacing="1">
  <tr>
    <td class="titulos">No se han encontrado datos para el criterio especificado</td>
  </tr>
</table>
<?
}
?>

</body>
</html>
