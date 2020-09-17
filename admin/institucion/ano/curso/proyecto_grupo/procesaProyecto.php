<?	require('../../../../../util/header.inc');


$institucion	=$_INSTIT;
$ano			=$_ANO;

$pag="fichaProyecto.php?caso=1&cmbALUMNO=".$cmbALUMNO."&cmbPROYECTO=".$cmbPROYECTO."";

//ver si existen proyectos asociados con la misma fecha


function CambioFecha($fecha)   //    cambia fecha del tipo  dd/mm/aaaa  ->  aaaa/mm/dd    para poder hacer insert y update
{
	$retorno="";
	if(strlen($fecha) !=10)
		return $retorno;
	$d=substr($fecha,0,2);
	$m=substr($fecha,3,2);
	$a=substr($fecha,6,4);
	if (checkdate($m,$d,$a))
		$retorno=$a."-".$m."-".$d;
	else
		$retorno="";
	return $retorno;
}

if($caso==1){
	/*if($lenguaje!=1) $lenguaje=0;
	if($deficit!=1) $deficit=0;
	if($audicion!=1) $audicion=0;
	if($mejora_leng!=1) $mejora_leng=0;
	if($mejora_mat!=1) $mejora_mat=0;*/
	if($aprobado!=1) $aprobado=0;
	if($reprobado!=1) $reprobado=0;
	if($retirado!=1) $retirado=0;
	if($txtINSTIT=="") $txtINSTIT=" ";
	if($txtOBS=="") $txtOBS=" ";
	/*if($pa!=1) $pa=0;
	if($tea!=1) $tea=0;
	if($sda!=1) $sda=0;
	if($l!=1) $l=0;*/
	/*$sql = "INSERT INTO alumno_proyecto (rdb,id_ano,rut_alumno,id_proy, lenguaje, deficit_mental, audicion, mejora_lenguaje, mejora_matematica, aprobado, reprobado, ";
	$sql.= " retirado,id_dignos,institucion,obs,pa,tea,sda,l) VALUES(".$institucion.",".$ano.",".$cmbALUMNO.",".$cmbPROYECTO.",".$lenguaje.",".$deficit.", ";
	$sql.= "".$audicion.",".$mejora_leng.", ".$mejora_mat.",".$aprobado.", ".$reprobado.", ".$retirado.", ".$cmbDIAGNOSTICO.", '".$txtINSTIT."','".$txtOBS."', ";
	$sql.= "".$pa.",".$tea.",".$sda.",".$l.")";*/
	 $sql = "INSERT INTO alumno_proyecto (rdb,id_ano,rut_alumno,id_proy, mejora_lenguaje, mejora_matematica, aprobado, reprobado, ";
	$sql.= " retirado,id_dignos,institucion,obs,fecha_reporte) VALUES(".$institucion.",".$ano.",".$cmbALUMNO.",".$cmbPROYECTO." ";
	$sql.= ",".$mejora_leng.", ".$mejora_mat.",".$aprobado.", ".$reprobado.", ".$retirado.", ".$cmbDIAGNOSTICO.", '".$txtINSTIT."','".$txtOBS."', '".CambioFecha($fecha_reporte)."'";
	$sql.= ")";
	//die($sql);
	$rs_alumno = @pg_exec($conn,$sql);	
}elseif($caso==2){
	/*if($lenguaje!=1) $lenguaje=0;
	if($deficit!=1) $deficit=0;
	if($audicion!=1) $audicion=0;*/
	//if($mejora_leng!=1) $mejora_leng=0;
	//if($mejora_mat!=1) $mejora_mat=0;
	if($aprobado!=1) $aprobado=0;
	if($reprobado!=1) $reprobado=0;
	if($retirado!=1) $retirado=0;
	if($txtINSTIT=="") $txtINSTIT="";
	if($txtOBS=="") $txtOBS="";
	/*if($pa!=1) $pa=0;
	if($tea!=1) $tea=0;
	if($sda!=1) $sda=0;
	if($l!=1) $l=0;*/
	
	 $sql = "UPDATE alumno_proyecto SET mejora_lenguaje=".$mejora_leng.", ";
	$sql.= "mejora_matematica=".$mejora_mat.", ";
	$sql.= "aprobado=".$aprobado.",reprobado=".$reprobado.", retirado=".$retirado.", id_dignos=".$cmbDIAGNOSTICO.", institucion='".$txtINSTIT."', obs='".$txtOBS."', fecha_reporte='".CambioFecha($fecha_reporte)."' ";
	$sql.= " WHERE rdb=".$institucion." AND id_ano=".$ano."  AND rut_alumno=".$cmbALUMNO." AND id_proy=".$cmbPROYECTO."  and fecha_reporte='".$hidden_fecha."'";
	//echo $sql;exit;
	$rs_alumno= @pg_exec($conn,$sql);

}elseif($caso==3){
	$sql = "DELETE FROM alumno_proyecto WHERE rdb=".$institucion." AND  id_ano=".$ano." AND rut_alumno=".$cmbALUMNO." AND id_proy=".$cmbPROYECTO." and fecha_reporte='".$hidden_fecha."'";
	//echo $sql;exit;
	$rs_alumno = @pg_exec($conn,$sql);
	//$pag="fichaProyecto.php";
}

echo "<script>window.location='".$pag."'</script>";




pg_close($conn);?>