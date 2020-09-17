<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_Reporte.php');



	$institucion	=$_INSTIT;
	$ano			=$cmbANO;
	$reporte		=$c_reporte;
	$ensenanza		=$cmbENSENANZA;
	$curso =1;
	
	
	$sql ="SELECT nro_ano FROM ano_Escolar WHERE id_ano=".$ano;
	$rs_ano =pg_exec($conn,$sql);
	$nro_ano = pg_result($rs_ano,0);
	
	$sql="SELECT nombre_tipo FROM tipo_ensenanza WHERE cod_tipo=".$ensenanza;
	$rs_ensenanza =pg_exec($conn,$sql);
	$nombre_tipo = pg_result($rs_ensenanza,0);
	
	if($rd_estado==1){
		$signo=">";	
		$estado="APROBADOS";
		$nota = "39";
	}else{
		$signo="<";
		$estado="REPROBADOS";
		$nota = "40";
	}
	
	
	$sql = "SELECT grado_curso,ti.nombre_tipo,s.cod_subsector,s.nombre,count(psa.*) as prom
 FROM promedio_sub_alumno psa
 INNER JOIN promocion pro ON pro.rut_alumno=psa.rut_alumno AND pro.id_curso=psa.id_curso AND situacion_final=1
 INNER JOIN ramo r ON psa.id_ramo=r.id_ramo
 INNER JOIN subsector s ON s.cod_subsector=r.cod_subsector
 INNER JOIN curso c ON c.id_curso=psa.id_curso AND r.id_curso=c.id_curso AND ensenanza=".$ensenanza."
 INNER JOIN tipo_ensenanza ti ON ti.cod_tipo=c.ensenanza
 WHERE psa.id_ano=".$ano." AND psa.promedio $signo '$nota' AND psa.promedio not in ('MB','B','S','I','0')
 GROUP BY 1,2,3,4
 ORDER BY grado_curso, nombre";
 	$result = pg_exec($conn,$sql);
	
	
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
	

?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
  <br>
  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="697"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
      <td width="10">&nbsp;</td>
      <td width="125" rowspan="4" align="center"><table width="125" border="0" cellpadding="0" cellspacing="0">
        <tr valign="top">
          <td width="125" align="center">
		<?	if($institucion!=""){
			    echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
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
<table width="650" border="0" align="center" >
  <tr>
    <td class="tableindex" align="center">&nbsp;<div align="center"><?=$titulo;?></div>&nbsp;</td>
  </tr>
</table>
<br>
<table width="650" border="0" align="center">
  <tr>
    <td width="181" class="textonegrita">A&Ntilde;O</td>
    <td width="459" class="textosimple">:&nbsp;<?=$nro_ano;?></td>
  </tr>
  <tr>
    <td class="textonegrita">TIPO DE ENSE&Ntilde;ANZA</td>
    <td class="textosimple">:&nbsp;<?=$nombre_tipo;?></td>
  </tr>
</table>
<table width="650" border="1" style="border-collapse:collapse" align="center">
  <tr class="tablatit2-1">
    <td align="center">NIVEL</td>
    <td align="center">ASIGNATURA</td>
    <td align="center">CANTIDAD<br>
      INSCRITOS</td>
    <td align="center">CANTIDAD<br>
      <?=$estado;?></td>
    <td align="center">PORCENTAJE</td>
  </tr>
  <? for($i=0;$i<pg_numrows($result);$i++){
	  	$fila = pg_fetch_array($result,$i);
		
		$sql="SELECT count(t.*)
			  FROM tiene$nro_ano t 
			  INNER JOIN matricula m ON m.rut_alumno=t.rut_alumno AND m.id_curso=t.id_curso and bool_ar=0
			  WHERE id_ramo IN (
				SELECT r.id_ramo
				FROM curso c
				INNER JOIN ramo r ON c.id_curso=r.id_curso
				WHERE id_ano=".$ano." AND ensenanza=".$ensenanza." AND grado_curso=".$fila['grado_curso']." AND cod_subsector=".$fila['cod_subsector'].")";
		$rs_inscritos = pg_exec($conn,$sql);
		$total_inscritos = pg_result($rs_inscritos,0);
		$porcentaje = round(($fila['prom'] * 100) / $total_inscritos,2);
 ?>
  <tr>
    <td class="textosimple">&nbsp;<?=$fila['grado_curso']."º-".$fila['nombre_tipo'];?></td>
    <td class="textosimple" align="left">&nbsp;<?=$fila['nombre'];?></td>
    <td class="textosimple" align="center">&nbsp;<?=$total_inscritos;?></td>
    <td class="textosimple" align="center">&nbsp;<?=$fila['prom'];?></td>
    <td class="textosimple" align="center">&nbsp;<?=$porcentaje;?></td>
  </tr>
  <? } ?>
</table>
<br>
<br>
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 $concur=0;
		 include("firmas/firmas.php");?>
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
<? pg_close($conn);?>