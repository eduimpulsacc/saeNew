<?php  
$id_base =4; 
$nano = 2018;

if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
	$conn=pg_connect("dbname=coi_final_vina host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi�a");	
	}

  if($id_base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
	$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");	
	 }?>
	 
<?php 
//a buscar todos los años de la base
 $sql_ano ="select * from ano_escolar where nro_ano=$nano order by id_ano";
$rs_nano = pg_exec($conn,$sql_ano);

for($an=0;$an<pg_numrows($rs_nano);$an++){
$fano = pg_fetch_array($rs_nano,$an);
$id_ano = $fano['id_ano'];

//periodos
$sql_per="select * from periodo where id_ano = $id_ano and (fecha_inicio is null or fecha_termino is null) order by id_periodo, nombre_periodo";
$rs_per = pg_exec($conn,$sql_per);

 $corte1 = "$nano-07-13";
 $corte2 = "$nano-07-23";

 $corte3 = "$nano-06-01"; //fin primer trimestre
 
 $corte4 = "$nano-06-04"; // comienzo segundo trimestre
 $corte5 = "$nano-09-08"; //fin segundo trimestre
 
 $corte6 = "$nano-09-09"; //comienzo tercer trimestre


for($pe=0;$pe<pg_numrows($rs_per);$pe++){
$fper= pg_fetch_array($rs_per,$pe);	
$id_periodo=$fper['id_periodo'];
 $nper=trim($fper['nombre_periodo']);

	if($nper=='PRIMER SEMESTRE'){
	 echo "<br>".$sql_up ="update periodo set fecha_termino='$corte1' where id_periodo=$id_periodo";
	 pg_exec($conn,$sql_up);
	}

	if($nper=="SEGUNDO SEMESTRE"){
	 echo "<br>".$sql_up ="update periodo set fecha_inicio='$corte2' where id_periodo=$id_periodo";
	 pg_exec($conn,$sql_up);
	}
	
	if($nper=="PRIMER TRIMESTRE"){
	 echo "<br>".$sql_up ="update periodo set fecha_termino='$corte3' where id_periodo=$id_periodo";
	 pg_exec($conn,$sql_up);
	}
	
	if($nper=="SEGUNDO TRIMESTRE"){
	 echo "<br>".$sql_up1 ="update periodo set fecha_inicio='$corte4' where id_periodo=$id_periodo";
	 pg_exec($conn,$sql_up1);
	 
	 echo "<br>".$sql_up2 ="update periodo set fecha_termino='$corte5' where id_periodo=$id_periodo";
	 pg_exec($conn,$sql_up2);
	}
	
	if($nper=="TERCER TRIMESTRE"){
	 echo "<br>".$sql_up ="update periodo set fecha_inicio='$corte6' where id_periodo=$id_periodo";
	 pg_exec($conn,$sql_up);
	}


}

}
?>