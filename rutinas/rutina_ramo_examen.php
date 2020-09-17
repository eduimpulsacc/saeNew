<?

$conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");

$sql ="SELECT id_ramo,nota_exim,pct_examen FROM ramo WHERE id_curso in (SELECT id_curso FROM curso WHERE id_ano=1217)";
$rs_ramo = @pg_exec($conn,$sql);
$rut=9756712;
for($i=0;$i<pg_numrows($rs_ramo);$i++){
	$fila = @pg_fetch_array($rs_ramo,$i);
	
	$sql ="UPDATE ramo SET conexper=1, nota_ex_semestral=".$fila['nota_exim'].", pct_ex_semestral=".$fila['pct_examen']." WHERE id_ramo=".$fila['id_ramo'];
	$rs_update = @pg_exec($conn,$sql) or die("UPDATE FALLO :".$sql);
}


echo "FIN PROCESO CURSO";

?>