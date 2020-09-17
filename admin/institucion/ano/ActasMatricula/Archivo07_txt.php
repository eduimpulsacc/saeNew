<?php require('../../../../util/header.inc');?>
<?
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
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
</style>
</head>
<body >
<center>
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
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
    <td height="71">
	  <div align="right">
		<INPUT class = "botonXX"  TYPE="button" value="VOLVER" name=btnModificar  onClick=document.location="Menu_Actas.php">
      </div></td>
  </tr>
  
  <tr height=30 bgcolor=#003b85> 
    <td height="25">
		<div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif" >
	    <strong> Generación Electrónica de la Información de Promoci&oacute;n Final </strong>
	    </font>
      </div></td>
  </tr>
  <tr> 
    <td>	  <div align="center">

      <p><strong><font face="Verdana, Arial, Helvetica, sans-serif">Archivo 07. Acta del Curso </font></strong></p>
      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
              archivo ha sido creado con el nombre de <a href='Actas/a<? echo $institucion ?>_7.txt'> &quot;a<? echo $institucion ?>_7.txt&quot;</a> <br>
          <br>
        </strong></font></p>
    </div>
	</td>
  </tr>
  <tr>
    <td>	  <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Para guardar el archivo en su PC Solo debe clickear con el boton derecho sobre el Link que esta en el nombre del archivo y elegir la opcion &quot;<strong>guardar destino como</strong>&quot; (Save Target As)</font></div>
	</td>
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
            <td height="45" colspan="2" class="piepagina">SAE Sistema 
              de Administraci&oacute;n Escolar - 2005 </td>
          </tr>
      </table></td>
    </tr>
  </table>
  </td>
      <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>"></td>
  </tr>
  </table>
<? pg_close($conn); ?>  
</center>
</body>
</html>


