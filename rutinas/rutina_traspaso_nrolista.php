<? 


$conn=@pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Antofagasta.");
$conn2=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");
//$conn2=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña."); 


$sql="SELECT id_ano FROM ano_Escolar WHERE id_institucion=1598 AND nro_ano=2014";    
$rs_ano = pg_exec($conn,$sql);  
$ano=pg_result($rs_ano,0); //coi_final

$rs_ano2 = pg_exec($conn2,$sql);
$ano2=pg_result($rs_ano2,0); //coi_final_vina

echo "<br>".$sql="SELECT nro_lista, rut_alumno FROM matricula WHERE matricula.id_ano=".$ano;
$rs_ano = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($rs_ano);$i++){
	$fila = pg_fetch_array($rs_ano,$i);
	
	
	echo "<br>".$sql="UPDATE matricula SET nro_lista=".$fila['nro_lista']." WHERE id_ano=".$ano2." AND rut_alumno=".$fila['rut_alumno'];
	$rs_lista = pg_exec($conn2,$sql);
}

echo "fin proceso";

?>







