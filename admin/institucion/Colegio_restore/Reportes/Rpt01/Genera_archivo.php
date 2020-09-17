<?include"../Coneccion/conexion.php"?>
<?
	//$ls_criterio = $_GET["as_criterio"];
	//$ls_input    = $_GET["as_input"];
	$ls_institucion    = $_GET["as_institucion"];
	$li_ano    = $_GET["ai_ano"];
		
	//echo " --->  $ls_institucion  -- > $as_criterio";
	
	If(Trim($ls_institucion) == '')
	{
		$ls_institucion=0;
		$li_ano    = 0;
	}
	
	//if(Trim($ls_criterio)!= '')
	//	{
	//		$ls_crit_busqueda = " and upper($ls_criterio) like upper('$ls_input%')";
	//	}
	//else
	//	{
	//		$ls_crit_busqueda = "";
	//	}
	
	$sql = "select institucion.nombre_instit,  ";
	$sql = $sql . " alumno.rut_alumno, alumno.dig_rut, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, ";
	$sql = $sql . " alumno.sexo, alumno.fecha_nac, alumno.nacionalidad, institucion.rdb,institucion.dig_rdb ";
	$sql = $sql . " from alumno, matricula, institucion ";
	$sql = $sql . " where alumno.rut_alumno = matricula.rut_alumno ";
	$sql = $sql . " and institucion.rdb = matricula.rdb and institucion.rdb = $ls_institucion  ";
	//$sql = $sql . " $ls_crit_busqueda;";
	$sql = "select institucion.nombre_instit,  ";
	$sql = $sql . " alumno.rut_alumno, alumno.dig_rut, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, ";
	$sql = $sql . " alumno.sexo, alumno.fecha_nac, alumno.nacionalidad, institucion.rdb,institucion.dig_rdb ";
	$sql = $sql . " from alumno, matricula, institucion, ano_escolar ";
	$sql = $sql . " where alumno.rut_alumno = matricula.rut_alumno and matricula.id_ANO = ano_escolar.id_ano ";
	$sql = $sql . " and institucion.rdb = matricula.rdb and institucion.rdb = $ls_institucion  and ano_escolar.nro_ano = $li_ano";
	$sql = $sql . " group by institucion.nombre_instit, alumno.rut_alumno, alumno.dig_rut,   ";
	$sql = $sql . " alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, alumno.sexo, alumno.fecha_nac,   ";
	$sql = $sql . " alumno.nacionalidad, institucion.rdb,institucion.dig_rdb order by alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu"; 

	// echo "--> $sql";
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);
	
	pg_close($conexion);

	$fichero = fopen("../Archivos/archivo01.txt", "w"); 
	
For ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\n"; 	 
 $ls_espacio= chr(9);
 
$li_rdb =  pg_result($resultado_query, $j, 9);
$li_dig_rdb = pg_result($resultado_query, $j, 10);
$li_rut = pg_result($resultado_query, $j, 1); 
$ls_dig_verif = pg_result($resultado_query, $j, 2);
$ls_ape_pat = pg_result($resultado_query, $j, 3); 
$ls_ape_mat = pg_result($resultado_query, $j, 4); 
$ls_nombres = pg_result($resultado_query, $j, 5);  
$li_sexo = pg_result($resultado_query, $j, 1);
 
 $ls_string = "1"."$ls_espacio".$li_rdb."$ls_espacio".$li_dig_rdb."$ls_espacio"; 
 $ls_string = $ls_string . $li_rut."$ls_espacio".$ls_dig_verif."$ls_espacio"; 
 $ls_string = $ls_string . $ls_ape_pat."$ls_espacio".$ls_ape_mat."$ls_espacio"; 
 $ls_string = $ls_string . $ls_nombres."$ls_espacio".pg_result($resultado_query, $j, 6)."$ls_espacio"; 
 $ls_string = $ls_string . substr(Trim(pg_result($resultado_query, $j, 7)),8,2)."/".substr(Trim(pg_result($resultado_query, $j, 7)),5,2);
 $ls_string = $ls_string . "/".substr(Trim(pg_result($resultado_query, $j, 7)),0,4)."$ls_espacio".pg_result($resultado_query, $j, 8)."$salto"; 
		//crea un fichero
	//echo $ls_string;
		
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
        archivo ha sido creado con el nombre de <a href='../Archivos/archivo01.txt'> 
        &quot;archivo01.txt&quot;</a> , en total se encontraron 
        <?=($total_filas)?>
        registros.<br>
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