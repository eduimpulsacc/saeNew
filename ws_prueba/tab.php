<?php
/*$conn1=pg_connect("dbname=coi_final host=192.168.100.93 port=5432 user=postgres password=300600") or die ("Error de conexion Coi_final");
$conn2=pg_connect("dbname=coi_corporaciones host=192.168.100.92 port=5432 user=postgres password=300600") or die ("Error de conexion coi_corporaciones");
$conn3=pg_connect("dbname=coi_final_vina host=192.168.100.92 port=5432 user=postgres password=300600") or die ("Error de conexion coi_final_vina");
*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn1=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
  de conexion Coi_final");
$conn2=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
$conn3=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");
$conn4=pg_connect("dbname=coi_usuario host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_Usuario ");



for($b=1;$b<=4;$b++){
//schemas
$sql1="select schema_name
from information_schema.schemata
where schema_name not like 'pg_%' and schema_name <> 'information_schema'
order by schema_name";
$cco = "conn$b";

$rs1=pg_exec($$cco,$sql1);	
for($a=0;$a<pg_numrows($rs1);$a++){
	$filaa = pg_fetch_array($rs1,$a);
	echo "<br>";
	echo $filaa['schema_name'];
	$sql2="SELECT tablename FROM pg_tables WHERE schemaname = '".$filaa['schema_name']."' ORDER BY tablename;";
	$rs2=pg_exec($$cco,$sql2);
	for($b=0;$b<pg_numrows($rs2);$b++){
		$filab = pg_fetch_array($rs2,$b);
		//echo $filaa['schema_name'].".".$filab['tablename'];
		echo "<br>".$sql2="grant select, insert, update, delete on ". $filaa['schema_name'].".".$filab['tablename']." to coi;";
		//$rs2 = pg_exec($$cco,$sql2);
		
	}
	
}
	
	
	
/*$sql="SELECT tablename FROM pg_tables
WHERE schemaname = 'public'  
ORDER BY tablename;"

$rs=pg_exec($conn.$b,$sql);

	for($i=0;$i<pg_numrows($rs);$i++){
		$fila = pg_fetch_array($rs,$i);
		$sql2="grant select, insert, update, delete on ".fila['tablename']." to coi;"
		$rs2 = pg_exec($conn.$b,$sql2);
	}
*/
}//fin for conexion

?>