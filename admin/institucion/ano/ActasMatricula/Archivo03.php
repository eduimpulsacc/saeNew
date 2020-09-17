<script>
function imprimir() 
{
window.open('Archivo03_print.php','','');
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



	//$ls_criterio = $_GET["as_criterio"];
	//$ls_input    = $_GET["as_input"];
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	//------------------------
	// A�o Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//------------------------	
	$sql = "SELECT institucion.rdb, institucion.dig_rdb, institucion.region, curso.ensenanza, curso.grado_curso, curso.letra_curso, ano_escolar.nro_ano, alumno.rut_alumno, alumno.dig_rut, alumno.region, alumno.ciudad, alumno.comuna ";
	$sql = $sql . "FROM institucion, ((matricula INNER JOIN ano_escolar ON matricula.id_ano = ano_escolar.id_ano) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN curso ON matricula.id_curso = curso.id_curso and ((matricula.bool_ar=1 and matricula.fecha_retiro > '04-30-".$ano_escolar."') or ( (matricula.bool_ar isnull) or (matricula.bool_ar=0)) )";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((curso.ensenanza)>109) AND ((matricula.id_ano)=".$ano.")) ";
	$sql = $sql . "ORDER BY curso.id_curso, alumno.ape_pat, alumno.ape_mat;"; 
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	$fichero = fopen("Actas/a".$institucion."_3.txt", "w+"); 
	
	///// consultar si la institucion es de vi�a del mar
	$sql_vina = "select * from corp_instit where num_corp = '1' and rdb = '$_INSTIT'";
	$res_vina = pg_Exec($conn,$sql_vina);
	$num_vina = pg_numrows($res_vina);	
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
                            <td align="right"><div id="capa0"><?php if ($_PERFIL==0){ ?><INPUT name=btnXLS TYPE="button" class = "botonXX" id="btnXLS"  onClick=document.location="Archivo03_xls.php" value="EXCEL"> <?php }?>
                              <INPUT class = "botonXX" TYPE="button" value="ARCHIVO" name=btnModificar  onClick=document.location="Archivo03_txt.php">
                                <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
                                <INPUT class = "botonXX"  TYPE="button" value="VOLVER" name=btnModificar2  onClick=document.location="Menu_Actas.php">
                            </div></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="650" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                          <tr  >
                            <td  class="fondo"><div align="center">  Archivo 03. Estudiantes del Curso   </div></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="650" border="1" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N&ordm;</strong></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rbd</strong></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Digito Rbd</strong></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Tipo Ense&ntilde;anza</strong></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Grado</strong></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Letra</strong></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nro A&ntilde;o </strong></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rut Estududiante</strong></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Digito Rut </strong></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>C&oacute;digo Comuna </strong></font></td>
                          </tr>
                          <?
						  
$k=1;						  
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
 $grado_curso = $fila['grado_curso'];
 $letra_curso = $fila['letra_curso'];
 $nro_ano = $fila['nro_ano'];
 $rut_alumno = $fila['rut_alumno'];
 $dig_rut = $fila['dig_rut'];
 $region_aux = $fila['region'];
 if ($region_aux<10) $region = "0".$region_aux; else $region = $region_aux;
 $ciudad = $fila['ciudad'];
 $comuna_aux = $fila['comuna'];
 if ($comuna_aux<10) $comuna = "0".$comuna_aux; else $comuna = $comuna_aux;
 
 
 if ($region==5 or $institucion==11209 or $institucion==2163){
   /// no entra a validar rut
   $ok = 1;			  
}else{
	/// validar rut  ///
	 /// validar rut  ///
	$ok = validar_dav($rut_alumno,$dig_rut);		
	if ($dig_rut==NULL){
	   $ok = 0;
	}	
}			   
if ($ok==1){ 

$ls_string = "3" . "$ls_espacio" . trim($rdb) . "$ls_espacio";
$ls_string = $ls_string . trim($dig_rdb)  . "$ls_espacio";
$ls_string = $ls_string . ltrim($ensenanza)  . "$ls_espacio";
$ls_string = $ls_string . trim($grado_curso) . "$ls_espacio";
$ls_string = $ls_string . trim($letra_curso)  . "$ls_espacio";
$ls_string = $ls_string . trim($nro_ano) . "$ls_espacio";
$ls_string = $ls_string . trim($rut_alumno) . "$ls_espacio";
$ls_string = $ls_string . trim($dig_rut) . "$ls_espacio";
$ls_string = $ls_string . trim($region).trim($ciudad).trim($comuna) ."$salto";

	//crea un fichero
	//echo $ls_string;
		
	@ fwrite($fichero,"$ls_string"); 
  ?>
                          <tr>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $k?></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rdb?></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rdb?></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ensenanza?></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $grado_curso?></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $letra_curso?></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nro_ano?></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rut_alumno?></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rut?></font></td>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo trim($region).trim($ciudad).trim($comuna)?></font></td>
                          </tr>
                          <? }
						  
$k++;						  
						  
}						  
pg_close($conn);
fclose($fichero); 

?>
                      </table></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="0" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
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
 </body>
</html>