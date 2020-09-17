<?
require("util/funciones_utiles.php");
// Rutina para varias cosas
//$conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Antofagasta.");	
//$conn_anto=pg_connect("dbname=coe host=200.29.20.214 port=1550 user=postgres password=post2005") or die ("No pude conectar a la base de datos destino");
$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña."); 
  
$rdb=9103;  
$nro_ano= 2015;                                             
   
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
		echo $fecha =substr($observacion,7,10);
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
}	


	$sql="SELECT id_ramo FROM ramo WHERE id_curso=".$curso;
	$rs_curso = pg_exec($conn,$sql);
	
	for($i=0;$i<pg_numrows($rs_curso);$i++){
		$fila_r=pg_fetch_array($rs_curso,$i);
		
		for($x=0;$x<$num_1;$x++){
			 $fil_2 = @pg_fetch_array($res_1,$x);
			 $rut	= $fil_2['campo1'];	
			 $sql="SELECT promedio FROM notas$nro_ano WHERE id_ramo=".$fila_r['id_ramo']." AND rut_alumno=".$fil_2['campo1'];
			 $rs_nota = pg_exec($conn,$sql);
			 
			 $fila_n = pg_fetch_array($rs_nota,0);
			 
			 if($fila_n['promedio']!=""){
				echo "<br>". $sql="INSERT INTO promedio_sub_alumno (rdb,id_ano,id_curso,id_ramo,rut_alumno,promedio) VALUES ($rdb,$ano,$curso,".$fila_r['id_ramo'].",".$fil_2['campo1'].",'".$fila_n['promedio']."')";
				 $rs_promedio = pg_exec($conn,$sql);
			 }
		}
			
	}


echo "<br><br>ok...actualizacion de datos.... "; 	
?>
