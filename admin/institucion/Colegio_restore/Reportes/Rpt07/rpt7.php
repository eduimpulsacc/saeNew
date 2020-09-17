<?include"../Coneccion/conexion.php"?>
<?
	$li_curso = $_GET["ai_curso"];
	$ls_letra = $_GET["as_letra"];
	$li_tipo_ense = $_GET["ai_tipo_ense"];
	$li_ano = $_GET["ai_ano"];
	$ls_institucion    = $_GET["as_institucion"];
	
	//echo "--> $ls_criterio <br> --> $ls_input <br> --> $ls_institucion  <br> --> ";
	//**************************************************
	If(Trim($ls_institucion) == '')
	{
		$ls_institucion=0;
		$li_curso = 0;
		$ls_letra = 0;
		$li_tipo_ense = 0;
		$li_ano = 0;
	}
	//-------------------------------------------------------------------------------------------------------------------
	//selecciona los codigos de ramos que tiene el curso
	$ls_sql = " select ramo.id_ramo, subsector.nombre, curso.id_curso, ano_escolar.id_ano ";
	$ls_sql = $ls_sql . " from curso, ano_escolar, ramo, subsector ";
	$ls_sql = $ls_sql . " where curso.ensenanza = $li_tipo_ense";
	$ls_sql = $ls_sql . " and curso.grado_curso = $li_curso";
	$ls_sql = $ls_sql . " and curso.letra_curso = '$ls_letra'";
	$ls_sql = $ls_sql . " and curso.id_ano = ano_escolar.id_ano";
	$ls_sql = $ls_sql . " and ano_escolar.id_institucion = $ls_institucion";
	$ls_sql = $ls_sql . " and ano_escolar.nro_ano = $li_ano ";
	$ls_sql = $ls_sql . " and curso.id_curso = ramo.id_curso";
	$ls_sql = $ls_sql . " and ramo.cod_subsector = subsector.cod_subsector";
	$ls_sql = $ls_sql . " order by ramo.id_ramo";
	
	//echo "$ls_sql";
	
	$resultado_query_ramos= pg_exec($conexion,$ls_sql);
	$total_filas_ramos= pg_numrows($resultado_query_ramos);

	//crea parte de la consulta
	For ($j=0; $j < $total_filas_ramos; $j++)
		{
			$ls_sum_case = $ls_sum_case . ",Sum((case when situacion_final.id_ramo =".pg_result($resultado_query_ramos, $j, 0);
			$ls_sum_case = $ls_sum_case . "then situacion_final.nota_final else 0 end)) as N".$j;			
		}

    //--------------------------------------------------------------------------------------------------------------------
	//selecciona cuerpo
	$ls_sql = "select alumno.rut_alumno, alumno.dig_rut, alumno.ape_pat, alumno.ape_mat, ";
	$ls_sql = $ls_sql . " alumno.nombre_alu, comuna.nom_com, alumno.sexo, alumno.fecha_nac ";
	$ls_sql = $ls_sql . $ls_sum_case;
	$ls_sql = $ls_sql . " from curso, tipo_ensenanza, ano_escolar, matricula, alumno, comuna, situacion_final ";
	$ls_sql = $ls_sql . " where curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$ls_sql = $ls_sql . " and curso.id_ano = ano_escolar.id_ano ";
	$ls_sql = $ls_sql . " and curso.id_ano = matricula.id_ano ";
	$ls_sql = $ls_sql . " and curso.id_curso = matricula.id_curso ";
	$ls_sql = $ls_sql . " and matricula.rut_alumno = alumno.rut_alumno ";
	$ls_sql = $ls_sql . " and alumno.rut_alumno = situacion_final.rut_alumno";
	$ls_sql = $ls_sql . " and alumno.region = comuna.cod_reg ";
	$ls_sql = $ls_sql . " and alumno.ciudad = comuna.cor_pro ";
	$ls_sql = $ls_sql . " and alumno.comuna = comuna.cor_com ";
	$ls_sql = $ls_sql . " and matricula.rdb = $ls_institucion ";
	$ls_sql = $ls_sql . " and curso.grado_curso = $li_curso ";
	$ls_sql = $ls_sql . " and curso.letra_curso = '$ls_letra' ";
	$ls_sql = $ls_sql . " and tipo_ensenanza.cod_tipo = $li_tipo_ense ";
	$ls_sql = $ls_sql . " and ano_escolar.nro_ano = $li_ano ";
	$ls_sql = $ls_sql . " group by alumno.rut_alumno, alumno.dig_rut, alumno.ape_pat, alumno.ape_mat, ";
	$ls_sql = $ls_sql . " alumno.nombre_alu, comuna.nom_com, alumno.sexo, alumno.fecha_nac";
	$ls_sql = $ls_sql . " order by alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu";

	//echo "$ls_sql";

	$resultado_query= pg_exec($conexion,$ls_sql);
	$total_filas= pg_numrows($resultado_query);
	
	//----------------------------------------------------------------------------------------------------------------------
	//cabecera
	$ls_sql = " select institucion.nombre_instit, plan_estudio.nombre_decreto,"; 
	$ls_sql = $ls_sql . " plan_estudio.cod_decreto, evaluacion.nombre_decreto_eval, evaluacion.cod_eval,";
	$ls_sql = $ls_sql . " institucion.rdb, comuna.nom_com, region.nom_reg, provincia.nom_pro";
	$ls_sql = $ls_sql . " from curso, plan_estudio, evaluacion, matricula, institucion, comuna, region, provincia";
	$ls_sql = $ls_sql . " where matricula.rdb = institucion.rdb";
	$ls_sql = $ls_sql . " and matricula.id_curso = curso.id_curso";
	$ls_sql = $ls_sql . " and institucion.comuna = comuna.cor_com";
	$ls_sql = $ls_sql . " and institucion.region = region.cod_reg";
	$ls_sql = $ls_sql . " and institucion.ciudad = provincia.cor_pro";
	$ls_sql = $ls_sql . " and comuna.cor_pro = provincia.cor_pro";
	$ls_sql = $ls_sql . " and comuna.cod_reg = region.cod_reg";
	$ls_sql = $ls_sql . " and provincia.cod_reg = region.cod_reg";
	$ls_sql = $ls_sql . " and curso.cod_decreto = plan_estudio.cod_decreto";
	$ls_sql = $ls_sql . " and curso.cod_eval = evaluacion.cod_eval";
	$ls_sql = $ls_sql . " and institucion.rdb = $ls_institucion";
	$ls_sql = $ls_sql . " and matricula.id_ano = 12";
	$ls_sql = $ls_sql . " and curso.ensenanza = $li_tipo_ense";
	$ls_sql = $ls_sql . " and curso.grado_curso = $li_curso";
	$ls_sql = $ls_sql . " and curso.letra_curso = '$ls_letra'";
	$ls_sql = $ls_sql . " group by institucion.nombre_instit, plan_estudio.nombre_decreto, ";
	$ls_sql = $ls_sql . " plan_estudio.cod_decreto, evaluacion.nombre_decreto_eval, evaluacion.cod_eval,";
	$ls_sql = $ls_sql . " institucion.rdb, comuna.nom_com, region.nom_reg, provincia.nom_pro";
	
	$resultado_query_cabecera= pg_exec($conexion,$ls_sql);
	$total_filas_cabecera= pg_numrows($resultado_query_cabecera);
	
