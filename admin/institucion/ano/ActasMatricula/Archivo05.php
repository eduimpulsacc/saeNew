<script>
function imprimir() 
{
window.open('Archivo05_print.php','','');
}
</script>
<?php require('../../../../util/header.inc');?>
<?php 


   //// FUNCION QUE VALIDA EL RUT   ///////
	function validar_dav ($alumno,$dig_rut){	      
		 $alumno = $alumno;
		 $dig_rut = $dig_rut;		  
		 $largo_rut = strlen($alumno);
		 $multiplicador = 2;
		 $resultado = 0;
		 $largo=$largo_rut-1;			 
		 for ($i=0; $i < $largo_rut; $i++){
			 $num = substr($alumno,$largo,1);
			 
			 if ($multiplicador > 7){
				 $multiplicador = 2;
			 }
			 $resultado = $resultado + ($multiplicador * $num);			 
			 $multiplicador++; 
			 $largo--;		 
		 }				 
		 $resto = 11-($resultado%11);		 
		 
		 if ($resto==10){
			 $dig = "K";
		 }else{
		     if ($resto==11){
			     $dig = 0;
			 }else{	 
		         $dig = $resto;
			 }	 
		 }	 
		 
		 if ($dig_rut=="k"){
		     $dig_rut="K";   
		 } 
		 
		 if ($dig==$dig_rut){
			  $ok=1;  
		 }else{
			  $ok=0;
		 }	
		 return $ok;
		       	 
	}
    //// fin funcion que valida el rut /////



	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	
	
	$sql ="SELECT num_corp FROM corp_instit WHERE rdb=".$institucion;
	$rs_corp = @pg_exec($conn,$sql);
	$corporacion = @pg_result($rs_corp,0);
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//------------------------	
	/*if($corporacion==13){
		$fecha_mat = "30-04-".$ano_escolar;
	}else{*/
		$fecha_mat = "04-30-".$ano_escolar;
//	}	

	
	if($_GET['grado_filtro']){
		
	$grado_filtro = $_GET['grado_filtro'];
	$filtro = explode("_",$_GET['grado_filtro']);
    
	$variable_validadora_super_pato = "AND (curso.grado_curso=".$filtro[0].") AND (curso.ensenanza = ".$filtro[1].")";
	
		}else{
	
		  $variable_validadora_super_pato = "";
	
			}
	
$sql = "SELECT institucion.rdb, institucion.dig_rdb, institucion.region, curso.ensenanza, curso.grado_curso, curso.letra_curso, ano_escolar.nro_ano, matricula.rut_alumno, alumno.dig_rut, promocion.promedio, promocion.asistencia, promocion.situacion_final, promocion.observacion ";
	$sql = $sql . "FROM (((matricula INNER JOIN curso ON (matricula.id_ano = curso.id_ano) AND (matricula.id_curso = curso.id_curso )  ".$variable_validadora_super_pato."  ) INNER JOIN ano_escolar ON matricula.id_ano = ano_escolar.id_ano) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN (institucion INNER JOIN promocion ON institucion.rdb = promocion.rdb) ON (matricula.id_ano = promocion.id_ano) AND (matricula.id_curso = promocion.id_curso) AND (matricula.rut_alumno = promocion.rut_alumno) ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND (curso.ensenanza > 109) AND ((matricula.id_ano)=".$ano.")) and ((matricula.bool_ar=1 and matricula.fecha_retiro > '".$fecha_mat."') or ((matricula.bool_ar is null) or (matricula.bool_ar=0)))";
	$sql = $sql . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; "; 
	
$qry="SELECT DISTINCT institucion.rdb, institucion.dig_rdb, institucion.region, curso.ensenanza, curso.grado_curso, 
curso.letra_curso, ano_escolar.nro_ano, alumno.rut_alumno, alumno.dig_rut, promocion.promedio, 
promocion.asistencia, promocion.situacion_final, promocion.observacion 
FROM promocion 
INNER JOIN curso ON promocion.id_curso=curso.id_curso $variable_validadora_super_pato 
INNER JOIN ano_escolar ON ano_escolar.id_ano=promocion.id_ano AND ano_escolar.id_ano=curso.id_ano
INNER JOIN institucion ON institucion.rdb=promocion.rdb AND ano_escolar.id_institucion=institucion.rdb
INNER JOIN alumno ON alumno.rut_alumno=promocion.rut_alumno
WHERE institucion.rdb=".$institucion." AND curso.ensenanza>109 AND ano_escolar.id_ano=".$ano." ";
	if($_PERFIL==0) echo $qry;

$resultado_query= pg_exec($conn,$qry);
$total_filas= pg_numrows($resultado_query);
	
	
	$fichero = fopen("Actas/a".$institucion."_5.txt", "w+"); 
	
	///// consultar si la institucion es de viña del mar
	$sql_vina = "select * from corp_instit where num_corp = '1' and rdb = '$_INSTIT'";
	$res_vina = pg_Exec($conn,$sql_vina);
	$num_vina = pg_numrows($res_vina);	
