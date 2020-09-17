<?php 
$id_base =2; 
$nano = 2018;
//1598
$rdb =array(133,253,433,50,341,14289,14299,565,8680,8861,10385,24730,25826,9502,9796,9797,16488,2162,2863,17686,4655,3714,3865,3866,4277,4268,11397,4139,4772,4779,18049,5265,5661,6122,6542,6835,11678,19968,22019,7405);      
        
  

if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
	
   }

  if($id_base==2){ 
	  $conn=pg_connect("dbname=coi_final_vina host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vina");	
	
	}

  if($id_base==3){
	$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Antofagasta.");	
	
	 }
	 
  if($id_base==4){ 

	$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");
	 }
	


//select feriados del año
$sql_fer="select * from feriado_ano where nro_ano = ".$nano;
$rs_fer = pg_exec($conn,$sql_fer);



for($col=0;$col<count($rdb);$col++){
$sql_a = "select * from ano_escolar where  nro_ano=$nano and id_institucion = ".$rdb[$col];

	$rs_ano = pg_exec($conn,$sql_a);
	$id_ano = pg_result($rs_ano,0);
	
//periodos
$sql_per="select * from periodo where id_ano = $id_ano order by id_periodo, nombre_periodo";
$rs_per = pg_exec($conn,$sql_per);
	

//select cursos
$sql_cur="select id_curso from curso where id_ano = ".$id_ano;
$rs_cur = pg_exec($conn,$sql_cur);
	
	
//select feriados
$sql_fer="select id_feriado from feriado where id_ano = ".$id_ano;
$rs_fer = pg_exec($conn,$sql_fer);
	
	
	
	for($c=0;$c<pg_numrows($rs_cur);$c++){
$fila_curso = pg_fetch_array($rs_cur,$c);

	//paseo por los feriados
	for($f=0;$f<pg_numrows($rs_fer);$f++){
	$fila_feriado = pg_fetch_array($rs_fer,$f);
	
	echo "<br>".$sql_copiaf ="insert into feriado_curso values(".$fila_feriado['id_feriado'].",".$fila_curso['id_curso'].")";
	//$rs_copiaf = pg_exec($conn,$sql_copiaf);
		
	}
	
}
	

}

	
/*
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


/*for($c=0;$c<pg_numrows($rs_cur);$c++){
$fila_curso = pg_fetch_array($rs_cur,$c);

	//paseo por los feriados
	for($f=0;$f<pg_numrows($rs_fer);$f++){
	$fila_feriado = pg_fetch_array($rs_fer,$f);
	
	echo "<br>".$sql_copiaf ="insert into feriado_curso values(".$fila_feriado['id_feriado'].",".$fila_curso['id_curso'].")";
	$rs_copiaf = pg_exec($conn,$sql_copiaf);
		
	}
	
}
	 
}*/


?>