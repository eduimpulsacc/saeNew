<?php 
require('../../../../../util/header.inc');
$ano			=$_ANO;
$empleado		=$_NOMBREUSUARIO;

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



foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
  // echo $asignacion."<br>";
}


if($accion==1){//insertar

  $sql_ins = "insert into entrevista_jefeutp (id_ano, id_curso,rut_emp,rut_entrevistado,fecha,tipo,observaciones, acuerdos)
values ($ano,$curso,'".trim($empleado)."',$cmb_entrevistado,'".CambioFecha($fecha_entrevista)."',$tipo,'$obs_entrevista','$obs_acuerdos')";
$result=@pg_Exec($conn, $sql_ins);

if(!$result)
		{
			echo 0;	
		}else{
			echo 1;
		}
}
elseif($accion==2){//modificar

	 $sql_up="update entrevista_jefeutp set fecha = '".CambioFecha($fecha_entrevista)."' , observaciones='$observaciones', acuerdos='$acuerdos'
where id_entrevista = ".$id_entrevista;
	
$result=@pg_Exec($conn, $sql_up);

	if(!$result)
		{
			echo 0;	
		}else{
			echo 1;
		}	
}
elseif($accion==3){//eliminar
echo $sql_del = "delete from entrevista_jefeutp where id_entrevista = ".$id_entrevista;
$result=@pg_Exec($conn, $sql_del);

	if(!$result)
		{
			echo 0;	
		}else{
			echo 1;
		}
}




?>

