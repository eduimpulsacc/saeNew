<?php

require('../../../../../util/header.inc');
// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects=array(
"cmb_curso"=>"lista_curso",
"cmb_alumno"=>"lista_alumno"
);

function validaSelect($selectDestino)
{
	// Se valida que el select enviado via GET exista
	global $listadoSelects;
	if(isset($listadoSelects[$selectDestino])) return true;
	else return false;
}

function validaOpcion($opcionSeleccionada)
{
	// Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
	if(is_numeric($opcionSeleccionada)) return true;
	else return false;
}

$selectDestino=$_GET["select"]; $opcionSeleccionada=$_GET["opcion"];

if(validaSelect($selectDestino) && validaOpcion($opcionSeleccionada))
{
	$tabla=$listadoSelects[$selectDestino];
	
	
	  $sql="select alumno.nombre_alu || '' || alumno.ape_pat || '' || alumno.ape_mat as nombre ,alumno.rut_alumno 
	from alumno inner join matricula on alumno.rut_alumno=matricula.rut_alumno
	where matricula.id_curso='$opcionSeleccionada' order by nombre";
	
	$rs_alumno=pg_exec($conn,$sql) or die ("select fallo:".$sql);
	
	// Comienzo a imprimir el select
	echo "<select name='".$selectDestino."' id='".$selectDestino."' onChange='cargaContenido(this.id)'>";
	echo "<option value='0'>Elige</option>";
	for($i=0; $i<pg_numrows($rs_alumno); $i++)
	{
		$fila=pg_fetch_array($rs_alumno,$i); 
		
		
		echo "<option value='".$fila['rut_alumno']."'>".$fila['nombre']."</option>";
	}			
	echo "</select>";
}
?>