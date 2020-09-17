<?
require("../modelo/modelo_1.php");

$corp = $_CORPORACION;
// llamado a funciones que devuelven datos

$instituciones = instituciones_por_corporacion($corp,$conn);


?>