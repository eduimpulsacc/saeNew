<script>
function imprimir() 
{
window.open('Archivo02_print.php','','');
}
</script>
<?php require('../../../../util/header.inc');?>
<?php 

	//$ls_criterio = $_GET["as_criterio"];
	//$ls_input    = $_GET["as_input"];
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	
	$sql = "SELECT institucion.rdb, institucion.dig_rdb, institucion.region, curso.ensenanza, curso.grado_curso, curso.letra_curso, ano_escolar.nro_ano, curso.cod_eval, plan_estudio.cod_decreto, plan_estudio.cod_plan, empleado.rut_emp, empleado.dig_rut  ";
	$sql = $sql . "FROM institucion, (((curso INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN supervisa ON curso.id_curso = supervisa.id_curso) INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
	$sql = $sql . "where curso.id_ano = ".$ano." and institucion.rdb = ".$institucion." and curso.ensenanza > 109 group by institucion.rdb, 
institucion.dig_rdb, 
institucion.region, 
curso.ensenanza, 
curso.grado_curso, 
curso.letra_curso, 
ano_escolar.nro_ano, 
curso.cod_eval, 
plan_estudio.cod_decreto, 
plan_estudio.cod_plan, 
empleado.rut_emp, 
empleado.dig_rut   order by curso.ensenanza, curso.grado_curso, curso.letra_curso  ;";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	$fichero = fopen("Actas/a".$institucion."_2.txt", "w+"); 
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
                  <td align="left" valign="top"><table width="1%" border="0">
                    <tr>
                      <td><table width="650" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="right"><div id="capa0"><?php if ($_PERFIL==0){ ?><INPUT name=btnXLS TYPE="button" class = "botonXX" id="btnXLS"  onClick=document.location="Archivo02_xls.php" value="EXCEL"><?php }?>
                              <INPUT class = "botonXX" TYPE="button" value="ARCHIVO" name=btnModificar  onClick=document.location="Archivo02_txt.php">
                                <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
                                <INPUT class = "botonXX"  TYPE="button" value="VOLVER" name=btnModificar2  onClick=document.location="Menu_Actas.php">
                            </div></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="650" border="0" cellspacing="0" cellpadding="0"  >
                          <tr>
                            <td align="center" class="fondo">Archivo 02. Informaci&oacute;n del Curso </td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="650" border="1" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N&ordm;</strong></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rbd</strong></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>DigRbd</strong></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Tipo Ense&ntilde;anza </strong></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Grado</strong></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Letra</strong></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>NroA&ntilde;o</strong></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Decreto Evaluaci&oacute;n </strong></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Plan de Estudios </strong></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rut Profesor </strong></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>DigRut</strong></font></td>
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
$region = $fila['region'];
$tipo_ense = $fila['ensenanza'];
$grado = $fila['grado_curso'];
$letra = $fila['letra_curso'];
$nro_ano = $fila['nro_ano'];
$dec_eval = $fila['cod_eval'];
$plan_estudios = $fila['cod_decreto'];
if ($plan_estudios==5451996) $plan_estudios = 6252003;
if ($plan_estudios==5521997) $plan_estudios = 6252003;
$rut_profe = $fila['rut_emp'];
$dig_rut = $fila['dig_rut'];


$ls_string = "2" . "$ls_espacio" . trim($rdb) . "$ls_espacio";
$ls_string = $ls_string . trim($dig_rdb)  . "$ls_espacio";
$ls_string = $ls_string . trim($tipo_ense)  . "$ls_espacio";
$ls_string = $ls_string . trim($grado) . "$ls_espacio";
$ls_string = $ls_string . trim($letra)  . "$ls_espacio";
$ls_string = $ls_string . trim($nro_ano) . "$ls_espacio";
$ls_string = $ls_string . trim($dec_eval) . "$ls_espacio";
$ls_string = $ls_string . trim($plan_estudios) . "$ls_espacio";
$ls_string = $ls_string . trim($plan_estudios) . "$ls_espacio";
$ls_string = $ls_string . trim($rut_profe) . "$ls_espacio";
$ls_string = $ls_string . trim($dig_rut)."$salto";

	//crea un fichero
	//echo $ls_string;
		
	@ fwrite($fichero,"$ls_string"); 
?>
                          <tr>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $j+1?></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rdb?></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rdb?></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $tipo_ense?></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $grado?></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $letra?></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nro_ano?></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dec_eval?></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $plan_estudios?></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rut_profe?></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rut?></font></td>
                          </tr>
                          <?
  

 
}
pg_close($conn);
fclose($fichero); 

?>
                      </table></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="0" align="left" valign="top">
				  <table width="100%" border="0" cellpadding="0" cellspacing="0" >
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
  </td><td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
  </table>
<? pg_close($conn); ?>
</body>
</html>