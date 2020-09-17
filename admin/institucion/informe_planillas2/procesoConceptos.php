<?php 
require('../../../util/header.inc');

$institucion 	=$_INSTIT;
$ano			=$_ANO;
$plantilla		= $_POST['plantilla'];


$contador = $_POST['contador'];

for($i=0;$i<$contador;$i++){
	$evaluacion = $_POST['evalu'][$i];
	$concepto	= $_POST['concepto'][$i]; 
	$nota_min	= $_POST['nota_minima'][$i];
	$nota_max	= $_POST['nota_maxima'][$i];
	$concep		= $_POST['cmbCONCEPTO'][$i];
	
	$sql ="UPDATE informe_concepto_eval SET nota=".$evaluacion." WHERE id_plantilla=".$plantilla." AND id_concepto=".$concepto;
	$rs_concepto = @pg_exec($conn,$sql) or die("UPDATE FALLO:".$sql);
	
	$sql ="SELECT * FROM informe_cuadro_eval WHERE id_plantilla=".$plantilla." AND id_concepto=".$concepto;
	$rs_cuadro =@pg_exec($conn,$sql) or die("SELECT FALLO:".$sql);
	
	if(@pg_numrows($rs_cuadro)==0){
		$sql ="INSERT INTO informe_cuadro_eval (id_plantilla, id_concepto, nota_minima, nota_maxima) VALUES(".$plantilla.",".$concep.", ".$nota_min.",".$nota_max.")";
	}else{
		$sql ="UPDATE informe_cuadro_eval SET nota_minima=".$nota_min.", nota_maxima=".$nota_max." WHERE id_plantilla=".$plantilla." AND id_concepto=".$concep;
	}
		$rs_eval = @pg_exec($conn,$sql) or die("SQL FALLO:".$sql);
	
}

echo "<script>window.location='cuadro_evaluacion.php?plantilla=$plantilla'</script>";
pg_close($conn);
?>
