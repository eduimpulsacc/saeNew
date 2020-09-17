<? 
//$conn=pg_connect("dbname=coi_antofagasta host=200.29.70.184 port=5432 user=postgres password=anto2010") or die ("Error de conexión Antofagasta.");
$id_base =4; 
$institucion =14885;
$ano2010 = 1800; 
$ano2011 = 1823; 
$grado = 1;
$ensenanza=310;  
$letra='A';
	
 if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
	$conn=pg_connect("dbname=coi_final_vina host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vina");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi?a");	
	}

  if($id_base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
	$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");	
	 }
    


echo "<br>". $sql ="SELECT ensenanza,grado_curso,letra_curso,cod_subsector, bool_ip,truncado, ramo.truncado_per,sub_obli,sub_elect,modo_eval,ramo.bool_pgeneral FROM curso INNER JOIN ramo ON curso.id_curso=ramo.id_curso WHERE id_ano=".$ano2010." AND ensenanza=$ensenanza and grado_curso=$grado ORDER BY ensenanza,grado_curso,letra_curso ASC";

exit;
 
$rs_curso_origen = @pg_exec($conn,$sql) or die("SELECT FALLO:".$sql);


for($i=0;$i<@pg_numrows($rs_curso_origen);$i++){
	$fila = @pg_fetch_array($rs_curso_origen,$i);

	echo "<br>". $sql ="SELECT id_curso FROM curso WHERE id_ano=".$ano2011." AND ensenanza=".$fila['ensenanza']." AND grado_curso=".$fila['grado_curso']." AND letra_curso='".trim($fila['letra_curso'])."'";
	$rs_curso_dest = @pg_exec($conn,$sql) or die("SELECT FALLO :".$sql);
	
	$curso = @pg_result($rs_curso_dest,0);

	if ($fila['sub_obli']==NULL) $sub_obli = 0; else $sub_obli = $fila['sub_obli'];
	if ($fila['sub_elect']==NULL) $sub_elect = 0; else $sub_elect = $fila['sub_elect'];
	if ($fila['truncado']==NULL) $truncado = 0; else $truncado = $fila['truncado'];
	if ($fila['truncado_per']==NULL) $truncado_per = 0; else $truncado_per = $fila['truncado_per'];
	if ($fila['bool_pgeneral']==NULL) $bool_pgeneral = 0; else $bool_pgeneral = $fila['bool_pgeneral'];
	

	echo "<br>". $sql3="SELECT * FROM ramo WHERE id_curso=".$curso." AND cod_subsector=".$fila['cod_subsector'];
	$rs_existe = pg_exec($conn,$sql3);

	if(pg_numrows($rs_existe)==0){
		
		

		echo "<br>".$sql = "INSERT INTO ramo (id_curso,cod_subsector,sub_obli, sub_elect, bool_ip, truncado, truncado_per, modo_eval, formacion,bool_pgeneral) VALUES (".$curso.", ".$fila['cod_subsector'].", ".$sub_obli.", ".$sub_elect.", ".$fila['bool_ip'].", ".$truncado.", ".$truncado_per.",".$fila['modo_eval'].",1,".$bool_pgeneral.")";
		$rs_ramo =@pg_exec($conn,$sql) or die("INSERT INTO :".$sql);

	}

	
}



?>






