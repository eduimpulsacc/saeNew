<?
// Rutina para varias cosas
//$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
/*$conn=@pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");*/
//$conn=pg_connect("dbname=coi_antofagasta host=200.29.70.184 port=5432 user=postgres password=anto2010") or die ("No pude conectar a la base de datos destino");
/*$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");*/


$conn=@pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");
//$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Antofagasta.");
//$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");
/*$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222."); */      
   
/*$conn=pg_connect("dbname=coi_final_vina host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi?a");	*/

				

$ano = 1902;     
$rdb = 31036;                            
 

echo $qry_1 = "select * from temporal_dav";
$res_1 = @pg_Exec($conn,$qry_1); 
echo "<br>".$num_1 = @pg_numrows($res_1); 

  
for ($i=0; $i < $num_1; $i++){
    $fil_1 = @pg_fetch_array($res_1,$i);
    $rut_alumno    = $fil_1['campo1'];
    $dig           = $fil_1['campo2'];
	$ape_pat       = $fil_1['campo3'];
    $ape_mat       = $fil_1['campo4'];
	$nombres       = $fil_1['campo5'];
    $sexo          = $fil_1['campo6'];
	$f_nacimiento  = $fil_1['campo7'];
    $region        = $fil_1['campo8'];
	$ciudad        = $fil_1['campo9'];
    $comuna        = $fil_1['campo10'];
	$id_curso	   = $fil_1['campo11'];
	$fecha_mat	   = $fil_1['campo12']; 
   //  $direccion   = substr($fil_1['campo13'],0,50);
   //$telefono	   = $fil_1['campo14'];
  //$numero 	   = $fil_1['campo14'];
	
	if ($sexo=="1"){
	   $sexo=1;
	}else{
	   $sexo=2;
	}
	$fecha = explode("/",$f_nacimiento);
	
	$dia = $fecha[0];
	$mes = $fecha[1];
	$ano2 = $fecha[2];
	$new_fecha_nac = $mes."-".$dia."-".$ano2;
	$f_nacimiento = $new_fecha_nac;
	
	$fecha1 = explode("/",$fecha_mat);
	$dia1 = $fecha1[0];
	$mes1 = $fecha1[1];
	$ano1 = $fecha1[2];
	$fecha2 = $mes1."-".$dia1."-".$ano1;
	$fecha_mat = $fecha2;
	
	echo "<br>".$sql_2 = "select * from alumno where rut_alumno = '".trim($rut_alumno)."'";
	$res_2 = @pg_Exec($conn,$sql_2);
	echo "<br>cantidad-->".$num_2 = @pg_numrows($res_2);
	
	if ($num_2 > 0){  // no inserto
	echo "<br>".$sql_3 = "select * from matricula where rut_alumno = '".trim($rut_alumno)."' and id_ano=1367";
	$res_3 = @pg_Exec($conn,$sql_3);
	$num_3 = @pg_numrows($res_3);
		if($num_3==0){
	echo 	$sql ="INSERT INTO matricula (rdb,rut_alumno,id_ano,id_curso,bool_ar,fecha) VALUES(".$rdb.",".$rut_alumno.",".$ano.",".$id_curso.",0,'".$fecha_mat."')";
		$rs_matricula = @pg_exec($conn,$sql) ;
		}
		
	}else{  /// inserto
	     echo "<br>".$sql_insert = "insert into alumno (rut_alumno, dig_rut, ape_pat, ape_mat, nombre_alu, sexo,  region, ciudad, comuna, calle,fecha_nac) values ('".trim($rut_alumno)."','$dig','$ape_pat','$ape_mat','$nombres','$sexo','$region','$ciudad','$comuna','$direccion','".$f_nacimiento."')";
		 $res_insert = pg_Exec($conn,$sql_insert) or die(pg_last_error($conn));
		 
		 $sql ="INSERT INTO matricula (rdb,rut_alumno,id_ano,id_curso,bool_ar,fecha) VALUES(".$rdb.",".$rut_alumno.",".$ano.",".$id_curso.",0,'".$fecha_mat."')";
		$rs_matricula = @pg_exec($conn,$sql) or die(pg_last_error($conn));
		 
		 echo "alumno insertado.... <br>";
	}
}	


echo "<br><br>ok...alumnos insertados...JUAN BAUTISTA PASTENE , alumnos insertados "; 	
?>
