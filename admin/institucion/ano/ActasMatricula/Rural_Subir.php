<?php require('../../../../util/header.inc');
	
 /*$filename = "comuna2.txt";
  if (file_exists("$filename")) {
       $fp 	= fopen($filename, "r");
       $linea = fread($fp, filesize($filename));
       fclose($fp);
  }else{
       $linea = "No lee Archivo.txt";  	
  }


//echo int ('pg_loimport -u postgres -p usuariocoegc10 -d --localhost sae_rural /Actas/comuna');
//exit;

//	$result1 =@pg_Exec($conn,$qry1);
   $database = $conn;
   pg_exec($database, "begin");
   $oid = pg_loimport($conn, "/Actas/comuna");
   pg_exec($database, "commit");
exit; */


/*COPY Tabla (campo1, campo2, etc....) from '/ruta/archivocondatos' with 
delimiter '|' null ' '; 
el null es para indicarle al motor que los campos que no se indican arriba 
(campo1, campo2, etc....) debe llenarlos con null.*/

//copy comuna from {'/Actas/comuna2' | stdin} delimiters '\t';

//COPY tabla_destino FROM '/path/archivo_datos.txt'  USING DELIMITERS '=,';

//$fichero = fopen("comuna2.txt", "r+"); 
//con.query("\copy tabla from 'tabla.txt'")



//$qry= "copy comuna2 from '/opt/www/coeint/admin/institucion/ano/ActasMatricula/comuna2.txt' USING DELIMITERS '\t'";
//$result= pg_exec($conn,$qry);



?>
<!--form action="subir.php" method="post" name="miformu" enctype="multipart/form-data"> 
<input name="archivo" type="file"> 
</form-->


<html>
<head>
<title>Sae - Sistema de administración escolar</title>
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

<body>
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
                                  <tr >
                                    <td height="25" class="fondo">Generaci&oacute;n Electr&oacute;nica de la Informaci&oacute;n de Base de Datos Rural </td>
                                  </tr>
                                  <tr>
                                    <td><div align="center">
                                        <p>&nbsp;</p>
                                      <p><strong><font face="Verdana, Arial, Helvetica, sans-serif">Archivos 
                                        Datos Rural</font></strong></p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><a href="comuna2.txt">Comunas</a> <br><br><br>
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
<? pg_close($conn); ?>
</body>
</html>