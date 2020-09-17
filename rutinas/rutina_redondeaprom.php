<?

//echo "modificado";
//exit;
// rutina para agregar 0 a promedios menores a 1
$id_base =4;
$rdb =9107;



 if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
	$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi�a");	
	}

  if($id_base==3){
	$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Antofagasta.");	
	//$conn=pg_connect("dbname=coi_antofagasta host=190.196.32.148 port=5432 user=postgres password=300600") or die ("Error de conexion Antofagasta.");	
	 }
	 
  if($id_base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
	$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
	 }
	
//voy a buscar los años del colegio
$sql1="select * from ano_escolar where id_institucion=$rdb order by id_ano";
$rs1 = pg_exec($conn,$sql1);
for($a=0;$a<pg_numrows($rs1);$a++){
$fila_a = pg_fetch_array($rs1,$a);
$id_ano = $fila_a['id_ano'];
$nro_ano = $fila_a['nro_ano'];	

//cursos
$sql_c = "select * from curso where id_ano = $id_ano and ensenanza>10 order by ensenanza,grado_curso,letra_curso";
$rsc = pg_exec($conn,$sql_c);
for($xx=0;$xx<pg_numrows($rsc);$xx++){
$fila_cc = pg_fetch_array($rsc,$xx);
$cursor=$fila_cc['id_curso'];

//ramos
 $sql_r="select * from ramo where id_curso=$cursor and modo_eval=1";
$rsr = pg_exec($conn,$sql_r);
for($rr=0;$rr<pg_numrows($rsr);$rr++){
	$fila_rr = pg_fetch_array($rsr,$rr);
	$ramor=$fila_rr['id_ramo'];
	//voy por las notas que necesito
	echo "<br>".$sqlnn="select * from notas$nro_ano where id_ramo=$ramor";
	$rnn = pg_exec($conn,$sqlnn);
	//$fila_nn = pg_fetch_array($rnn,0);
	for($np=0;$np<pg_numrows($rnn);$np++){
		$fila_nn = pg_fetch_array($rnn,$np);
		$nota1=$fila_nn['nota1'];
		$promedion=$fila_nn['promedio'];
		$rut_n=$fila_nn['rut_alumno'];
		$id_periodo=$fila_nn['id_periodo'];
		
		if($nota1<10){
		$nota1 = $nota1*10;
		echo "<br>".$sql_upn ="update notas$nro_ano set nota1='$nota1' where rut_alumno=$rut_n and id_periodo=$id_periodo and id_ramo=$ramor ";
		$rno = pg_exec($conn,$sql_upn);
		}
		if($promedion<10){
		$promedion = $promedion*10;
		echo "<br>".$sql_upp ="update notas$nro_ano set promedio='$promedion' where rut_alumno=$rut_n and id_periodo=$id_periodo and id_ramo=$ramor ";
		$rpm = pg_exec($conn,$sql_upp);	
		}
	}

}

}
 
//promocion
echo "<br>".$sql2="select * from promedio_sub_alumno where id_ano = $id_ano and promedio not in('0','MB','B','S','I',' ','x','P','AL','L','NL','EP','X','EX','G','RV','N','NO')" ;
$rs2 = pg_exec($conn,$sql2);
for($b=0;$b<pg_numrows($rs2);$b++){
	$fila_b = pg_fetch_array($rs2,$b);
	echo "<br>".$fila_b['promedio'];
	$curso = $fila_b['id_curso'];
	$ramo = $fila_b['id_ramo'];
	$alu =  $fila_b['rut_alumno'];
	
	if($fila_b['promedio']<10){
		$notaf = $fila_b['promedio']*10;
		echo $sql3="update promedio_sub_alumno set promedio='$notaf' where rdb=$rdb and id_ano=$id_ano and id_curso=$curso and id_ramo=$ramo and rut_alumno=$alu";
		$rs3 = pg_exec($conn,$sql3);
	
	}
}



}
?>
