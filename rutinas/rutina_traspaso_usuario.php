<?
$conn = @pg_connect("dbname=coi_final_12_12 host=190.196.32.148 port=5432 user=postgres password=300600") or die ("No pude conectar a la base de datos destino 1");

$conn_final = @pg_connect("dbname=coi_final host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino 2");


$sql ="SELECT count(*) FROM asistencia WHERE ano=1284";
$rs_antes =pg_exec($conn_final,$sql);
echo "antes-->".pg_result($rs_antes,0);

$sql ="select * from asistencia where ano=1284";
$rs_asistencia = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($rs_asistencia);$i++){
	$fila = pg_fetch_array($rs_asistencia,$i);
	
	$sql ="INSERT INTO asistencia (rut_alumno,ano,id_curso,fecha) VALUES (".$fila['rut_alumno'].",".$fila['ano'].",".$fila['id_curso'].",'".$fila['fecha']."')";
	$result =pg_exec($conn_final,$sql);
	
}
$sql ="SELECT count(*) FROM asistencia WHERE ano=1284";
$rs_despues =pg_exec($conn_final,$sql);
echo "Despues-->".pg_result($rs_despues,0); 
exit;


$conn = @pg_connect("dbname=coi_usuario host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino 1");
$conn_final = @pg_connect("dbname=coi_final host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino 2");
/*$conn_vina = @pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino 3");
$conn_corp = @pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino 4");
$conn_final = @pg_connect("dbname=coi_antofagasta host=200.29.70.184  port=5432 user=postgres password=anto2010") or die ("No pude conectar a la base de datos destino");*/


/************* TRASPASO INSTITUCION DE LA COI FINAL *************************/
//$sql ="SELECT rut_emp, dig_rut, nombre_emp, ape_pat, ape_mat FROM empleado";
$sql ="SELECT rut_alumno, dig_rut, nombre_alu, ape_pat, ape_mat FROM alumno";
$rs_final = pg_exec($conn_final,$sql);
echo "<br> contador coi_final-->".pg_numrows($rs_final);
$contador_final=0;

for($i=0;$i<@pg_numrows($rs_final);$i++){
	$fila = @pg_fetch_array($rs_final,$i);
	
	$sql ="SELECT count(*) as contador FROM dato_usuario WHERE rut_usuario=".$fila['rut_alumno'];
	$rs_existe = @pg_exec($conn,$sql);
	$contador = pg_result($rs_existe,0);
	
	if($contador==0){	
		$sql ="INSERT INTO dato_usuario (rut_usuario, dig_rut, nombre, ape_pat, ape_mat) VALUES (".$fila['rut_alumno'].",'".$fila['dig_rut']."','".$fila['nombre_alu']."','".$fila['ape_pat']."','".$fila['ape_mat']."')";
		$rs_usuario = @pg_exec($conn,$sql);	
		$contador_final++;
	}
}
echo "--->".$contador_final;
