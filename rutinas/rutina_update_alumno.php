<? 

$conn=pg_connect("dbname=coi_final_22_02_2013 host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión coi.");

$conn2=pg_connect("dbname=coi_final host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión co2.");


$sql="select * from alumno";
$rs_alumno = pg_exec($conn,$sql);
for($i=0;$i<pg_numrows($rs_alumno);$i++){
	
	$fila_al=pg_fetch_array($rs_alumno,$i);
	
	
	
	$rut_alumno = $fila_al['rut_alumno'];
	$nombre_alu = $fila_al['nombre_alu'];
	$ape_pat = $fila_al['ape_pat'];
	$ape_mat = $fila_al['ape_mat'];
	$fecha_nac = $fila_al['fecha_nac'];
	$sexo = $fila_al['sexo'];
	$nacionalidad = $fila_al['nacionalidad'];
	$c_procedencia = $fila_al['c_procedencia'];
	$cq_vive = $fila_al['cq_vive'];
	$calle = $fila_al['calle'];
	$nro = $fila_al['nro'];
	$block = $fila_al['block'];
	$depto = $fila_al['depto'];
	$villa = $fila_al['villa'];
	$telefono = $fila_al['telefono'];
	$email = $fila_al['email'];
	$region = $fila_al['region'];
	$ciudad = $fila_al['ciudad'];
	$comuna = $fila_al['comuna'];
	
	
	if($nacionalidad==""){
		$nacionalidad=2;
		}
		
	if($fecha_nac==""){
		$fecha_nac='1990-01-01';
		}	
		if($c_procedencia==""){
		$c_procedencia='-';
		}
		if($cq_vive==""){
		$cq_vive="-";
		}
		if($calle==""){
		$calle="-";
		}
		if($nro==""){
		$nro="-";
		}
		if($block==""){
		$block="-";
		}
		if($depto==""){
		$depto="-";
		}
		if($villa==""){
		$villa="-";
		}
		if($telefono==""){
		$telefono="-";
		}
		if($email==""){
		$email="-";
		}
		if($region==""){
		$region=0;
		}
		if($ciudad==""){
		$ciudad=0;
		}
		if($comuna==""){
		$comuna=0;
		}
		if($sexo==""){
		$sexo=0;
		}
		
		if($ape_mat=="O'SHEE"){
		$ape_mat="OSHEE";
			
		}
	
/***********otra coneccion**********************/	
	
	$sql2 ="update alumno set nombre_alu='$nombre_alu',ape_pat='$ape_pat',ape_mat='$ape_mat',fecha_nac='$fecha_nac',sexo=$sexo,nacionalidad='$nacionalidad',c_procedencia='$c_procedencia',cq_vive='$cq_vive',calle='$calle',nro='$nro',block='$block',depto='$depto',villa='$villa',telefono='$telefono',email='$email',region='$region',ciudad='$ciudad',comuna='$comuna' where rut_alumno = $rut_alumno ";
	
	echo "<pre>";
	echo $sql2;
	echo "</pre>";
	$rs_alumno2 = pg_exec($conn2,$sql2);
}


/*echo $sql ="SELECT id_curso,letra_curso FROM curso WHERE id_ano=1203 and grado_curso=6";
$rs_curso = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($rs_curso);$i++){
	$fila =pg_fetch_array($rs_curso,$i);
	
	echo "<br>".$sql="SELECT id_curso FROM curso WHERE id_ano=1260 and grado_curso=7 and letra_curso='".$fila['letra_curso']."'";
	$rs_curso_act = pg_exec($conn,$sql);
	$id_curso = pg_result($rs_curso_act,0);
	
	echo "<br>".$sql ="select * from matricula where rut_alumno in 
(select rut_alumno from promocion where id_curso=".$fila['id_curso']." and situacion_final=1)
and id_curso=".$fila['id_curso'];
	$rs_alumno = pg_exec($conn,$sql);
	
	for($x=0;$x<pg_numrows($rs_alumno);$x++){
		$fila_a =pg_fetch_array($rs_alumno,$x);
		
		echo "<br>".$sql="INSERT INTO matricula (rut_alumno,rdb,id_ano,id_curso,fecha,bool_ar) VALUES (".$fila_a['rut_alumno'].",40251,1260,".$id_curso.",'01/01/2013',0)";
		$result =pg_exec($conn,$sql);
		
	}

} 
*/




?>







