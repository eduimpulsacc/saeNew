<?
// Rutina para varias cosas
$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");


$qry_1 = "select * from temporal_dav";
$res_1 = @pg_Exec($conn,$qry_1);
$num_1 = @pg_numrows($res_1);


for ($i=0; $i < $num_1; $i++){
    $fil_1 = @pg_fetch_array($res_1,$i);
    $rut_alumno  	= $fil_1['campo1'];
   /* $calle        	= $fil_1['campo2'];
	$nro        	= $fil_1['campo3'];
	$block        	= $fil_1['campo4'];
	$dept        	= $fil_1['campo5']; 
	$villa        	= $fil_1['campo6'];
	$telefono       = $fil_1['campo7'];*/
	$nombre			= $fil_1['campo2'];
	$ape_pat		= $fil_1['campo3'];
	$ape_mat		= $fil_1['campo4'];
	 if($fil_1['campo5']=="M") $genero = 2; else $genero=1;
	$fecha_ac		= $fil_1['campo6'];
	
	
	$sql_upd = "update alumno set nombre_alu='".$nombre."', ape_pat='".$ape_pat."', ape_mat='".$ape_mat."', fecha_nac='".$fecha_nac."', sexo='".$genero."' where rut_alumno = '".trim($rut_alumno)."'";
	$res_upd = pg_Exec($conn,$sql_upd);		 
	
}	

echo "<br><br>ok...actualizacion de datos.... "; 	
?>
