<?php
function validaValor($cadena)
{
	// Funcion utilizada para validar el dato a ingresar recibido por GET	
	if(eregi('^[a-zA-Z0-9._αινσϊρ‘!Ώ? -]{1,70}$', $cadena)) return TRUE;
	else return FALSE;
}

$valor=trim($_GET['dato']); $campo=trim($_GET['actualizar']);

	// Si los campos son validos, se procede a actualizar los valores en la DB
	$conn=pg_connect("dbname=coe_traspaso host=200.2.201.33 port=1550 user=postgres password=cole#newaccess") or die ("No puede conectarme");

	// Actualizo el campo recibido por GET con la informacion que tambien hemos recibido
	$sql="UPDATE notas2007 SET nota1='$valor' WHERE rut_alumno = '19703862' and id_ramo = '119640'";
	$res_sql = @pg_Exec($conn, $sql); 
// No retorno ninguna respuesta
?>