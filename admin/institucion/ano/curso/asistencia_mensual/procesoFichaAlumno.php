<?php

require('../../../../../util/header.inc');
// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects=array(
"cmb_ano"=>"lista_ano",
"cmb_curso"=>"lista_curso"
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
	
	
	 $sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto
FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo 
WHERE (((curso.id_ano)=".$opcionSeleccionada.")) $whe_perfil_curso
ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";

$resultado_query_cue = @pg_exec($conn,$sql_curso); 
				 
 // Comienzo a imprimir el select
	echo ": <select name='".$selectDestino."' id='".$selectDestino."' onChange='cargartabla()'>";
	echo "<option value='0'>Elige</option>";
	for($i=0; $i<pg_numrows($resultado_query_cue); $i++)
	{
		$fila=pg_fetch_array($resultado_query_cue,$i); 
		$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
		
		
		echo "<option value='".$fila['id_curso']."'>".$Curso_pal."</option>";
	}			
	echo "</select>";                

}
?>