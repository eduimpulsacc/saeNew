<?php
require('../../../../../../util/header.inc');
require('../../../../../../util/LlenarCombo.php3');
require('../../../../../../util/SeleccionaCombo.inc');
include('../../../../../clases/class_MotorBusqueda.php');
include('../../../../../clases/class_Membrete.php');
include('../../../../../clases/class_Reporte.php');



	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$reporte		=$c_reporte;
	$ensenanza		=$cmbENSENANZA;
	$curso =1;
	
	$fechaIni = $_POST['fechaIni'];
	$fechaFin = $_POST['fechaFin'];

	$fi = explode("-",$fechaIni);
	$fn = explode("-",$fechaFin);
	$fechaInicialKey = $fi[2];
	$fechaInicial =$fi[2]."-".$fi[1]."-".$fi[0];
	$fechaFinal =$fn[2]."-".$fn[1]."-".$fn[0];

	
	
 	$result = pg_exec($conn,$sql);
	$conteo = @pg_numrows($result_periodo);
	
		
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	
	/************** FIRMA ***********************/
		$ob_reporte->rdb=$institucion;
		$ob_reporte->usuario= $_NOMBREUSUARIO;
		$ob_reporte->item=$reporte;
		
	
		
	

	function mes_pal($mes){
	if ($mes == 01) $mes_pal = "Enero de ";
	    if ($mes == 02) $mes_pal = "Febrero de ";
	    if ($mes == 03) $mes_pal = "Marzo de ";
	    if ($mes == 04) $mes_pal = "Abril de ";
	    if ($mes == 05) $mes_pal = "Mayo de ";
	    if ($mes == 06) $mes_pal = "Junio de ";
	    if ($mes == 07) $mes_pal = "Julio de ";
	    if ($mes == 08) $mes_pal = "Agosto de ";
	    if ($mes == 09) $mes_pal = "Septiembre de ";
	    if ($mes == 10) $mes_pal = "Octubre de ";
	    if ($mes == 11) $mes_pal = "Noviembre de ";
	    if ($mes == 12) $mes_pal = "Diciembre de ";
		 return $mes_pal;	
	}
	
	
	//cursos
	/*$sql = "SELECT 
				n.pagina_tabla,
				count(n.pagina_tabla) as cuenta,
				c.id_curso,
				c.grado_curso,
				c.letra_curso,
				e.cod_tipo,
				e.nombre_tipo,
				n.rut_usuario,
				n.rbd 
				from navegacion n
				inner join curso c on c.id_curso = n.id_curso 
				inner join tipo_ensenanza e on c.ensenanza = e.cod_tipo 
				where (n.fecha BETWEEN '$fechaInicial' and '$fechaFinal') and n.rbd = 25241
				and c.id_ano in (select id_ano from ano_escolar where id_institucion=25241 
				and nro_ano= $fechaInicialKey)
				GROUP BY n.pagina_tabla,c.id_curso,c.grado_curso,c.letra_curso,e.cod_tipo,e.nombre_tipo,n.rut_usuario,n.rbd 
				order by e.cod_tipo,c.grado_curso,c.letra_curso,e.nombre_tipo;
				";*/
				  $sql="SELECT distinct(n.pagina_tabla), 
count(n.pagina_tabla) as cuenta, 
c.id_curso, c.grado_curso, c.letra_curso, 
e.cod_tipo, e.nombre_tipo,
n.rbd 
from navegacion n 
inner join curso c on c.id_curso = n.id_curso 
inner join tipo_ensenanza e on c.ensenanza = e.cod_tipo
where (n.fecha BETWEEN '$fechaInicial' and '$fechaFinal')
and n.rbd = $institucion and c.id_ano in 
(select id_ano from ano_escolar 
where id_institucion=$institucion and nro_ano= $fechaInicialKey)
GROUP BY n.pagina_tabla,c.id_curso,c.grado_curso,c.letra_curso,
e.cod_tipo,e.nombre_tipo,
n.rbd 
order by e.cod_tipo,c.grado_curso,c.letra_curso,e.nombre_tipo;";
	$result = pg_exec($conn,$sql);
	
	

?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="">
<script src="https://code.highcharts.com/highcharts.js"></script>



<SCRIPT language="JavaScript">
	function MM_goToURL() { //v3.0
	  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
	}
									
