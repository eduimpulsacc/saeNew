<?php
require('../../../../../../util/header.inc');
require('../../../../../../util/LlenarCombo.php3');
require('../../../../../../util/SeleccionaCombo.inc');
include('../../../../../clases/class_MotorBusqueda.php');
include('../../../../../clases/class_Membrete.php');
include('../../../../../clases/class_Reporte.php');

//var_dump($_POST);

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$reporte		=$c_reporte;
	$ensenanza		=$cmbENSENANZA;
	$curso =$cmb_curso;
	
	$desde =CambioFE($_POST['fecha_desde']);
	$hasta =CambioFE($_POST['fecha_hasta']);
	
	
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
	

	
	$ob_reporte->curso=$curso;
	$ob_reporte->fecha_desde=$desde;
	$ob_reporte->fecha_hasta=$hasta;
	$rs_retiro=$ob_reporte->traeRetirados($conn);
	
	
	
	//firma
	$ob_reporte->rdb=$institucion;
		$ob_reporte->item= $reporte;
		$ob_reporte->usuario= $_NOMBREUSUARIO;
		if($_PERFIL!=0 && $_PERFIL!=14){
			//veo si tiene autorizacion permanente
			$autp=$ob_reporte->checAutReporteTrabaja($conn);
			$aut = pg_result($autp,0);
			if($aut==0){
				//veo si el usuario tiene el reporte
				$ob_reporte->rdb=$institucion;
				$ob_reporte->item= $fils_item['id_item'];
				$ob_reporte->usuario= $_NOMBREUSUARIO;
				$ob_reporte->item=$reporte;
				$rp = $ob_reporte->checAutReporte($conn);
				$crp= pg_numrows($rp);
				//echo "aut2->".$crp;
				
			
				}
				else{
				$crp = $aut;
				}
			
			$rs_quita = $ob_reporte->quitaAutReporte($conn);
		}else{
		$crp=1;
		}
	

?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="697"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
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
      <td><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Fono: &nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="41" valign="top">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <br>
<table width="650" border="0" align="center" >
  <tr>
    <td class="textonegrita" align="center" style="font-size:16px" >&nbsp;<div align="center">ESTADISTICA RETIROS</div>
      &nbsp;</td>
  </tr>
</table>
<br>
<br>
<table width="650" border="0" align="center" class="textosimple" >
  <tr>
    <td width="68" class=""><strong>CURSO</strong></td>
    <td width="572" class=""><?php echo CursoPalabra($curso,1,$conn) ?></td>
  </tr>
  <tr>
    <td class=""><strong>FECHA</strong></td>
    <td class="">DESDE <strong><?php echo $fecha_desde ?></strong> HASTA  <strong><?php echo $fecha_hasta ?></strong></td>
  </tr>
</table>
<br>
<br>
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse" >
  <tr class="textonegrita" >
    <td width="250" align="center" class="">ALUMNO</td>
    <td width="100" align="center" class="">FECHA</td>
    <td width="100" align="center" class="">HORA RETIRO</td>
    <td width="100" align="center" class="">HORA REGRESO</td>
    <td width="100" align="center" class="">RETIRA</td>
    <td width="250" align="center" class="">AUTORIZA</td>
    <td width="250" align="center" class="">MOTIVO</td>
  </tr>
  <?php for($i=0;$i<pg_numrows($rs_retiro);$i++){
	  $fila=pg_fetch_array($rs_retiro,$i);
	  ?>
  <tr class="textosimple">
    <td class="">
	<?php 
	$ob_reporte->ano=$ano;
	$ob_reporte->alumno=$fila['rut_alumno'];
	$result_alu=$ob_reporte->TraeUnAlumno($conn);
	$fila_alu = @pg_fetch_array($result_alu,0);	
	echo ucwords(strtoupper(trim($fila_alu['ape_pat']) . " " .trim($fila_alu['nombre_alu'])));
	 ?></td>
    <td width="100" align="center" class=""><?php echo CambioFD($fila['fecha']) ?></td>
    <td width="100" align="center" class=""><?php echo $fila['hora_salida'] ?></td>
    <td width="100" align="center" class=""><?php echo $fila['hora_regreso'] ?></td>
    <td width="100" class=""><?php echo strtoupper($fila['quien_retira']) ?></td>
    <td class="">
    <?php  
	$ob_reporte->rut_emp=$fila['rut_emp'];
    $ob_reporte->Profesor($conn);
    echo $ob_reporte->profesor ?>
    </td>
    <td class=""><?php echo strtoupper($fila['motivo']) ?></td>
  </tr>
  <?php }?>
</table>
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