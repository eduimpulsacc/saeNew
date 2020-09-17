
<?
require('../../util/header.inc');
require('../../util/funciones_new.php');

$ano		= $_ANO;
$curso		= $c_curso;
$alumno		= $c_alumno;
$institucion= $_INSTIT;
$_POSP = 2;
$_bot = 8;

	// REGISTRO DE HISTORIAL DE NAVEGACION
	registrarnavegacion($_USUARIO,'INFORME HOGAR',1,0,$_SERVER[REMOTE_ADDR],pg_dbname($conn),ObtenerNavegador($_SERVER['HTTP_USER_AGENT']),$_INSTIT,$_NOMBREUSUARIO,$_CURSO,$conn);
	//******************************************************//


if($funcion==1){
?>


<table width="85%" border="0" align="center">
              <tr>
                <td class="titulo_new">&nbsp;INFORME EDUCACIONAL</td>
              </tr>
            </table>
            <table width="85%" border="1" align="center">
              <tr>
                <td colspan="4">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="4">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="4">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>ALUMNO</td>
                <td>&nbsp;</td>
                <td>RUT</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>CURSO</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>PROFESOR JEFE</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
<?
}

?>