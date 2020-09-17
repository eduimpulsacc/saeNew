<?php require('../../../../util/header.inc');?>
<?php 
		
	//$ls_criterio = $_GET["as_criterio"];
	//$ls_input    = $_GET["as_input"];
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$con			=0;	
	 $sql = "select * from archivo04 where rdb = $institucion";  
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	$ls_string = "";
	$salto = "\r\n"; 	 
	$ls_espacio= chr(9);
	$fichero = fopen("Actas/a".$institucion."_4.txt", "w+"); 
for ($j=0; $j < pg_numrows($resultado_query); $j++)
{
	$fila 		= @pg_fetch_array($resultado_query,$j);
	$rdb		= $fila['rdb']			;
	$dig_rdb	= $fila['dig_rdb']		;
	$ensenanza 	= $fila['ensenanza']	;
	$grado 		= $fila['grado']	;	
	$letra 		= $fila['letra']	;
	$nro_ano 	= $fila['nro_ano']		;		
	$alumno 	= $fila['alumno']	;
	$dig_rut 	= $fila['dig_rut']		;	
	$cod_decreto= $fila['cod_decreto']	;
	$cod_eval 	= $fila['cod_eval']		;	
	$subsector 	= $fila['subsector'];
	if (chop($fila['promedio1'])==".")
		$promedio1 = "";
	else
		$promedio1 	= chop($fila['promedio1']);
		
	$promedio2 	= chop($fila['promedio2']);
	$promedio3 	= chop($fila['promedio3']);
	
	
	
	$con = $con + 1;
	
	if ($institucion == 9827){
    if ($promedio1==3.9){
    $promedio1=4.0;
	 }
	
	if ($promedio2==3.9){
    $promedio2=4.0;
	 }
	if ($promedio3==3.9){
    $promedio3=4.0;
	 
	 }
	}
	
	$ls_string = "4" . "$ls_espacio" . trim($rdb) . "$ls_espacio";
	$ls_string = $ls_string . trim($dig_rdb) . "$ls_espacio";
	$ls_string = $ls_string . ltrim($ensenanza) . "$ls_espacio";
	$ls_string = $ls_string . trim($grado) . "$ls_espacio";
	$ls_string = $ls_string . trim($letra)  . "$ls_espacio";
	$ls_string = $ls_string . trim($nro_ano) . "$ls_espacio";
	$ls_string = $ls_string . trim($alumno) . "$ls_espacio";
	$ls_string = $ls_string . trim($dig_rut) . "$ls_espacio";
	$ls_string = $ls_string . trim($cod_decreto). "$ls_espacio";
	$ls_string = $ls_string . trim($cod_eval). "$ls_espacio";		
	$ls_string = $ls_string . trim($subsector). "$ls_espacio";		
	$ls_string = $ls_string . trim($promedio1). "$ls_espacio";		
	$ls_string = $ls_string . trim($promedio2). "$ls_espacio";		
	$ls_string = $ls_string . trim($promedio3). "$salto";
	
	@ fwrite($fichero,"$ls_string"); 
}

fclose($fichero); 
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
                      <table width="100%" height="172" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td height="71"><div align="right">
                        <?php if ($_PERFIL==0){ ?><INPUT name=btnXLS TYPE="button" class = "botonXX" id="btnXLS"  onClick=document.location="Archivo04_xls.php" value="EXCEL"><?php }?>      <INPUT class = "botonXX"  TYPE="button" value="VOLVER" name=btnModificar  onClick=document.location="Volver04.php">
                          </div></td>
                        </tr>
                        <tr height=30 >
                          <td height="25" class="fondo"><div align="center"> Generaci&oacute;n Electr&oacute;nica de la Informaci&oacute;n de Promoci&oacute;n Final </div></td>
                        </tr>
                        <tr>
                          <td><div align="center">
                              <p><strong><font face="Verdana, Arial, Helvetica, sans-serif">Archivo 04. Antecedentes Acad&eacute;micos de los Estudiantes </font></strong></p>
                            <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                              archivo ha sido creado con el nombre de <a href='Actas/a<? echo $institucion ?>_4.txt'> &quot;a<? echo $institucion ?>_4.txt&quot;</a> <br>
                        <br>
                              </strong></font></p>
                          </div></td>
                        </tr>
                        <tr>
                          <td><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Para guardar el archivo en su PC Solo debe clickear con el boton derecho sobre el Link que esta en el nombre del archivo y elegir la opcion &quot;<strong>guardar destino como</strong>&quot; (Save Target As)</font></div></td>
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