// decretos

	$ls_sql = " select institucion.nombre_instit, plan_estudio.cod_decreto, plan_estudio.nombre_decreto,";
	$ls_sql = $ls_sql . " institucion.rdb, plan_estudio.cod_decreto, plan_estudio.nombre_decreto, evaluacion.cod_eval, ";
	$ls_sql = $ls_sql . " evaluacion.nombre_decreto_eval";
	$ls_sql = $ls_sql . " from institucion, matricula, curso, ano_escolar, evaluacion, plan_estudio";
	$ls_sql = $ls_sql . " where institucion.rdb = matricula.rdb ";
	$ls_sql = $ls_sql . " and curso.id_curso = matricula.id_curso";
	$ls_sql = $ls_sql . " and ano_escolar.id_ano = matricula.id_ano";
	$ls_sql = $ls_sql . " and curso.cod_decreto = plan_estudio.cod_decreto";
	$ls_sql = $ls_sql . " and curso.cod_eval = evaluacion.cod_eval";
	$ls_sql = $ls_sql . " and institucion.rdb = $ls_institucion";
	$ls_sql = $ls_sql . " and ano_escolar.nro_ano = $li_ano";
	$ls_sql = $ls_sql . " and curso.grado_curso = $li_curso";
	$ls_sql = $ls_sql . " and curso.letra_curso = '$ls_letra'";
	$ls_sql = $ls_sql . " group by institucion.nombre_instit, plan_estudio.cod_decreto, plan_estudio.nombre_decreto,";
	$ls_sql = $ls_sql . " institucion.rdb, plan_estudio.cod_decreto, plan_estudio.nombre_decreto, evaluacion.cod_eval, ";
	$ls_sql = $ls_sql . " evaluacion.nombre_decreto_eval;";
	
	$resultado_query_decretos= pg_exec($conexion,$ls_sql);
	$total_filas_decretos= pg_numrows($resultado_query_decretos);
	
	if($total_filas_ramos>0){
		$li_id_curso = pg_result($resultado_query_ramos, 0, 2);
		$li_ano_escolar = pg_result($resultado_query_ramos, 0, 3);
	}else{
		$li_id_curso = 0;
		$li_ano_escolar = 0;
	}
	
