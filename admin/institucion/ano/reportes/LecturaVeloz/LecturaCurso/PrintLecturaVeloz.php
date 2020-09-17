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
	$curso =$select_cursos;
	
	$fecha = $_POST['fecha'];
	
	$f = explode("-",$fecha);
	
	$fecha =$f[2]."-".$f[1]."-".$f[0];
	
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
	$ob_config->ano=$ano;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	$ob_config->AnoEscolar($conn);
	$ano_escolar=$ob_config->nro_ano;
	
	$ob_config->ramo=$select_ramos;
	$rs_ramo=$ob_config->ramoUNO($conn);
	$nom_ramo = pg_result($rs_ramo,1);
	
	$ob_reporte = new Reporte();
	$ob_reporte->curso=$curso;
	$ob_reporte->ano=$ano;
	$ob_reporte->ramo=$select_ramos;
	$ob_reporte ->retirado =$ret;
	$ob_reporte ->orden =1;
	$result_alu =$ob_reporte ->TraeTodosAlumnos($conn);
	
	 $ob_reporte ->fecha_conc=CambioFE($txtFECHA);

	
	
	
	
	

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
  <table width="650" border="0" align="center">
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
      <td width="697"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
      <td width="10">&nbsp;</td>
      <td width="125" rowspan="4" align="center"><table width="125" border="0" cellpadding="0" cellspacing="0">
        <tr valign="top">
          <td width="125" align="center">
		<?
						if($institucion!=""){
						   echo "<img src='../../../../../../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='../../../../../../menu/imag/logo.gif' >";
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
<table width="650" border="0" align="center" >
  <tr>
    <td class="tableindex" align="center">&nbsp;<div align="center">ESTAD&Iacute;STICAS VELOCIDAD LECTORA</div>
      &nbsp;</td>
  </tr>
</table>
<br>
<table width="650" border="0" align="center">
  <tr>
    <td class="textonegrita">A&ntilde;o Escolar:</td>
    <td class="textosimple"><?php echo $ano_escolar ?></td>
  </tr>
  <tr>
    <td class="textonegrita">Curso:</td>
    <td class="textosimple"><?php echo CursoPalabra($curso,1,$conn); ?></td>
  </tr>
  <?php if($institucion!=9510){?>
  <tr>
    <td class="textonegrita">Asignatura: </td>
    <td class="textosimple"><?php echo $nom_ramo ?></td>
  </tr>
  <?php }?>
  <tr>
    <td width="113" class="textonegrita">Fecha:</td>
    <td width="827" class="textosimple">&nbsp;<?php echo $_POST['txtFECHA'] ?></td>
  </tr>
</table>
<br>
<br>
<br>
<table width="650" border="1" align="center" style="border-collapse:collapse">
<tr class="tableindex"><td width="386">Alumno</td><td width="104" align="center">Palabras</td><td width="146" align="center">Concepto</td></tr>
<?php for($a=0;$a<pg_numrows($result_alu);$a++){
	$fila= pg_fetch_array($result_alu,$a);
	$ob_reporte->rut_alumno=$fila['rut_alumno'];
	
	$ob_reporte->ramo=($institucion!=9510)?$select_ramos:"";
	
	@$rs_vel=$ob_reporte->velLectora($conn);
	
	
	if(pg_numrows($rs_vel)>0){
		$filac=pg_fetch_array($rs_vel,0);
		$ob_reporte->concepto=$filac['concepto'];
		@$rs_cal=$ob_reporte->calvelLectora($conn);
		$conc=pg_result($rs_cal,2);
		$pun=pg_result($rs_vel,5);
	}else{
		$conc="";
		$pun="";
	}
	?>
<tr class="textosimple">
  <td><?php echo $fila['ape_pat']." ".$fila['ape_mat'].", ".$fila['nombre_alu'] ?></td>
  <td align="center"><?php echo $pun; ?></td>
  <td align="center"><?php echo $conc; ?></td>
</tr>
<?php }?>
</table>
<br>
<br>
<?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 $concur=0;
		 include("../../firmas/firmas.php");?>
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