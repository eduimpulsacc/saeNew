<?php require('../../../../util/header.inc');?>
<?php 

	//$ls_criterio = $_GET["as_criterio"];
	//$ls_input    = $_GET["as_input"];
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	
	$sql = "SELECT institucion.rdb, institucion.dig_rdb, matriculatpsincurso.cod_tipo, ano_escolar.nro_ano, matriculatpsincurso.rut_alumno, alumno.dig_rut, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, alumno.sexo, alumno.fecha_nac, matriculatpsincurso.estado, alumno.nacionalidad ";
	$sql = $sql . "FROM institucion, (matriculatpsincurso INNER JOIN ano_escolar ON matriculatpsincurso.id_ano = ano_escolar.id_ano) INNER JOIN alumno ON matriculatpsincurso.rut_alumno = alumno.rut_alumno ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((matriculatpsincurso.id_ano)=".$ano.")); ";

	$resultado_query1	= pg_exec($conn,$sql);
	$total_filas1		= pg_numrows($resultado_query1);
	
	//pg_close($conn);

	$fichero = @fopen("Actas/m".$institucion."_26.txt", "w+"); 
	
	For ($K=0; $K < $total_filas1; $K++)
	{
		$ls_string 	= "";
		$salto 		= "\r\n"; 	 
		$ls_espacio	= chr(9);
		
		//--------------------------------------------------------------------------
		// Respuesta directa de la consulta
		//--------------------------------------------------------------------------
		$Rdb 				= trim(pg_result($resultado_query1, $K, 0));
		$DigRut				= trim(pg_result($resultado_query1, $K, 1));
		$TipoEnsenanza		= trim(pg_result($resultado_query1, $K, 2));
		$AnoEscolar			= trim(pg_result($resultado_query1, $K, 3));
		$RutAlumno			= trim(pg_result($resultado_query1, $K, 4));
		$DigRut				= trim(pg_result($resultado_query1, $K, 5));
		$ApePat				= trim(pg_result($resultado_query1, $K, 6));
		$ApeMat				= trim(pg_result($resultado_query1, $K, 7));
		$Nombres			= trim(pg_result($resultado_query1, $K, 8));
		$Sexo				= trim(pg_result($resultado_query1, $K, 9));
		$FechaNacimiento	= Cfecha2(trim(pg_result($resultado_query1, $K, 10)));
		$Estado				= trim(pg_result($resultado_query1, $K, 11));
		$Extranjero			= trim(pg_result($resultado_query1, $K, 12));


		//--------------------------------------------------------------------------
		// Consulta para obtener tipo de jornada
		//--------------------------------------------------------------------------		
		$ls_string 		= "26" 							. "$ls_espacio";
		$ls_string 		= $ls_string . $Rdb				. "$ls_espacio";
		$ls_string 		= $ls_string . $DigRut			. "$ls_espacio";
		$ls_string 		= $ls_string . $TipoEnsenanza	. "$ls_espacio";
		$ls_string 		= $ls_string . $AnoEscolar		. "$ls_espacio";
		$ls_string 		= $ls_string . $RutAlumno		. "$ls_espacio";
		$ls_string 		= $ls_string . $DigRut			. "$ls_espacio";
		$ls_string 		= $ls_string . $ApePat			. "$ls_espacio";
		$ls_string 		= $ls_string . $ApeMat			. "$ls_espacio";
		$ls_string 		= $ls_string . $Nombres			. "$ls_espacio";
		$ls_string 		= $ls_string . $Sexo			. "$ls_espacio";
		$ls_string 		= $ls_string . $FechaNacimiento	. "$ls_espacio";
		$ls_string 		= $ls_string . $Estado			. "$ls_espacio";
		$ls_string 		= $ls_string . $Extranjero		. " $salto";

		
		@ fwrite($fichero,"$ls_string"); 
	 
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
                                        <INPUT class="botonXX" TYPE="button" value="VOLVER" name=btnModificar  onClick="document.location='Menu_Actas.php'">
                                    </div></td>
                                  </tr>
                                  <tr height=30 >
                                    <td height="25"  class="fondo"align="center" valign="middle">Generaci&oacute;n Electr&oacute;nica de la Informaci&oacute;n de Matr&iacute;cula Inicial </td>
                                  </tr>
                                  <tr>
                                    <td><div align="center">
                                        <p>&nbsp;</p>
                                      <p><strong><font face="Verdana, Arial, Helvetica, sans-serif">Archivo 26:	Estudiantes en n&oacute;minas (s&oacute;lo Ense&ntilde;anza Media TP)</font></strong> </p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Actas/m<? echo $institucion ?>_26.txt'> &quot;m<? echo $institucion ?>_26.txt&quot;</a> , en total se encontraron
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
<? pg_close($conn); ?>
</body>
</html>