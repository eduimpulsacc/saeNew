<? 


$conn=@pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Antofagasta.");
$conn2=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");
//$conn2=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña."); 


$sql="SELECT id_ano FROM ano_Escolar WHERE id_institucion=1598 AND nro_ano=2015";   
$rs_ano = pg_exec($conn,$sql);  
$ano=pg_result($rs_ano,0); //coi_final

$rs_ano2 = pg_exec($conn2,$sql);
$ano2=pg_result($rs_ano2,0); //coi_final_vina

$sql="	SELECT * 
		FROM dicta 
		INNER JOIN ramo ON dicta.id_ramo=ramo.id_ramo 
		INNER JOIN curso ON curso.id_curso=ramo.id_curso
		WHERE id_ano=".$ano;
$rs_curso = pg_exec($conn,$sql);


for($i=0;$i<pg_numrows($rs_curso);$i++){
	$fila =pg_fetch_array($rs_curso,$i);
	
	echo "<br>".$sql="SELECT id_curso FROM curso WHERE id_ano=".$ano2." AND ensenanza=".$fila['ensenanza']." AND grado_curso=".$fila['grado_curso']." AND letra_curso='".$fila['letra_curso']."'";
	$rs_nuevo_curso = pg_exec($conn2,$sql);
	$curso = pg_result($rs_nuevo_curso,0);
	
	$sql="SELECT  id_ramo FROM ramo WHERE id_curso=".$curso." AND cod_subsector=".$fila['cod_subsector'];
	$rs_ramo = pg_exec($conn2,$sql);
	$ramo = pg_result($rs_ramo,0);
	
	//echo "<br>".$sql="INSERT INTO dicta (rut_emp,id_ramo) VALUES(".$fila['rut_emp'].",".$ramo.")";
	echo "<br>".$sql="UPDATE ramo SET id_orden=".$fila['id_orden']." WHERE id_ramo=".$ramo;
	$rs_supervisa =pg_exec($conn2,$sql);
	

}


echo "fin proceso";

?>







