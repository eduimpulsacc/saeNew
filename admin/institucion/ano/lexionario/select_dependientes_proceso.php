
<?php
require('../../../../util/header.inc');

// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects=array(
"cmb_curso"=>"lista_curso",
"cmb_ramo"=>"lista_ramo"
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
		

 	 
$sql="select distinct id_ramo, ramo.cod_subsector, subsector.nombre
from ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector
where id_curso='$opcionSeleccionada' ";
           
	
	$rs_ramo=pg_exec($conn,$sql) or die ("select fallo:".$sql);		
		
	// Comienzo a imprimir el select
	echo "<select name='".$selectDestino."' id='".$selectDestino."' onChange='cargadatos(0)'>";
	echo "<option value='0'>Elige</option>";
	for ($i=0; $i< pg_numrows($rs_ramo);$i++)
	{
	  	
	$fila=pg_fetch_array($rs_ramo,$i);
		
	// Imprimo las opciones del select
	echo "<option value='".$fila['id_ramo']."'>".$fila['nombre']."</option>";
	}			
	echo "</select>";
}
?>