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
    <th colspan="3" scope="col" class="tableindex">DATOS DE REVISION</th>
    </tr>
  <tr>
    <td width="99">&nbsp;</td>
    <td width="505">&nbsp;</td>
   
  </tr>
  <tr>
    <td class="cuadro02">EJECUTIVO </td>
    <td class="cuadro01"><label for="textfield"><SELECT>
  <OPTION>CLAUDIO GOMEZ</OPTION>
  <OPTION>BORIS VARGAS</OPTION>
  <OPTION>AIDA CORTES</OPTION>
</SELECT></label></td>
 
  </tr>
  <tr>
    <td class="cuadro02">ESTADO</td>
    <td class="cuadro01"><SELECT>
  <OPTION>RECHAZADO</OPTION>
  <OPTION>APROBADO</OPTION>
</SELECT></td>
   
  </tr>
 
  <tr>
    <td class="cuadro02">OBSERVACIONES</td>
    <td class="cuadro01"><label for="textfield4"></label>
      <textarea name="textfield3" id="textfield4" ROWS="5" COLS="50">SE RECHAZA DADO QUE NO POSEE LAS VALIDACIONES DE DATOS SOLICITADAS, ADEMÁS DE NO EXISTIR EL AVISO EN LA FICHA ACADEMICA EN EL PERFIL DE APODERADO</textarea></td>
   
  </tr>
  <tr>
    <td colspan="3" align="right"><input type="submit" name="button" id="button" value="GUARDAR" CLASS="botonXX" />
      <input type="submit" name="button2" id="button2" value="VOLVER" CLASS="botonXX" /></td>
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
