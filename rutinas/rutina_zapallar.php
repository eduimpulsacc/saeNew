<? 
$conn=pg_connect("dbname=coe_traspaso host=190.196.32.150 port=1550 user=sae2006 password=zapallar2006") or die ("No pude conectar a la base de datos destinoqq");
//$conn=pg_connect("dbname=coi_antofagasta host=200.29.70.184 port=5432 user=postgres password=anto2010") or die ("Error de conexión Antofagasta.");
//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión Viña.");


if($conn){
	echo "exito";
}else{
	echo "no pasa na";
}
?>







