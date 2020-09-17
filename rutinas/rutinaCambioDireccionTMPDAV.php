<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<? 

$id_base =4;
$rdb =1914;



 if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
	$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi�a");	
	}

  if($id_base==3){
	$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Antofagasta.");	
	//$conn=pg_connect("dbname=coi_antofagasta host=190.196.32.148 port=5432 user=postgres password=300600") or die ("Error de conexion Antofagasta.");	
	 }
	 
  if($id_base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
	$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
	 }


$sql="SELECT * FROM temporal_dav";
$rs_tmp = pg_exec($conn,$sql);

for($a=0;$a<pg_numrows($rs_tmp);$a++){
	$fila_dir = pg_fetch_array($rs_tmp,$a);
	
	$sql_dir="update alumno set calle='".$fila_dir['campo2']."',region=".$fila_dir['campo3'].",ciudad=".$fila_dir['campo4'].",comuna=".$fila_dir['campo5']." where rut_alumno=".$fila_dir['campo1'] ;
	
	echo $sql_dir."<br>";
	$rs_ins = pg_exec($conn,$sql_dir) or die ("error 1:".$sql_dir);	

}




?>
