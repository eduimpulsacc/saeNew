<?php
	
	require_once('../reporte_subvencion/mod_reporte_subvencion.php');
    require_once('../../../../util/header.inc');
	include_once("funciones_php/FusionCharts.php");
	
	//print_r($_POST);
	
	$id_nacional= $_ID_NACIONAL;
	$mes = $cmb_mes;
	$nro_ano=$cmb_anos;
	
	$ob_grafico = new Motor($conn);
			   
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link href="../../../corporacion/estilo.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/JavaScript">

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}


function imprimir() {
        document.getElementById("capa0").style.display='none';
        window.print();
        document.getElementById("capa0").style.display='block';
}

function cerrar(){ 
window.close() 
} 

</script>

<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
 }
</style>



</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">

<div id="capa0">
  <table width="650" align="center" >
    <tr>
      <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">
      </td>
      <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	  <? if($_PERFIL==0){?>		  
		<!--<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">-->
	<? }?>
      </td>
    </tr>
  </table>
</div>

 <BR>
  <BR>
  <? 	$sql="SELECT logo FROM corporacion WHERE num_corp=".$_CORPORACION;
	$rs_logo = pg_exec($conn,$sql);
	$logo = pg_result($rs_logo,0);?>
<table width="650"  align="center" border="0" cellspacing="0" cellpadding="5">
	  <tr>
		<td>
       
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr align="center">
    <td><img src="<?=$logo;?>" /></td>
    <td>
    <img src='../../img/logo_colegiointeractivo.jpg' width="194" height="104" >
    
    </tr>
                  
				</table>
                <br>
               
              
<?
   	
		
		//echo $sql;
		$rs_contador=$ob_grafico->cuenta_nacional_mensual($id_nacional,$mes,$nro_ano);
		$contador=pg_result($rs_contador,0);
		$contador=round($contador/2);
 	
	$result=$ob_grafico->busca_grafico_nacional($id_nacional,$mes,$nro_ano,$contador);
	if(pg_numrows($result)==0){
		echo "<script type=\"text/javascript\">alert(\"No Hay Datos\");</script>";
		echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
		
		}
 	 
    $strXML = "";
	$strXML .= "<graph caption='Gr&aacute;fico Subvenci&oacute;n Real' xAxisName='Instituci&oacute;n' yAxisName='totales' decimalPrecision='0' formatNumberScale='0'>";

	for($i=0 ; $i < @pg_numrows($result); $i++ ){
			$fila = @pg_fetch_array($result,$i); 
			//print_r($fila);
			$institucion=$fila['rdb'];
			
			$sep=$fila['sep'];
			$pie=$fila['pie'];
			$retos=$fila['retos'];
			$normal=$fila['normal'];
			
			$Total_subvencion=$sep+$pie+$retos+$normal;
			 $Total_subvencion;
			 if($Total_subvencion<=0){
				 continue;
				 }
			
			
			 $strXML .= "<set name= '$instituci&oacute;n' color = 'FFBA00' value = '$Total_subvencion' />";
	   }

   $strXML .= "</graph>";
   
	$ancho=400+(55*15);
	echo renderChartHTML("FusionCharts/FCF_Column3D.swf","",$strXML, "myNext", $ancho, 500);
	
	
	echo "<H1 class=SaltoDePagina></H1>";
	
	
	
	$result=$ob_grafico->busca_grafico_nacional2($id_nacional,$mes,$nro_ano,$contador);
	if(pg_numrows($result)==0){
		echo "<script type=\"text/javascript\">alert(\"No Hay Datos\");</script>";
		echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
		
		}
 	 
    $strXML = "";
	$strXML .= "<graph caption='Gr&aacute;fico Subvenci&oacute;n Real' xAxisName='Institucion' yAxisName='totales' decimalPrecision='0' formatNumberScale='0'>";

	for($i=0 ; $i < @pg_numrows($result); $i++ ){
			$fila = @pg_fetch_array($result,$i); 
			//print_r($fila);
			$institucion=$fila['rdb'];
			
			$sep=$fila['sep'];
			$pie=$fila['pie'];
			$retos=$fila['retos'];
			$normal=$fila['normal'];
			
			$Total_subvencion=$sep+$pie+$retos+$normal;
			 $Total_subvencion;
			 if($Total_subvencion<=0){
				 continue;
				 }
			
			
			 $strXML .= "<set name= '$institucion' color = '6D8D16'  value = '$Total_subvencion'  />";
	   }

   $strXML .= "</graph>";
   
   
	$ancho=400+(55*15);
	echo renderChartHTML("FusionCharts/FCF_Column3D.swf","",$strXML, "myNext", $ancho, 500);
	?>
	
	
	
    
    
    
    
    
   	    </td>
         
        
	  </tr>
       <tr>
      
      <td>&nbsp;</td>
      </tr>
      <tr>
      
      <td><div align="right" class="subitem"><? //=$fecha=$ob_reporte->fecha_actual();?></div></td>
      </tr>
      
</table>

</body>
</html> 

