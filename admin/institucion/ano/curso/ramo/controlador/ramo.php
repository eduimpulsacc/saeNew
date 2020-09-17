<?
include('../modelo/ramo.php');

function get_institucion($institucion, $conn){
    $fil = datos_institucion($institucion, $conn);
	
	return $fil;
}

function get_ano($id_ano, $conn){
   $fil = datos_ano_escolar($id_ano, $conn);
   
   return $fil;
}   

function get_subsector($id_ramo, $conn){
   $fil = datos_subsector($id_ramo, $conn);
   
   return $fil;
}

function get_ramo($id_ramo, $conn){
   $fil = datos_ramo($id_ramo, $conn);
   
   return $fil;
}

function get_docente($id_ramo, $conn){
   $fil = datos_docente($id_ramo, $conn);
   
   return $fil;
}
function get_ayudante($id_ramo, $conn){
   $fil = datos_ayudante($id_ramo, $conn);
   
   return $fil;
}
function get_examen_semestral($id_ramo, $conn){
   $examenes = array();
   $examenes = datos_examen_semestral($id_ramo, $conn);
   
   return $examenes;
}
function get_all_docentes($institucion, $conn){
   $docentes = array();
   $docentes = datos_all_docentes($institucion, $conn);
   
   return $docentes;
}

function actualizar_ramo($datos, $id_ramo, $conn){
    $valor = actualiza_por_ramo($datos, $id_ramo, $conn);
	return $valor;
}

?>