// saca los profesores de los subsectores
	$ls_sql = "select subsector.cod_subsector,subsector.nombre, empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, ";
	$ls_sql = $ls_sql . " empleado.ape_pat, empleado.ape_mat  ";
	$ls_sql = $ls_sql . " from curso, ramo, subsector, dicta, empleado ";
	$ls_sql = $ls_sql . " where curso.id_curso = ramo.id_curso ";
	$ls_sql = $ls_sql . " and ramo.cod_subsector = subsector.cod_subsector ";
	$ls_sql = $ls_sql . " and ramo.id_ramo = dicta.id_ramo ";
	$ls_sql = $ls_sql . " and dicta.rut_emp = empleado.rut_emp ";
	$ls_sql = $ls_sql . " and curso.id_curso = $li_id_curso order by empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
	
	//echo "SQL : $ls_sql";

	$resultado_query_profes= pg_exec($conexion,$ls_sql);
	$total_filas_profes = pg_numrows($resultado_query_profes);
	
//*
	$ls_sql = " select ";
	$ls_sql = $ls_sql . " sum(case when to_char(fecha,'yyyymmdd') <= '20020430' then 1 else 0 end) as m01, ";
	$ls_sql = $ls_sql . " sum(case when (to_char(fecha,'yyyymmdd') >= '20020501')  ";
	$ls_sql = $ls_sql . " and (to_char(fecha,'yyyymmdd') <= '20021129') then 1 else 0 end) as m02, ";
	$ls_sql = $ls_sql . " sum(case when to_char(fecha,'yyyymmdd') <= '20021130' then 1 else 0 end) as m03, ";
	$ls_sql = $ls_sql . " sum(case when to_char(fecha,'yyyymmdd') <= '20021130' then 1 else 0 end) as m04 ";
	$ls_sql = $ls_sql . " from matricula ";
	$ls_sql = $ls_sql . " where matricula.rdb= $ls_institucion ";
	$ls_sql = $ls_sql . " and matricula.id_curso = $li_id_curso  ";
	$ls_sql = $ls_sql . " and matricula.id_ano = $li_ano_escolar ";

	$resultado_query_result01= pg_exec($conexion,$ls_sql);
	$total_filas_result01 = pg_numrows($resultado_query_result01);


	$ls_sql = " select sum(case when (to_char(fecha_retiro,'yyyymmdd') >= '20020501') ";
	$ls_sql = $ls_sql . " and (to_char(fecha_retiro,'yyyymmdd') <= '20021129') then 1 else 0 end) as R01,";
	$ls_sql = $ls_sql . " sum(case when situacion_final = 1 then 1 else 0 end) as p01,";
	$ls_sql = $ls_sql . " sum(case when (situacion_final = 2) and (promedio < 40) ";
	$ls_sql = $ls_sql . " and (asistencia >= 85)  then 1 else 0 end) as RI01,";
	$ls_sql = $ls_sql . " sum(case when (situacion_final = 2) and (asistencia < 85) then 1 else 0 end) as RA, ";
	$ls_sql = $ls_sql . " sum(case when situacion_final = 2 Then 1 else 0 end ) as tot_rep from promocion ";
	$ls_sql = $ls_sql . " where rdb = $ls_institucion and id_ano = $li_ano_escolar"; 
	$ls_sql = $ls_sql . " and id_curso = $li_id_curso  ;";
	
	$resultado_query_result02= pg_exec($conexion,$ls_sql);
	$total_filas_result02 = pg_numrows($resultado_query_result02);
	
	
