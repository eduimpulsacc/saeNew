<?  
$conn=pg_connect("dbname=coi_final host=192.168.100.203 port=5432 user=postgres password=300600");

$id_periodo=$_POST["id_periodo"];
$id_ramo=$_POST["id_ramo"];
$id_ano=$_POST["id_ano"];

$sql_query ="SELECT matricula.rut_alumno,alumno.dig_rut,matricula.bool_ar,matricula.nro_lista,initcap(alumno.nombre_alu) as nombre,initcap(alumno.ape_pat)as ape_pat,initcap(alumno.ape_mat)as   ape_mat,tiene2008.id_curso,notas2008.id_periodo,notas2008.id_ramo,notas2008.nota1,notas2008.nota2,notas2008.nota3,notas2008.nota4,notas2008.nota5,notas2008.nota6,notas2008.nota7,notas2008.nota8,notas2008.nota9,notas2008.nota10,notas2008.nota11,notas2008.nota12,notas2008.nota13,notas2008.nota14,notas2008.nota15,notas2008.nota16,notas2008.nota17,notas2008.nota18,notas2008.nota19,notas2008.nota20,notas2008.promedio FROM alumno INNER JOIN notas2008 ON notas2008.rut_alumno= alumno.rut_alumno AND notas2008.id_periodo = $id_periodo AND notas2008.id_ramo = $id_ramo INNER JOIN tiene2008 ON alumno.rut_alumno = tiene2008.rut_alumno AND tiene2008.id_ramo = $id_ramo INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno AND matricula.id_ano = $id_ano ORDER BY 4,5";
$result =@pg_Exec($conn,$sql_query);
$curso = array ();
if (pg_numrows($result)!=0){
for($i=0 ; $i < @pg_numrows($result) ; $i++){
$fila1 = @pg_fetch_array($result,$i);
			$curso[$i] = array ( 
			"rut" => $fila1["rut_alumno"],
			"dig_rut" => $fila1["dig_rut"],
			"id_curso" => $fila1["id_curso"],
			"nro_lista" => $fila1["nro_lista"],
			"ape_pat" => utf8_encode($fila1["ape_pat"]),
			"ape_mat" => utf8_encode($fila1["ape_mat"]),
			"nombres" => utf8_encode($fila1["nombre"]),
			"bool_ar" => $fila1["bool_ar"],
			"id_periodo" => $fila1["id_periodo"],
			"id_ramo" => $fila1["id_ramo"],
													notas => array( 
													trim($fila1["nota1"]),
													trim($fila1["nota2"]),
													trim($fila1["nota3"]),
													trim($fila1["nota4"]),
													trim($fila1["nota5"]),
													trim($fila1["nota6"]),
													trim($fila1["nota7"]),
													trim($fila1["nota8"]),
													trim($fila1["nota9"]),
													trim($fila1["nota10"]),
													trim($fila1["nota11"]),
													trim($fila1["nota12"]),
													trim($fila1["nota13"]),
													trim($fila1["nota14"]),
													trim($fila1["nota15"]),
													trim($fila1["nota16"]),
													trim($fila1["nota17"]),
													trim($fila1["nota18"]),
													trim($fila1["nota19"]),
													trim($fila1["nota20"]),
													trim($fila1["promedio"]) 
													  )
					 );  // fin array curso
   }
} 
echo json_encode($curso);
?>