<? require("../util/header.php");
session_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
<link  rel="shortcut icon" href="../images/icono_sae_33.png">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="head.css" rel="stylesheet" type="text/css" />
<link href="css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../menu_new/css/styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="1280" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="100%" align="left" valign="top">
	   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <!--<td width="53" align="center" valign="top">ACA IMAGEN IZQUIERDA</td>-->
          <td width="640" align="center" valign="top" bgcolor="f7f7f7"><? include("../cabecera_new/head.html");?></td>
         </tr>
         <tr align="left" valign="top"> 
            <td height="83" colspan="3" valign="top">
				   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <? include("../menu_new/index.php");?>
						
					  </td>
                      <td align="left" valign="middle" class="s"><? include("contenido.html");?>
					 </td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("footer.html");?></td>
                    </tr>
                  </table>
		    </td>
         </tr>
       </table>
    </td>

  </tr>
</table>

</td>

    <!--<td width="53" align="center" valign="top" height="100%" >ACA IMAGEN DERECHA</td>-->
  </tr>
</table> 
</body>
</html>
