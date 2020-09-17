<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin9" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>

<?

//echo "modificado";
//exit;
// Rutina para varias cosas
$id_base =1;
$nano =2017; 
$nano_ant = 2016;
$rdb =8905; 
$orden=2;
$ense =310;           
$grado = "(1,2,3,4)";        
  
if($orden==1){
//solo ordenar por apellido y fecha de matricula
$ord = " m.fecha,a,a.ape_mat,a.nombre_alu";
$and = "";
}
if($orden==2){
// resetar por numero de enseñanza, da lo mismo la fecha
$and="and c.ensenanza=$ense";
$ord = " c.grado_curso,c.letra_curso,paterno,a.ape_mat,a.nombre_alu";
}

if($orden==3){
//resetear por tipo de enseñanza y luego por grado, da lo mismo la fecha
$and=" and c.ensenanza=$ense and c.grado_curso in $grado";
$ord = " c.ensenanza, c.grado_curso,c.letra_curso,paterno,a.ape_mat,a.nombre_alu";
}

 if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
	$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi?a");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi?a");	
	}

  if($id_base==3){
	$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Antofagasta.");	
	//$conn=pg_connect("dbname=coi_antofagasta host=190.196.32.148 port=5432 user=postgres password=300600") or die ("Error de conexion Antofagasta.");	
	 }
	 
  if($id_base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
	$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
	 }
	
	//ano escolar
	$sql_a = "select * from ano_escolar where id_institucion=$rdb and nro_ano=$nano";
	$rs_ano = pg_exec($conn,$sql_a);
	$id_ano = pg_result($rs_ano,0);
	//exit;

 

	$sql="SELECT rut_alumno, num_mat 
FROM matricula m 
INNER JOIN ano_escolar ae ON m.id_ano=ae.id_ano AND nro_ano=".$nano_ant."
INNER JOIN curso c ON c.id_curso=m.id_curso AND ensenanza=".$ense."
WHERE ae.id_institucion=".$rdb;
	$rs = pg_exec($conn,$sql);
	


echo "<br>";
$rs = pg_exec($conn,$sql);
//$mat=0;
for($i=0;$i<pg_numrows($rs);$i++){
	$fila = pg_fetch_array($rs,$i);
	
	
	$squ = "update matricula set num_mat = ".$fila['num_mat']." where rut_alumno = ".$fila['rut_alumno']." and id_ano=$id_ano";
	echo $squ."<br>";
	$rsu = pg_exec($conn,$squ);
	
}

?>
 </body>
</html>
