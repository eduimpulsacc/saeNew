<?php 
$id_base =1;
$nano = 2017;
$rdb =9074; 


 
 if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
	$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi�a");	
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
	$sql_ano = "select * from ano_escolar where id_institucion=$rdb and nro_ano=$nano";
	$rs_ano = pg_exec($conn,$sql_ano);
	$id_ano = pg_result($rs_ano,0);
	

//alumnos
$sql_alumno="select a.* from alumno a inner join matricula m on m.rut_alumno = a.rut_alumno where m.id_ano=$id_ano";
$rs_alumno = pg_exec($conn,$sql_alumno);

for($a=0;$a<pg_numrows($rs_alumno);$a++){
$fila_alumno = pg_fetch_array($rs_alumno,$a);
$sql_tiene="select rut_apo,rut_alumno from tiene2 where rut_alumno=".$fila_alumno['rut_alumno'];
$rs_tiene=pg_exec($conn,$sql_tiene);

// si tengo datos, acutalizar
if(pg_numrows($rs_tiene)>0){
	for($p=0;$p<pg_numrows($rs_tiene);$p++){
	$fila_tiene=pg_fetch_array($rs_tiene,$p);
	
	//veo si apoderado tiene datos
	echo "<br>".$sql_dapo="select * from apoderado where rut_apo =".$fila_tiene['rut_apo'];
	$rs_apo=pg_exec($conn,$sql_dapo);
	$fila_apo=pg_fetch_array($rs_apo,0);
	
	echo "calle->".$fila_apo['calle'];
	if(strlen(trim($fila_apo['calle']))<2){
	echo $sql_cambiocalle="update apoderado set calle='".$fila_alumno['calle']."' where rut_apo=".$fila_apo['rut_apo'];
	$rs_cambiocalle=pg_exec($conn,$sql_cambiocalle);	
	}
	
	echo "nro->".$fila_apo['nro'];
	if(strlen(trim($fila_apo['nro']))<2){
	echo $sql_cambionro="update apoderado set nro='".$fila_alumno['nro']."' where rut_apo=".$fila_apo['rut_apo'];
	$rs_cambionro=pg_exec($conn,$sql_cambionro);	
	}
	
	echo "telefono->".$fila_apo['telefono'];
	if(strlen(trim($fila_apo['telefono']))<2){
	echo $sql_cambiotelefono="update apoderado set telefono='".$fila_alumno['telefono']."' where rut_apo=".$fila_apo['rut_apo'];
	$rs_cambiotelefono=pg_exec($conn,$sql_cambiotelefono);	
	}
	
	echo "celular->".$fila_apo['celular'];
	if(strlen(trim($fila_apo['celular']))<2){
	echo $sql_cambiocelular="update apoderado set celular='".$fila_alumno['celular']."' where rut_apo=".$fila_apo['rut_apo'];
	$rs_cambiocelular=pg_exec($conn,$sql_cambiocelular);	
	}
	
	//cambio los datos
	//$sql_cambio="update apoderado set calle='".$fila_alumno['calle']."',nro='".$fila_alumno['nro']."' ,telefono='".$fila_alumno['telefono']."',celular='".$fila_alumno['celular']."' where rut_apo=".$fila_apo['rut_apo'];	
	//$rs_cambio=pg_exec($conn,$sql_cambio);
	}
}	
}



?>