</script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<script>
function exportar(form){
	form.target="_blank";
	document.form.action='printInformeAsistenciaPorcentaje_C.php';
	document.form.submit(true);
}
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<style type="text/css">
.item { font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;
}
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<div id="capa0">
  <table width="950" border="0" align="center">
    <tr>
      <td><input type="button" name="Submit" value="CERRAR" onClick="window.close()" class="botonXX"/></td>
      <td><div align="right">
        <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
      </div></td>
    </tr>
  </table>
</div>
  <br>
  <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="697"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
      <td width="10">&nbsp;</td>
      <td width="125" rowspan="4" align="center"><table width="125" border="0" cellpadding="0" cellspacing="0">
        <tr valign="top">
          <td width="125" align="center">
		<?
						if($institucion!=""){
							
						   echo "<img src='../../../../../../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}?>
          </td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono: &nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="41" valign="top">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <br>
<table width="950" border="0" align="center" >
  <tr>
    <td class="tableindex" align="center">&nbsp;<div align="center">Informe de Navegaci&oacute;n </div>
      &nbsp;</td>
  </tr>
</table>
<br>
<table width="950" border="0" align="center">
  <tr>
    <td width="120" class="textonegrita">Fecha Inicial:</td>
    <td width="878" class="textosimple">&nbsp;<?php echo $_POST['fechaIni'] ?></td>
  </tr>
  <tr>
    <td width="120" class="textonegrita">Fecha Final:</td>
    <td width="878" class="textosimple">&nbsp;<?php echo $_POST['fechaFin'] ?></td>
  </tr>
</table>
<br>
<table width="950" border="0" align="center">
  <tr class="tableindex">
    <td width="162" class="textonegrita">Curso</td>
    <td width="498" class="textonegrita">P&aacute;gina</td>
    <td width="102" align="center" class="textonegrita">Apoderado</td>
    <td width="91" align="center" class="textonegrita">Alumno</td>
   
    
  </tr>
  <?php  for($i=0;$i<@pg_numrows($result);$i++){
	  	$fila = pg_fetch_array($result,$i);?>
  <tr class="textosimple">
    <td >&nbsp;<?=$fila['grado_curso']."º-".$fila['letra_curso'] ." ".$fila['nombre_tipo'];?></td>
    <td ><?php echo strtoupper($fila['pagina_tabla']) ?></td>
    <?php 
		$sql_cc = "select id_perfil from accede
join usuario on usuario.id_usuario = accede.id_usuario
where usuario.nombre_usuario = '".$fila['rut_usuario'] ."' and accede.id_perfil in(15,16) and accede.rdb = ".$fila['rbd'];
$result_cc = pg_exec($connection,$sql_cc);

$perfil = @pg_fetch_array($result_cc,0);
		
		?>
    <td align="center" >
    <?php 
	 $sql_apo = "select count(n.*)
from navegacion n
inner join apoderado ap on ap.rut_apo = n.rut_usuario
where n.id_curso = ".$fila['id_curso']."
and (n.fecha BETWEEN '$fechaInicial' and '$fechaFinal')
and n.pagina_tabla = '".$fila['pagina_tabla']."'";
$rs_apo = pg_exec($conn,$sql_apo);
echo pg_result($rs_apo,0);

?>
        </td>
	<td align="center" >
	<?php 
		 $sql_alu= "select count(n.*)
from navegacion n
inner join matricula ap on ap.rut_alumno = n.rut_usuario
where n.id_curso = ".$fila['id_curso']."
and (n.fecha BETWEEN '$fechaInicial' and '$fechaFinal')
and n.pagina_tabla = '".$fila['pagina_tabla']."'";
$rs_alu = pg_exec($conn,$sql_alu);
echo pg_result($rs_alu,0);
		
		?>
   </td>
    
   <?php 

   $pagina[] = $fila['pagina_tabla'];

   $paginaTotal = array_unique($pagina);

   $valores = $paginaTotal;

   ?>
   
  </tr>
  <?php }?>
</table>

<br>
<br>
 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("../../firmas/firmas.php");?>
<br>
<br>
<table width="650" border="0" align="center">
  <tr>
    <td class="textosimple">&nbsp;<? echo $ob_membrete->comuna.", ".date("d-m-Y");?></td>
  </tr>
</table>
</div>
</body>
</html>
<? 
	//fin ano
pg_close($conn);?>