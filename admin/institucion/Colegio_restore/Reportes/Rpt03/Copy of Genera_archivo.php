<?include"../Coneccion/conexion.php"?>
<?
	$li_curso = $_GET["ai_curso"];
	$ls_letra = $_GET["as_letra"];
	$li_tipo_ense = $_GET["ai_tipo_ense"];
	$li_ano = $_GET["ai_ano"];
	$ls_criterio = $_GET["as_criterio"];
	$ls_input    = $_GET["as_input"];
	$ls_institucion    = $_GET["as_institucion"];
	
	//echo "--> $ls_criterio <br> --> $ls_input <br> --> $ls_institucion  <br> --> ";
	//**************************************************
	If(Trim($ls_institucion) == '')
	{
		$ls_institucion=0;
	}
	//**************************************************
	if(Trim($ls_criterio)!= '')
		{
			$ls_crit_busqueda = " and $ls_criterio like '%$ls_input%'";
		}
	else
		{
			$ls_crit_busqueda = "";
		}
	//**************************************************
	if(Trim($li_curso)!= '')
		{
			$ls_crit_curso 		= " and curso.grado_curso = $li_curso";
			$ls_crit_letra 		= " and curso.letra_curso = '$ls_letra'";
			$ls_crit_tipo_ense  = " and tipo_ensenanza.cod_tipo = $li_tipo_ense";
			$ls_crit_ano 		= " and ano_escolar.nro_ano = $li_ano";
			
		}
	else
		{
			$ls_crit_curso 		= " ";
			$ls_crit_letra 		= " ";
			$ls_crit_tipo_ense  = " ";
			$ls_crit_ano 		= " ";
		}
	
	
	
	$sql = "select institucion.rdb, institucion.dig_rdb,"; 
	$sql = $sql . " tipo_ensenanza.cod_tipo, curso.grado_curso, curso.letra_curso,";
	$sql = $sql . " ano_escolar.id_ano, ano_escolar.nro_ano, alumno.rut_alumno, alumno.dig_rut, alumno.ape_pat, ";
	$sql = $sql . " alumno.ape_mat, alumno.nombre_alu, comuna.cor_com, comuna.nom_com, comuna.cod_reg, comuna.cor_pro, ";
	$sql = $sql . " comuna.cor_com ";
	$sql = $sql . " from institucion, curso, tipo_ensenanza, ano_escolar, matricula, alumno, comuna";
	$sql = $sql . " where curso.ensenanza = tipo_ensenanza.cod_tipo	and curso.id_ano = ano_escolar.id_ano";
	$sql = $sql . " and curso.id_ano = matricula.id_ano	and curso.id_curso = matricula.id_curso";
	$sql = $sql . " and matricula.rut_alumno = alumno.rut_alumno and institucion.rdb = matricula.rdb and alumno.region = comuna.cod_reg";
	$sql = $sql . " and alumno.ciudad = comuna.cor_pro and alumno.comuna = comuna.cor_com and matricula.rdb = $ls_institucion";
	$sql = $sql . " and ano_escolar.nro_ano = $li_ano ";
	$sql = $sql . " and tipo_ensenanza.cod_tipo > 100 ";
	//$sql = $sql . " $ls_crit_busqueda $ls_crit_curso $ls_crit_letra $ls_crit_tipo_ense $ls_crit_ano  ";
	$sql = $sql . " order by cod_tipo, id_ano;";
	 
	//echo " <br> $sql" ;
	 
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);

	
	pg_close($conexion);

	$fichero = fopen("../Archivos/archivo03.txt", "w"); 
	
For ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\n"; 	 
 $ls_espacio= chr(9);
 
 $li_rdb =  pg_result($resultado_query, $j, 0);
 $li_dig_rdb = pg_result($resultado_query, $j, 1);
 $li_cod_tipo = pg_result($resultado_query, $j, 2);
 $li_grado_curso = pg_result($resultado_query, $j, 3);
 $ls_letra_curso = pg_result($resultado_query, $j, 4);
 $li_ano_escolar = pg_result($resultado_query, $j, 6); 
 $li_rut_estud  = pg_result($resultado_query, $j, 7);
 $li_dig_verif  = pg_result($resultado_query, $j, 8); 
 $li_cod_comuna = pg_result($resultado_query, $j, 14); 
 $li_cod_comuna = $li_cod_comuna . pg_result($resultado_query, $j, 15); 
 $li_cod_comuna = $li_cod_comuna . substr("00",1,2-strlen(pg_result($resultado_query, $j, 16))).pg_result($resultado_query, $j, 16); 

 $ls_string = "3".chr(9).$li_rdb."$ls_espacio".$li_dig_rdb."$ls_espacio"; 
 $ls_string = $ls_string . $li_cod_tipo."$ls_espacio".$li_grado_curso."$ls_espacio"; 
 $ls_string = $ls_string . $ls_letra_curso."$ls_espacio".$li_ano_escolar."$ls_espacio"; 
 $ls_string = $ls_string . $li_rut_estud."$ls_espacio".$li_dig_verif ."$ls_espacio".$li_cod_comuna."$salto"; 
 
 @ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<br><br>
<br>
<br>
<table width="60%" height="27" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
        archivo ha sido creado con el nombre de <a href='../Archivos/archivo03.txt'> 
        &quot; 
        archivo03.txt
        &quot;</a> , en total se encontraron 
        <?=($total_filas)?>
        registros para el a&ntilde;o <b>
        <?=($li_ano)?>
        </b>.<br>
        <br>
        </strong></font></div></td>
  </tr>
  <tr> 
    <td><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Para 
        guardar el archivo en su PC Solo debe clickear con el boton derecho sobre 
        el Link que esta en el nombre del archivo y elegir la opcion guardar archivo 
        como(Save Target As)</font></div></td>
  </tr>
</table>

</body>
</html>