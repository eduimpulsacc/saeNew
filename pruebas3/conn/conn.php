<?
session_start();	
/// es de otra corporaci�n... debe conectar a la base de datos nueva coi_corporacion
$conn=pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de 
conexi�n.");			 
?>


