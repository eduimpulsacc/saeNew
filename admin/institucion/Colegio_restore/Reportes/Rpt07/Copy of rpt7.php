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
	$ls_sql = " select ramo.id_ramo, subsector.nombre ";
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
	
	

?>
<html>
<head>
<title>rpt7</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/objeto.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
//echo "$total_filas";
if ($total_filas > 0){
?>
<table width="1100" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td valign="top" class="textosdiminuto"> 
      <div align="center"><strong>REPUBLICA DE CHILE <br>
        </strong>MINISTERIO DE EDUCACI&Oacute;N<br>
        DIVISI&Oacute;N DE EDUCACI&Oacute;N GENERAL<br>
        SECRETARIA REGIONAL MINISTERIAL<br>
        DE EDUCACION</div>
    </td>
    <td colspan="5" valign="top" class="titulos"> 
      <div align="center"><font size="1"><strong>ACTA DE CALIFICACIONES ANUALES 
        Y PROMOCI&Oacute;N ESCOLAR</strong></font></div>
    </td>
    <td width="344" rowspan="2"> 
      <table width="330" border="1" align="center" cellpadding="0" cellspacing="1">
        <tr> 
          <td> 
            <table width="330" border="0" align="right" cellpadding="0" cellspacing="0">
              <tr > 
                <td width="200" class="textosdiminuto"> 
                  <div align="center"><strong> 
                    <?print pg_result($resultado_query_cabecera, 0, 7);?>
                    </strong> </div>
                </td>
                <td width="200" class="textosdiminuto"> 
                  <div align="center"><strong> 
                    <?print pg_result($resultado_query_cabecera, 0, 8);?>
                    </strong> </div>
                </td>
              </tr>
              <tr > 
                <td class="textosdiminuto"> 
                  <div align="center">REGI&Oacute;N</div>
                </td>
                <td class="textosdiminuto"> 
                  <div align="center">PROVINCIA</div>
                </td>
              </tr>
              <tr > 
                <td class="textosdiminuto"> 
                  <div align="center"><strong> 
                    <?print pg_result($resultado_query_cabecera, 0, 6);?>
                    </strong> </div>
                </td>
                <td class="textosdiminuto"> 
                  <div align="center"><strong> 
                    <?print $li_ano;?>
                    </strong> </div>
                </td>
              </tr>
              <tr > 
                <td class="textosdiminuto"> 
                  <div align="center">COMUNA</div>
                </td>
                <td class="textosdiminuto"> 
                  <div align="center">A&Ntilde;O ESCOLAR</div>
                </td>
              </tr>
              <tr > 
                <td colspan="2" class="textosdiminuto"> 
                  <div align="center">CURSO <strong> 
                    <?=($li_curso)?>
                    &nbsp; 
                    <?=($ls_letra )?>
                    </strong></div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td width="213" valign="top" >&nbsp;</td>
    <td colspan="5" valign="top" class="textosdiminuto" > 
      <?print Trim(pg_result($resultado_query_decretos, 0, 0));?>
      reconocido oficialmente por el ministerio de educaci&oacute;n de chile seg&uacute;n 
      decreto 
      <?print Trim(pg_result($resultado_query_decretos, 0, 1));?>
      n&ordm; 
      <?print Trim(pg_result($resultado_query_decretos, 0, 2));?>
      rol base datos n&ordm; 
      <?print Trim(pg_result($resultado_query_decretos, 0, 3));?>
      , plan de estudios aprobado por decreto 
      <?print Trim(pg_result($resultado_query_decretos, 0, 4));?>
      n&ordm; 
      <?print Trim(pg_result($resultado_query_decretos, 0, 5));?>
      y del reglamento de evaluaci&oacute;n y promoci&oacute;n escolar decreto 
      exento n&ordm; 
      <?print Trim(pg_result($resultado_query_decretos, 0, 7));?>
    </td>
  </tr>
</table>
<br>
<table width="1100" border="1" cellspacing="1" cellpadding="0">
  <tr> 
    <td width="15"> <img src="../letras/E.gif" width="15" height="15"><br>
      <img src="../letras/V.gif" width="15" height="15"><br>
      <img src="../letras/A.gif" width="15" height="15"><br>
      <img src="../letras/L.gif" width="15" height="15"><br>
      <img src="../letras/C.gif" width="15" height="15"></td>
    <td width="28" class="textosmediano"> 
      <div align="center">N&ordm; </div>
    </td>
    <td width="562"> 
      <div align="center"><span class="titulos">N&Oacute;MINA DE ALUMNOS</span><br>
        <span class="textosmediano"> (Nombre completo, seg&uacute;n certificados 
        de nacimiento)<br>
        (Orden Alfab&eacute;tico) </span><br>
        <br>
        <span class="textosmediano">Apellido Paterno, Apellido Materno, Nombres</span></div>
    </td>
    <td width="77" valign="bottom" class="textosmediano"> 
      <div align="center"><strong>R.U.N</strong></div>
    </td>
    <td width="33" valign="bottom" class="textosdiminuto"> 
      <div align="center"><strong>SEXO</strong></div>
    </td>
    <td width="111" valign="bottom" class="textosmediano"> 
      <div align="center"><strong>Fecha<br>
        Nacimiento </strong></div>
    </td>
    <td width="141" valign="bottom" class="textosmediano"> 
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
          <td> <img src="../letras/O.gif" width="7" height="7"><br>
            <img src="../letras/I.gif" width="7" height="7"><br>
            <img src="../letras/D.gif" width="7" height="7"><br>
            <img src="../letras/E.gif" width="7" height="7"><br>
            <img src="../letras/M.gif" width="7" height="7"><br>
            <img src="../letras/O.gif" width="7" height="7"><br>
            <img src="../letras/R.gif" width="7" height="7"><br>
            <img src="../letras/P.gif" width="7" height="7"> </td>
          <td valign="middle"><img src="../letras/L.gif" width="7" height="7"><br>
            <img src="../letras/A.gif" width="7" height="7"><br>
            <img src="../letras/R.gif" width="7" height="7"><br>
            <img src="../letras/E.gif" width="7" height="7"><br>
            <img src="../letras/N.gif" width="7" height="7"><br>
            <img src="../letras/E.gif" width="7" height="7"><br>
            <img src="../letras/G.gif" width="7" height="7"><br>
          </td>
        </tr>
      </table>
    </td>
    <td valign="bottom"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td valign="middle"> <img src="../letras/N.gif" width="7" height="7"><br>
            <img src="../letras/O.gif" width="7" height="7"><br>
            <img src="../letras/I.gif" width="7" height="7"><br>
            <img src="../letras/C.gif" width="7" height="7"><br>
            <img src="../letras/A.gif" width="7" height="7"><br>
            <img src="../letras/C.gif" width="7" height="7"><br>
            <img src="../letras/I.gif" width="7" height="7"><br>
            <img src="../letras/F.gif" width="7" height="7"><br>
            <img src="../letras/I.gif" width="7" height="7"><br>
            <img src="../letras/L.gif" width="7" height="7"><br>
            <img src="../letras/A.gif" width="7" height="7"><br>
            <img src="../letras/C.gif" width="7" height="7"> </td>
          <td valign="middle"> <img src="../letras/L.gif" width="7" height="7"><br>
            <img src="../letras/A.gif" width="7" height="7"><br>
            <img src="../letras/U.gif" width="7" height="7"><br>
            <img src="../letras/N.gif" width="7" height="7"><br>
            <img src="../letras/A.gif" width="7" height="7"><br>
          </td>
        </tr>
      </table>
    </td>
    <td valign="bottom"> 
      <table cellpadding="0"  cellspacing="0">
        <tr valign="middle"> 
          <TD valign="bottom"> <img src="../letras/e.gif" width="7" height="7"><br>
            <img src="../letras/j.gif" width="7" height="7"><br>
            <img src="../letras/a.gif" width="7" height="7"><br>
            <img src="../letras/t.gif" width="7" height="7"><br>
            <img src="../letras/n.gif" width="7" height="7"><br>
            <img src="../letras/e.gif" width="7" height="7"><br>
            <img src="../letras/c.gif" width="7" height="7"><br>
            <img src="../letras/r.gif" width="7" height="7"><br>
            <img src="../letras/o.gif" width="7" height="7"><br>
            <img src="../letras/p.gif" width="7" height="7"> </TD>
          <td valign="bottom"> <img src="../letras/a.gif" width="7" height="7"><br>
            <img src="../letras/i.gif" width="7" height="7"><br>
            <img src="../letras/c.gif" width="7" height="7"><br>
            <img src="../letras/n.gif" width="7" height="7"><br>
            <img src="../letras/e.gif" width="7" height="7"><br>
            <img src="../letras/t.gif" width="7" height="7"><br>
            <img src="../letras/s.gif" width="7" height="7"><br>
            <img src="../letras/i.gif" width="7" height="7"><br>
            <img src="../letras/s.gif" width="7" height="7"><br>
            <img src="../letras/A.gif" width="7" height="7"><br>
            <!--img src='../letras/ESPACIOENBLANCO.gif' width='7' height='4'>
			<img src="../letras/e.gif" width="7" height="7"><br>
				<img src="../letras/d.gif" width="7" height="7"><br-->
          </td>
        </tr>
      </table>
    </td>
    <td valign="bottom"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr valign="middle"> 
          <td> <img src="../letras/N.gif" width="7" height="7"><br>
            <img src="../letras/O.gif" width="7" height="7"><br>
            <img src="../letras/I.gif" width="7" height="7"><br>
            <img src="../letras/C.gif" width="7" height="7"><br>
            <img src="../letras/A.gif" width="7" height="7"><br>
            <img src="../letras/U.gif" width="7" height="7"><br>
            <img src="../letras/T.gif" width="7" height="7"><br>
            <img src="../letras/I.gif" width="7" height="7"><br>
            <img src="../letras/S.gif" width="7" height="7"> </td>
          <td valign="middle"><img src="../letras/L.gif" width="7" height="7"><br>
            <img src="../letras/A.gif" width="7" height="7"><br>
            <img src="../letras/N.gif" width="7" height="7"><br>
            <img src="../letras/I.gif" width="7" height="7"><br>
            <img src="../letras/F.gif" width="7" height="7"><br>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <?
	For ($j=0; $j < $total_filas; $j++)
	{
	?>
  <tr > 
    <td class="textosdiminuto">&nbsp;</td>
    <td class="textosdiminuto"> 
      <?=($j + 1)?>
    </td>
    <td class="textosdiminuto"> 
      <?print Trim(pg_result($resultado_query, $j, 2));?>
      &nbsp; 
      <?print Trim(pg_result($resultado_query, $j, 3));?>
      &nbsp; 
      <?print Trim(pg_result($resultado_query, $j, 4));?>
      &nbsp; </td>
    <td class="textosdiminuto"> 
      <?print pg_result($resultado_query, $j, 0);?>
      - 
      <?print pg_result($resultado_query, $j, 1);?>
    </td>
    <td class="textosdiminuto"> 
      <?print pg_result($resultado_query, $j, 6);?>
    </td>
    <td class="textosdiminuto"> 
      <?print Trim(pg_result($resultado_query, $j, 7));?>
    </td>
    <td class="textosdiminuto"> 
      <?print Trim(pg_result($resultado_query, $j, 5));?>
    </td>
    <?
	For ($x=0; $x < $total_filas_ramos; $x++)
	{
	?>
    <td class="textosdiminuto"> 
      <?print pg_result($resultado_query, $j, $x + 8);?>
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
	?>
    <td class="textosdiminuto"> 
      <?print Trim(pg_result($resultado_query_temp, 0, 0));?>
    </td>
    <td class="textosdiminuto"> 
      <?print Trim(pg_result($resultado_query_temp, 0, 0));?>
    </td>
    <td class="textosdiminuto"> 
      <?print Trim(pg_result($resultado_query_temp, 0, 1));?>
    </td>
    <td class="textosdiminuto"> 
      <?print Trim(pg_result($resultado_query_temp, 0, 2));?>
    </td>
  </tr>
  <?
	}
	?>
</table>
<?
}
?>
</body>
</html>
<?
pg_close($conexion);
?>