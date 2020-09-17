<? 

$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final");

  //$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final");

 
$sql ="select c.id_curso,ensenanza,grado_curso,letra_curso, ape_pat, ape_mat,a.rut_alumno, m.num_mat 
from curso c 
INNER JOIN matricula m ON c.id_ano=m.id_ano AND c.id_curso=m.id_curso 
INNER JOIN alumno a ON a.rut_alumno=m.rut_alumno 
where c.id_ano=1628 AND ensenanza=310 and m.num_mat=0
ORDER BY ensenanza, grado_curso,letra_curso,ape_pat,ape_mat ASC";

	//$sql="SELECT id_curso, m.rut_alumno FROM matricula m INNER JOIN alumno a ON m.rut_alumno=a.rut_alumno WHERE id_ano=1553 ORDER BY ape_pat, ape_mat, nombre_alu ASC";
	$rs_curso = pg_exec($conn,$sql);
 
 for($i=0;$i<pg_numrows($rs_curso);$i++){
	$fila_c = pg_Fetch_array($rs_curso,$i);
	$contador=$i+1;
	echo "<br>".$sql="UPDATE matricula SET num_mat=".$contador." WHERE rut_alumno=".$fila_c['rut_alumno']." AND id_curso=".$fila_c['id_curso'];
	$result = pg_exec($conn,$sql);
	 
 }



?>


