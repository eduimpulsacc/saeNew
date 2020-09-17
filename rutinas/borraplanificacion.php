<?php 
$id_base =1;
$nano = 2010;
$rdb =24985;


 


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
	$sql_a = "select * from ano_escolar where id_institucion=$rdb and nro_ano=$nano";
	$rs_ano = pg_exec($conn,$sql_a);
	$id_ano = pg_result($rs_ano,0);
	//exit;

// borrar clases
echo $sql1="delete from planificacion.clase_tipoevaluacion, planificacion.clase_recurso, planificacion.clase_observacion, planificacion.clase_obj, planificacion.clase_nota, planificacion.clase_archivo,planificacion.clase 
where id_clase in 
(select id_clase from planificacion.unidad where id_unidad 
in(select id_unidad from planificacion.unidad where id_ano=$id_ano))"

//delete from planificacion.clase where id_unidad in (select id_unidad from planificacion.unidad where id_ano=$id_ano);

//borrar planificaciones unidad

//borrar planificaciones anuales
?>