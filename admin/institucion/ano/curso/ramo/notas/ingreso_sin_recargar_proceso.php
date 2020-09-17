<?php
require('../../../../../../util/header.inc');
function validaValor($cadena)
{
	// Funcion utilizada para validar el dato a ingresar recibido por GET	
	//if(eregi('^[a-zA-Z0-9._αινσϊρ‘!Ώ? -]{1,40}$', $cadena)) return TRUE;
	//else return FALSE;
}

$valor=trim($_GET['valor']);
$alumno=trim($_GET['alumno']);
$ramo=trim($_GET['ramo']);
$periodo=trim($_GET['periodo']);
$casilla=trim($_GET['casilla']);

$ano = $_ANO;
$sql_ano = "select nro_ano from ano_escolar where id_ano = ".$ano;
$result_ano =@pg_Exec($conn,$sql_ano);
$fila_ano = @pg_fetch_array($result_ano,0);	
$nro_ano = $fila_ano['nro_ano'];


/// primero consultar si la informaciσn existe
$sql_existe = "select * from notas$nro_ano where rut_alumno = '".trim($alumno)."' and id_ramo = '$ramo' and id_periodo = '$periodo'";
$res_existe = @pg_Exec($conn,$sql_existe);
$num_existe = @pg_numrows($res_existe);

if ($num_existe==0){
   $sql_inserta = "insert into notas$nro_ano (rut_alumno, id_ramo, id_periodo) values ('".trim($alumno)."','$ramo','$periodo')";
   $res_inserta = @pg_Exec($conn, $sql_inserta);

}

	// Actualizo el campo recibido por GET con la informacion que tambien hemos recibido
	$sql_actualizar = "update notas$nro_ano set nota$casilla = '$valor', promedio = '$promedio' where rut_alumno = '".trim($alumno)."' and id_ramo = '$ramo' and  id_periodo='$periodo'";
	$res_actualizar = pg_Exec($conn,$sql_actualizar);
?>