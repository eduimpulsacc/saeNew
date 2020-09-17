<script>
function imprimir() 
{
window.open('Archivo09_print.php','','');
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
	
	$sql = "select institucion.rdb, ";
	$sql = $sql . "institucion.dig_rdb, institucion.region, ";
	$sql = $sql . "curso.cod_es, ";
	$sql = $sql . "ano_escolar.nro_ano, ";
	$sql = $sql . "alumno.ape_pat, ";
	$sql = $sql . "alumno.ape_mat, ";
	$sql = $sql . "alumno.nombre_alu, ";
	$sql = $sql . "alumno.rut_alumno, ";
	$sql = $sql . "alumno.dig_rut, ";
	$sql = $sql . "curso.ensenanza ";
	$sql = $sql . "from   institucion, matricula, curso, ano_escolar, alumno, promocion ";
	$sql = $sql . "where  institucion.rdb = $institucion ";
	$sql = $sql . "and    matricula.id_curso = curso.id_curso ";
	$sql = $sql . "and    curso.id_ano = $ano ";
	$sql = $sql . "and    curso.ensenanza > 309 ";
	$sql = $sql . "and    curso.grado_curso = 4 ";
	$sql = $sql . "and    ano_escolar.id_ano = $ano ";
	$sql = $sql . "and    alumno.rut_alumno = matricula.rut_alumno ";
	$sql = $sql . "and    promocion.id_ano = $ano ";
	$sql = $sql . "and    promocion.rut_alumno = matricula.rut_alumno ";
	$sql = $sql . "and    promocion.situacion_final = 1 order by alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	
	$fichero = fopen("Actas/a".$institucion."_9.txt", "w+"); 
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>
<body >
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
	<INPUT class = "botonXX"  value="ARCHIVO" name="btnModificar"  onClick=document.location="Archivo09_txt.php">
	<input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	<INPUT class = "botonXX"  value="VOLVER" name=btnModificar  onClick=document.location="Menu_Actas.php">
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
	    <strong> Archivo 09. N&oacute;mina de Alumnos Licenciados </strong>
	    </font>
      </div></td>
  </tr>
	</td>
  </tr>
</table><br>
      <table width="650" border="1" cellspacing="0" cellpadding="0">
        <tr>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N&ordm;</strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rbd</strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Dig Rbd </strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Especialidad</strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>A&ntilde;o N&oacute;mina </strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N&ordm; Registro </strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Apellido Paterno</strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Apellido Materno </strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nombres</strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rut</strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Dig Rut </strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>C&oacute;digo Tipo Licencia </strong></font></td>
        </tr>
<?	
$k = 1;
for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);
 $fila = @pg_fetch_array($resultado_query,$j);

$rdb 				= $fila['rdb'];
$dig_rdb 			= $fila['dig_rdb'];
$region 			= $fila['region'];
$rut_alumno 		= $fila['rut_alumno'];
$dig_rut 			= $fila['dig_rut'];
$ape_pat 			= strtoupper($fila['ape_pat']);
$ape_mat 			= strtoupper($fila['ape_mat']);
$nombre_alumno 		= strtoupper($fila['nombre_alu']);
if (empty($fila['cod_es']))
	$especialidad		= 0;
else
	$especialidad		= $fila['cod_es'];	
$nro_ano			= $fila['nro_ano'];
$ensenanza			= $fila['ensenanza'];
if ($ensenanza==410 or $ensenanza==510 or $ensenanza==610 or $ensenanza==710 or $ensenanza==810)
	$tipo_licencia = 1;
if ($ensenanza==310)
	$tipo_licencia = 2;
if ($ensenanza==460 or $ensenanza==461 or $ensenanza==560 or $ensenanza==561 or $ensenanza==660 or $ensenanza==661 or $ensenanza==760 or $ensenanza==761 or $ensenanza==860 or $ensenanza==861)
	$tipo_licencia = 3;
if ($ensenanza==360 or $ensenanza==361)
	$tipo_licencia = 4;
$cont = $j+1;

if ($region==5){
			    /// no entra a validar rut
	$ok = 1;			  
}else{

	$ok = validar_dav($rut_alumno,$dig_rut);		
	if ($dig_rut==NULL){
	   $ok = 0;
	}
}
			   
if ($ok==1){

$ls_string = "9" 								. "$ls_espacio"; 
$ls_string = $ls_string . trim($rdb) 			. "$ls_espacio"; 
$ls_string = $ls_string . trim($dig_rdb)  		. "$ls_espacio";
$ls_string = $ls_string . trim($especialidad)  	. "$ls_espacio";
$ls_string = $ls_string . trim($nro_ano) 		. "$ls_espacio";
$ls_string = $ls_string . trim($cont)			. "$ls_espacio";
$ls_string = $ls_string . trim($ape_pat) 		. "$ls_espacio";
$ls_string = $ls_string . trim($ape_mat) 		. "$ls_espacio";
$ls_string = $ls_string . trim($nombre_alumno) 	. "$ls_espacio";
$ls_string = $ls_string . trim($rut_alumno) 	. "$ls_espacio";
$ls_string = $ls_string . trim($dig_rut) 		. "$ls_espacio";
$ls_string = $ls_string . trim($tipo_licencia)	."$salto";
?>
        <tr>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $k;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rdb;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rdb;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $especialidad;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nro_ano;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo ($j+1);?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ape_pat;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ape_mat;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nombre_alumno;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rut_alumno;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rut;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $tipo_licencia;?></font></td>
        </tr>
<?
	//crea un fichero
	//echo $ls_string;
		
	@ fwrite($fichero,"$ls_string"); 
	$k++;
}	
 
}
pg_close($conn);
fclose($fichero); 

?>
</table>











							  
							  
							  
							  
                         
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
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