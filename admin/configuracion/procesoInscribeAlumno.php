<?	require('../../util/header.inc');


for($i=0;$i<$cont;$i++){
	$rut_alumno = ${"noinscrito".$i};
	if($rut_alumno!=""){
		$sql = "SELECT * FROM inscribe_proyecto WHERE  rut_alumno=".$rut_alumno." AND id_proy=".$id_pro;
		$rs_alumno = @pg_exec($conn,$sql);
		if(@pg_numrows($rs_alumno)==0){
			$sql = "INSERT INTO inscribe_proyecto (rut_alumno,id_proy) VALUES(".$rut_alumno.",".$id_pro.")";
			$rs_proyecto = pg_exec($conn,$sql);
		}
	}
}

for($i=0;$i<$cuenta;$i++){
	$rut_alumno = ${"inscrito".$i};
	if($rut_alumno!=""){
		$sql = "SELECT * FROM inscribe_proyecto WHERE  rut_alumno=".$rut_alumno." AND id_proy=".$id_pro;
		$rs_alumno = @pg_exec($conn,$sql);
		if(@pg_numrows($rs_alumno)!=0){
			$sql = "DELETE FROM inscribe_proyecto WHERE id_proy=".$id_pro." AND rut_alumno=".$rut_alumno."";
			$rs_proyecto = pg_exec($conn,$sql);
		}
	}
}


echo "<script>window.location='inscribeAlumnosProyecto.php?id_pro=".$id_pro."'</script>";


pg_close($conn);?>