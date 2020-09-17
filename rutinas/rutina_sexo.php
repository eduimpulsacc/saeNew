<?

echo "modificado";
exit;
// Rutina para varias cosas
$conn=@pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");
//$conn_anto=pg_connect("dbname=coe host=200.29.20.214 port=1550 user=postgres password=post2005") or die ("No pude conectar a la base de datos destino");


$qry_1 = "select * from temporal_dav";
$res_1 = @pg_Exec($conn,$qry_1);
$num_1 = @pg_numrows($res_1);


for ($i=0; $i < $num_1; $i++){
    $fil_1 = @pg_fetch_array($res_1,$i);
    $rut_alumno  = $fil_1['campo1'];
    $sexo        = $fil_1['campo2'];
	
	if ($sexo=="1"){
	   $sexo=2;
	}else{
	   $sexo=1;
	}
	
	$sql_upd = "update alumno set Nacionalidad = 2 where rut_alumno = '".trim($rut_alumno)."'";
	$res_upd = pg_Exec($conn,$sql_upd);		 
	
}	

echo "<br><br>ok...actualizacion de sexos.... 10277 ver 2"; 	
?>
