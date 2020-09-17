<?
$conn=@pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");
// borrar matricula de cursos
//$borra = "delete from matricula where id_ano = '580'";
//$res_borra = @pg_Exec($conn,$borra);


$sql = "select * from temporal_dav ";
$res = pg_Exec($conn, $sql);
$num = pg_numrows($res);

$contador_alu=0;

for ($i = 0; $i < $num; $i++){
    $fil = pg_fetch_array($res,$i);
	
	$rut_alumno   = $fil['campo1'];
	$dig          = $fil['campo2'];
	$ape_pat      = $fil['campo3'];
	$ape_mat      = $fil['campo4'];
	$nombres      = $fil['campo5'];
	$sexo         = $fil['campo6'];
	$fecha_nac    = $fil['campo7'];
	$nacionalidad = $fil['campo8'];
	
	if ($sexo==1){
	    $sexo=2;
	}else{
	    $sexo=1;
	}		
	
	$region     = 5;
	$ciudad     = 1;
	$comuna     = 1;
	
	$dd = substr($fecha_nac,0,2);
	$mm = substr($fecha_nac,3,2);
	$aa = substr($fecha_nac,6,4);
	
	$fecha_nac = "$aa$mm$dd";
	
		
	///////  buscar al alumno en la tabla alumno para ver si existe o no
	
	$sql2 = "select rut_alumno from alumno where rut_alumno = '".trim($rut_alumno)."'";
	$res2 = @pg_Exec($conn,$sql2);
	$num2 = @pg_numrows($res2);
	
		
	if ($num2==0){
	    /// no existe, ingresar en la tabla alumno
		$sql3 = "insert into alumno (rut_alumno, dig_rut, nombre_alu, ape_pat, ape_mat, region, ciudad, comuna,  sexo, fecha_nac, nacionalidad) 
		values ('$rut_alumno','$dig','$nombres','$ape_pat','$ape_mat','$region','$ciudad','$comuna','$sexo','$fecha_nac','2')";
		$res3 = pg_Exec($conn,$sql3);
		
		if ($res2){		
		     echo "alumno, nuevo insertado con exito <br>";
			 $contador_alu++;
		}else{
		     echo "error, alumno no insertado...  <br>";
		}	 
		/// alumno insertado
	}else{
	    //Actualizo digito verificador
		/*
		$sql6 = "update alumno set calle = '$calle', nro = '$nro', region = '$region', ciudad = '$ciudad', comuna = '$comuna', telefono = '$fono', sexo = '$sexo', fecha_nac = '$fecha_nac'  where rut_alumno = '$rut_alumno'";
		$res6 = pg_Exec($conn, $sql6);
		
		echo "alumno actualizado <br>";
		*/
	}	
	
}

echo "Total de alumno insertados: $contador_alu   <br>";

?>