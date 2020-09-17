<?php
require('../../util/header.inc');
	
	$_POSP = 4;
	$_bot = 8;
	$cmb_alumnos=$_POST['cmb_alumnos'];
	echo $cmb_alumnos;
	echo $cmb_estados;
	//$ANO = $cmb_ano;	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	//$curso		= $cmb_curso;
	//$reporte		= $c_reporte;
	$count = 0;
for($i=1;$i<7;$i++){
	if(${"ck_".$i} == 1){
	$count = $count+1;
	}
}
//echo "count".$count;
//echo $cmb_tipo_ensenanza;
//echo $ANO;
//echo $valor;	
if($valor == "1"){
	$Fecha= date("d-m-Y_h:i");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Informe_Practicas_$Fecha.xls"); 
	
}	
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link href="../../../../cortes/12086/estilos.css" rel="stylesheet" type="text/css">
<script>
function enviapag2(form){ //-------------------para exportar
		form.target="_blank";
		form.action='InformeEstadiscticoPracticas.php?valor=1&cmb_estados=<?=$cmb_estados?>&cmb_alumnos=<?=$cmb_alumnos?>&r_ordena=<?=$r_ordena?>&cmb_ano=<?=$ANO?>&ck_1=<?=$ck_1?>&ck_2=<?=$ck_2?>&ck_3=<?=$ck_3?>&ck_4=<?=$ck_4?>&ck_5=<?=$ck_5?>&ck_6=<?=$ck_6?>&ck_7=<?=$ck_7?>&r_puntaje=<?=$r_puntaje?>';
		form.submit(true);
}
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
function cerrar(){ 
window.close() 
} 
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
<script src="../../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

<SCRIPT LANGUAGE="Javascript" SRC="FusionCharts.js"></SCRIPT>
</head>

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
<body>

<form name="form" action="InformeEstadisticoPracticas.php" method="post">
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="capa0">
	<table width="100%">
	  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		  </td>
	    <td align="right"><input name="button4" type="button" class="botonXX" onClick="enviapag2(this.form)"  value="EXPORTAR"></td>
	  </tr></table>
      
      </div></td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<?
		$sql_inst="select * from institucion where rdb=".$institucion;
		$result = @pg_Exec($conn,$sql_inst);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{ ?>
			<td width="119" rowspan="6">
						<?
	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>
			</td>
			<td width="50">&nbsp;</td>
			<td>
	
				<table>
				  <tr>
					<td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$arr['nombre_instit']?></strong></font></div></td>
				  </tr>
				</table>
				<table>  <tr>
					<td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$arr['calle'].$arr['nro'];?></strong></font></div></td>
					</tr>
				</table>
				<table>  <tr>
					<td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$arr['telefono'];?></strong></font></div></td>
					</tr>
				</table>
			</td>

	<? }
		else{?>
		<td>
			<table width="100%">
			  <tr>
				<td width="100%"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$ob_membrete->ins_pal?></strong></font></div></td>
			  </tr>
			</table>
			<table>  <tr>
				<td width="100%"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$ob_membrete->direccion;?></strong></font></div></td>
				</tr>
			</table>
			<table>  <tr>
				<td width="100%"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$ob_membrete->telefono;?></strong></font></div></td>
				</tr>
			</table>
		</td>
	<? }  ?>
	</tr>
