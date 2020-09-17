<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
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
	$ls_string = "&nbsp;";
	$salto = "\r\n"; 	 
	$ls_espacio= chr(9);
	$fichero = fopen("Actas/a".$institucion."_4.txt", "w+"); 
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
                                <table width="1%" border="0">
                                    <tr>
                                      <td><table width="650" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td align="right"><div id="capa0">
                                                <INPUT class = "botonXX"  TYPE="button" value="ARCHIVO" name=btnModificar  onClick=document.location="Archivo04_txt.php">
                                                <input name="button3" type="button" class="botonXX" onClick="imprimir();" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR">
                                                <INPUT class = "botonXX" TYPE="button" value="VOLVER" name=btnModificar2  onClick=document.location="Volver04.php">
                                            </div></td>
                                          </tr>
                                      </table></td>
                                    </tr>
                                    <tr>
                                      <td><table width="650" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                          <tr >
                                            <td ><div align="center"> Archivo 04. Antecedentes Acad&eacute;micos de los Estudiantes </div></td>
                                          </tr>
                                      </table></td>
                                    </tr>
                                    <tr>
                                      <td><table width="650" border="1" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N&ordm;</strong></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rbd</strong></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>D&iacute;gito Rbd</strong></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Tipo de Ensenanza </strong></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Grado</strong></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Letra</strong></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nro A&ntilde;o </strong></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rut Estudiante </strong></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Digito Rut </strong></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Plan de Estudio </strong></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Cod Eval </strong></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>C&oacute;digo Subsector </strong></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Calificaci&oacute;n Final </strong></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Calificaci&oacute;n Conceptual </strong></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Eximido en el subsector </strong></font></td>
                                          </tr>
                                          <?
  
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
?>
                                          <tr>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $con?></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rdb?></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rdb?></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ensenanza?></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $grado?></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $letra?></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nro_ano?></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $alumno?></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rut?></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $cod_decreto?></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $cod_eval?></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $subsector?></font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2">
                                              <? if (empty($promedio1))echo "&nbsp;"; else echo $promedio1;?>
                                            </font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2">
                                              <? if (empty($promedio2))echo "&nbsp;"; else echo $promedio2;?>
                                            </font></td>
                                            <td><font face="Arial, Helvetica, sans-serif" size="-2">
                                              <? if (empty($promedio3))echo "&nbsp;"; else echo $promedio3;?>
                                            </font></td>
                                          </tr>
                                          <?		
}
pg_close($conn);
fclose($fichero); 
  ?>
                                      </table></td>
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
  <br>
  <br>
</center>
<? pg_close($conn); ?>
</body>
</html>