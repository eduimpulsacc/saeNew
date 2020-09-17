<?php

	require('../../../../../../util/header.inc');
	include('../../../../../clases/class_Reporte.php');
	include ("funciones_php/FusionCharts.php");
	
	
	 $institucion	= $_INSTIT;
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
	
	
	
	
	if($select_alumnos!=0){
	$sql_alumno="select nombre_alu,ape_pat,ape_mat from alumno where rut_alumno=".$select_alumnos;
	$result = pg_exec($conn,$sql_alumno)  or die ( pg_last_error($conn));
	$fila_alum=pg_fetch_array($result,0);
	$nombre_alumno=$fila_alum['nombre_alu'].' '.$fila_alum['ape_pat'].' '.$fila_alum['ape_mat'];
	}
	
	$sql_ramo="select su.nombre from ramo 
	           inner join subsector su on ramo.cod_subsector=su.cod_subsector
	           where ramo.id_ramo=".$select_ramos;
			   
			   $result_ramo = pg_exec($conn,$sql_ramo)  or die ( pg_last_error($conn));
	           $fila_ramo=pg_fetch_array($result_ramo,0);
			   $nombre_ramo=$fila_ramo['nombre'];
			   
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../../../clases/highcharts/js/highcharts.js"></script>
<!--<script type="text/javascript" src="../../../../../clases/highcharts/js/modules/exporting.js"></script>-->
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
						   echo "<img src='../../../../../../tmp/".$institucion."insignia". "' >";
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
			   if($select_alumnos!=0){
				   ?>
                <div align="left" class="item"> Nombre Alumno: <?=strtoupper($nombre_alumno);?></div>
                <? }?>
                <br>
                <div align="left" class="item"> Curso: <?=$Curso_pal;?></div>
                <br>
                <div align="left" class="item"> Asignatura: <?=$nombre_ramo;?></div>
                
                
                <br>
<?
    if($select_alumnos!=0){
		
	$sql_ram="select * from curso c where id_curso=".$select_cursos;	
	$resultado_ramo = pg_exec($conn,$sql_ram)  or die ( pg_last_error($conn));
	$fila_r = @pg_fetch_array($resultado_ramo,0);
	$id_ramo=$fila_r[0];	
	$grado=	$fila_r[1];
	$letra=	$fila_r[2];
	$ensenanza=	$fila_r[3];
		
    /*echo "<pre>";		
	echo $id_ramo.'-'.$grado.'-'.$letra.'-'.$ensenanza;
	echo "</pre>";*/
		
		
	/* $sql="select count(v.*),vl.nombre_concepto from curso c 
		inner join velocidad_lectora v on c.grado_curso=v.grado_curso and c.ensenanza=v.ensenanza  
		inner join concepto_velocidad_lectora vl on v.id_concepto=vl.id_concepto 
		inner JOIN lectura_veloz lvl on v.id_ano = lvl.id_ano
		where v.id_ano=".$select_ano." and  c.id_curso=".$select_cursos." and lvl.rut_alumno=".$select_alumnos." and
		lvl.palabra between rango_inicial and rango_final group by vl.nombre_concepto";	
		
   /*$sql="select * from lectura_veloz  en where en.id_ano=".$select_ano." and id_curso=".$select_cursos." and id_ramo=".$select_ramos." 
   and rut_alumno=".$select_alumnos." ORDER BY fecha";*/
	 
	 $sql="select sum(lv.palabra),lv.fecha
from curso c 
inner JOIN lectura_veloz lv ON lv.id_curso=c.id_curso
where c.id_ano=".$select_ano." and c.id_curso=".$select_cursos." and lv.rut_alumno=".$select_alumnos." 
group by lv.fecha";
	}else{
	 $sql="select avg(palabra) as palabra,fecha from lectura_veloz en where en.id_ano=".$select_ano." and id_curso=".$select_cursos." and id_ramo=".$select_ramos." GROUP BY id_curso,fecha order by fecha";	
		

		}	
		
		//if($_PERFIL==0){echo $sql;}
		
		
	$r = pg_exec($conn,$sql)  or die ( pg_last_error($conn));
 
 	 
    $strXML = "";
	
	
	

		
	
	//$strXML .= "<graph caption='Gráfico Léctura Veloz' xAxisName='Conceptos' yAxisName='Cantidad de Palabras' decimalPrecision='0' formatNumberScale='0'>";
	$cat="";
	$val="";

	for( $i=0 ; $i < @pg_numrows($r) ; $i++ ){
		
			$fila = @pg_fetch_array($r,$i); 
			$nombre_concepto=$fila[1];
			$contador=$fila[0];		
			
			 $cat.="'".CambioFD($nombre_concepto)."',";
			 $val.=round($contador,0).",";
/**/
			/*if(!$fila){
		echo "No hay Datos";
		}
			*/		
			
		//	 $strXML .= "<set name= '$contador'  value = '$nombre_concepto' />";
			 
			 
	
	   }
	 // $cat;
//	echo "--".
 $categories= $cat;
   $strXML .= "</graph>";
   
   
$ancho=200+(60*10);
	//echo renderChartHTML("FusionCharts/FCF_Column2D.swf","",$strXML, "myNext", $ancho, 350);

	?>
    
    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

    
    	 </td>
         
        
	  </tr>
       <tr>
      
      <td>&nbsp;</td>
      </tr>
      <tr>
      
      <td><div align="right" class="subitem"><?=$fecha=$ob_reporte->fecha_actual();?></div></td>
      </tr>
      
</table>
<script>
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Gráfico Léctura Veloz'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
               <?php echo $categories; ?>
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Cantidad de Palabras por Minuto'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'PPM',
            data: [<?php echo $val; ?>]

        }]
    });
});
</script>

</body>
</html> 

