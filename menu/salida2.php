<?
require('../util/header.inc');
session_start();
$institucion = $_INSTIT;
$qry = "select direccion from salida where rdb = '$institucion'";
$res = pg_Exec($qry);
if(pg_numrows($res)==1)
{
	$fila = pg_fetch_array($res,0);
	$direccion = $fila['direccion'];
}else{
	$direccion = "http://www.colegiointeractivo.com";
}
@session_unset('_CHK_ID');
@session_unset('_USUARIO');
@session_unset('_NOMBREUSUARIO');
@session_unset('_NOMBREUSUARIO2');
@session_unset('_POSP');
@session_unset('_MDINAMICO');
@session_unset('_PERFIL');
@session_unset('_USUARIOENSESION');
@session_unset('_URLBASE');
@session_unset('_INSTIT');
@session_unset('_FRMMODO');
@session_unset('_ALUMNO');
@session_unset('_ANO');
@session_unset('_CURSO');
@session_unset('_TIPOREGIMEN');
@session_unset('_APODERADO');
@session_unset('_EMPLEADO');
@session_unset('_OCULTAMENUSUPERIOR');
@session_destroy('_CHK_ID');
@session_destroy('_USUARIO');
@session_destroy('_NOMBREUSUARIO');
@session_destroy('_NOMBREUSUARIO2');
@session_destroy('_POSP');
@session_destroy('_MDINAMICO');
@session_destroy('_PERFIL');
@session_destroy('_USUARIOENSESION');
@session_destroy('_URLBASE');
@session_destroy('_INSTIT');
@session_destroy('_FRMMODO');
@session_destroy('_ALUMNO');
@session_destroy('_ANO');
@session_destroy('_CURSO');
@session_destroy('_TIPOREGIMEN');
@session_destroy('_APODERADO');
@session_destroy('_EMPLEADO');
@session_destroy('_OCULTAMENUSUPERIOR');

?>

<script>window.location = '<?=$direccion?>'</script>