//*******************************

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

//*******************************

$ls_sql = " select empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat ";
$ls_sql = $ls_sql . " from supervisa, empleado  ";
$ls_sql = $ls_sql . " where empleado.rut_emp = supervisa.rut_emp  ";
$ls_sql = $ls_sql . " and supervisa.id_curso = $li_id_curso ";

	$resultado_query_profe_jefe= pg_exec($conexion,$ls_sql);
	$total_filas_profe_jefe= pg_numrows($resultado_query_profe_jefe);
//echo "$ls_sql";
	//pg_close($conexion);

if ($total_filas_dire > 0){
	$ls_nom_profe_jefe = TRIM(pg_result($resultado_query_profe_jefe, 0, 0)) . ' ' . TRIM(pg_result($resultado_query_profe_jefe, 0, 1)) . ' ' . TRIM(pg_result($resultado_query_profe_jefe, 0, 2));
}else{
	$ls_nom_profe_jefe = " ";
}


?>
<html>
<head>
<title>rpt7</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/objeto.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<script>
//document.getElementById("capa4").style.display='none';

function imprimir1() 
{
	document.getElementById("capa0").style.display='none';
	document.getElementById("capa2").style.display='none';
	document.getElementById("capa4").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
	document.getElementById("capa2").style.display='block';
	document.getElementById("capa4").style.display='block';
	
}
function imprimir2() 
{
	document.getElementById("capa0").style.display='none';
	document.getElementById("capa1").style.display='none';
	
	window.print();
	document.getElementById("capa0").style.display='block';
	document.getElementById("capa1").style.display='block';
	//document.getElementById("capa4").style.display='none';
	//if
}
</script>



