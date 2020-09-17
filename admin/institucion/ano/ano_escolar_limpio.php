<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link  rel="shortcut icon" href="../../../images/icono_sae_33.png">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css"> 
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="1280" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="100%" align="left" valign="top">
	   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" align="center" valign="top">ACA IMAGEN IZQUIERDA</td>
          <td width="640" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   //include("../../../cabecera/menu_superior.php");
			   ?>
              </td>
         </tr>
         <tr align="left" valign="top"> 
            <td height="83" colspan="3">
				   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         ACA MENU LATERAL
						
					  </td>
                      <td align="left" valign="middle" class="s">CONTENIDO DE LA PAGINA
					 </td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">PIE DE PAGINA</td>
                    </tr>
                  </table>
		    </td>
         </tr>
       </table>
    </td>

  </tr>
</table>

</td>

    <td width="53" align="center" valign="top" height="100%" >ACA IMAGEN DERECHA</td>
  </tr>
</table> 
<?
	pg_close($conn);
	pg_close($connection);
?>
</body>
</html>
