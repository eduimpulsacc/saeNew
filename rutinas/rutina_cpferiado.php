<?php 
$id_base =2; 
$nano = 2017;
//$rdb =10774;      
        

   
   

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
	//id_institucion=$rdb and
	$sql_a = "select * from ano_escolar where  nro_ano=$nano";
	$rs_ano = pg_exec($conn,$sql_a);
	//$id_ano = pg_result($rs_ano,0);
	//exit;

//cursos
//echo "<br>".$sql_cur = "select * from curso where id_ano=$id_ano";
for($a=0;$a<pg_numrows($rs_ano);$a++){
$fila_ano = pg_fetch_array($rs_ano,$a);

//select cursos
echo "<br>".$sql_cur="select id_curso from curso where id_ano = ".$fila_ano['id_ano'];
$rs_cur = pg_exec($conn,$sql_cur);

//select feriados
echo "<br>".$sql_fer="select id_feriado from feriado where id_ano = ".$fila_ano['id_ano'];
$rs_fer = pg_exec($conn,$sql_fer);


for($c=0;$c<pg_numrows($rs_cur);$c++){
$fila_curso = pg_fetch_array($rs_cur,$c);

	//paseo por los feriados
	for($f=0;$f<pg_numrows($rs_fer);$f++){
	$fila_feriado = pg_fetch_array($rs_fer,$f);
	
	echo "<br>".$sql_copiaf ="insert into feriado_curso values(".$fila_feriado['id_feriado'].",".$fila_curso['id_curso'].")";
	$rs_copiaf = pg_exec($conn,$sql_copiaf);
		
	}
	
}
	 
}


?>