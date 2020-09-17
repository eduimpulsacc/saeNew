<?php
session_start();
if(!empty($_GET['_ID_BASE']))
           $_SESSION['_ID_BASE'] = $_GET['_ID_BASE'];
  
  
  
	$id_base = $_ID_BASE;
	
	@pg_close($conn);
	@pg_close($connection);
//192.168.1.10
  // Primero abrimos CONEXION en coi_usuario	
  $connection=pg_connect("dbname=coi_usuario host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_Usuario ");
  
  if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
	$conn=pg_connect("dbname=coi_final_vina host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi?a");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi?a");	
	}

  if($id_base==3){
	$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Antofagasta.");	
	//$conn=pg_connect("dbname=coi_antofagasta host=190.196.32.148 port=5432 user=postgres password=300600") or die ("Error de conexion Antofagasta.");	
	 }
	 
  if($id_base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
	$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");	
	 }

  /* if($id_base ==1){
   //$conn=pg_connect("dbname=coi_final host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final");	
   
   $conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final");	
   }
   
    if($id_base==2){ 
	$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vina");	
	}
	
	 if($id_base==3){
	$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Antofagasta.");	
	 }
	 
	if($id_base==4){ 
	$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
	 }*/
     //10.132.10.36
	/*$conn=pg_connect("dbname=coi_final host=200.29.21.124 port=5432 user=postgres password=cole#newaccess");
	
    $sql_corp = "select num_corp from corp_instit where rdb = '".$_INSTIT."'";
	$res_corp = @pg_Exec($conn, $sql_corp);
	
	$num_corp = @pg_numrows($res_corp);
	$numero_corp=@pg_result($res_corp,0);
	
	if ($num_corp>0 and $numero_corp!=21 and $numero_corp!=29){  

	     $fil_corp = @pg_fetch_array($res_corp,0);
		 $corporacion = $fil_corp['num_corp'];
			 
		 if ($corporacion=="1" or $corporacion=="4" or $corporacion=="12" or $corporacion=="14" or $corporacion=="15" or $corporacion=="16" or $corporacion=="17" or $corporacion=="18" or $corporacion=="19" or $corporacion=="20" or $corporacion=="22" or $corporacion=="23" or $corporacion=="24" or $corporacion=="25" or $corporacion=="26" or $corporacion=="33" or $corporacion=="34"){
		
			$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión.");
		
		}elseif ($corporacion=="13"){ //200.29.70.184
		
			$conn=pg_connect("dbname=coi_antofagasta host=200.29.70.184  port=5432 user=postgres password=anto2010") or die ("Error de conexión Antofagasta.");
		
		 }else{
		
			$conn=pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión.");	
		
		 }
	
	}*/
?>
