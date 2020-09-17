<?php

	require('../../util/header.inc');
    require('../../util/funciones_new.php'); 
	
	include ("funciones_php/FusionCharts.php");
	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
    $alumno			=$_ALUMNO;
	$curso			=$_CURSO;
    	
	$sql_alumno="select nombre_alu,ape_pat,ape_mat from alumno where rut_alumno=".$alumno;
	$result = pg_exec($conn,$sql_alumno);
	$fila_alum=pg_fetch_array($result,0);
	$nombre_alumno=$fila_alum['nombre_alu'].' '.$fila_alum['ape_pat'].' '.$fila_alum['ape_mat'];
	
	
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

</head>
<body>



<table width="680"  align="center" border="0" cellspacing="0" cellpadding="5">
	  <tr>
		<td>
				
<?
   
   $sql="select * from ensayos_psu  en where en.id_ano=".$ano." and id_curso=".$curso." and id_ramo=".$select_ramos." 
   and rut_alumno=".$alumno." ORDER BY fecha";
	
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
      </table>
</body>
</html> 

