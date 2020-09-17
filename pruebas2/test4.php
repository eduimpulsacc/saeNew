<? 
$conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");


$sql = "select rut_alumno from matricula where id_curso = '10004'";
$res = pg_Exec($conn, $sql);

for ($i=0; $i < @pg_numrows($res); $i++){
    $fil = pg_fetch_array($res,$i);	
	$rut_alumno_[] = $fil['rut_alumno'];
}

$sqlramo = "select id_ramo from ramo where id_curso = '10004' and cod_subsector not in (13)";
$resramo = pg_Exec($conn, $sqlramo);

for ($i=0; $i < @pg_numrows($resramo); $i++){
    $filramo = pg_fetch_array($resramo, $i);
	$id_ramo_[] = $filramo['id_ramo'];
}

$nota = 10;
 
for ($i=0; $i < 7; $i++){

    // subsectores
	for ($j=0; $j < @pg_numrows($resramo); $j++){
	     
		 // alumnos
		 for ($x=0; $x < @pg_numrows($res); $x++){
		      
			  // consultar si existe el registro
			  $sql_existe = "select count(*) as cantidad from notas2008 where id_periodo = '1233' and id_ramo = '$id_ramo_[$j]' and rut_alumno = '$rut_alumno_[$x]'";
			  $res_existe = @pg_exec($conn, $sql_existe);
			  $fil_existe = @pg_fetch_array($res_existe,0);
			  
			  if ($fil_existe['cantidad'] > 0){
			       /// existe, actualizar
				   
				   for ($y=1; $y < 21; $y++){ 
				       $sql_update = "update notas2008 set nota$y = '$nota' where id_periodo = '1233' and id_ramo = '$id_ramo_[$j]' and rut_alumno = '$rut_alumno_[$x]'";
				       $res_update = @pg_exec($conn, $sql_update);
					   
					   if ($res_update){
					       $exito++;
					   }else{
					       $error++;
					   }
				   } 			   
				   
			  }else{
			       // no existe, insertar				   
				   $sql_insert = "insert into notas2008 (id_periodo, id_ramo, rut_alumno, nota1) values ('1233','$id_ramo_[$j]','$rut_alumno_[$x]', '$nota')";
				   $res_insert = @pg_exec($conn, $sql_insert);
				   
				   if ($res_insert){
					   $exito++;
				   }else{
				       $error++;
				   }
				   
				   
				   
				   // ya insertamos un registro, ahora actualizar en las demás posiciones de notas
				   for ($y=2; $y < 21; $y++){ 
				       $sql_update = "update notas2008 set nota$y = '$nota' where id_periodo = '1233' and id_ramo = '$id_ramo_[$j]' and rut_alumno = '$rut_alumno_[$x]'";
				       $res_update = @pg_exec($conn, $sql_update);
					   
					   if ($res_update){
					       $exito++;
					   }else{
					       $error++;
					   }
				   }  			   
				   
			  }	   
		
		 }
	
	}
	
	$nota = $nota + 10;	

}

echo "total de exito: $exito";

echo "<br><br>total de error: $error";

?>