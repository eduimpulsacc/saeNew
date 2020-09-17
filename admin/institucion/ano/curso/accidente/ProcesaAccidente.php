<?php 
require('../../../../../util/header.inc');


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



  $sql_ins = "insert into declaracion_accidente (id_ano,id_curso,rut_alumno,fecha,hora,minuto,dia_accidente,tipo,observaciones,nombre_testigo1,nombre_testigo2,rut_testigo1,rut_testigo2,fecha_registro,folio)
values ($anio,$curso,$alumno,'".CambioFecha($fecha_accidente)."', $hora_accidente,$minuto_accidente,$diasemana_accidente,$tipo_accidente,'".utf8_decode($observaciones)."','$nom_testigo1','$nom_testigo2','$rut_testigo1','$rut_testigo2','".date("Y-m-d")."',$folio)";
$result=@pg_Exec($conn, $sql_ins);

if(!$result)
		{
			echo 0;	
		}else{
			echo 1;
		}
}
elseif($accion==2){//modificar

	$sql_up="update declaracion_accidente set fecha = '".CambioFecha($fecha_accidente)."' ,hora='$hora_accidente' , minuto='$minuto_accidente', dia_accidente =$diasemana_accidente ,tipo=$tipo_accidente, observaciones='".utf8_decode($observaciones)."', nombre_testigo1='$nom_testigo1', nombre_testigo2='$nom_testigo2', rut_testigo1='$rut_testigo1', rut_testigo2='$rut_testigo2' where id_accidente = ".$id_accidente;
	
$result=@pg_Exec($conn, $sql_up);

	if(!$result)
		{
			echo 0;	
		}else{
			echo 1;
		}	
}
elseif($accion==3){//eliminar
$sql_del = "delete from declaracion_accidente where id_accidente = ".$id_accidente;
$result=@pg_Exec($conn, $sql_del);

	if(!$result)
		{
			echo 0;	
		}else{
			echo 1;
		}
}




?>

