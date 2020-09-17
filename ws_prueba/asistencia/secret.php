<?php 

$corp=38;

//voy a ver si institucion tiene la semilla
$connection=pg_connect("dbname=coi_usuario host=190.196.143.171 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_usuario");

$sql_ins = "select rdb from institucion where rdb in (select rdb from corp_instit where num_corp=$corp)";
$rs_ins = pg_exec($connection,$sql_ins);

for($o=0;$o<pg_numrows($rs_ins);$o++){
$f= pg_fetch_array($rs_ins,$o);

$secret = base64_encode("semilla".$f['rdb']);
echo "<br>".$sup= "update institucion set secret='$secret' where rdb=".$f['rdb']; 
	
}

	?>