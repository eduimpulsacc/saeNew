<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php 
$id_base =1; 
$nano1 = 2017;
$nano2 = 2018;
$rdb="2278"; 


 if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
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
	 }?>
     
     
<?php 
//año fuente
echo $sql_af="select id_ano from ano_escolar where nro_ano=$nano1 and id_institucion=$rdb";
$rs_af = pg_exec($conn,$sql_af);
$id1=pg_result($rs_af,0);

//año destino
echo "<br>".$sql_de="select id_ano from ano_escolar where nro_ano=$nano2 and id_institucion=$rdb";
$rs_de = pg_exec($conn,$sql_de);
$id2=pg_result($rs_de,0);

//matricula año nuevo
echo "<br>".$sql_mat="select * from matricula where id_ano=$id2 and bool_ar=0";
$rs_mat = pg_exec($conn,$sql_mat);
for($i=0;$i<pg_numrows($rs_mat);$i++){
	$fila_mat =pg_fetch_array($rs_mat,$i);
	
	//busco si el alumno existio en el año anterior
	echo "<br>".$sql_al="select * from matricula where rut_alumno=".$fila_mat['rut_alumno']." and id_ano=$id1 and bool_ar=0";
	$rs_al=pg_exec($conn,$sql_al);
	if(pg_numrows($rs_al)>0){
	$fila_alum = pg_fetch_array($rs_al,0);
	echo "<br>".$sql_up1="update matricula set 
	rut_retira= '".$fila_alum['rut_retira']."',  
  nombre_retira = '".$fila_alum['nombre_retira']."', 
  parentesco_retira = '".$fila_alum['parentesco_retira']."', 
  fono_retira = '".$fila_alum['fono_retira']."', 
  celular_retira = '".$fila_alum['celular_retira']."',  
  
   rut_retira2 = '".$fila_alum['rut_retira2']."',  
  nombre_retira2 = '".$fila_alum['nombre_retira2']."', 
  parentesco_retira2 = '".$fila_alum['parentesco_retira2']."',  
  fono_retira2 = '".$fila_alum['fono_retira2']."',  
  celular_retira2 = '".$fila_alum['celular_retira2']."',  
  
   rut_retira3 = '".$fila_alum['rut_retira3']."',  
  nombre_retira3 = '".$fila_alum['nombre_retira3']."',  
  parentesco_retira3 = '".$fila_alum['parentesco_retira3']."',  
  fono_retira3 = '".$fila_alum['fono_retira3']."', 
  celular_retira3 = '".$fila_alum['celular_retira3']."'
    where rut_alumno=".$fila_mat['rut_alumno']." and id_ano=$id2 and bool_ar=0";
	$rs_up=pg_exec($conn,$sql_up1);	
	}
	
}




  
  
?> 
