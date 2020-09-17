	<?php 
$id_base =1; 
$nano = 2019; 
$rdb =10232;                                
  
                       
      
           
	     

 /*if($id_base ==1){
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
 
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi�a");	
	}

  if($id_base==3){
	$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Antofagasta.");	
	//$conn=pg_connect("dbname=coi_antofagasta host=190.196.32.148 port=5432 user=postgres password=300600") or die ("Error de conexion Antofagasta.");	
	 }
	 
  if($id_base==4){ 
  
  
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
	//$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");	
	$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi?a");
	 }
	
	//ano escolar
    $sql_a = "select * from ano_escolar where id_institucion=$rdb and nro_ano=$nano";
	$rs_ano = pg_exec($conn,$sql_a) or die($sql_a);
	$id_ano = pg_result($rs_ano,0);   
	//exit; 

//cursos
echo "<br>".$sql_cur = "select * from curso where id_ano=$id_ano";

$rs_cur = pg_exec($conn,$sql_cur);
for($c=0;$c<pg_numrows($rs_cur);$c++){
	$f_cur = pg_fetch_array($rs_cur,$c);
	
	//alumnos
	echo "<br>".$sql_alu = "select m.rut_alumno from matricula m inner join alumno a on a.rut_alumno = m.rut_alumno where m.id_curso=".$f_cur['id_curso']." order by a.ape_pat,a.ape_mat,a.nombre_alu";
	$rs_alu = pg_exec($conn,$sql_alu);
	for($al=0;$al<pg_numrows($rs_alu);$al++){
		$f_alu = pg_fetch_array($rs_alu,$al);
		//poner numero lista
		echo "<br>".$sql_num = "update matricula set nro_lista=".($al+1).",numero_reporte=".($al+1)." where rut_alumno=".$f_alu['rut_alumno']." and id_curso=".$f_cur['id_curso'];
		$rs_num = pg_exec($conn,$sql_num);
	}
	
}


?>