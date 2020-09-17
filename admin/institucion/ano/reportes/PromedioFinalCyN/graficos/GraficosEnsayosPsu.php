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
   $sql="select * from ensayos_psu  en where en.id_ano=".$select_ano." and id_curso=".$select_cursos." and id_ramo=".$select_ramos." 
   and rut_alumno=".$select_alumnos." ORDER BY fecha";
	 
	}else{
	 $sql="select avg(puntaje) as puntaje,fecha from ensayos_psu en where en.id_ano=".$select_ano." and id_curso=".$select_cursos." and id_ramo=".$select_ramos." GROUP BY id_curso,fecha order by fecha";	
		

		}	
				
		
		//echo $sql;
		
		
	$r = pg_exec($conn,$sql)  or die ( pg_last_error($conn));
 
 	 
    $strXML = "";
	
	
	

		
	
	$strXML .= "<graph caption='Grafico Ensayo P.S.U' xAxisName='Puntajes PSU' yAxisName='Puntajes' decimalPrecision='0' formatNumberScale='0'>";

	for( $i=0 ; $i < @pg_numrows($r) ; $i++ ){
		
			$fila = @pg_fetch_array($r,$i); 
			//print_r($fila);
			$fecha=$fila['fecha'];
			$puntaje=$fila['puntaje'];
					
					$fecha_separ=explode('-',$fecha);
					
					 $fecha_ano=$fecha_separ[0];
					 $fecha_mes=$fecha_separ[1];
					 $fecha_dia=$fecha_separ[2];
				 $fecha_nueva=$fecha_dia.'/'.$fecha_mes.'/'.$fecha_ano;
				
			
			//print_r($fila);
			if(!$fila){
		echo "No hay Datos";
		}
			/*if($select_alumnos==0){
				
				$puntaje=
				$strXML .= "<set name= '$fecha_nueva'  value = '$puntaje' />";
					
				}*/
			
			
			 $strXML .= "<set name= '$fecha_nueva'  value = '$puntaje' />";
			//echo $strXML .= "<set name= '$puntaje'  value = '$fecha_nueva' />";
	
	   }

   $strXML .= "</graph>";
   
   
	$ancho=200+(60*10);
	echo renderChartHTML("FusionCharts/FCF_Line.swf","",$strXML, "myNext", $ancho, 350);

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

