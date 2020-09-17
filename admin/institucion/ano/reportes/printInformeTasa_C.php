<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_Reporte.php');



	$institucion	=$_INSTIT;
	$ano			=$cmb_ano;
	$reporte		=$c_reporte;
	$ensenanza		=$cmbENSENANZA;
	$curso =1;
	if($ensenanza!=0){
		$AND =" AND te.cod_tipo=".$ensenanza;	
	}
		
	if($ck_opcion==1){
		$titulo ="REPORTE TASA DE REPROBADOS POR NIVEL";	
		
		
		$sql="SELECT ae.id_ano,nro_ano,grado_curso, te.nombre_tipo,te.cod_tipo, 
CASE WHEN p.situacion_final=2 then count(p.*) END as prom
FROM promocion p 
INNER JOIN ano_escolar ae ON p.id_ano=ae.id_ano
INNER JOIN curso c ON ae.id_ano=c.id_ano AND c.id_ano=p.id_ano AND p.id_curso=c.id_curso
INNER JOIN tipo_ensenanza te ON te.cod_tipo=c.ensenanza $AND
WHERE ae.id_institucion= ".$institucion." and situacion_final=2
GROUP BY 1,2,3,4,5,p.situacion_final
ORDER BY nro_ano,nombre_tipo,grado_curso ASC";
	
	}else{
		$titulo ="REPORTE TASA DE RETIRADOS POR NIVEL";	
		
		$sql="SELECT ae.id_ano,nro_ano,grado_curso, te.nombre_tipo,te.cod_tipo,
CASE WHEN (m.bool_ar=1) then count(m.*) end as prom
FROM  ano_escolar ae 
INNER JOIN curso c ON ae.id_ano=c.id_ano 
INNER JOIN tipo_ensenanza te ON te.cod_tipo=c.ensenanza  $AND
INNER JOIN matricula m ON m.id_curso=c.id_curso  AND m.id_ano=ae.id_ano
WHERE ae.id_institucion= ".$institucion."  and bool_ar=1
GROUP BY 1,2,3,4,5, bool_ar
ORDER BY nro_ano,grado_curso ASC";
	}
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
<table width="650" border="1" style="border-collapse:collapse" align="center">
  <tr class="tablatit2-1">
    <td align="center">A&Ntilde;O</td>
    <td align="center">NIVEL</td>
    <td align="center">CANTIDAD</td>
    <td align="center">PORCENTAJE</td>
  </tr>
  <? for($i=0;$i<pg_numrows($result);$i++){
	  	$fila = pg_fetch_array($result,$i);
		
		$sql=" select count(m.*)
FROM matricula m INNER JOIN ano_Escolar ae ON m.id_ano=ae.id_ano
INNER JOIN curso c ON c.id_curso=m.id_curso  AND ensenanza=".$fila['cod_tipo']." AND grado_curso=".$fila['grado_curso']."
WHERE m.id_ano=".$fila['id_ano'];
$rs_matricula = pg_exec($conn,$sql);
$total_matricula = pg_result($rs_matricula,0);
$porcentaje = round(($fila['prom'] * 100) / $total_matricula,2);
 ?>
  <tr>
    <td class="textosimple">&nbsp;<?=$fila['nro_ano'];?></td>
    <td class="textosimple">&nbsp;<?=$fila['grado_curso']."º-".$fila['nombre_tipo'];?></td>
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