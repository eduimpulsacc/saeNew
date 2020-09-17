<? 
require('../../../../../util/header.inc');

 
$ano	= $_ANO;
echo "cuenta-->".$count	= $_REQUEST['count'];
echo "<br> MODO-->".$frmModo = $_REQUEST['frmModo'];


if($frmModo=="modificar"){
	for($i=0;$i<$count;$i++){
		$rut_alumno = ${"rut_alumno".$i};
		$obs		= ${"obs_reporte".$i};
		
		if($obs!=""){
			$sql ="UPDATE matricula SET obs_reporte='$obs' WHERE rut_alumno=".$rut_alumno." AND id_ano=".$ano;
			$rs_matricula = @pg_exec($conn,$sql) or die ("UPDATE FALLO:".$sql);
		}

	}
}else{
	echo "prueba";
}


echo "<script>window.location='obsreporte.php?frmModo=mostrar'</script>";


?>