<?
//echo "$total_filas";
if ($total_filas > 0){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<div id="capa0"> 
        <input 
		name="cmdimprimiroriginal" 
		type="button" 
		class="cb_submit_9_x_100" 
		id="cmdimprimiroriginal" 
		onclick="imprimir1();" 
		value="Imprimir parte1">
        <input 
		name="cmdimprimiroriginal2" 
		type="button" 
		class="cb_submit_9_x_100" 
		id="cmdimprimiroriginal2" 
		onclick="imprimir2();" 
		value="Imprimir parte2">
        <br>
        <br>
      </div>
	</td>
  </tr>
</table>
<div id="capa1">
<table width="1100" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="213" rowspan="2" valign="top" class="textosdiminuto"> <div align="center"><strong>REPUBLICA 
        DE CHILE <br>
        </strong>MINISTERIO DE EDUCACI&Oacute;N<br>
        DIVISI&Oacute;N DE EDUCACI&Oacute;N GENERAL<br>
        SECRETARIA REGIONAL MINISTERIAL<br>
        DE EDUCACION</div></td>
    <td colspan="5" valign="top" class="titulos"> <div align="center"><font size="1"><strong>ACTA 
        DE CALIFICACIONES ANUALES Y PROMOCI&Oacute;N ESCOLAR</strong></font></div></td>
    <td width="344" rowspan="2"> <table width="330" border="1" align="center" cellpadding="0" cellspacing="1">
        <tr> 
          <td> <table width="330" border="0" align="right" cellpadding="0" cellspacing="0">
              <tr > 
                <td width="200" class="textosdiminuto"> <div align="center"><strong> 
                    <?print pg_result($resultado_query_cabecera, 0, 7);?> </strong> 
                  </div></td>
                <td width="200" class="textosdiminuto"> <div align="center"><strong> 
                    <?print pg_result($resultado_query_cabecera, 0, 8);?> </strong> 
                  </div></td>
              </tr>
              <tr > 
                <td class="textosdiminuto"> <div align="center">REGI&Oacute;N</div></td>
                <td class="textosdiminuto"> <div align="center">PROVINCIA</div></td>
              </tr>
              <tr > 
                <td class="textosdiminuto"> <div align="center"><strong> <?print pg_result($resultado_query_cabecera, 0, 6);?> 
                    </strong> </div></td>
                <td class="textosdiminuto"> <div align="center"><strong> <?print $li_ano;?> 
                    </strong> </div></td>
              </tr>
              <tr > 
                <td class="textosdiminuto"> <div align="center">COMUNA</div></td>
                <td class="textosdiminuto"> <div align="center">A&Ntilde;O ESCOLAR</div></td>
              </tr>
              <tr > 
                <td colspan="2" class="textosdiminuto"> <div align="center">CURSO 
                    <strong> 
                    <?=($li_curso)?>
                    &nbsp; 
                    <?=($ls_letra )?>
                    </strong></div></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td colspan="5" valign="top" class="textosdiminuto" ><u> <?print Trim(pg_result($resultado_query_decretos, 0, 0));?> </u>
      reconocido oficialmente por el ministerio de educaci&oacute;n de chile seg&uacute;n 
      decreto <u> <?print Trim(pg_result($resultado_query_decretos, 0, 1));?></u> n&ordm; 
      <u><?print Trim(pg_result($resultado_query_decretos, 0, 2));?></u> rol base datos 
      n&ordm; <u><?print Trim(pg_result($resultado_query_decretos, 0, 3));?></u> , plan 
      de estudios aprobado por decreto <u><?print Trim(pg_result($resultado_query_decretos, 0, 4));?> </u>
      n&ordm; <u><?print Trim(pg_result($resultado_query_decretos, 0, 5));?> </u>y del 
      reglamento de evaluaci&oacute;n y promoci&oacute;n escolar decreto exento 
      n&ordm; <u><?print Trim(pg_result($resultado_query_decretos, 0, 7));?></u> </td>
  </tr>
</table>
<br>
<table width="1100" border="1" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="15"> <img src="../letras/E.gif" width="15" height="15"><br>
      <img src="../letras/V.gif" width="15" height="15"><br>
      <img src="../letras/A.gif" width="15" height="15"><br>
      <img src="../letras/L.gif" width="15" height="15"><br>
      <img src="../letras/C.gif" width="15" height="15"></td>
    <td width="28" class="textosmediano"> 
      <div align="center">N&ordm; </div>
    </td>
    <td > 
      <div align="center"><span class="titulos">N&Oacute;MINA DE ALUMNOS</span><br>
        <span class="textosdiminuto"> (Nombre completo, seg&uacute;n certificados 
        de nacimiento)<br>
        (Orden Alfab&eacute;tico) </span><br>
        <br>
        <span class="textosdiminuto">Apellido Paterno, Apellido Materno, Nombres</span></div>
    </td>
    <td valign="bottom" class="textosmediano"> 
      <div align="center"><strong>R.U.N</strong></div>
    </td>
    <td valign="bottom" class="textosdiminuto"> 
      <div align="center"><strong>SEXO</strong></div>
    </td>
    <td valign="bottom" class="textosmediano"> 
      <div align="center"><strong>Fecha<br>
        Nacimiento </strong></div>
    </td>
    <td valign="bottom" class="textosmediano"> 
      <div align="center"><strong>Comuna <br>
        Residencia</strong></div>
    </td>
    <?
			For ($x=0; $x < $total_filas_ramos; $x++)
			{
			?>
    <td valign="bottom"  class="textosdiminuto"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <?
$ls_string = trim(pg_result($resultado_query_ramos, $x, 1));

$ls_result = split(' ', $ls_string);
$li_cant = count($ls_result);


for($m=0;$m<=$li_cant;$m++){
	if(strlen($ls_result[$m])>3){
	echo "<td> ";
	}
	for($j=0;$j<strlen(trim($ls_result[$m]));$j++)
		{
			if (substr($ls_result[$m],strlen($ls_result[$m])-($j+1),1) == ' '){ 
			 //$ls_var = Trim(strtoupper(substr($ls_string,$j,1)));
				echo "<img src='../letras/ESPACIOENBLANCO.gif' width='7' height='4'>";
			}else{	
				echo "<img src='../letras/".substr($ls_result[$m],strlen($ls_result[$m])-($j+1),1).".gif' width='7' height='7'>";
			}
			//print substr($ls_string,strlen($ls_string)-($j+1),1);
			echo "<br>";
		}
	//echo "<img src='../letras/ESPACIOENBLANCO.gif' width='7' height='4'>";
	if(strlen($ls_result[$m])>3){
	echo "</td> ";	
	}	
}
?>
        </tr>
      </table>
    </td>
    <?
			}
			?>
    <td valign="bottom"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr valign="middle"> 
            <td><img src="../letras/promedio.gif" width="19" height="59"> </td>
          </tr>
        </table>
    </td>
      <td valign="bottom"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr valign="middle"> 
            <td><img src="../letras/calificacion.gif" width="20" height="85"> 
            </td>
          </tr>
        </table></td>
      <td valign="bottom"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr valign="middle"> 
            <td><img src="../letras/porcentaje.gif" width="20" height="77"> </td>
          </tr>
        </table></td>
      <td valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr valign="middle"> 
            <td><img src="../letras/situacion.gif" width="21" height="64"> </td>
          </tr>
        </table> </td>
  </tr>
  <?
	For ($j=0; $j < $total_filas; $j++)
	{
	?>
  <tr > 
    <td class="textosdiminuto">&nbsp;</td>
    <td class="textosdiminuto" height="10"> 
      <?=($j + 1)?>
    </td>
    <td class="textosdiminuto" height="10"> 
      <?print Trim(pg_result($resultado_query, $j, 2));?>
      &nbsp; 
      <?print Trim(pg_result($resultado_query, $j, 3));?>
      &nbsp; 
      <?print Trim(pg_result($resultado_query, $j, 4));?>
      &nbsp; </td>
    <td class="textosdiminuto" height="10"> 
      <?print pg_result($resultado_query, $j, 0);?>
      - 
      <?print pg_result($resultado_query, $j, 1);?>
    </td>
    <td class="textosdiminuto" height="10"> 
      <?print pg_result($resultado_query, $j, 6);?>
    </td>
    <td class="textosdiminuto" height="10"> 
      <?print Trim(pg_result($resultado_query, $j, 7));?>
    </td>
    <td class="textosdiminuto" height="10"> 
      <?print Trim(pg_result($resultado_query, $j, 5));?>
    </td>
    <?
	For ($x=0; $x < $total_filas_ramos; $x++)
	{
	?>
    <td class="textosdiminuto" height="10"> 
      <?print number_format(pg_result($resultado_query, $j, $x + 8)/10,1);?>
    </td>
    <?
	}
	$ls_sql = " select promedio, asistencia, ";
	$ls_sql = $ls_sql . " case when situacion_final= 1 then '1' else ";
	$ls_sql = $ls_sql . " case when situacion_final= 2 then '2' else";
	$ls_sql = $ls_sql . " case when situacion_final= 3 then '3' else '--'";
	$ls_sql = $ls_sql . " end end  end as situacion_final";
	$ls_sql = $ls_sql . " from promocion where promocion.rut_alumno = ".pg_result($resultado_query, $j, 0);
	
	//echo "$ls_sql";
	$resultado_query_temp= pg_exec($conexion,$ls_sql);
	$total_filas_temp = pg_numrows($resultado_query_temp);
	if ($total_filas_temp > 0){
	?>
    <td class="textosdiminuto" height="10"> 
      <?print number_format(pg_result($resultado_query_temp, 0, 0)/10,1);?>
    </td>
    <td class="textosdiminuto" height="10"> 
      <?print number_format(pg_result($resultado_query_temp, 0, 0)/10,1);?>
    </td>
    <td class="textosdiminuto" height="10"> 
      <?print Trim(pg_result($resultado_query_temp, 0, 1));?>
    </td>
    <td class="textosdiminuto" height="10"> 
      <?print Trim(pg_result($resultado_query_temp, 0, 2));?>
    </td>
  </tr>
  <?
  	}else{
  ?>	
    <td class="textosdiminuto" height="10"> 
     0
    </td>
    <td class="textosdiminuto" height="10"> 
      0
    </td>
    <td class="textosdiminuto" height="10"> 
      0
    </td>
    <td class="textosdiminuto" height="10"> 
      0
    </td>
  </tr>

<?	}
}
	?>
</table>

</div>
<p>&nbsp;</p>
<div id="capa2">
  <table width="1000" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="701"><table width="1000" border="1" cellspacing="0" cellpadding="0">
          <tr > 
            <td width="72" class="textosdiminuto"> <div align="center"><strong>Codigo 
                N&ordm; o <br>
                Abreviatura</strong></div></td>
            <td width="232" class="textosmediano"> <div align="center"><strong>Subsector 
                o asignaturas</strong></div></td>
            <td width="323" class="textosmediano"> <div align="center"><strong>Nombre 
                y Apellidos del profesor(A) de la asignatura</strong></div></td>
            <td width="76" class="textosmediano"> <div align="center"><strong>R.U.N</strong></div></td>
            <td width="137" class="textosmediano"> <div align="center"><strong>Titulo/habilitado</strong></div></td>
            <td width="146" class="textosmediano"> <div align="center"><strong>Firma</strong></div></td>
          </tr>
          <?
	For ($j=0; $j < $total_filas_profes; $j++)
	{
	?>
          <tr class="texto8px"> 
            <td height="20"><?print pg_result($resultado_query_profes, $j, 0);?></td>
            <td><?print pg_result($resultado_query_profes, $j, 1);?></td>
            <td><?print pg_result($resultado_query_profes, $j, 5);?> <?print pg_result($resultado_query_profes, $j, 6);?> 
              <?print pg_result($resultado_query_profes, $j, 4);?> </td>
            <td><?print pg_result($resultado_query_profes, $j, 2);?>-<?print pg_result($resultado_query_profes, $j, 3);?></td>
            <td>&nbsp;</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <?
	}
	?>
        </table></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Resultado 
          General del Curso</font></strong><br>
        </div>
        <table width="500" border="1" align="center" cellpadding="0" cellspacing="0">
          <tr class="texto8px"> 
            <td>1.- Matricula al 30 de Abril(inicial)</td>
            <td><?print pg_result($resultado_query_result01, 0, 0);?></td>
          </tr>
          <tr class="texto8px"> 
            <td>2.- Ingresos entre el 1&ordm; de mayo y el 29 de noviembre</td>
            <td><?print pg_result($resultado_query_result01, 0, 1);?></td>
          </tr>
          <tr class="texto8px"> 
            <td>2.- retirados entre el 1&ordm; de mayo y el 29 de noviembre</td>
            <td><?print pg_result($resultado_query_result02, 0, 0);?></td>
          </tr>
          <tr class="texto8px"> 
            <td>3.- matricula al 30 de noviembre</td>
            <td><?print pg_result($resultado_query_result01, 0, 2);?></td>
          </tr>
          <tr class="texto8px"> 
            <td>4.- promovidos</td>
            <td><?print pg_result($resultado_query_result02, 0, 1);?></td>
          </tr>
          <tr class="texto8px"> 
            <td>6.- Reprobados Por<br> &nbsp;&nbsp;&nbsp;&nbsp; 6.1.- Inassitencia<br> 
              &nbsp;&nbsp;&nbsp;&nbsp; 6.2.- Rendimeinto</td>
            <td><br> <?print pg_result($resultado_query_result02, 0, 3);?><br> 
              <?print pg_result($resultado_query_result02, 0, 2);?> </td>
          </tr>
          <tr class="texto8px"> 
            <td>Total de reprobados</td>
            <td><?print pg_result($resultado_query_result02, 0, 4);?></td>
          </tr>
        </table></td>
    </tr>
  </table>
</div><br>
<br>
<div id="capa4" >
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="300"><div align="center">___________________________</div></td>
    <td width="300"><div align="center">___________________________</div></td>
  </tr>
  <tr class="textosmediano"> 
    <td> <div align="center">Firma del Encargado(a) de la<br>
        confecci&oacute;n del acta</div></td>
    <td> <div align="center"><?=($ls_nom_profe_jefe)?><br>
        Profesor(a) Jefe</div></td>
  </tr>
  <tr> 
    <td><div align="center"></div></td>
    <td><div align="center"></div></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2"><div align="center">___________________________</div></td>
  </tr>
  <tr> 
    <td colspan="2" class="textosmediano"> <div align="center">
	<?=($ls_nom_dire)?>
	<br>
Director(a) del 
        establecimiento</div></td>
  </tr>
</table>
<?
}
?>
</div>

</body>
</html>
<?
pg_close($conexion);
?>