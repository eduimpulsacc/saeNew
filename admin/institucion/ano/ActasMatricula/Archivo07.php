<script>
function imprimir() 
{
window.open('Archivo07_print.php','','');
}
</script>
<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	//------------------------
	// Año Escolar
	//------------------------
	$sql_consulta = "select * from archivo07 where rdb = $institucion";
	$result_consulta =@pg_Exec($conn,$sql_consulta);
	$total_filas= pg_numrows($result_consulta);
	$fichero = fopen("Actas/a".$institucion."_7.txt", "w+"); 
	
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			   <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>			
                <!-- FIN DE COPIA DE CABECERA -->
                   </td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						 $menu_lateral=3; 
						 include("../../../../menus/menu_lateral.php");
						 ?>
						
						</td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 









<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right">
	<div id="capa0">
	<INPUT class = "botonXX"  TYPE="button" value="ARCHIVO" name=btnModificar  onClick=document.location="Archivo07_txt.php">
	<input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
	<INPUT class = "botonXX"  TYPE="button" value="VOLVER" name=btnModificar  onClick=document.location="Menu_Actas.php">
	</div>
	
	</td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<tr  > 
    <td class="fondo"  >
		<div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif" >
	    <strong>Archivo 07. Acta del Curso </strong>
	    </font>
      </div></td>
  </tr>
	</td>
  </tr>
</table>
<br>
<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nº</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rbd</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>D&iacute;gito Rbd </strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Tipo Ense&ntilde;anza </strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Grado</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Letra</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Ano Escolar </strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N° Estudiantes Matriculados al 30 de abril (Matrícula inicial)</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N° Estudiantes Matriculados al 30 de noviembre (Matrícula Final)</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N° de estudiantes promovidos</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N° de estudiantes reprobados por inasistencia</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N° de estudiantes reprobados por rendimiento</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N° Estudiantes Ingresados entre el 1º de mayo y el  29 de noviembre</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N° Estudiantes Retirados entre el 1º de mayo y el  29 de noviembre</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Encargado del Acta </strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Fecha del Acta</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Director del Establecimiento</strong></font></td>		
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Profesor Jefe</strong></font></td>			
  </tr>
<?
for ($j=0; $j < $total_filas; $j++)
{
	$ls_string = "";
	$salto = "\r\n"; 	 
	$ls_espacio= chr(9);
	$fila = @pg_fetch_array($result_consulta,$j);
	
	$rdb			=	trim($fila['rdb']);
	$dig_rdb 		=	trim($fila['dig_rdb']);
	$ensenanza 		=	trim($fila['ensenanza']);
	$grado 			=	trim($fila['grado']);
	$letra 			=	trim($fila['letra']);
	$nro_ano		=	trim($fila['ano']);
	$indicador1 	=	trim($fila['indicador1']);
	$indicador2 	=	trim($fila['indicador2']);
	$indicador3 	=	trim($fila['indicador3']);
	$indicador4 	=	trim($fila['indicador4']);
	$indicador5 	=	trim($fila['indicador5']);
	$indicador6 	=	trim($fila['indicador6']);
	$indicador7 	=	trim($fila['indicador7']);
	$encargado 		=	trim($fila['encargado']);
	$fecha_acta 	=	trim($fila['fecha_acta']);
	$director 		=	trim($fila['director']);
	$profe			=	trim($fila['profe']);
	//----------------------------------------------------------------		
	$ls_string = "7" . "$ls_espacio" . trim($rdb) . "$ls_espacio";
	$ls_string = $ls_string . trim($dig_rdb)  . "$ls_espacio";
	$ls_string = $ls_string . trim($ensenanza)  . "$ls_espacio";
	$ls_string = $ls_string . trim($grado)  . "$ls_espacio";
	$ls_string = $ls_string . trim($letra)  . "$ls_espacio";
	$ls_string = $ls_string . trim($nro_ano)  . "$ls_espacio";
	$ls_string = $ls_string . trim($indicador1)  . "$ls_espacio";	
	$ls_string = $ls_string . trim($indicador2)  . "$ls_espacio";
	$ls_string = $ls_string . trim($indicador3)  . "$ls_espacio";
	$ls_string = $ls_string . trim($indicador4)  . "$ls_espacio";
	$ls_string = $ls_string . trim($indicador5)  . "$ls_espacio";
	$ls_string = $ls_string . trim($indicador6)  . "$ls_espacio";
	$ls_string = $ls_string . trim($indicador7)  . "$ls_espacio";
	$ls_string = $ls_string . trim($encargado)  . "$ls_espacio";
	$ls_string = $ls_string . date("d/m/Y") . "$ls_espacio";
	$ls_string = $ls_string . trim($director)  . "$ls_espacio";	
	$ls_string = $ls_string . trim($profe)  . "$salto";
	@ fwrite($fichero,"$ls_string"); 
  ?>
  <tr>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $j+1?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rdb?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rdb?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ensenanza?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $grado?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $letra?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nro_ano?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $indicador1?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $indicador2?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $indicador3?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $indicador4?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $indicador5?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $indicador6?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $indicador7?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $encargado?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo date("d/m/Y")?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $director?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $profe?></font></td>			
  </tr>
  <?
}
//---------------------------------------------------
$sql="delete from archivo07 where rdb = $institucion";
$rsDele =@pg_Exec($conn,$sql);
//---------------------------------------------------
pg_close($conn);
fclose($fichero); 


?>
</table>












							  
							  
							  
						
                         
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td><td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
          
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>