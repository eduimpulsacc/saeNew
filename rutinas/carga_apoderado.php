<?
// Rutina para varias cosas
/* $conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");*/
//$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Antofagasta.");
//$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");
//$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");   
 /* $conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi?a");
	 }*/

 $conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	

/*$conn=pg_connect("dbname=coi_final_vina host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi?a");	 
            */ 
	   
 
echo $qry_1 = "select * from temporal_dav";  
$res_1 = @pg_Exec($conn,$qry_1); 
$num_1 = @pg_numrows($res_1); 
 

for ($i=0; $i < $num_1; $i++){    
    $fil_1 = @pg_fetch_array($res_1,$i);       
    $rut_alumno    = $fil_1['campo1']; 
	$rut_apo       = $fil_1['campo2'];
	$dig_apo       = $fil_1['campo3'];    
	$nombre_apo    = $fil_1['campo4'];
	$ape_pat       = $fil_1['campo5'];  
	$ape_mat       = $fil_1['campo6'];  
	$sexo_apo      = $fil_1['campo7'];  
    $direccion_apo = $fil_1['campo8']; 
	$region_apo    = $fil_1['campo9'];
	$ciudad_apo    = $fil_1['campo10'];
	$comuna_apo    = $fil_1['campo11'];
   /* $numero        = $fil_1['campo12'];*/
    //$depto         = $fil_1['campo13'];     
    $fono          = $fil_1['campo12'];  
    //$email         = $fil_1['campo13']; 
	
    //// buscar en la tabla apoderado si el rut existe
	
	
	echo "<br>".$qry_2 = "select rut_apo from apoderado where rut_apo = '".trim($rut_apo)."'";
	$res_2 = @pg_Exec($conn,$qry_2);
    $num_2 = @pg_numrows($res_2); 
	if ($num_2>0){   // existe, no grabar
	         
			 //// buscar en la tabla tiene2 la relacion con el alumno
			 
			 
			 $qry_3 = "select rut_apo from tiene2 where rut_apo = '".trim($rut_apo)."' and rut_alumno='".trim($rut_alumno)."'";
			 $res_3 = @pg_Exec($conn,$qry_3);
             $num_3 = @pg_numrows($res_3);
			 if ($num_3>0){  // existe, no insertar
			 			 
			 }else{  // no existe, insertar
			        
					// insertar registro en tiene2
			         $sql_ins2 = "insert into tiene2 (rut_apo,rut_alumno,responsable) values ('".trim($rut_apo)."','".trim($rut_alumno)."','1')"; 
		             $res_ins2 = @pg_Exec($conn,$sql_ins2);
			 }
			
			 // actualiza datos
			 /*
			 if ($sexo_apo=='2'){ 
			     $sexo_apo='1';
			 }else{
			     $sexo_apo='2';
			 }	 
			 
			 $sql_up = "update apoderado set nacionalidad = '2' where rut_apo = '".trim($rut_apo)."'";
			 $res_up = pg_Exec($conn, $sql_up);
			 */
			 
	}else{ // no existe, insertar apoderado
	       // insertar registro en apoderado
		   
	      echo "<br>".$sql_ins2 = "insert into apoderado (rut_apo,nombre_apo,dig_rut,ape_pat,ape_mat,region,ciudad,comuna,celular,sexo,depto,calle,nro,email) values ('".trim($rut_apo)."','".trim($nombre_apo)."','".trim($dig_apo)."','".trim($ape_pat)."','".trim($ape_mat)."','".trim($region_apo)."','".trim($ciudad_apo)."','".trim($comuna_apo)."','".trim($fono)."','".trim($sexo_apo)."','".trim($depto)."','".trim($direccion_apo)."','".trim($numero)."','".trim($email)."')"; 
		  $res_ins2 = pg_Exec($conn,$sql_ins2);
	$apo++;
	
	       // insertar registro en tiene2
	        $sql_ins2 = "insert into tiene2(rut_apo,rut_alumno,responsable) values ('".trim($rut_apo)."','".trim($rut_alumno)."','1')";
	        $res_ins2 = @pg_Exec($conn,$sql_ins2);
	}	
  
}	

   
echo "<br><br>ok...actualizacion de apoderado....PROVIDENCIA ... ";   	          
 
echo "<br><br>total de insertados $apo"; 
?>