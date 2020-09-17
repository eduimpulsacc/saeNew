<?php 
require("../util/header.php");
session_start();
$_POSP=0; 
$_INSTIT=24977;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin9" />
<link  rel="shortcut icon" href="../images/icono_sae_33.png">
<link href="../menu_new/head.css" rel="stylesheet" type="text/css" />
<link href="../cabecera_new/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../menu_new/css/styles.css">
<link href="../cortes/24977/estilos.css" rel="stylesheet" type="text/css"> 
<link href="../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css"> 
<script type="text/javascript" src="../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script><script type="text/javascript" src="../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.js"></script>

<title>SISTEMA SAE:====> PLANIFICACION</title>
</head>

<body leftmargin="0" marginheight="0" rightmargin="0" marginwidth="0">


<table width="1280" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td rowspan="3" valign="top" background="../cortes/24977/fondo_01_reca.jpg" width="50"  height="900"></td>
    <td colspan="2" align="left" valign="top" height="70"><? include("../cabecera_new/head.php");?></td>
    <td rowspan="3" background="../cortes/24977/fomdo_02_reca.jpg" width="53" height="900"></td>
  </tr>
  <tr>
    <td valign="top" align="left"><? include("../menu_new/index.php");?></td>
    <td valign="top" align="center"><br />
<br />
<table width="870" border="0" cellpadding="0" cellspacing="0" class="cajaborde" >
                          <tr>
                            <td width="5%" colspan="4">
                            
                            <br />
                            
                            
<table width="650" border="0" align="center">
  <tr>
    <th colspan="3" scope="col" class="tableindex">DATOS DE DESARROLLO</th>
    </tr>
  <tr>
    <td width="150">&nbsp;</td>
    <td width="500">&nbsp;</td>
     </tr>
  <tr>
    <td class="cuadro02">PROGRAMADOR</td>
    <td class="cuadro01"><label for="textfield"></label>
      <input type="text" name="textfield" id="textfield" value="CLAUDIA CANTO" size="30"/></td>
   
  </tr>
  <tr>
    <td class="cuadro02">FECHA DE ASIGNACIÓN</td>
    <td class="cuadro01"><label for="textfield"></label>
      <input type="text" name="textfield" id="textfield" value="06/07/2015" size="30"/></td>
   
  </tr>
  <tr>
    <td class="cuadro02">FECHA DE ENTREGA</td>
    <td class="cuadro01"><label for="textfield"></label>
      <input type="text" name="textfield" id="textfield" value="08/07/2015" size="30"/></td>
   
  </tr>
  <tr>
    <td class="cuadro02">&nbsp;OBSERVACIONES</td>
    <td class="cuadro01"><label for="textfield2"></label>
      <textarea name="textfield2" id="textfield2" ROWS="5" COLS="50">SE CREA MODULO CON NUEVA FICHA MEDICA, Y VALIDACIONES CON ALERTAS PARA EL APODERADO EN LA SECCIÓN DE FICHA ACADEMICA, DEL MISMO PERFIL. TODO SEGUN LAS INDICACIONES ENTRAGADAS</textarea></td>
     </tr>
 
  <tr>
    <td colspan="3" align="right"><input type="submit" name="button" id="button" value="GUARDAR" class="botonXX"/>
      <input type="submit" name="button2" id="button2" value="VOLVER" class="botonXX" /></td>
    </tr>
</table>

                            <br />
                            
                            </td>
                          </tr>
                          </table></td>
  </tr>
  <tr>
    <td valign="top" colspan="2" align="left"><? include("../cabecera_new/footer.html");?></td>
  </tr>
</table>




</body>

</html>
