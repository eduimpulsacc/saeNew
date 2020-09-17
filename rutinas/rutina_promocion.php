<?
require("../util/funciones_utiles.php");
// Rutina para varias cosas
/*$conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Antofagasta.");*/	
//$conn_anto=pg_connect("dbname=coe host=200.29.20.214 port=1550 user=postgres password=post2005") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña."); 


$conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	 
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
  
$rdb=31068;     
$nro_ano= 2017;                                                                                                                
      
$qry_1 = "select * from temporal_dav";        
$res_1 = @pg_Exec($conn,$qry_1);  
$num_1 = @pg_numrows($res_1);     


for ($i=0; $i < $num_1; $i++){ 
    $fil_1 = @pg_fetch_array($res_1,$i);   
	$rut			= $fil_1['campo1'];
	$promedio		= $fil_1['campo2'];
	$asistencia		= $fil_1['campo3'];  
	$situacion		= $fil_1['campo4']; 
    $observacion  	= $fil_1['campo5'];
	$ano		 	= $fil_1['campo6'];
	$curso 			= $fil_1['campo7'];   
	
	$promedio = str_replace(",","",$promedio);
	if(strchr($observacion,"RET. ")==true){
		$fecha =substr($observacion,5,10); 
		$fecha=fEs2En($fecha); 
	}else{
		$fecha="";	
	}
	
	switch ($situacion){
		case "P":
			$estado = 1;
			break;
		case "R":
			$estado=2;
			break;
		case "Y":
			$estado=3;
			$promedio=0;
			$asistencia=0;
			break;
	}
	if($promedio<10) $promedio=$promedio * 10;
	
	$sql="INSERT INTO promocion (rdb,id_ano,id_curso,rut_alumno,promedio,asistencia,situacion_final";
	if($fecha!=NULL){
		$sql.="	,fecha_retiro ";
	}
	if($observacion!=""){
		$sql.=" ,observacion ";
	}
	
		$sql.=" ) VALUES(".$rdb.",".$ano.",".$curso.",".$rut.",".$promedio.",".$asistencia.",".$estado." ";
	if($fecha!=NULL){
		$sql.=",'".$fecha."'";
	}
	if($observacion!=""){
		$sql.=",'".$observacion."'";
	}
	echo "<br>".$sql.=")";	
	$rs_promocion=pg_exec($conn,$sql);
	


	$sql="SELECT id_ramo FROM ramo WHERE id_curso=".$curso;
	$rs_curso = pg_exec($conn,$sql);
	
	for($k=0;$k<pg_numrows($rs_curso);$k++){
		$fila_r=pg_fetch_array($rs_curso,$k); 
		
		
			 $sql="SELECT promedio FROM notas$nro_ano WHERE id_ramo=".$fila_r['id_ramo']." AND rut_alumno=".$rut;
			 $rs_nota = pg_exec($conn,$sql);
			 
			 $fila_n = pg_fetch_array($rs_nota,0);
			 
			 if($fila_n['promedio']!=""){
				echo "<br>". $sql="INSERT INTO promedio_sub_alumno (rdb,id_ano,id_curso,id_ramo,rut_alumno,promedio) VALUES ($rdb,$ano,$curso,".$fila_r['id_ramo'].",".$rut.",'".trim($fila_n['promedio'])."')";
				 $rs_promedio = pg_exec($conn,$sql);
			 }
		
			
	}
}
echo "<br><br>ok...actualizacion de datos TERRA MONTE.... "; 	
?>
