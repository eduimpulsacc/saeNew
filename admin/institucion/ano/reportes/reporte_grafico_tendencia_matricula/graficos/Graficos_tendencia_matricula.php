<?php

	require('../../../../../../util/header.inc');
	include('../../../../../clases/class_Reporte.php');
	include ("funciones_php/FusionCharts.php");
	
	
	//print_r($_POST);
	
	echo $institucion	= $_INSTIT;
	 $reporte		= $c_reporte;
	 $ob_reporte = new Reporte();
	 //-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	$Curso_pal = CursoPalabra($select_cursos, 1, $conn);
	
	/////////////////////////////////////////////////////////////////////////////
	
	 if($grupo==1){
		$tipo_grafico = " Solo Mujeres";
  		}else if($grupo==2){
		$tipo_grafico = " Solo Hombres";
		}
	
	if($hidden_nombre_tipo!='(Todos)'){
		$separa=explode('-',$hidden_nombre_tipo);
		$nombre_tipo=$separa[1];
		}else{
		$nombre_tipo="Todos";	
		}
	
			   
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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


<table width="680"  align="center" border="0" cellspacing="0" cellpadding="5">
	  <tr>
		<td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td>
					<!-- aqui va la insignia -->
					
					<table width="125" border="0" cellpadding="0" cellspacing="0">
					<tr valign="top" >
					  <td width="125" align="center"> 	  
						<?
						if($institucion!=""){
						   echo "<img src='".$d."../../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}?>		  </td>
					</tr>
				  </table>
					
					<!-- fin de la insignia -->					</td>
					<td>&nbsp;</td>
                    
				  </tr>
                  
				</table>
                <br>
             
                
<?
  $sql="select * from ano_escolar an where an.id_institucion=$institucion order by an.nro_ano asc";
		
  $result = pg_exec($conn,$sql)  or die ( pg_last_error($conn));
  
 	 
    $strXML = "";
	
	
	

		
	
	$strXML .= "<graph caption='Grafico Tendencia de Matricula".$tipo_grafico." ".$nombre_tipo." ' xAxisName='A&ntilde;os' yAxisName='totales' decimalPrecision='0' formatNumberScale='0'>";

	for( $i=0 ; $i < @pg_numrows($result) ; $i++ ){
		
			$fila = @pg_fetch_array($result,$i); 
			//print_r($fila);
			$id_ano=$fila['id_ano'];
			$nro_ano=$fila['nro_ano'];
			$ensenanza = $select_tipo_ense;
	       $sql_2="select count(*) as contador from ano_escolar an 
			inner join curso c on c.id_ano=an.id_ano ";
		   if($ensenanza>0){
           $sql_2.=	" and c.ensenanza=".$ensenanza."";
			}
			
			$sql_2.=" inner join matricula m on m.id_curso=c.id_curso and m.bool_ar=0
			inner join alumno al on m.rut_alumno=al.rut_alumno
			where an.id_ano=$id_ano";
			
	   if($grupo==1){
		$sql_2.=" and al.sexo=1 ";
  		}else if($grupo==2){
		$sql_2.=" and al.sexo=2 ";	
		}
				
						
					
			$result_2 = pg_exec($conn,$sql_2)  or die ( pg_last_error($conn));
			
			for($j=0;$j<pg_numrows($result_2);$j++){
			$fila_2=pg_fetch_array($result_2,0);
			$cantidad = $fila_2['contador'];
					
			/*echo"<pre>";
			print_r($fila_2);
			echo"<pre>";*/
			if(!$fila_2){
		echo "No hay Datos";
		}
		
			
			 $strXML .= "<set name= '$nro_ano'  value = '$cantidad' />";
	
	   }
	}
   $strXML .= "</graph>";
   
   
	$ancho=200+(60*10);
	
	if($tipo_g==1){
	echo renderChartHTML("FusionCharts/FCF_Line.swf","",$strXML, "myNext", $ancho, 350);
	}else if($tipo_g==2){
	echo renderChartHTML("FusionCharts/FCF_Column2D.swf","",$strXML, "myNext", $ancho, 350);	
	}
	?>
    	 </td>
         
        
	  </tr>
       <tr>
      
      <td>&nbsp;</td>
      </tr>
      <tr>
      
      <td><div align="right" class="subitem"><?=$fecha=$ob_reporte->fecha_actual();?></div></td>
      </tr>
      
</table>

</body>
</html> 

