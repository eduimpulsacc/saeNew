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
$nano =2019;         
$rdb =14629;            
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
/*
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
		$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
	 }*/
	 
	  if($id_base ==1){ 
  $conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
$conn=pg_connect("dbname=coi_final_vina host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi?a");	 
        	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi?a");	
	}

  if($id_base==3){
	$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Antofagasta.");	
	//$conn=pg_connect("dbname=coi_antofagasta host=190.196.32.148 port=5432 user=postgres password=300600") or die ("Error de conexion Antofagasta.");	
	 }
	 
  if($id_base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
	$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi?a");
	 }
	
	//ano escolar
	$sql_a = "select * from ano_escolar where id_institucion=$rdb and nro_ano=$nano";
	$rs_ano = pg_exec($conn,$sql_a);
	$id_ano = pg_result($rs_ano,0);
	//exit;

 


   /*$sql = "select a.rut_alumno,m.id_curso,m.fecha, a.ape_pat,a.ape_mat,a.nombre_alu from matricula m 
inner join curso c on c.id_curso = m.id_curso 
inner join alumno a on a.rut_alumno = m.rut_alumno
 where m.id_ano = $id_ano $and order by $ord ";*/
echo  $sql="select case 
WHEN (SUBSTRING(upper(a.ape_pat),1,1)='Á') THEN REPLACE(upper(a.ape_pat),'Á','A') 
WHEN (SUBSTRING(upper(a.ape_pat),1,1)='É') THEN REPLACE(upper(a.ape_pat),'É','E') 
WHEN (SUBSTRING(upper(a.ape_pat),1,1)='Í') THEN REPLACE(upper(a.ape_pat),'Í','I') 
WHEN (SUBSTRING(upper(a.ape_pat),1,1)='Ó') THEN REPLACE(upper(a.ape_pat),'Ó','O') 
WHEN (SUBSTRING(upper(a.ape_pat),1,1)='Ú') THEN REPLACE(upper(a.ape_pat),'Ú','U') 
ELSE upper(a.ape_pat) END AS paterno,
a.rut_alumno,m.id_curso,m.fecha, a.ape_pat,a.ape_mat,a.nombre_alu 
from matricula m 
inner join curso c on c.id_curso = m.id_curso 
inner join alumno a on a.rut_alumno = m.rut_alumno 
where m.id_ano = $id_ano $and 
order by $ord ";

echo "<br>";
$rs = pg_exec($conn,$sql);
//$mat=0;
for($i=0;$i<pg_numrows($rs);$i++){
	$fila = pg_fetch_array($rs,$i);
	echo $fila['paterno'];
	
	$squ = "update matricula set num_mat = ".($i+1)." where rut_alumno = ".$fila['rut_alumno']." AND id_curso=".$fila['id_curso']."  and id_ano=$id_ano";
	echo $squ."<br>";
	$rsu = pg_exec($conn,$squ);
	$mat++;
}

?>
 </body>
</html>
