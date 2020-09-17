<? 	require('../../../../../util/header.inc');
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $_CURSO;	
	$ramo 			= $_RAMO;
	$frmModo		= $_FRMMODO;
	$periodo 		= $_PERIODO;
	
	$sql ="SELECT nro_ano FROM ano_escolar WHERE id_ano=".$ano;
	$rs_ano = @pg_exec($conn,$sql);
	$nro_ano = @pg_result($rs_ano,0);

if($frmModo=="modificar"){
	for($i=0;$i<$contador;$i++){
		$nota = ${"txtNOTA".$i};
		$promedio = ${"txtPROMEDIO".$i};
		$rut_alumno = ${"txtRUT".$i};
		if($nota!=""){
			$notaap=$nota;
		}else{
			$notaap=$promedio;
		}
		$sql  ="UPDATE notas$nro_ano SET notaap='".$notaap."' WHERE id_ramo=".$ramo." AND id_periodo=".$periodo." AND rut_alumno=".$rut_alumno;
		$rs_notas = @pg_exec($conn,$sql);
	}
}
if($frmModo=="eliminar"){
 	$sql  ="UPDATE notas$nro_ano SET notaap=0 WHERE id_ramo=".$ramo." AND id_periodo=".$periodo."";
	$rs_notas = @pg_exec($conn,$sql);

} 
	echo "<script>window.location='seteaApreciacion.php?caso=4&curso=$curso&id_ramo=$ramo&cmbPERIODO=$periodo'</script>";

 pg_close($conn)?>