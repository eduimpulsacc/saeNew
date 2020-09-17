<? 
//$conn=pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");
$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_antofagasta host=200.29.70.184 port=5432 user=postgres password=anto2010") or die ("Error de conexión Antofagasta.");
//$conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión.");
// borrar matricula de cursos
//$borra = "delete from matricula where id_ano = '580'";
//$res_borra = @pg_Exec($conn,$borra);

$sql = "select * from temporal_dav ";
$res = pg_Exec($conn, $sql);
echo "<br>TOTAL DE DATOS--> ".$num = pg_numrows($res);


for ($i = 0; $i < $num; $i++){
    $fil = pg_fetch_array($res,$i);
	
	$rut_alumno = $fil['campo1'];
	$dig        = $fil['campo2'];
	$nombres    = $fil['campo3'];
	$ape_pat    = $fil['campo4'];
	$ape_mat    = $fil['campo5'];
	$sexo       = $fil['campo6'];
	$comuna     = $fil['campo7'];
	$ciudad     = $fil['campo8'];
	$region     = $fil['campo9'];	
	$fecha_mat  = $fil['campo10'];
	$id_curso   = $fil['campo11'];
	$nacionalidad = 2;
	$fecha_nac  = $fil['campo12'];
	$id_ano     = "1156";
	$rdb        = "1676";
	
	$direccion  = $fil['campo13'];
	/*$numero     = $fil['campo14'];*/
	/*$telefono   = $fil['campo14'];
	/*
	$direccion  = $fil['campo11'];
	$numero     = $fil['campo12'];
	$telefono   = $fil['campo13'];
	$n_lista    = $fil['campo14'];
	$fecha_mat  = $fil['campo15'];
	$id_curso   = $fil['campo16'];
	$id_ano     = $fil['campo17'];
	*/
	$dd = substr($fecha_nac,0,2);
	$mm = substr($fecha_nac,3,2);
	$aa = substr($fecha_nac,6,4);
	
	$fecha_nac = "$aa-$mm-$dd";		
																																
	
	$dd1 = substr($fecha_mat,0,2);
	$mm1 = substr($fecha_mat,3,2);
	$aa1 = substr($fecha_mat,6,4);
																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																															
	$fecha_mat= "$aa1-$mm1-$dd1";
	
	///////  buscar al alumno en la tabla alumno para ver si existe o no
	
	$sql2 = "select rut_alumno from alumno where rut_alumno = '".trim($rut_alumno)."'";
	$res2 = pg_Exec($conn,$sql2);
	$num2 = pg_numrows($res2);
	
		
	if ($num2==0){
	    echo "inserto alumno--- <br>";
	    /// no existe, ingresar en la tabla alumno
		echo $sql3 = "insert into alumno (rut_alumno, dig_rut, nombre_alu, ape_pat, ape_mat, sexo, fecha_nac, region, ciudad, comuna) 
		values ('$rut_alumno','$dig','$nombres','$ape_pat','$ape_mat','$sexo','$fecha_nac','$region','$ciudad','$comuna')";
		$res3 = pg_Exec($conn,$sql3);
		
		/// alumno insertado
	}else{
	    echo "existe... <br>";
	    //Actualizo los datos de los alumnos
		$sql6 = "update alumno set  telefono = '$telefono', calle='".$direccion."' where rut_alumno = '".trim($rut_alumno)."'";
		$res6 = pg_Exec($conn, $sql6);		
	    
	}
	
	
	/// buscar en Matrícula al alumno para ese año
	
	$sql4 = "select rut_alumno from matricula where id_ano='$id_ano' AND rut_alumno = '".trim($rut_alumno)."'";
	$res4 = pg_Exec($conn,$sql4);	
	$num4 = pg_numrows($res4);
	
	if ($num4==0){
	     /// inserto x que no existe
	    $bool_ed=0;
	    $bool_mun=0;
	    $bool_cpadre=0;
	    $bool_otros=0;
	    $bool_seg=0;
	    $bool_baj=0;
	    $bool_bchs=0;
	    $bool_aoi=0;
	    $bool_rg=0;
	    $bool_ae=0;
	    $bool_i=0;
	    $bool_gd=0;
	    $bool_ar=0;
		
		//echo "<br>rut_alumno faltante--> ".$rut_alumno;
		$cont_faltante++;
	    	
		echo "<br><br>".$sql5 = "insert into matricula (rut_alumno, rdb, id_ano, id_curso, fecha, num_mat, bool_baj, bool_bchs, bool_aoi, bool_rg, bool_ae, bool_i, bool_gd, bool_ar, nro_lista, bool_ed, bool_mun, bool_cpadre, bool_otros, bool_seg) values ('".trim($rut_alumno)."','$rdb','$id_ano','$id_curso', '$fecha_mat', '0', '$bool_baj','$bool_bchs','$bool_aoi','$bool_rg','$bool_ae','$bool_i','$bool_gd','$bool_ar','0','$bool_ed','$bool_mun','$bool_cpadre','$bool_otros','$bool_seg')";
		$rs5 = pg_exec($conn,$sql5);
		
		
	}else{
	    $cont_existe++;	
	
	}	
	
}
	echo "<br> faltan -->".$cont_faltante;
	echo "<br> existen -->".$cont_existe;
	echo "<br> I -->".$i;
	


?>