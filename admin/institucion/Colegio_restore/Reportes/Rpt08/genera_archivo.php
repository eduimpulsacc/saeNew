<?include"../Coneccion/conexion.php"?>
<?
	
	$li_ano = $_GET["ai_ano"];
	$ls_institucion    = $_GET["as_institucion"];
	
	//echo "--> $ls_criterio <br> --> $ls_input <br> --> $ls_institucion  <br> --> ";
	//**************************************************
	If(Trim($ls_institucion) == '')
	{
		$ls_institucion=0;
		$li_ano = 0;
	}
	//**************************************************
	
	$sql = " select institucion.rdb, institucion.dig_rdb, ano_escolar.id_ano ";
	$sql = $sql . " from institucion, ano_escolar ";
	$sql = $sql . " where institucion.rdb = ano_escolar.id_institucion ";
	$sql = $sql . " and institucion.rdb = $ls_institucion ";
	$sql = $sql . " and ano_escolar.nro_ano = $li_ano; ";
	$resultado_query_cab= pg_exec($conexion,$sql);
	$total_filas_cab= pg_numrows($resultado_query_cab);
	
	if ($total_filas_cab>0){
		$li_rdb 		= pg_result($resultado_query_cab, 0, 0);
		$li_drdb 	= pg_result($resultado_query_cab, 0, 1);
		$li_ano__ 	= pg_result($resultado_query_cab, 0, 2);	
	}else{
		$li_rdb 		= 0;
		$li_drdb 	= 0;
		$li_ano__ 	= 0;
	}
		
	$sql = " select distinct subsector.cod_subsector, subsector.nombre from ramo, curso, subsector where curso.id_curso = ramo.id_curso ";
	$sql = $sql . " and ramo.cod_subsector = subsector.cod_subsector and curso.id_ano = $li_ano__ order by cod_subsector;";
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);

	pg_close($conexion);

	$fichero = fopen("../Archivos/archivo08.txt", "w"); 
	
For ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\n"; 	 
 $ls_espacio= chr(9);

 $li_subsector = pg_result($resultado_query, $j, 0);
 $ls_descripcion = pg_result($resultado_query, $j, 1); 
 
 $ls_string = "8".chr(9).$li_rdb."$ls_espacio".$li_drdb."$ls_espacio"; 
 $ls_string = $ls_string . $li_ano."$ls_espacio".$li_subsector."$ls_espacio".$ls_descripcion."$salto"; 
 
 @ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 


?>

<html>
<head>
<title>rpt8</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<br>
<br>
<br>
<br>
<table width="60%" height="27" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
        archivo ha sido creado con el nombre de <a href='../Archivos/archivo08.txt'> 
        &quot; 
        archivo08.txt
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