?>
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
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
                                <table width="1%" border="0">
                                  <tr>
                                    <td><table width="650" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td align="right"><div id="capa0">
                                              <INPUT class = "botonXX" TYPE="button" value="ARCHIVO" name=btnModificar  onClick=document.location="Archivo05_txt.php">
                                              <input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
                                              <INPUT class = "botonXX" TYPE="button" value="VOLVER" name=btnModificar2  onClick=document.location="IniciaArchivo05.php">
                                          </div></td>
                                        </tr>
                                    </table></td>
                                  </tr>
                                  <tr>
                                    <td><table width="650" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                        <tr  >
                                          <td  class="fondo"><div align="center"> Archivo 05. Situaci&oacute;n de Promoci&oacute;n de los Estudiantes </div></td>
                                        </tr>
                                    </table></td>
                                  </tr>
                                  <tr>
                                    <td><table width="650" border="1" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N&ordm;</strong></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rbd</strong></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>D&iacute;gito Rbd </strong></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Tipo Ense&ntilde;anza</strong></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Grado Curso </strong></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Letra Curso </strong></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>A&ntilde;o Escolar </strong></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rut Estudiante </strong></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>D&iacute;gito Rut</strong></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Promedio General </strong></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Porcentaje Asistencia </strong></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Observaci&oacute;n</strong></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Situaci&oacute;n Final </strong></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Tipo Promoci&oacute;n </strong></font></td>
                                        </tr>
                                        <?
$ii = 1;										
for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);
 $fila = @pg_fetch_array($resultado_query,$j);

$rdb = $fila['rdb'];
$dig_rdb = $fila['dig_rdb'];
$region = $fila['region'];
$ensenanza = $fila['ensenanza'];
$grado = $fila['grado_curso'];
$letra = $fila['letra_curso'];
$nro_ano = $fila['nro_ano'];
$alumno = $fila['rut_alumno'];
$dig_rut = $fila['dig_rut'];
if($fila['observacion']=="") $observacion = "&nbsp;"; else $observacion = $fila['observacion'];
if (!empty($fila['promedio']))
	$promedio = substr($fila['promedio'],0,1).".".substr($fila['promedio'],1,1);
else
	$promedio = "";

$asistencia = $fila['asistencia'];

$situacion_aux = $fila['situacion_final'];
if ($situacion_aux==1) $situacion_final = "P";
if ($situacion_aux==2) $situacion_final = "R";
if ($situacion_aux==3) $situacion_final = "Y";
if ($situacion_final == "Y") $asistencia=0;
if ($situacion_final == "Y")
{
	$sql_retirado = "select fecha_retiro from matricula where rut_alumno = " . $alumno . " and id_ano = " . $ano;
	$resultado_retirado = pg_exec($conn,$sql_retirado);
    $fila_retirado = @pg_fetch_array($resultado_retirado,0);
	$observacion = "RET ".substr(cfecha($fila_retirado['fecha_retiro']),0,5);
	$promedio = "";
	$asistencia = "";
	
}
 if ($region==5 or $institucion==11209 or $institucion==2163){
   /// no entra a validar rut
   $ok = 1;			  
}else{
		
	/// validar rut  ///
	$ok = validar_dav($alumno,$dig_rut);		
	if ($dig_rut==NULL){
	   $ok = 0;
	}
}				   
if ($ok==1){ 


$ls_string = "5" . "$ls_espacio" . trim($rdb) . "$ls_espacio";
$ls_string = $ls_string . trim($dig_rdb)  . "$ls_espacio";
$ls_string = $ls_string . trim($ensenanza)  . "$ls_espacio";
$ls_string = $ls_string . trim($grado)  . "$ls_espacio";
$ls_string = $ls_string . trim($letra)  . "$ls_espacio";
$ls_string = $ls_string . trim($nro_ano)  . "$ls_espacio";
$ls_string = $ls_string . trim($alumno)  . "$ls_espacio";
$ls_string = $ls_string . trim($dig_rut)  . "$ls_espacio";
$ls_string = $ls_string . trim($promedio)  . "$ls_espacio";
$ls_string = $ls_string . trim($asistencia)  . "$ls_espacio";
$ls_string = $ls_string . trim($observacion)  . "$ls_espacio";
$ls_string = $ls_string . trim($situacion_final)  . "$ls_espacio";
$ls_string = $ls_string ."1"."$salto";

	//crea un fichero
	//echo $ls_string;
		
	@ fwrite($fichero,"$ls_string"); 
?>
                                        <tr>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ii?></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rdb?></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rdb?></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ensenanza?></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $grado?></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $letra?></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nro_ano?></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $alumno?></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rut?></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2">
                                            <? if (empty($promedio)) echo "&nbsp;"; else echo $promedio;?>
                                          </font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2">
                                            <? if ($asistencia>0)echo $asistencia; else echo "&nbsp;";?>
                                          </font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2">
                                            <? if (empty($observacion)) echo "&nbsp;"; else echo $observacion;?>
                                          </font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $situacion_final?></font></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo "1"?></font></td>
                                        </tr>
                                        <?
$ii++;										
}

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

</body>
</html>