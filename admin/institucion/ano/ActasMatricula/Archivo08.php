<script>
function imprimir() 
{
window.open('Archivo08_print.php','','');
}
</script>
<?php require('../../../../util/header.inc');?>
<?php 

	//$ls_criterio = $_GET["as_criterio"];
	//$ls_input    = $_GET["as_input"];
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	
	$sql = "SELECT DISTINCT institucion.rdb, institucion.dig_rdb, ano_escolar.nro_ano, ramo.cod_subsector, subsector.nombre ";
	$sql = $sql . "FROM institucion, ((ano_escolar INNER JOIN curso ON ano_escolar.id_ano = curso.id_ano) INNER JOIN ramo ON curso.id_curso = ramo.id_curso) INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.")) AND ramo.cod_subsector< 50000";
	$sql = $sql . "ORDER BY ramo.cod_subsector; ";
	

	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	$fichero = fopen("Actas/a".$institucion."_8.txt", "w+"); 

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









<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right">
	<div id="capa0">
	<INPUT class = "botonXX"  value="ARCHIVO" name="btnModificar"  onClick=document.location="Archivo08_txt.php">
	<input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	<INPUT class = "botonXX"  TYPE="button" value="VOLVER" name="btnModificar"  onClick=document.location="Menu_Actas.php">
	</div>
	
	</td>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<tr  bgcolor=#003b85> 
    <td class="fondo">
		<div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif" >
	    <strong>Archivo 08. Subsectores, asignaturas o módulos</strong>
	    </font>
      </div></td>
  </tr>
	</td>
  </tr>
</table>
<br>
<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nº</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rbd</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>D&iacute;gito Rbd </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>A&ntilde;o Escolar </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>C&oacute;digo Subsector </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nombre Subsector</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Horas Semanales</strong></font></td>	
  </tr>
 <?
for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);
 $fila = @pg_fetch_array($resultado_query,$j);

$rdb = $fila['rdb'];
$dig_rdb = $fila['dig_rdb'];
$nro_ano = $fila['nro_ano'];
$cod_subsector= $fila['cod_subsector'];
$nombre_subsector = $fila['nombre'];
//-------------
$sql_horas="select * from horas_subsectores where cod_subsector = $cod_subsector and id_ano = $ano";
$resultado_horas = pg_exec($conn,$sql_horas);
$fila_horas = @pg_fetch_array($resultado_horas,0);
$horas = $fila_horas['horas'];
//-------------
$ls_string = "8" . "$ls_espacio" . trim($rdb) . "$ls_espacio";
$ls_string = $ls_string . trim($dig_rdb)  . "$ls_espacio";
$ls_string = $ls_string . trim($nro_ano)  . "$ls_espacio";
$ls_string = $ls_string . trim($cod_subsector) . "$ls_espacio";
$ls_string = $ls_string . trim($nombre_subsector) . "$ls_espacio";
$ls_string = $ls_string . trim($horas)."$salto";

	//crea un fichero
	//echo $ls_string;
		
	@ fwrite($fichero,"$ls_string"); 
?>
  <tr>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $j+1?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rdb?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rdb?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nro_ano?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $cod_subsector?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nombre_subsector?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $horas?></font></td>	
  </tr>
<? 
}
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
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>