</table>
<br/><SCRIPT LANGUAGE="JavaScript">
		//In this example, we'll show you how to plot and update charts on the
		//client side. Here, we first store our data (to be plotted) in client side
		//JavaScript arrays. This data is hard-coded in this example. However,
		//in your applications, you can build this JavaScript arrays with live
		//data using server side scripting languages.
		// Or, you can make AJAX calls to get this data live.
		
		//We store all our data in an array data. It contains data for three Products
		//for 3 quarters. The first column of each array contains the product Name.
		//Thereafter 4 columns contain data for 4 quarters.
		var data = new Array();   																	///CAMBIAR DATOS
		//Data for each product
		data[0] = new Array("En practica",1,0,0,0,0,0,0);
		data[1] = new Array("Practica Aprobada",0,2,0,0,0,0,0);
		data[2] = new Array("Practica Reprobada",0,0,3,0,0,0,0);
		data[3] = new Array("En proceso de Titulacion",0,0,0,4,0,0,0);
		data[4] = new Array("Titulado",0,0,0,0,5,0,0);
		data[5] = new Array("Varios (Estudios Universitarios)",0,0,0,0,0,6,0);
		data[6] = new Array("Varios (Desicion Personal)",0,0,0,0,0,0,7);
		
		//the array of colors contains 4 unique Hex coded colours (without #) for the 4 products
		var colors=new Array("AFD8F8", "F6BD0F", "8BBA00", "FF8E46","AFD8F8", "F6BD0F", "8BBA00"); ///CAMBIAR COLORES
		
		/**
		 * updateChart method is called, when user changes any of the checkboxes.
		 * Here, we generate the XML data again and build the chart.		  
		 *	@param	domId	domId of the Chart
		*/
		function updateChart(domId){			
				//Update it's XML - set animate Flag from AnimateChart checkbox in form
				//using updateChartXML method defined in FusionCharts.js
				updateChartXML(domId,generateXML(this.document.productSelector.AnimateChart.value=1));
		}

		/**
		 * generateXML method returns the XML data for the chart based on the
		 * checkboxes which the user has checked.
		 *	@param	animate		Boolean value indicating to  animate the chart.
		 *	@return				XML Data for the entire chart.
		*/		
		function generateXML(animate){			
			//Variable to store XML
			var strXML="";
			
			//<graph> element
			//Added animation parameter based on animate parameter			
			//Added value related attributes if show value is selected by the user
			strXML = "<graph numberPrefix='' decimalPrecision='0' animation='" + ((animate==true)) + "' " + ((this.document.productSelector.ShowValues.value==1)?("showValues='1' rotateValues='1'"):(" showValues='1' ")) + "yaxismaxvalue='<?=$max+3;?>'>";

			//Store <categories> and child <category> elements
			strXML = strXML + "<categories><category name='En practica' /><category name='Practica Reprobada' /><category name='Practica Aprobada' /><category name='En proceso de Titulacion' /><category name='Titulado' /><category name='Varios (Estudios Universitarios)' /><category name='Varios (Decision Personal)' /></categories>";

			//Based on the products for which we've to generate data, generate XML			
			strXML = (this.document.productSelector.ProductA.value==1)?(strXML + getProductXML(0)):(strXML);
			strXML = (this.document.productSelector.ProductB.value==1)?(strXML + getProductXML(1)):(strXML);
			strXML = (this.document.productSelector.ProductC.value==1)?(strXML + getProductXML(2)):(strXML);
			strXML = (this.document.productSelector.ProductD.value==1)?(strXML + getProductXML(3)):(strXML);
			strXML = (this.document.productSelector.ProductE.value==1)?(strXML + getProductXML(4)):(strXML);
			strXML = (this.document.productSelector.ProductF.value==1)?(strXML + getProductXML(5)):(strXML);
			strXML = (this.document.productSelector.ProductG.value==1)?(strXML + getProductXML(6)):(strXML);
 
			//Close <graph> element;
			strXML = strXML + "</graph>";

			//Return data
			return strXML;
		}
		/**
		 * getProductXML method returns the <dataset> and <set> elements XML for
		 * a particular product index (in data array). 
		 *	@param	productIndex	Product index (in data array)
		 *	@return					XML Data for the product.
		*/
		function getProductXML(productIndex){		
			var productXML;
			//Create <dataset> element taking data from 'data' array and color vaules from 'colors' array defined above
			productXML = "<dataset seriesName='" + data[productIndex][0] + "' color='"+ colors[productIndex]  +"' >";			
			//Create set elements
			for (var i=0; i<7; i++){
				productXML = productXML + "<set value='" + data[productIndex][i] + "' />";
			}
			//Close <dataset> element
			productXML = productXML + "</dataset>";
			//Return dataset data
			return productXML;			
		}
		
</SCRIPT>
     <FORM  NAME='productSelector' Id='productSelector' action='InformeEstadisticoPracticas.php' method='POST' >		
			<INPUT type="hidden" name='ProductA' onClick="JavaScript:updateChart('chart1Id');"  value="1"/>
			<INPUT type="hidden" name='ProductB' onClick="JavaScript:updateChart('chart1Id');"  value="1"/>
			<INPUT type="hidden" name='ProductC' onClick="JavaScript:updateChart('chart1Id');"  value="1"/>	
            <INPUT type="hidden" name='ProductD' onClick="JavaScript:updateChart('chart1Id');"  value="1"/>
            <INPUT type="hidden" name='ProductE' onClick="JavaScript:updateChart('chart1Id');"  value="1"/>
            <INPUT type="hidden" name='ProductF' onClick="JavaScript:updateChart('chart1Id');"  value="1"/>
            <INPUT type="hidden" name='ProductG' onClick="JavaScript:updateChart('chart1Id');"  value="1"/>						
			<INPUT type="hidden" name='AnimateChart' />
			<INPUT type="hidden" name='ShowValues' onClick="JavaScript:updateChart('chart1Id');"/>
	 </FORM>
		<br/><br/>
		<div id="chart1div" align="center">
			FusionCharts		</div>
		
		<script language="JavaScript">					
			var chart1 = new FusionCharts("FCF_MSColumn3D.swf", "chart1Id", "600", "400");		   
			//Initialize graph with chart data returned by generateXML() function. [ note: the parameter 'this.document.productSelector.AnimateChart.checked' is passed to set animation property of the chart]
			//loading XML data into variable strXML 
			var strXML=generateXML(this.document.productSelector.AnimateChart.value=1);
			chart1.setDataXML(strXML);
			chart1.render("chart1div");
		</script>	


</form>
</body>
</html>
<? pg_close($conn);?>