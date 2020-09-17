<? 
$conn=@pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");

$qry_0 = "select * from temporal_dav";
$res_0 = pg_Exec($conn,$qry_0);
$num_0 = pg_numrows($res_0);

for ($k=0; $k < $num_0; $k++){
     $fil_0 = pg_fetch_array($res_0,$k);
	 
	 $rut           = $fil_0['campo1'];
	 
	 // buscar este rut en la tabla matrícula
	 $sql_rut = "select * from matricula where id_ano = '822' and rut_alumno = '".trim($rut)."'";
	 $res_rut = pg_Exec($conn, $sql_rut);
	 $num_rut = pg_numrows($res_rut);
	 
	 
	 if ($num_rut==0){
	     echo "rut no existe.... en matrícula: $rut  <br>";
	 }
	 
	 
	 /// buscar en alumno
	 $sql_alu = "select * from alumno where rut_alumno = '".trim($rut)."'";
	 $res_alu = pg_Exec($conn, $sql_alu);
	 $num_alu = pg_numrows($res_alu);
	 
	 if ($num_alu==0){
	      echo "$rut  <br>";
	 }
	 
}


echo "fin proceso......";	 
	 
	 
?>