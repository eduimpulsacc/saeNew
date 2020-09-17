<?php 
require('../../../../util/header.inc');

foreach($_GET as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);

//echo "asignacion=$asignacion<br>";
   }
   
   foreach($_POST as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);

 //echo "asignacion=$asignacion<br>";
   }

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

//hago el delete
$sql_del_plan="delete from plan_curricular_$nro_ano where id=$id ";
$res_ins_plan=@pg_exec($conn,$sql_del_plan);

 ?>
 <script>
 alert("Actividad eliminada exitosamente");
 window.open('InformePlanificacionCurricular_C.php?cmb_periodos=<?php echo $cmb_periodos ?>&cmb_curso=<?php echo $cmb_curso ?>','_self')
 </script>