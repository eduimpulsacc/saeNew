<?php 

$id_base =2; 
//$nano = 2017;
//$rdb =9121;  
  


 if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
 $conn=pg_connect("dbname=coi_final_vina host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vina");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi?a");	
	}

  if($id_base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");
	 }
	 
	 
	 //buscar todos los grupos de notas que existen
	echo $sql_grupo = "select * from grupo_nota where id_ano in(select id_ano from ano_escolar where nro_ano=2020)";
	$rs_grupo = pg_exec($conn,$sql_grupo);
	
	for($g=0;$g<pg_numrows($rs_grupo);$g++){
	$fila_grupo = pg_fetch_array($rs_grupo,$g);
	
	$id_grupo  =$fila_grupo['id_grupo'];
	$id_ano  =$fila_grupo['id_ano'];
	
	//buscar el priodo del año 
	$sqlbp = "select id_periodo from periodo where id_ano = $id_ano and nombre_periodo like 'PRIMER%'";
	$rs_bp = pg_exec($conn,$sqlbp);
	
	$id_periodo = pg_result($rs_bp,0);
	
	//actualizar periodo
	echo "<br>".$rs_actP = "update grupo_nota set id_periodo=$id_periodo where id_grupo = $id_grupo";
	pg_exec($conn,$rs_actP);
	
	}
	 
?>