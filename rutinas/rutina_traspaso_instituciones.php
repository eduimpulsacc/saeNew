<?
$conn = @pg_connect("dbname=coi_usuario host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino 1");

$conn_final = @pg_connect("dbname=coi_final host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino 2");

$conn_vina = @pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino 3");

$conn_corp = @pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino 4");

//$conn_final = @pg_connect("dbname=coi_antofagasta host=200.29.70.184  port=5432 user=postgres password=anto2010") or die ("No pude conectar a la base de datos destino");






/************* TRASPASO INSTITUCION DE LA COI FINAL *************************/
//$sql ="SELECT rut_emp, dig_rut, nombre_emp, ape_pat, ape_mat FROM empleado";
//$sql ="SELECT rut_alumno, dig_rut, nombre_alu, ape_pat, ape_mat FROM alumno";
 $sql =" select ins.rdb,ins.dig_rdb,ins.nombre_instit from institucion ins";
$rs_final = pg_exec($conn_corp,$sql);
echo "<br> contador coi_final-->".pg_numrows($rs_final);
$contador_final=0;

for($i=0;$i<@pg_numrows($rs_final);$i++){
	$fila = @pg_fetch_array($rs_final,$i);
	
	 $sql ="SELECT count(*) as contador FROM institucion WHERE rdb=".$fila['rdb'];
	$rs_existe = @pg_exec($conn,$sql);
	$contador = pg_result($rs_existe,0);
	
	if($contador==0){	
	 $sql ="INSERT INTO institucion (rdb, dig_rdb, nombre_instit) VALUES (".$fila['rdb'].",'".$fila['dig_rdb']."','".$fila['nombre_instit']."')";
		$rs_usuario = @pg_exec($conn,$sql);	
		$contador_final++;
	}
}
echo "--->".$contador_final;