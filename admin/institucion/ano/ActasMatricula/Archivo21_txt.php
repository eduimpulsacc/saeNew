<?php require('../../../../util/header.inc');?>
<?php 

	//$ls_criterio = $_GET["as_criterio"];
	//$ls_input    = $_GET["as_input"];
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	
	$sql = "SELECT institucion.rdb, institucion.rdb, institucion.dig_rdb, institucion.nombre_instit, institucion.calle, institucion.nro, institucion.telefono, institucion.email, institucion.fecha_resolucion, institucion.nu_resolucion, empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_mat, empleado.ape_pat, comuna.nom_com ";
	$sql = $sql . "FROM empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp, institucion INNER JOIN comuna ON (institucion.comuna = comuna.cor_com) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.region = comuna.cod_reg) ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((trabaja.cargo)=1) AND ((trabaja.rdb)=".$institucion."));";

	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	
	$fichero = @fopen("Actas/m".$institucion."_21.txt", "w+"); 
	
for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);
 

$li_rdb = trim(pg_result($resultado_query, $j, 1));
$li_dig_rdb = trim(pg_result($resultado_query, $j, 2));
$li_nombre_instit = trim(pg_result($resultado_query, $j, 3));
$li_direccion = trim(pg_result($resultado_query, $j, 4)). " " .  trim(pg_result($resultado_query, $j, 5));
$li_telefono = trim(pg_result($resultado_query, $j, 6));
$li_celular = " ";
$li_email = trim(pg_result($resultado_query, $j, 7));
$li_localidad = trim(pg_result($resultado_query, $j, 15));
$li_fecha_resolucion = Cfecha2(pg_result($resultado_query, $j, 8));
$li_nu_resolucion = trim(pg_result($resultado_query, $j, 9));
$li_rut_emp = trim(pg_result($resultado_query, $j, 10));
$li_dig_rut = trim(pg_result($resultado_query, $j, 11));
$li_ape_pat = trim(pg_result($resultado_query, $j, 14));
$li_ape_mat = trim(pg_result($resultado_query, $j, 13));
$li_nombre_emp = trim(pg_result($resultado_query, $j, 12));


$ls_string = "21" . "$ls_espacio" . trim($li_rdb) . "$ls_espacio";
$ls_string = $ls_string . trim($li_dig_rdb)  . "$ls_espacio";
$ls_string = $ls_string . ltrim($li_nombre_instit)  . "$ls_espacio";
$ls_string = $ls_string . trim($li_direccion) . "$ls_espacio";
$ls_string = $ls_string . trim($li_telefono)  . "$ls_espacio";
$ls_string = $ls_string . trim($li_celular) . "$ls_espacio";
$ls_string = $ls_string . trim($li_email) . "$ls_espacio";
$ls_string = $ls_string . trim($li_localidad) . "$ls_espacio";
$ls_string = $ls_string . trim($li_nu_resolucion) . "$ls_espacio";
$ls_string = $ls_string . $li_fecha_resolucion . "$ls_espacio";
$ls_string = $ls_string . trim($li_rut_emp) . "$ls_espacio";
$ls_string = $ls_string . trim($li_dig_rut) . "$ls_espacio";
$ls_string = $ls_string . trim($li_ape_pat) . "$ls_espacio";
$ls_string = $ls_string . trim($li_ape_mat) . "$ls_espacio";
$ls_string = $ls_string . trim($li_nombre_emp);

	//crea un fichero
	//echo $ls_string;
		
	@fwrite($fichero,"$ls_string"); 
 
}
//@pg_close($conn);
@fclose($fichero); 

?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><?
			   include("../../../../cabecera/menu_superior.php");
			   ?>
        </td>
      </tr>
      <tr align="left" valign="top">
        <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="27%" height="363" align="left" valign="top"><?
						 $menu_lateral=3;
						 include("../../../../menus/menu_lateral.php");
						 ?>
            </td>
            <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td height="0" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                  <tr>
                    <td><!-- AQUI VA TODA LA PROGRAMACI&Oacute;N  -->
                                <table border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td  align="center" valign="top"><?
						 include("../../../../cabecera/menu_inferior.php");
						 ?>
                                    </td>
                                  </tr>
                                </table>
                                <table width="100%" height="172" border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td height="71"><div align="right">
                                        <INPUT class = "botonXX"  TYPE="button" value="VOLVER" name=btnModificar  onClick=document.location="Menu_Actas.php">
                                    </div></td>
                                  </tr>
                                  <tr height=30>
                                    <td height="25" class="fondo" align="center"> Generaci&oacute;n Electr&oacute;nica de la Informaci&oacute;n de Matr&iacute;cula Inicial </td>
                                  </tr>
                                  <tr>
                                    <td><div align="center">
                                        <p>&nbsp;</p>
                                      <p><strong><font face="Verdana, Arial, Helvetica, sans-serif">Archivo 21. Datos del Establecimiento</font></strong> </p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Actas/m<? echo $institucion ?>_21.txt'> &quot;m<? echo $institucion ?>_21.txt&quot;</a> , en total se encontraron
                                        <?=($total_filas)?>
                                        registros.<br>
                                        <br>
                                        </strong></font></p>
                                    </div></td>
                                  </tr>
                                  <tr>
                                    <td><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Para 
                                      guardar el archivo en su PC Solo debe clickear con el boton derecho sobre 
                                      el Link que esta en el nombre del archivo y elegir la opcion guardar archivo 
                                      como(Save Target As)</font></div></td>
                                  </tr>
                                </table>
                                <!-- FIN DE INGRESO DE CODIGO NUEVO -->
                    </td>
                  </tr>
                </table>
                </tr>
            </table></td>
          </tr>
          <tr align="center" valign="middle">
            <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
</table>
</td>
</tr>
</table>
</body>
</html>