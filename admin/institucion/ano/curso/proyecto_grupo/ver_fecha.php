<?php 
require('../../../../../util/header.inc');
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	
	//var_dump($_POST);exit;
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

if($caso==1 || ($caso==2 && ($fec_ant != CambioFecha($date)) )){
	
	$sql = "SELECT * FROM alumno_proyecto WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_proy=".$cmbPROYECTO." AND rut_alumno=".$cmbALUMNO.
" and fecha_reporte='".CambioFecha($date)."'";
$rs_existe = @pg_exec($conn,$sql);
//$fila_alumno = @pg_fetch_array($rs_existe,0);
if(pg_num_rows($rs_existe)>0)
echo 1;
else echo 0;
}
?>