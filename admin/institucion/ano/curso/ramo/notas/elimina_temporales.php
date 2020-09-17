<?
require('../../../../../../util/header.inc');
$dia = date('d');
$qry = "select * from registra_temporales where dia != '$dia'";
$res = pg_Exec($qry);
for($i=0;$i<pg_numrows($res);$i++){
	$fila = pg_fetch_array($res,$i);
	$nombre_tabla = $fila['nombre'];
	$qry_drop = "DROP TABLE $nombre_tabla";	
	$res_drop = @pg_Exec($qry_drop);	
} 

$qry_del = "delete from registra_temporales where dia != '$dia'";
$res_del = @pg_Exec($qry_del);
?>
<script>
	alert ("Tablas eliminadas correctamente")
	window.location = 'new_mostrarNotas.php3'
</script>";


