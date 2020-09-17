<?php require('../../../../util/header.inc');?>
<?php 

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	
	
	
	
	
	$sql = "select * from archivo24 where rbd=" . $institucion;
	$resultado_query	= pg_exec($conn,$sql);
	$total_filas1		= pg_numrows($resultado_query);
	$fichero = @fopen("Actas/m".$institucion."_24.txt", "w+"); 
	
	
	For ($K=0; $K < $total_filas1; $K++)
	{
		$fila = @pg_fetch_array($resultado_query,$K);
		$ls_string 	= "";
		$salto 		= "\r\n"; 	 
		$ls_espacio	= chr(9);
		
		//--------------------------------------------------------------------------
		// Respuesta directa de la consulta
		//--------------------------------------------------------------------------
		$Rdb 				= trim($fila['rbd']);
		$DigRdb 			= trim($fila['dig_rbd']);
		$TipoEnseñanza		= trim($fila['tipo_ensenanza']);
		$Grado				= trim($fila['grado']);
		$Letra				= trim($fila['letra']);
		$AnoEscolar			= trim($fila['ano_escolar']);
		$RutProfe			= trim($fila['rut_profe']);
		$DigProfe			= trim($fila['dig_profe']);
		$ApePatProfe		= trim($fila['apepat_profe']);
		$ApeMatProfe		= trim($fila['apemat_profe']);
		$NombresProfe		= trim($fila['nombre_profe']);
		$Jornada			= trim($fila['jornada']);		 		
		$TipoCurso 			= trim($fila['tipo_curso']);		 		
		$AlumnosHombres 	= trim($fila['nro_hombres']);
		$AlumnosMujeres 	= trim($fila['nro_mujeres']);
		$AlumnosHombresIndi = trim($fila['nro_hombre_indig']);
		$AlumnosMujeresIndi = trim($fila['nro_mujer_indig']);
		$AlumnasEmbara 		= trim($fila['nro_mujer_emb']);
	
	   	
	
			//------------------------------------------------------------------------				
			
			$ls_string 		= "24" . "$ls_espacio";
			$ls_string 		= $ls_string . $Rdb					. "$ls_espacio";
			$ls_string 		= $ls_string . $DigRdb				. "$ls_espacio";
			$ls_string 		= $ls_string . $TipoEnseñanza		. "$ls_espacio";
			$ls_string 		= $ls_string . $Grado				. "$ls_espacio";
			$ls_string 		= $ls_string . $Letra				. "$ls_espacio";
			$ls_string 		= $ls_string . $AnoEscolar			. "$ls_espacio";
			$ls_string 		= $ls_string . $Jornada				. "$ls_espacio";
			$ls_string 		= $ls_string . $TipoCurso			. "$ls_espacio";
			$ls_string 		= $ls_string . $AlumnosHombres		. "$ls_espacio";
			$ls_string 		= $ls_string . $AlumnosMujeres		. "$ls_espacio";
			$ls_string 		= $ls_string . $AlumnosHombresIndi	. "$ls_espacio";
			$ls_string 		= $ls_string . $AlumnosMujeresIndi	. "$ls_espacio";
			$ls_string 		= $ls_string . $AlumnasEmbara		. "$ls_espacio";
			$ls_string 		= $ls_string . $RutProfe			. "$ls_espacio";
			$ls_string 		= $ls_string . $DigProfe			. "$ls_espacio";
			$ls_string 		= $ls_string . $ApePatProfe			. "$ls_espacio";
			$ls_string 		= $ls_string . $ApeMatProfe			. "$ls_espacio";
			$ls_string 		= $ls_string . $NombresProfe		. " $salto";
			
			fwrite($fichero,"$ls_string"); 
		
	}
	
//pg_close($conn);
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
                                        <INPUT class="botonXX"  TYPE="button" value="VOLVER" name=btnModificar  onClick=document.location="Menu_Actas.php">
                                    </div></td>
                                  </tr>
                                  <tr >
                                    <td  class="fondo" align="center">Generaci&oacute;n Electr&oacute;nica de la Informaci&oacute;n de Matr&iacute;cula Inicial </td>
                                  </tr>
                                  <tr>
                                    <td><div align="center">
                                        <p>&nbsp;</p>
                                      <p><strong><font face="Verdana, Arial, Helvetica, sans-serif">Archivo 24. Datos de los cursos</font></strong> </p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Actas/m<? echo $institucion ?>_24.txt'> &quot;m<? echo $institucion ?>_24.txt&quot;</a> , en total se encontraron
                                        <?=($total_filas1)?>
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