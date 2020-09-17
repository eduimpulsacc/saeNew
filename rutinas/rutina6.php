<?
// Rutina para varias cosas
//$conn_anto=pg_connect("dbname=coe host=200.29.20.214 port=1550 user=postgres password=post2005") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");
//$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");

//$conn=pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión Corporacion.");	
$conn=@pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	  		
//$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");     

 
$qry_1 = "select * from temporal_dav";
$res_1 = pg_Exec($conn,$qry_1) or die  (pg_last_error($conn));    
$num_1 = pg_numrows($res_1);

 
for ($i=0; $i < $num_1; $i++){  
    $fil_1 = @pg_fetch_array($res_1,$i);     
    $rut       = $fil_1['campo1'];
    $dig       = $fil_1['campo2']; 
	$ape_pat   = $fil_1['campo3']; 
	$ape_mat   = $fil_1['campo4'];
	$nombre    = $fil_1['campo5'];
	//$rdb       = $fil_1['campo6'];
	$rdb = 2278;                 
	    

	$sexo      = $fil_1['campo6']; 
	//$calle     = $fil_1['campo7'];
	//$numero    = $fil_1['campo8'];
	$region    = $fil_1['campo7'];  
	$ciudad    = $fil_1['campo8'];     
	$comuna    = $fil_1['campo9'];
	//$fono      = $fil_1['campo11'];
	//$email     = $fil_1['campo12'];
	//$calle	   = $fil_1['campo13'];
	
	

	echo $qry_2 = "select rut_emp from empleado where rut_emp = '".trim($rut)."'";
	//$qry_2 = "select rut_emp from trabaja where rut_emp = '$rut'";
    $res_2 = @pg_Exec($conn,$qry_2);
    $num_2 = @pg_numrows($res_2);

    if ($num_2 > 0){
	     echo "rut ".$rut ." existe <br>";
		 
		 $sql="SELECT * from trabaja WHERE rut_emp='".trim($rut)."' AND rdb='".trim($rdb)."'";
		 $rs_trabaja = pg_exec($conn,$sql);
		 
		 if(pg_numrows($rs_trabaja)==0){
	     /// ingresar en trabaja
		 
		$sql_trab = "insert into trabaja (rdb, rut_emp, cargo) values ('".trim($rdb)."','".trim($rut)."','5')";
		$res_trab = pg_Exec($conn,$sql_trab);
		 
		 }
		 /// actualizar en trabaja
		 //$sql_upd = "update trabaja set rdb = '115' where rut_emp = '".trim($rut)."'";
		 //$res_upd = @pg_Exec($conn,$sql_upd);		
		 
		 
		 /// actualizar empleado
		 /*
		 echo "<br>".$sql_upd = "update empleado set email = '$email', telefono = '$fono', calle = '$calle', nro = '$numero', region = '1', ciudad = '1', comuna = '1'  where rut_emp = '".trim($rut)."'";
		 $res_upd = pg_Exec($conn,$sql_upd);		 
		 */
	}else{
	     
		  /// no existe grabar en empleado  y en trabaja
		  echo "inserto rut: $rut <br>"; 
		  
		  
		  $sql_ins = "insert into empleado (rut_emp, dig_rut, nombre_emp, ape_pat, ape_mat,sexo,region,ciudad,comuna,email,calle,telefono ) values ('".trim($rut)."','$dig','$nombre','$ape_pat','$ape_mat','$sexo','$region','$ciudad','$comuna','$email','$calle','$fono')";
		  $res_ins = pg_Exec($conn,$sql_ins);
  
		  
		  /*
		  $sql_ins = "insert into empleado (rut_emp, dig_rut, nombre_emp, ape_pat, ape_mat, sexo, calle, nro, region, ciudad, comuna, telefono, email ) values ('$rut','$dig','$nombre','$ape_pat','$ape_mat','$sexo','$calle','$nro','$region','$ciudad','$comuna','$fono', '$email')"; 
		  $res_ins = pg_Exec($conn,$sql_ins);
		  */  
		  
		  // COMENTAR SENTENCIA SQL SI LOS DOCENTES ESTAN ASIGNADOS EN LAS ASIGNATURAS		  
		  $sql_ins2 = "insert into trabaja (rdb, rut_emp, cargo) values ('".trim($rdb)."','".trim($rut)."','5')"; 
		  $res_ins2 = @pg_Exec($conn,$sql_ins2);
		  
	}
}	 
  

//$sql_ins3 = "delete from temporal_dav";   
//$res_ins3 = @pg_Exec($conn,$sql_ins3); 

echo "<br><br>ok...actualizacion leonardo carga de personal .... ".$rdb; 	 
?>
